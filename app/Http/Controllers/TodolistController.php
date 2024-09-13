<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoRequest;
use App\Services\TodolistService;
use Illuminate\Http\Request;

class TodolistController extends Controller
{
    public function __construct(private TodolistService $todolistService){}
    // tampilkan halaman
    public function todolistPage(Request $request){
        $todolist = $this->todolistService->getTodolist(); // array
        return response()->view("todolist.todolist",[
            "title" => "Todolist",
            "todolist" => $todolist
        ]);
    }

    public function addTodo(TodoRequest $request){

        // validasi data input todo
        $data = $request->validated();
        $todo = $data["todo"];

        // buat uniq id
        $this->todolistService->saveTodo(uniqid(),$todo);
        return redirect()->action([TodolistController::class, "todolistPage"]); // balik lagi ke halaman todolist
    }

    public function removeTodo(Request $request, string $todoId){
        $this->todolistService->removeTodo($todoId);
        return redirect()->action([TodolistController::class, "todolistPage"]);
    }
}
