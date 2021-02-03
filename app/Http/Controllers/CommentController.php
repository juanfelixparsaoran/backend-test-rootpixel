<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    //
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Comment::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $model = Comment::create($request->all());
        $post_model = Post::find($request->post_id);
        $post_model->comment = $post_model->comment + 1;
        $post_model->save();
        return response()->json([
            'data' => $model
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $model = Comment::find($id);
        return response()->json([
            'data' => $model
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $model = Comment::find($id);
        if ($model != null){
            $model->fill($request->all())->save();
            return response()->json([
                'data' => $model,
                'message' => 'update succed'
            ]);
        }else{
            return response()->json([
                'message' => 'update failed, post not found'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $model = Comment::destroy($id);
        return response()->json([
            'message' => "deleted"
        ]);
    }

    public function postcomment($id){
        $model = Comment::where('post_id',$id)->get();
        return response()->json([
            'data' => $model
        ]);
    }
}
