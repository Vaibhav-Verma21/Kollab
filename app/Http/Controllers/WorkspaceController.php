<?php

namespace App\Http\Controllers;

use App\Models\WhiteboardAction;
use App\Models\ChatMessage;
use App\Models\Whiteboard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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
        
        // Find or create a default whiteboard for the user
        $whiteboard = Whiteboard::firstOrCreate(
            ['owner_id' => $user->id],
            ['uuid' => Str::uuid()->toString()]
        );

        return redirect()->route('workspace.show', ['uuid' => $whiteboard->uuid]);
    }

    public function show($uuid)
    {
        $user = Auth::user();
        $userColor = $this->getUserColor($user->id);

        $whiteboard = Whiteboard::where('uuid', $uuid)->firstOrFail();

        // Fetch initial whiteboard state scoped to this whiteboard
        $actions = WhiteboardAction::where('whiteboard_id', $whiteboard->id)
            ->where('created_at_ms', '>', 0)
            ->orderBy('created_at_ms', 'asc')
            ->get();

        // Fetch recent chat messages for this whiteboard
        $chatMessages = ChatMessage::where('whiteboard_id', $whiteboard->id)
            ->orderBy('created_at_ms', 'asc')
            ->take(50)
            ->get();

        // Server time in ms
        $serverTimeMs = round(microtime(true) * 1000);

        return view('workspace', compact('user', 'userColor', 'actions', 'chatMessages', 'serverTimeMs', 'whiteboard'));
    }

    public function sync(Request $request, $uuid)
    {
        $user = Auth::user();
        $userId = $user->id;
        $username = $user->name;
        $userColor = $this->getUserColor($userId);

        $whiteboard = Whiteboard::where('uuid', $uuid)->firstOrFail();
        $whiteboardId = $whiteboard->id;

        $serverTimeMs = round(microtime(true) * 1000);

        // 1. Save or update whiteboard actions sent by this client
        $newActions = $request->input('actions', []);
        $actionTime = $serverTimeMs;
        
        $savedActions = [];

        foreach ($newActions as $act) {
            $actId = $act['id'] ?? null;
            if ($actId) {
                // Try to find existing action by its ID to update
                $existingAction = WhiteboardAction::where('whiteboard_id', $whiteboardId)
                    ->where(function($q) use ($actId) {
                        $q->where('_id', $actId)->orWhere('id', $actId);
                    })->first();
                    
                if ($existingAction) {
                    $existingAction->update([
                        'points' => $act['points'] ?? $existingAction->points,
                        'text' => $act['text'] ?? $existingAction->text,
                        'size' => isset($act['size']) ? (int)$act['size'] : $existingAction->size,
                        'color' => $act['color'] ?? $existingAction->color,
                        'type' => $act['type'] ?? $existingAction->type,
                        'created_at_ms' => $actionTime++, // update timestamp to trigger other clients sync
                    ]);
                    $savedActions[] = $existingAction;
                    continue;
                }
            }

            // Create new action
            $newAction = WhiteboardAction::create([
                '_id' => $actId,
                'id' => $actId,
                'whiteboard_id' => $whiteboardId,
                'user_id' => $userId,
                'username' => $username,
                'color' => $act['color'] ?? $userColor,
                'type' => $act['type'] ?? 'stroke',
                'points' => $act['points'] ?? null,
                'text' => $act['text'] ?? null,
                'size' => isset($act['size']) ? (int)$act['size'] : 2,
                'created_at_ms' => $actionTime++,
            ]);
            $savedActions[] = $newAction;
        }

        if (!empty($savedActions)) {
            broadcast(new \App\Events\WhiteboardActionDispatched($uuid, $savedActions))->toOthers();
        }

        // 2. Save new chat message if sent
        $newMsgText = $request->input('chat_message');
        if (!empty($newMsgText)) {
            $chat = ChatMessage::create([
                'user_id' => $userId,
                'username' => $username,
                'whiteboard_id' => $whiteboardId,
                'message' => $newMsgText,
                'color' => $userColor,
                'created_at_ms' => $serverTimeMs,
            ]);
            broadcast(new \App\Events\WhiteboardChatDispatched($uuid, $chat))->toOthers();
        }

        return response()->json([
            'success' => true,
            'server_time' => $serverTimeMs,
        ]);
    }

    public function clear(Request $request, $uuid)
    {
        $user = Auth::user();
        $whiteboard = Whiteboard::where('uuid', $uuid)->firstOrFail();
        
        // Only owner can clear
        if ($whiteboard->owner_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $serverTimeMs = round(microtime(true) * 1000);

        // Delete all actions for this whiteboard
        WhiteboardAction::where('whiteboard_id', $whiteboard->id)->delete();

        // Insert a 'clear' action so other clients know to clear immediately
        $clearAction = WhiteboardAction::create([
            'whiteboard_id' => $whiteboard->id,
            'user_id' => $user->id,
            'username' => $user->name,
            'color' => '#000000',
            'type' => 'clear',
            'created_at_ms' => $serverTimeMs,
        ]);

        broadcast(new \App\Events\WhiteboardCleared($uuid, $clearAction))->toOthers();

        return response()->json(['success' => true]);
    }
}
