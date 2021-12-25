<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\TodoList;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TodoListTest extends TestCase
{
    use RefreshDatabase;
    private $todo_list = null;

    public function setUp(): void
    {
        parent::setUp();
        $this->todo_list = TodoList::factory()->create();
    }

    public function test_fetch_all_todo_list()
    {
        $response = $this->getJson(route('todo-lists.index'))
            ->assertOk()
            ->json();
        $this->assertEquals(1, count($response));
    }

    public function test_fetch_single_todo_list()
    {
        $response = $this->getJson(route('todo-lists.show', $this->todo_list->id))
            ->assertOk()
            ->json();
        $this->assertEquals($response['title'], $this->todo_list->title);
    }

    public function test_fail_fetch_single_todo_list()
    {
        $this->withExceptionHandling();
        $this->getJson(route('todo-lists.show', 2))
            ->assertSee('No query results');
    }
}