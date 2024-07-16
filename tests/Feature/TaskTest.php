<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    protected $user;
    protected function setUp(): void
    {
        parent::setUp();

        // Create a user for authentication
        $this->user = User::factory()->create();
    }

    public function testStoreTasks()
    {

        Task::factory()->count(5)->create();

        $response = $this->actingAs($this->user, 'sanctum')->postJson('/api/v1/tasks', [
            'title' => 'Test Task',
            'description' => 'Test description',
            'status' => 'in_progress',
            'deadline' => '2024-12-31',
        ]);

        $response->assertStatus(201);
    }

    public function testListTasks()
    {
        $response = $this->actingAs($this->user, 'sanctum')->getJson('/api/v1/tasks');
        $response->assertStatus(200);
    }

    public function testUpdateTask()
    {
        $task = Task::limit(1)->value('id');

        $response = $this->actingAs($this->user, 'sanctum')->putJson("/api/v1/tasks/update/$task", [
            'title' => 'Updated Task',
            'description' => 'Updated description',
            'status' => 'completed',
            'deadline' => '2024-12-31',
        ]);

        $response->assertStatus(200);
    }

    public function testDeleteTask()
    {
        $task = Task::limit(1)->value('id');

        $response = $this->actingAs($this->user, 'sanctum')->delete("/api/v1/tasks/delete/$task");
        $response->assertStatus(200);
    }
}
