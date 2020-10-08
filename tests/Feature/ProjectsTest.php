<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Project;
use App\Models\Status;

class ProjectsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function guests_cannot_see_project_list()
    {
        $response = $this->get('/dashboard/projects');
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * @test
     */
    public function logged_in_users_can_see_project_list()
    {
        $user = User::factory()->create();
        $status = Status::create(['status' => 'Test']);
        Project::create([
            'project' => 'Project 1',
            'active' => true,
            'status_id' => $status->id,
        ]);
        Project::create([
            'project' => 'Project 2',
            'active' => true,
            'status_id' => $status->id,
        ]);

        $response = $this->actingAs($user)
            ->get('/dashboard/projects');

        $response->assertStatus(200);
        $response->assertSee('Projects');
        $response->assertViewHas('projects');
        $response->assertSee('Project 1');
        $response->assertSee('Test');
    }
}
