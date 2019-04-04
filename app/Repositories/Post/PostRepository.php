<?php

namespace App\Repositories\Post;

use App\Repositories\Post\PostInterface as PostInterface;
use App\Post;
use App\Comment;
use Exception;
use Illuminate\Support\Facades\Validator;

class PostRepository implements PostInterface
{

    public function __construct()
    {
    }

    /*
     * return array of users object
     * */
    public function getAll($params = "*", $flag = true)
    {
        return Post::select($params)->get();
    }

    /*
     * return array of users object
     * */
    public function getMyPost($params = "*", $flag = true)
    {
        if ($flag) {
            // work for web
            return Post::select($params)->where("id", "!=", auth()->user()->id)->get();
        }
        //work for api
        return Post::select($params)->where("id", "!=", auth()->guard('api')->user()->id)->get();
    }


    /*
     * return user object if user find by id
     * return object
     * */
    public function find($id)
    {
        try {
            $post = Post::find($id);

            if (!isset($post->id) || empty($post->id)) {
                throw new Exception("Post not found.", BAD_REQUEST);
            }

            return ["status" => true, "data" => $post];
        } catch (Exception $exception) {
            return ["status" => false, "message" => $exception->getMessage(), "code" => $exception->getCode()];
        }
    }

    /*
     * remove user object
     * return void
     * */
    public function delete($id)
    {
        try {
            $post = Post::find($id);
            if (!isset($post->id) || empty($post->id)) {
                throw new Exception("Post not found.", BAD_REQUEST);
            }
            $post->delete();
            return ["status" => true, "message" => "Post removed successfully."];
        } catch (Exception $exception) {
            return ["status" => false, "message" => $exception->getMessage(), "code" => $exception->getCode()];
        }
    }

    /*
     * params Request
     * */
    public function createPost(array $data)
    {
        try {
            $validator = Validator::make($data, [
                "name" => "required|max:255",
                "user_id" => "required"
            ]);
            if ($validator->fails()) {
                throw new Exception(implode(",", $validator->errors()->all()), BAD_REQUEST);
            }

            $post = new Post();
            $post->name = $data['name'];
            $post->user_id = $data['user_id'];
            $post->save();
            return ["status" => true, "message" => "Post created successfully."];
        } catch (\Exception $e) {
            return ["status" => false, "message" => $e->getMessage(), "code" => $e->getCode()];
        }
    }

    /*
     * params Request
     * */
    public function updatePost(array $data)
    {
        try {
            $validator = Validator::make($data, [
                "name" => "required|max:255",
                "user_id" => "required"
            ]);
            if ($validator->fails()) {
                throw new Exception(explode(",", $validator->errors()->all()), BAD_REQUEST);
            }

            $post = Post::find($data['id']);

            if (!isset($post->id) || empty($post->id)) {
                throw new Exception("Post not found.", BAD_REQUEST);
            }

            if ($post->user_id != $data['user_id']) {
                throw new Exception("Permission dinned.", UNAUTHORIZED);
            }

            $post->name = $data['name'];
            $post->user_id = $data['user_id'];
            $post->save();
            return ["status" => true, "message" => "Post updated successfully."];
        } catch (\Exception $e) {
            return ["status" => false, "message" => $e->getMessage(), "code" => $e->getCode()];
        }
    }

    /*
     * params Request
     * */
    public function createComment(array $data)
    {
        try {
            $validator = Validator::make($data, [
                "body" => "required",
                "user_id" => "required",
                "post_id" => "required"
            ]);
            if ($validator->fails()) {
                throw new Exception(explode(",", $validator->errors()->all()), BAD_REQUEST);
            }

            $post = Post::find($data['post_id']);

            if (!isset($post->id) || empty($post->id)) {
                throw new Exception("Post not found.", BAD_REQUEST);
            }
            $comment = new Comment();
            $comment->user_id = $data['user_id'];
            $comment->body = $data['body'];
            $post->comments()->save($comment);
            return ["status" => true, "message" => "Comment created successfully."];
        } catch (\Exception $e) {
            return ["status" => false, "message" => $e->getMessage(), "code" => $e->getCode()];
        }
    }

    /*
     * params Request
     * */
    public function updateComment(array $data)
    {
        try {
            $validator = Validator::make($data, [
                "body" => "required",
                "user_id" => "required",
                "post_id" => "required"
            ]);
            if ($validator->fails()) {
                throw new Exception(explode(",", $validator->errors()->all()), BAD_REQUEST);
            }

            $comment = Comment::find($data['id']);
            if (!isset($comment->id) || empty($comment->id)) {
                throw new Exception("Post not found.", BAD_REQUEST);
            }
            $comment->body = $data['body'];
            $comment->user_id = $data['user_id'];
            $comment->save();
            return ["status" => true, "message" => "Comment updated successfully."];
        } catch (\Exception $e) {
            return ["status" => false, "message" => $e->getMessage(), "code" => $e->getCode()];
        }
    }
}