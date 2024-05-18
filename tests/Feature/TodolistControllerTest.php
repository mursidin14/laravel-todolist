<?php

namespace Tests\Feature;

use Database\Seeders\TodoSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;

class TodolistControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        DB::delete('delete from todos');
    }

    public function testTodoList()
    {

        $this->seed(TodoSeeder::class);

        $this->withSession([
            'username' => 'mursidin',
            'todolist' => [
                'id' => '1',
                'todo' => 'asrul'
            ]
        ])->get('/todolist')
        ->assertSeeText('1')->assertSeeText('asrul');
    }

    public function testTodoListFiled()
    {
        $this->withSession([
            'username' => 'mursidin'
        ])->post('/todolist', [])
          ->assertSeeText('Todo is required');
    }

    public function testAddTodoSuccess()
    {
        $this->withSession([
            'username' => 'mursidin'
        ])->post('/todolist', [
            'todo' => 'asrul'
        ])->assertRedirect('/todolist');
    }

    public function testRemoveTodoList()
    {
        $this->withSession([
            'username' => 'mursidin',
            'todolist' => [
                'id' => '1',
                'todo' => 'asrul'
            ],
            [
                'id' => '2',
                'todo' => 'anca'
            ]
        ])->post('/todolist/1/delete')
          ->assertRedirect('/todolist');
    }
}
