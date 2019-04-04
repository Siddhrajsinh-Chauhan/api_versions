<?php 
namespace App\Repositories\Post;

use Illuminate\Http\Request;

interface PostInterface {
    public function getAll($params = "*");
    public function getMyPost($params = "*", $flag = true);
    public function find($id);
    public function delete($id);
    public function createPost(array $data);
    public function updatePost(array $data);
    public function createComment(array $data);
    public function updateComment(array $data);
}
