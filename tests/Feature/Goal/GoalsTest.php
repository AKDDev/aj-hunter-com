<?php

namespace Tests\Feature\Goal;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Goal;
use App\Models\Status;

class GoalsTest extends TestCase
{
    use RefreshDatabase;

    protected function startup()
    {
        $status = Status::create(['status' => 'test']);
    }

    /**
     * @test
     */
    public function guests_cannot_see_goal_list()
    {
        $response = $this->get('/dashboard/goals');
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * @test
     */
    public function logged_in_users_can_see_goal_list()
    {
        $user = User::factory()->create();
        $this->setup();

        $response = $this->actingAs($user)
            ->get('/dashboard/goals');

        $response->assertStatus(200);
        $response->assertSee('Goals');
        $response->assertViewHas('goals');
    }

    /**
     * @test
     */
    public function empty_goal_list_displays_message()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get('/dashboard/goals');

        $response->assertStatus(200);
        $response->assertSee('There are no goals at this time.');
    }
}
