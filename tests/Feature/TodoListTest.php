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

    public function test_should_fail_fetch_single_todo_list()
    {
        $this->withExceptionHandling();
        $this->getJson(route('todo-lists.show', 2))
            ->assertSee('No query results');
    }

    public function test_store_single_todo_list()
    {
        $todo_list_array = TodoList::factory()->make();
        $response = $this->postJson(route('todo-lists.store'), ['title' => $todo_list_array->title])
            ->assertCreated()
            ->json();

        $this->assertEquals($todo_list_array->title, $response['title']);
        $this->assertDatabaseHas('todo_lists', ['title' => $todo_list_array->title]);
    }

    public function test_should_fail_store_todo_list()
    {
        $this->withExceptionHandling();
        $response = $this->postJson(route('todo-lists.store'))
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['title']);

        $response->assertSee('The given data was invalid.');
    }

    public function test_delete_todo_list()
    {
        $this->deleteJson(route('todo-lists.destroy', $this->todo_list->id))
            ->assertNoContent();

        $this->assertDatabaseMissing('todo_lists', ['title' => $this->todo_list->title]);
    }

    public function test_update_todo_list()
    {
        $this->putJson(route('todo-lists.update', $this->todo_list->id), ['title' => 'Updated title!'])
            ->assertOk();

        $this->assertDatabaseHas('todo_lists', ['id' => $this->todo_list->id, 'title' => 'Updated title!']);
    }

    public function test_should_fail_update_todo_list()
    {
        $this->withExceptionHandling();
        $response = $this->putJson(route('todo-lists.update', $this->todo_list->id))
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['title']);

        $response->assertSee('The given data was invalid.');
    }
}