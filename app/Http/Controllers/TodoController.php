<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $todos=Todo::paginate(10);
        return $todos;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $todo=Todo::create([
            'created_by'=>$request->id,
            'body'=>$request->body,
            'title'=>$request->title
        ]);
        return response()->json([
            'message'=>'creadted is successfully'
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function show(Todo $todo)
    {
        return $todo;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Todo $todo)
    {
        $todo->update($request->all());


        return response()->json([
           'message'=>'item has updated successfully'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Todo $todo)
    {
        $todo->delete();
        return response()->json([
            'message'=>'Deleted is succesfull'
        ],200);
    }
    public function myTodos($id){
       $todos=User::find($id)->todos()->paginate(2);
       return $todos;
    }
    public function search($serach){
        $result=Todo::search($serach)->paginate(10);
        return $result;
    }
}
