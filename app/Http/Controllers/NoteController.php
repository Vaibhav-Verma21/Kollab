<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    public function save(Request $request)
    {
        $request->validate([
            'course_id' => 'required|string',
            'content' => 'nullable|string',
        ]);

        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $note = Note::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'course_id' => $request->course_id,
            ],
            [
                'content' => $request->content ?? '',
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Notes saved to MongoDB!',
            'note' => $note
        ]);
    }
}
