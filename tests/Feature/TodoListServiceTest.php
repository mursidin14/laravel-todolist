<?php

namespace Tests\Feature;

use App\Services\TodoListService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class TodoListServiceTest extends TestCase
{

    private TodoListService $todoListService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->todoListService = $this->app->make(TodoListService::class);
    }

    public function testTodoListNotNull()
    {
        self::assertNotNull($this->todoListService);
    }

    public function testSaveTodo()
    {
        $this->todoListService->saveTodo('1', 'mursidin');

        $todolist = Session::get('todolist');
        foreach($todolist as $value){
            self::assertEquals('1', $value['id']);
            self::assertEquals('mursidin', $value['todo']);
        }
    }

    public function testGetTodoListEmpty()
    {
        self::assertEquals([], $this->todoListService->getTodoList());
    }

    public function testGetTodoListNotEmpty()
    {
        $excepted = [
            [
                'id' => '1',
                'todo' => 'mursidin'
            ],
            [
                'id' => '2',
                'todo' => 'asrul'
            ]
        ];

        $this->todoListService->saveTodo('1', 'mursidin');
        $this->todoListService->saveTodo('2', 'asrul');

        self::assertEquals($excepted, $this->todoListService->getTodoList());
    }
}
