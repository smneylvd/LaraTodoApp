<?php

namespace Tests\Unit;

use App\Models\Task;
use App\Models\User;
use App\Models\Status;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_belongs_to_user()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $task->user);
    }

    public function test_belongs_to_status()
    {
        $status = Status::factory()->create();
        $task = Task::factory()->create(['status_id' => $status->id]);

        $this->assertInstanceOf(Status::class, $task->status);
    }

    public function test_fillable()
    {
        $data = [
            'title' => 'Test Task',
            'description' => 'This is a test task',
            'user_id' => 1,
            'status_id' => 1,
        ];

        $task = new Task($data);

        $this->assertEquals($data['title'], $task->title);
        $this->assertEquals($data['description'], $task->description);
        $this->assertEquals($data['user_id'], $task->user_id);
        $this->assertEquals($data['status_id'], $task->status_id);
    }

    public function test_dates()
    {
        $task = Task::factory()->create();

        $this->assertInstanceOf(Carbon::class, $task->created_at);
        $this->assertInstanceOf(Carbon::class, $task->updated_at);
        $this->assertNull($task->deleted_at);
    }

}
