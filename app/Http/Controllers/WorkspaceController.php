<?php

namespace App\Http\Controllers;

use App\Models\WhiteboardAction;
use App\Models\WhiteboardUser;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class WorkspaceController extends Controller
{
    private function getUserColor($userId)
    {
        $colors = ['#ef4444', '#3b82f6', '#10b981', '#f59e0b', '#8b5cf6', '#ec4899', '#14b8a6', '#f43f5e', '#a855f7', '#06b6d4'];
        $index = hexdec(substr(md5($userId), 0, 4)) % count($colors);
        return $colors[$index];
    }

    public function index()
    {
        $user = Auth::user();
        $userColor = $this->getUserColor($user->id);

        // Fetch initial whiteboard state
        $actions = WhiteboardAction::where('created_at_ms', '>', 0)->orderBy('created_at_ms', 'asc')->get();

        // Fetch recent chat messages (last 50)
        $chatMessages = ChatMessage::orderBy('created_at_ms', 'asc')->take(50)->get();

        // Server time in ms
        $serverTimeMs = round(microtime(true) * 1000);

        return view('workspace', compact('user', 'userColor', 'actions', 'chatMessages', 'serverTimeMs'));
    }

    public function sync(Request $request)
    {
        $user = Auth::user();
        $userId = $user->id;
        $username = $user->name;
        $userColor = $this->getUserColor($userId);

        $lastSync = (float) $request->input('last_sync', 0);
        $serverTimeMs = round(microtime(true) * 1000);

        // 1. Update current user's cursor position and presence
        $cursor = $request->input('cursor');
        if ($cursor && isset($cursor['x']) && isset($cursor['y'])) {
            WhiteboardUser::updateOrCreate(
                ['user_id' => $userId],
                [
                    'name' => $username,
                    'x' => (float)$cursor['x'],
                    'y' => (float)$cursor['y'],
                    'color' => $userColor,
                    'last_seen' => Carbon::now(),
                ]
            );
        } else {
            // Even if cursor isn't moving, keep user online
            WhiteboardUser::updateOrCreate(
                ['user_id' => $userId],
                [
                    'name' => $username,
                    'color' => $userColor,
                    'last_seen' => Carbon::now(),
                ]
            );
        }

        // 2. Prune offline users (inactive for more than 6 seconds)
        WhiteboardUser::where('last_seen', '<', Carbon::now()->subSeconds(6))->delete();

        // 3. Save or update whiteboard actions sent by this client
        $newActions = $request->input('actions', []);
        $actionTime = $serverTimeMs;
        foreach ($newActions as $act) {
            $actId = $act['id'] ?? null;
            if ($actId) {
                // Try to find existing action by its ID to update
                $existingAction = WhiteboardAction::where('_id', $actId)->orWhere('id', $actId)->first();
                if ($existingAction) {
                    $existingAction->update([
                        'points' => $act['points'] ?? $existingAction->points,
                        'text' => $act['text'] ?? $existingAction->text,
                        'size' => isset($act['size']) ? (int)$act['size'] : $existingAction->size,
                        'color' => $act['color'] ?? $existingAction->color,
                        'type' => $act['type'] ?? $existingAction->type,
                        'created_at_ms' => $actionTime++, // update timestamp to trigger other clients sync
                    ]);
                    continue;
                }
            }

            // Create new action
            WhiteboardAction::create([
                '_id' => $actId,
                'id' => $actId,
                'user_id' => $userId,
                'username' => $username,
                'color' => $act['color'] ?? $userColor,
                'type' => $act['type'] ?? 'stroke',
                'points' => $act['points'] ?? null,
                'text' => $act['text'] ?? null,
                'size' => isset($act['size']) ? (int)$act['size'] : 2,
                'created_at_ms' => $actionTime++,
            ]);
        }

        // 4. Save new chat message if sent
        $newMsgText = $request->input('chat_message');
        if (!empty($newMsgText)) {
            ChatMessage::create([
                'user_id' => $userId,
                'username' => $username,
                'message' => $newMsgText,
                'color' => $userColor,
                'created_at_ms' => $serverTimeMs,
            ]);
        }

        // 5. Fetch new actions since client's last sync (with a 5-second overlap window), excluding own actions
        $overlapSync = max(0, $lastSync - 5000);
        $actions = WhiteboardAction::where('created_at_ms', '>', $overlapSync)
            ->where('user_id', '!=', $userId)
            ->orderBy('created_at_ms', 'asc')
            ->get();

        // 6. Fetch new chat messages since client's last sync (with a 5-second overlap window)
        $chatMessages = ChatMessage::where('created_at_ms', '>', $overlapSync)
            ->orderBy('created_at_ms', 'asc')
            ->get();

        // 7. Get all online users (excluding current user)
        $onlineUsers = WhiteboardUser::where('user_id', '!=', $userId)->get();

        return response()->json([
            'actions' => $actions,
            'chat_messages' => $chatMessages,
            'online_users' => $onlineUsers,
            'server_time' => $serverTimeMs,
        ]);
    }

    public function clear()
    {
        $user = Auth::user();
        $serverTimeMs = round(microtime(true) * 1000);

        // Delete all actions
        WhiteboardAction::truncate();

        // Insert a 'clear' action so other clients know to clear immediately
        WhiteboardAction::create([
            'user_id' => $user->id,
            'username' => $user->name,
            'color' => '#000000',
            'type' => 'clear',
            'created_at_ms' => $serverTimeMs,
        ]);

        return response()->json(['success' => true]);
    }
}
