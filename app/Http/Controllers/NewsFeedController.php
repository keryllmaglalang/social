<?php

// app/Http/Controllers/NewsfeedController.php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;

class NewsfeedController extends Controller
{
    public function index()
    {
        $activeUsers = User::where('email_verified_at', '!=', null )->get();
        $activeUserIds = $activeUsers->pluck('id')->toArray();

        $userPost = Post::whereIn('user_id', $activeUserIds)->get();
        dd($userPost);
        $posts = Post::latest()->paginate(10);
        return view('newsfeed.index', compact('posts'));
    }

    public function store(Request $request)
    {
        
        $validated = $request->validate([
            'content' => 'required|string|max:1000'
        ]);

        Post::create([
            'user_id' => auth()->id(),
            'content' => $validated['content']
        ]);

        return redirect()->route('newsfeed.index')->with('success', 'Post created successfully!');
    }

    public function storeComment(Request $request, Post $post)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:500'
        ]);

        Comment::create([
            'post_id' => $post->id,
            'user_id' => auth()->id(),
            'content' => $validated['content']
        ]);

        return back()->with('success', 'Comment added successfully!');
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();

        return back()->with('success', 'Post deleted successfully!');
    }

    public function destroyComment(Comment $comment)
    {
        $this->authorize('delete', $comment);
        $comment->delete();

        return back()->with('success', 'Comment deleted successfully!');
    }
}