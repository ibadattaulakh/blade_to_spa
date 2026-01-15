<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'content' => $this->content,
            'created_at' => $this->created_at->diffForHumans(),
            'updated_at' => $this->updated_at,
            'profile' => $this->whenLoaded('profile', function () {
                return new ProfileResource($this->profile);
            }),
            'repost_of' => $this->whenLoaded('repostOf', function () {
                return new PostResource($this->repostOf);
            }),
            'replies' => $this->whenLoaded('replies', function () {
                return PostResource::collection($this->replies);
            }),
            'replies_count' => $this->whenCounted('replies'),
            'likes' => $this->whenLoaded('likes', function () {
                return LikeResource::collection($this->likes);
            }),
            'likes_count' => $this->whenCounted('likes'),
            'has_liked' => $this->has_liked ?? false,
            'reposts' => $this->whenLoaded('reposts', function () {
                return PostResource::collection($this->reposts);
            }),
            'reposts_count' => $this->whenCounted('reposts'),
            'has_reposted' => $this->has_reposted ?? false,
            'can' => [
                'update' => $request->user() ? $request->user()->can('update', $this->resource) : false,
            ],
        ];
    }
}
