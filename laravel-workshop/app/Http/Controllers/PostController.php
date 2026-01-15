<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Http\Resources\PostResource;
use App\Http\Resources\ProfileResource;
use App\Models\Like;
use App\Models\Post;
use App\Models\Profile;
use App\Queries\PostThreadQuery;
use App\Queries\TimelineQuery;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PostController extends Controller
{
    public function index()
    {
        $profile = Auth::user()->profile;

        $posts = TimelineQuery::forViewer($profile)->get();

        return Inertia::render('Posts/Index', [
            'profile' => new ProfileResource($profile),
            'posts' => PostResource::collection($posts),
        ]);
    }

    public function show(Profile $profile, Post $post)
    {
        $post = PostThreadQuery::for($post, Auth::user()?->profile)->load();

        return Inertia::render('Posts/Show', [
            'post' => new PostResource($post),
        ]);
    }

    public function store(CreatePostRequest $createPostRequest)
    {
        $profile = Auth::user()->profile;

        Post::publish($profile, $createPostRequest->input('content'));

        return to_route('posts.index')->with('success', 'Your post is now live!');
    }

    public function reply(Profile $profile, Post $post, CreatePostRequest $createPostRequest): RedirectResponse
    {
        $currentProfile = Auth::user()->profile;

        Post::reply($currentProfile, $post, $createPostRequest->input('content'));

        // Redirect to post show page so user can see the full thread
        return to_route('posts.show', [$profile, $post]);
    }

    public function repost(Profile $profile, Post $post)
    {
        $currentProfile = Auth::user()->profile;

        Post::repost($currentProfile, $post);

        return to_route('posts.index');
    }

    public function quote(Profile $profile, Post $post, CreatePostRequest $createPostRequest)
    {
        $currentProfile = Auth::user()->profile;

        Post::repost($currentProfile, $post, $createPostRequest->input('content'));

        return to_route('posts.index');
    }

    public function like(Profile $profile, Post $post): RedirectResponse
    {
        $currentProfile = Auth::user()->profile;

        Like::createLike($currentProfile, $post);

        return back();
    }

    public function unlike(Profile $profile, Post $post): RedirectResponse
    {
        $currentProfile = Auth::user()->profile;

        Like::removeLike($currentProfile, $post);

        return back();
    }

    public function destroy(Profile $profile, Post $post): RedirectResponse
    {
        $this->authorize('update', $post);

        // Delete original post
        $post->delete();

        // Delete any reposts for this post by the current user (if any)
        $post
            ->reposts()
            ->where('profile_id', Auth::user()->profile->id)
            ->first()
            ?->delete();

        return back();
    }
}
