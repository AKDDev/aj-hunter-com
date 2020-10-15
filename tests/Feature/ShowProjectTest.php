<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Status;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShowProjectTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function guests_can_view_project()
    {
        $status = Status::create(['status' => 'Test']);

        $project = Project::create([
            'project' => 'Project 1',
            'active' => 1,
            'status_id' => $status->id,
        ]);

        $response = $this->get(route('projects.show', ['project' => $project->id]));

        $response->assertStatus(200);
        $response->assertSee('Project 1');
        $response->assertSee('Test');
    }

    /**
    * @test
    */
   public function display_error_when_project_does_not_exist()
   {
       $response = $this->get(route('projects.show', ['project' => 1]));

       $response->assertStatus(404);
       $response->assertSee('The page you are looking for cannot be found.');
   }

    /**
     * @test
     */
    public function logged_in_user_can_view_project()
    {
        $user = User::factory()->create();
        $status = Status::create(['status' => 'Test']);

        $project = Project::create([
            'project' => 'Project 1',
            'active' => 1,
            'status_id' => $status->id,
        ]);

        $response = $this->actingAs($user)->get(route('projects.show', ['project' => $project->id]));

        $response->assertStatus(200);
        $response->assertSee('Project 1');
        $response->assertSee('Test');
    }
}
