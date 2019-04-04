<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = "comments";
    protected $primaryKey = "id";

    protected $fillable = ["body", "user_id", "commentable_id", "commentable_type", "created_at"];

    /**
     * Get all of the owning commentable models.
     */
    public function commentable()
    {
        return $this->morphTo();
    }


    public function post()
    {
        return $this->belongsTo(Post::class,"commentable_id");
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
