<?php

namespace App\Http\Controllers;

use App\Models\TodoList;
use Illuminate\Http\Request;
use App\Http\Requests\TodoListRequest;
use Symfony\Component\HttpFoundation\Response;

class TodoListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $todo_lists = TodoList::all();

        return response()->json($todo_lists, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  TodoListRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TodoListRequest $request)
    {
        $todo_list = TodoList::create($request->all());
        return response()->json($todo_list, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TodoList  $todoList
     * @return \Illuminate\Http\Response
     */
    public function show(TodoList $todoList)
    {
        return response()->json($todoList);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  TodoListRequest  $request
     * @param  \App\Models\TodoList  $todoList
     * @return \Illuminate\Http\Response
     */
    public function update(TodoListRequest $request, TodoList $todoList)
    {
        $todo_list = $todoList->update($request->all());
        return response()->json($todo_list);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TodoList  $todoList
     * @return \Illuminate\Http\Response
     */
    public function destroy(TodoList $todoList)
    {
        $todoList->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}