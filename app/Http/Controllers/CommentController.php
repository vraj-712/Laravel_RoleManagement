<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('frontpanel.comments.index')->with('comments',Comment::all());
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
        Comment::create([
            'user_id' => auth()->user()->id,
            'post_id' => $request->post_id,
            'comment' => $request->comment,
            'parent_id' => $request->parent_id ?? null,
        ]);
        return redirect()->route('post.show',$request->post_id)->with('success','Commented Added Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        Comment::where('id',$comment->id)->orWhere('parent_id',$comment->id)->delete();
        return redirect()->route('comment.index')->with('success', 'Comment Deleted Successfully');
    }
    public function approveComment(Comment $comment){
        $comment->status = !$comment->status;
        $comment->save();
        return redirect()->route('comment.index')->with('success', 'Comment Status Updated');
    }
}
