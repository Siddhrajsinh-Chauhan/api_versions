<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Post as PostResource;
class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'status' =>  $this->status,
            // it set single parameters in response
            'secret' => $this->when($this->id == 4, 'secret-value'),
            // when we want to check specific conditions and return set more than one parameters in response
            $this->mergeWhen($this->id == 3, [
                'first-secret' => 'value1',
                'second-secret' => 'value2',
            ]),
            'created_at' => $this->created_at,
            'updated_at' => $this->when($this->updated_at ?? false, $this->updated_at),
            'posts' => $this->posts
//            'posts' => PostResource::collection($this->whenLoaded('posts'))
        ];
    }
}
