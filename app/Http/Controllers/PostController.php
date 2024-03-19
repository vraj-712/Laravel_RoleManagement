<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Exception;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){
        return view('frontpanel.posts.index')->with('posts',Post::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(){
        return view('frontpanel.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request){
        try{

            $imageName = '';
            if($request->hasFile('image')){
                $imageName = time() . '.' . $request->image->extension();
                $request->image->move(public_path('images'), $imageName);
            }
            Post::create([
                'title' => $request->title,
                'content' => $request->content,
                'user_id' => auth()->user()->id,
                'image' => $imageName,
            ]);
            return redirect()->route('post.index')->with('success', 'Post Created Successfully');
        }catch (Exception $e) {
            return $e->getMessage();
        }
    }
    
    /**
     * Display the specified resource.
     */
    public function show(Post $post){
        return view('frontpanel.posts.show',compact('post'));
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post){
        return view('frontpanel.posts.edit',compact('post'));
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post){
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
                'user_id' => auth()->user()->id,
                'image' => $imageName,
            ]);
            return redirect()->route('post.index')->with('success', 'Post Updated Successfully');
        }catch (Exception $e) {
            return $e->getMessage();
        }
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post){
        try{

            $post->delete();
            return redirect()->route('post.index')->with('success', 'Post Deleted Successfully');
        }catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
