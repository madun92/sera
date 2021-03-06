<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\UnauthorizedException;

class PostController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Listing post
     * 
     * @OA\Get(
     *     path="/post",
     *     tags={"Post"},
     *     description="Home page",
     *     @OA\Response(response="default", description="listing post"),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *          @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/User")
     *         ),
     *     ),
     * )
     */
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->responseJson(false, Post::all(), "List Post");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            "title" => "required",
            "slug" => "required|unique:posts",
            "content" => ["required",function($attr, $val, $fail) {
                $max = 2;
                str_word_count($val) < $max ? $fail(__('validation.max',["attribute" => "$attr word length", "max" => "$max"])) : '';
                
            }],
        ]);
        $data['id'] = 1;
        $data = auth()->user()->posts()->create($data);
        return $this->responseJson(false, $data->makeHidden(["created_at"]), "Success add new Post");

    }

    /**
     * Show a post
     *
     * @OA\Get(
     *     path="/post/{postId}",
     *     tags={"Post"},
     *     operationId="showpost",
     *     @OA\Parameter(
     *         name="postId",
     *         in="path",
     *         description="ID of post to return",
     *         required=true,
     *         example="6129116617c8fef7ff49c890",
     *         @OA\Schema(
     *             type="string",
     *             format="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="post not found"
     *     ),
     * )
     */
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = DB::collection("posts")->select("id ","title", "slug","content")->where("_id",$id)->first();
    //     $data = DB::collection("posts")->raw((function($collection) {
    //         return $collection->aggregate([
    //           [
    //             '$lookup' => [
    //               'as' => 'user',
    //               'from' => 'users',
    //               'localField' => 'id',
    //               'foreignField'=> 'uid',
    //             ]
    //           ]
    //         ]);
    //    }));
        // $data = Post::find($id);
        // dd($data['_id']->__toString());
        if($data) {
            $data['id']     =  $data['_id']->__toString();
            $data = ["id" => $data['_id']->__toString() ] + $data;
            unset($data["_id"]);
            return $this->responseJson(false, $data, "Show Post");
        }
        abort(404);
    }

    /**
     * Update an existing post
     *
     * @OA\Put(
     *     path="/post",
     *     tags={"Post"},
     *     operationId="updatepost",
     *     @OA\Response(
     *         response=200,
     *         description="Success"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="post not found"
     *     ),
     *     security={
     *         {"bearerAuth": {"write:posts", "read:posts"}}
     *     },
     * )
     */
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id = null)
    {
        // dd($request->all());
        $request["id"] = $request->id ?? $id;
        $payload = $this->validate($request, [
            "id" => ["required","exists:posts,_id", function($attr, $val, $fail) {
                    auth()->user()->posts()->where('_id', $val)->exists() ? : $fail(__('you don\'t have permission to do this!'));
                }],
            "title" => "sometimes",
            "slug" => "sometimes|unique:posts,slug,".$request->id.",_id",
            "content" => "sometimes",
        ]);
        $data = Post::find($request->id)->fill($payload);
        if($data->isDirty()) {
            $data->save();
            return $this->responseJson(false, $data);
        }
        return $this->responseJson(true, [], "No Data changes!");
    }

    /**
     * Delete an existing post
     *
     * @OA\Delete(
     *     path="/post/{postId}",
     *     tags={"Post"},
     *     operationId="deletepost",
     *     @OA\Parameter(
     *         name="postId",
     *         in="path",
     *         description="ID of post",
     *         required=true,
     *         example="6129116617c8fef7ff49c890",
     *         @OA\Schema(
     *             type="string",
     *             format="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="post not found"
     *     ),
     *     security={
     *         {"bearerAuth": {}}
     *     },
     * )
     */
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = auth()->user()->posts()->find($id);
        if (!$post) {
            throw new UnauthorizedException("you don't have permission to do this.");
        }
        $post->delete();
        return $this->responseJson(false, [], "Delete post succesfully!");
    }

    //
}
