<?php

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase 
{
  use RefreshDatabase;

  public function test_a_task_can_be_created()
  {
    $data = [
      'title' => 'Test Task',
      'description' => 'Test Description',
      'completed' => false,
      'user_id' => 1
    ];

    $response = $this->post('/api/tasks', $data);

    $response->assertStatus(201);
  }

  public function test_a_task_can_be_listed()
  {
    Task::factory()->count(1)->create();

    $response = $this->get('/api/tasks');

    $response->assertStatus(200)
      ->assertJsonCount(1);
  }
}