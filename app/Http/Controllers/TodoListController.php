<?php

namespace App\Http\Controllers;

use App\Services\TodoListService;
use Illuminate\Http\Request;

class TodoListController extends Controller
{
    private TodoListService $todoListService;

    public function __construct(TodoListService $todoListService)
    {
        $this->todoListService = $todoListService;
    }

    public function todoList(Request $request)
    {
        $todoList = $this->todoListService->getTodoList();
        return response()->view('todolist.todolist', [
            'title' => 'TodoList',
            'todolist' => $todoList
        ]);
    }

    public function addTodoList(Request $request)
    {

    }

    public function removeTodoList(Request $request, string $todoId)
    {

    }
}
