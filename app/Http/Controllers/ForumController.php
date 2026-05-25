<?php

namespace App\Http\Controllers;

use App\Models\ForumReply;
use App\Models\ForumThread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForumController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->query('category', 'All');
        
        $query = ForumThread::with('user')->orderBy('created_at', 'desc');
        
        if ($category !== 'All') {
            $query->where('category', $category);
        }
        
        $threads = $query->get();
        
        return view('forum', compact('threads', 'category'));
    }

    public function create()
    {
        return view('forum.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'content' => 'required|string',
        ]);

        $thread = ForumThread::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'category' => $request->category,
            'content' => $request->content,
            'views' => 0,
        ]);

        return redirect()->route('forum.show', $thread->id);
    }

    public function show($id)
    {
        $thread = ForumThread::with('user', 'replies.user')->findOrFail($id);
        
        // Increment view count
        $thread->increment('views');
        
        return view('forum.show', compact('thread'));
    }

    public function reply(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        ForumReply::create([
            'thread_id' => $id,
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return redirect()->route('forum.show', $id);
    }
}
