<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class ApiPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $posts =  PostResource::collection(Post::all());
        return response()->json([
                "status" => 200,
                "data" => $posts
                ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $user = auth('sanctum')->user();
            if(!$user){
                return response()->json([
                    'status' => 401,
                    'message' => 'Unauthorized Request'
                ]);
            }
            $imageName = '';
                if($request->hasFile('image')){
                    $imageName = time() . '.' . $request->image->extension();
                    $request->image->move(public_path('images'), $imageName);
                }
            


            $post =  Post::create([
                    'title' => $request->title,
                    'content' => $request->content,
                    'user_id' => $user->id,
                    'image' => $imageName,
                ]);
            $post = new PostResource($post);
            return response()->json([
                "status" => 200,
                "data" => $post,
                "message" => "Post Added SuccessFully",
            ]);
        }catch(Exception $e){
            return response()->json([
                "status" => 500,
                "message" => $e->getMessage(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        
        return response()->json([
            "status" => 200,
            "data" => new PostResource($post)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        
        try{
            $user = auth('sanctum')->user();
            if(!$user){
                return response()->json([
                    'status' => 401,
                    'message' => 'Unauthorized Request'
                ]);
            }
            if(!($user->id == $post->user_id)){

                return response()->json([
                    'status' => 401,
                    'message' => 'Unauthorized Request'
                ]);
                
            }
            $imageName = $post->image;
                if(file_exists(public_path('images').'/'.$post->image)  && $request->image != ''){
                    unlink(public_path('images').'/'.$post->image);
                    $imageName = time() . '.' . $request->image->extension();
                    $request->image->move(public_path('images'), $imageName);
                }
        
                $post->update([
                    'title' => $request->title ?? $post->title,
                    'content' => $request->content ?? $post->content,
                    'user_id' => $user->id,
                    'image' => $imageName ?? $post->image,
                ]);
                return response()->json([
                    "status" => 200,
                    "message" => "Post Updated SuccessFully",
                ]);
        }catch(Exception $e){
            return response()->json([
                "status" => 500,
                "message" => $e->getMessage(),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        try{
            $user = auth('sanctum')->user();
            if(!($user->id == $post->user_id)){

                return response()->json([
                    'status' => 401,
                    'message' => 'Unauthorized Request'
                ]);
                
            }
            $post->delete();
            return response()->json([
                "status" => 200,
                "message" => "Post Deleted SuccessFully",
            ]);
        }catch(Exception $e){
            return response()->json([
                "status" => 500,
                "message" => $e->getMessage(),
            ]);
        }
    }
}
