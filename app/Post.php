<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = "posts";
    protected $primaryKey = "id";

    protected $fillable = ["name", "user_id", "created_at"];

    /**
     * Get all of the post's comments.
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /**
     * Get details of the post user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
