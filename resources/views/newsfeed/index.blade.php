{{-- resources/views/newsfeed/index.blade.php --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Newsfeed</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen py-8">
        <div class="max-w-2xl mx-auto px-4">
            {{-- Header --}}
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h1 class="text-3xl font-bold text-gray-800">Newsfeed</h1>
                <p class="text-gray-600 mt-1">Welcome, {{ auth()?->user()?->name }}!</p>
            </div>

            {{-- Success Message --}}
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Create Post Form --}}
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Create a Post</h2>
                <form action="{{ route('posts.store') }}" method="POST">
                    @csrf
                    <textarea 
                        name="content" 
                        rows="4" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="What's on your mind?"
                        required
                    >{{ old('content') }}</textarea>
                    @error('content')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <button 
                        type="submit" 
                        class="mt-3 bg-blue-500 hover:bg-blue-600 text-white font-semibold px-6 py-2 rounded-lg transition"
                    >
                        Post
                    </button>
                </form>
            </div>

            {{-- Posts Feed --}}
            <div class="space-y-6">
                @forelse ($posts as $post)
                    <div class="bg-white rounded-lg shadow-md p-6">
                        {{-- Post Header --}}
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-500 rounded-full flex items-center justify-center text-white font-semibold">
                                    {{ strtoupper(substr($post->user?->name, 0, 1)) }}
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-800">{{ $post->user?->name }}</h3>
                                    <p class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            @can('delete', $post)
                                <form action="{{ route('posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this post?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            @endcan
                        </div>

                        {{-- Post Content --}}
                        <p class="text-gray-700 mb-4">{{ $post->content }}</p>

                        {{-- Comments Section --}}
                        <div class="border-t pt-4">
                            <h4 class="font-semibold text-gray-800 mb-3">
                                Comments ({{ $post->comments->count() }})
                            </h4>

                            {{-- Add Comment Form --}}
                            <form action="{{ route('comments.store', $post) }}" method="POST" class="mb-4">
                                @csrf
                                <div class="flex space-x-2">
                                    <input 
                                        type="text" 
                                        name="content" 
                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        placeholder="Write a comment..."
                                        required
                                    >
                                    <button 
                                        type="submit" 
                                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition"
                                    >
                                        Comment
                                    </button>
                                </div>
                            </form>

                            {{-- Comments List --}}
                            <div class="space-y-3">
                                @foreach ($post->comments as $comment)
                                    <div class="bg-gray-50 rounded-lg p-3">
                                        <div class="flex items-start justify-between">
                                            <div class="flex items-start space-x-2">
                                                <div class="w-8 h-8 bg-gradient-to-br from-green-500 to-teal-500 rounded-full flex items-center justify-center text-white text-sm font-semibold">
                                                    {{ strtoupper(substr($comment->user?->name, 0, 1)) }}
                                                </div>
                                                <div class="flex-1">
                                                    <p class="font-semibold text-sm text-gray-800">{{ $comment->user?->name }}</p>
                                                    <p class="text-gray-700 text-sm mt-1">{{ $comment->content }}</p>
                                                    <p class="text-xs text-gray-500 mt-1">{{ $comment->created_at->diffForHumans() }}</p>
                                                </div>
                                            </div>
                                            @can('delete', $comment)
                                                <form action="{{ route('comments.destroy', $comment) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this comment?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-700">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-lg shadow-md p-12 text-center">
                        <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                        </svg>
                        <p class="text-gray-500 text-lg">No posts yet. Be the first to post!</p>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div class="mt-6">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
</body>
</html>