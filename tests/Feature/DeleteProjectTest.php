<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Project;
use App\Models\Status;

class DeleteProjectTest extends TestCase
{
    use RefreshDatabase;

    protected function startup()
    {
        $status = Status::create(['status' => 'Test']);

        return Project::create([
            'project' => 'Project 1',
            'active' => 1,
            'status_id' => $status->id,
        ]);
    }

    /**
     * @test
     */
    public function cannot_delete_if_guest()
    {
        $id = $this->startup()->id;

        $response = $this->delete("/dashboard/projects/$id");
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * @test
     */
    public function required_id_field_must_be_existing_project_integer()
    {
        $user = User::factory()->create();
        $project = $this->startup();
        $ids = [
            'abc' => 'The id must be an integer.',
            3 => 'The selected id is invalid.',
        ];

        foreach($ids as $a => $error) {
            $data = [
                'id' => $a,
            ];

            $response = $this->actingAs($user)
            ->delete(route('projects.delete',['project' => $project->id]), $data);

            $response->assertStatus(302);
            $response->assertRedirect();
            $response->assertSessionHasErrors();

            $errors = session('errors');

            $this->assertEquals($error, ($errors->get('id'))[0]);
        }
    }

    /**
     * @test
     */
    public function logged_in_user_can_delete_project()
    {
        $user = User::factory()->create();
        $id = $this->startup()->id;

        $data = [
            'id' => $id,
        ];

        $response = $this->actingAs($user)
            ->delete(route('projects.delete',['project' => $id]), $data);

        $response->assertStatus(302);
        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
    }

    /**
     * @test
     */
    public function soft_delete_project_valid()
    {
        $user = User::factory()->create();
        $id = $this->startup()->id;

        $data = [
            'id' => $id,
        ];

        $response = $this->actingAs($user)
            ->delete(route('projects.delete',['project' => $id]), $data);

        $project = Project::find($id);
        $this->assertEmpty($project);

        $project = Project::findWithTrashed($id);
        $this->assertNotEmpty($project->first()->deleted_at);
    }
}
