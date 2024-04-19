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
        $todo = $request->input('todo');

        if(empty($todo)){
            $todoList = $this->todoListService->getTodoList();
            return response()->view('todolis.todolist', [
                'title' => 'TodoList',
                'todolist' => $todoList,
                'error' => 'Todo is required'
            ]);
        }

        $this->todoListService->saveTodo(uniqid(), $todo);

        return redirect()->action([TodoListController::class, 'todoList']);
    }

    public function removeTodoList(Request $request, string $todoId)
    {

    }
}
