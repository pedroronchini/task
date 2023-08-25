<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * 
     */
    use RefreshDatabase;

    public function test_user_can_be_created()
    {
      $data = [
        'name' => 'John Doe',
        'email' => 'test@test.com',
        'password' => 'password'
      ];

      $response = $this->post('/api/users', $data);

      $response->assertStatus(201);
    }

    public function test_user_list() {
      User::factory()->count(1)->create();

      $response = $this->get('/api/users');

      $response->assertStatus(200)
        ->assertJsonCount(1);
    }
}