<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Http\Resources\ProfileResource;
use App\Models\Follow;
use App\Models\Profile;
use App\Queries\ProfilePageQuery;
use App\Queries\ProfileWithRepliesQuery;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ProfileController extends Controller
{
    public function show(Profile $profile)
    {
        $profile->loadCount(['followings', 'followers']);

        if (Auth::check()) {
            $profile->has_followed = Auth::user()->profile->isFollowing($profile);
        }

        $posts = ProfilePageQuery::for($profile, Auth::user()?->profile)->get();

        return Inertia::render('Profiles/Show', [
            'profile' => new ProfileResource($profile),
            'posts' => PostResource::collection($posts),
        ]);
    }

    public function replies(Profile $profile)
    {
        $profile->loadCount(['followings', 'followers']);

        if (Auth::check()) {
            $profile->has_followed = Auth::user()->profile->isFollowing($profile);
        }

        $posts = ProfileWithRepliesQuery::for($profile, Auth::user()?->profile)->get();

        return Inertia::render('Profiles/Show', [
            'profile' => new ProfileResource($profile),
            'posts' => PostResource::collection($posts),
        ]);
    }

    public function follow(Profile $profile)
    {
        $currentProfile = Auth::user()->profile;

        Follow::createFollow($currentProfile, $profile);

        return back()->with('success', 'You are now following '.$profile->handle);
    }

    public function unfollow(Profile $profile)
    {
        $currentProfile = Auth::user()->profile;

        Follow::removeFollow($currentProfile, $profile);

        return back()->with('success', 'You have now unfollowed '.$profile->handle);
    }
}
