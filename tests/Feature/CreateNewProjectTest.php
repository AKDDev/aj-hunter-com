<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Project;
use App\Models\Status;

class CreateNewProjectTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function guests_cannot_see_add_new_project()
    {
        $response = $this->get('/dashboard/projects/create');
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * @test
     */
    public function logged_in_users_can_add_new_project()
    {
        $user = User::factory()->create();
        Status::create(['status' => 'First Draft']);
        Status::create(['status' => 'Revising']);
        Status::create(['status' => 'Published']);
        Status::create(['status' => 'Arcived']);

        $response = $this->actingAs($user)
            ->get('/dashboard/projects/create');

        $response->assertStatus(200);
        $response->assertSee('Add New Project');
        $response->assertSee('<form method="post" action="'.route('projects.store').'">',false);
        $response->assertViewHas('statuses');
    }
}
