<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use Illuminate\Http\Request;
use Exception;
use App\Repositories\Post\PostRepository as PostRepository;

class PostController extends Controller
{
    protected $post;

    public function __construct(PostRepository $post)
    {
        $this->post = $post;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $posts = $this->post->getAll();
            return view("post.index", ["posts" => $posts]);
        } catch (Exception $e) {
            return redirect()->route('home')->withError($e->getMessage());
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $post = new Post();
            return view("post.form", ["post" => $post]);
        } catch (Exception $e) {
            return redirect()->route('posts')->withError($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $input = $request->all();
            $input['user_id'] = auth()->user()->id;
            if (isset($request->id) && !empty($request->id)) {
                $post = $this->post->updatePost($input);

                if (!$post['status']) {
                    throw new Exception($post['message'], $post['code']);
                }
            } else {
                $post = $this->post->createPost($input);
                if (!$post['status']) {
                    throw new Exception($post['message'], $post['code']);
                }
            }
            return redirect()->route('posts')->withSuccess($post['message']);
        } catch (Exception $e) {
            return redirect()->back()->withError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id = 0)
    {
        try {
            if (empty($id)) {
                throw new Exception("Invalid request");
            }
            $post = $this->post->find($id);
            if (!$post['status']) {
                throw new Exception($post['message'], $post['code']);
            }
            return view('post.show', ['post' => $post['data']]);
        } catch (Exception $e) {
            return redirect()->route('posts')->withError($e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id = 0)
    {
        try {
            if (empty($id)) {
                throw new Exception("Invalid request");
            }
            $post = $this->post->find($id);
            if (!$post['status']) {
                throw new Exception($post['message'], $post['code']);
            }

            return view("post.form", ["post" => $post['data']]);
        } catch (Exception $e) {
            return redirect()->route('posts')->withError($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        try {
            if (!$request->ajax()) {
                throw new Exception("Not valid request.");
            }

            if (empty($id)) {
                throw new Exception("Invalid input.");
            }

            $post = $this->post->delete($id);
            if (!$post['status']) {
                throw new Exception($post['message'], $post['code']);
            }

            return response()->Json(["isSuccess" => "success", "message" => $post['message']]);
        } catch (Exception $e) {
            return response()->Json(["isSuccess" => "failure", "message" => $e->getMessage()]);
        }
    }


    public function comment($id = 0)
    {
        try {
            if (empty($id)) {
                throw new Exception("Invalid request");
            }
            $post = $this->post->find($id);
            if (!$post['status']) {
                throw new Exception($post['message'], $post['code']);
            }
            $comment = new Comment();
            return view("comment.form", ["post" => $post['data'], "comment" => $comment]);
        } catch (Exception $e) {
            return redirect()->route('posts')->withError($e->getMessage());
        }
    }

    public function editComment($id = 0)
    {
        try {
            if (empty($id)) {
                throw new Exception("Invalid request");
            }
            $comment = Comment::find($id);
            if (!isset($comment->id) || empty($comment->id)) {
                throw new Exception("Post not found.", BAD_REQUEST);
            }
            return view("comment.form", ["post" => $comment->post, "comment" => $comment]);
        } catch (Exception $e) {
            return redirect()->route('posts')->withError($e->getMessage());
        }
    }

    public function storeComment(Request $request)
    {
        try {
            $data = $request->all();
            $data['user_id'] = auth()->user()->id;

            if (isset($request->id) && !empty($request->id)) {
                $comment = $this->post->updateComment($data);
            } else {
                $comment = $this->post->createComment($data);
            }
            if (!$comment['status']) {
                throw new Exception($comment['message'], $comment['code']);
            }
            return redirect()->route('post.show', $data['post_id'])->withSuccess($comment['message']);
        } catch (Exception $e) {
            return redirect()->back()->withError($e->getMessage());
        }
    }
}
