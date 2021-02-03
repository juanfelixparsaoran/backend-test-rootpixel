<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\Result;
use App\Http\Resources\ResultCollection;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return User::all();
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
        $model = User::create($request->all());
        $request->session()->put('username', $model->username);
        $request->session()->put('id', $model->id);

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
        $model = User::find($id);
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
        $model = User::find($id);
        if ($model != null){
            $model->fill($request->all())->save();
            return response()->json([
                'data' => $model,
                'message' => 'update succed'
            ]);
        }else{
            return response()->json([
                'message' => 'update failed, user not found'
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
    }

    public function login(Request $request){
        $model = User::where('username', $request->username)->where('password',$request->password)->first();
        if ($model != null){
            config(['session.lifetime' => 35791394]);
            $request->session()->put('id',$model->id);
            $request->session()->put('username', $request->username);
        }
        return response()->json([
            'data' => $model,
            'session' => $request->session()->get('username')
        ]);
    }

    public function checkAuth(Request $request){
        
        if ($request->session()->has('username')){
            $model = User::where('username',$request->session()->get('username'))->first();
            return response()->json([
                'message' => 'logged in',
                'data' => $model
            ],200);
        }else{
            return response()->json([
                'message' => 'not logged in',
                'data' => $request->session()->get('id')
            ],400);
        }
    }

    public function logout(Request $request){
        $request->session()->forget('username');
        $request->session()->forget('id');
        return response()->json([
            'message' => 'logout'
        ]);
    }

    public function checkUsername(Request $request){
        $model = User::where('username', $request->username)->first();
        if ($model != null){
            return response()->json([
                'data' => 'Not Available'
            ]);
        }else{
            return response()->json([
                'data' => 'Available'
            ]);
        }
    }
}
