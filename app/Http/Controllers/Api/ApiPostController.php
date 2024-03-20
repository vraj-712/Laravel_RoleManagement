<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Auth;

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
            $imageName = '';
                if($request->hasFile('image')){
                    $imageName = time() . '.' . $request->image->extension();
                    $request->image->move(public_path('images'), $imageName);
                }
             Post::create([
                    'title' => $request->title,
                    'content' => $request->content,
                    'user_id' => 5,
                    'image' => $imageName,
                ]);
            return response()->json([
                "status" => 200,
                "message" => "Post Added SuccessFully",
            ]);
        }catch(\Exception $e){
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
            "data" => $post
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

            $imageName = $post->image;
                if(file_exists(public_path('images').'/'.$post->image)  && $request->image != ''){
                    unlink(public_path('images').'/'.$post->image);
                    $imageName = time() . '.' . $request->image->extension();
                    $request->image->move(public_path('images'), $imageName);
                }
        
                $post->update([
                    'title' => $request->title,
                    'content' => $request->content,
                    'user_id' => 5,
                    'image' => $imageName,
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
