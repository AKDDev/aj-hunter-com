<?php

namespace Tests\Feature\Status;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Status;

class StatusTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function guests_cannot_see_status_list()
    {
        $response = $this->get('/dashboard/statuses');
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * @test
     */
    public function logged_in_users_can_see_status_list()
    {
        $user = User::factory()->create();
        $status = Status::create(['status' => 'Test']);
        $status = Status::create(['status' => 'Completed']);


        $response = $this->actingAs($user)
            ->get('/dashboard/statuses');

        $response->assertStatus(200);
        $response->assertSee('Statuses');
        $response->assertViewHas('statuses');
        $response->assertSee('Completed');
        $response->assertSee('Test');
    }

    /**
     * @test
     */
    public function empty_status_list_displays_message()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get('/dashboard/statuses');

        $response->assertStatus(200);
        $response->assertSee('There are no statuses at this time.');
    }
}
