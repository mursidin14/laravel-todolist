<?php

namespace Tests\Feature;

use App\Services\TodoListService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Testing\Assert;

class TodoListServiceTest extends TestCase
{

    private TodoListService $todoListService;

    protected function setUp(): void
    {
        parent::setUp();

        DB::delete('delete from todos');

        $this->todoListService = $this->app->make(TodoListService::class);
    }

    public function testTodoListNotNull()
    {
        self::assertNotNull($this->todoListService);
    }

    public function testSaveTodo()
    {
        $this->todoListService->saveTodo('1', 'mursidin');

        $todolist = $this->todoListService->getTodoList();
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

        Assert::assertArraySubset($excepted, $this->todoListService->getTodoList());
    }

    public function testRemoveTodoList()
    {
        $this->todoListService->saveTodo('1', 'mursidin');
        $this->todoListService->saveTodo('2', 'asrul');

        self::assertEquals(2, sizeof($this->todoListService->getTodoList()));

        $this->todoListService->removeTodoList('3');
        self::assertEquals(2, sizeof($this->todoListService->getTodoList()));

        $this->todoListService->removeTodoList('1');
        self::assertEquals(1, sizeof($this->todoListService->getTodoList()));

        $this->todoListService->removeTodoList('2');
        self::assertEquals(0, sizeof($this->todoListService->getTodoList()));
    }
}
