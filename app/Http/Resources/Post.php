<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class Post extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
//        return parent::toArray($request);
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'name' => $this->name,
            'created_at' => date("Y-m-d H:i:s", strtotime($this->created_at)) ?? '',
            'comments' => $this->comments
        ];
    }
}
