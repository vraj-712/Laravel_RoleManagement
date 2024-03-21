<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'postId' =>$this->id,
            'title' => $this->title,
            'image' => $this->image,
            'content' => $this->content,
            'author' => [
                'name' => $this->user->name,
                'email' => $this->user->email,
                'id' => $this->user->id

            ]
        ];
    }
}
