<?php

namespace Tests\Feature\Project;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Status;
use App\Models\Project;
use App\Models\User;

class EditProjectTest extends TestCase
{
    use RefreshDatabase;

    protected function startup()
    {
        $status = Status::create(['status' => 'Test']);
        $status = Status::create(['status' => 'Change To']);

        return Project::create([
            'project' => 'Project 1',
            'active' => 1,
            'status_id' => $status->id,
        ]);
    }

    /**
     * @test
     */
    public function guests_cannot_see_editproject()
    {
        $id = $this->startup()->id;

        $response = $this->get("/dashboard/projects/$id/edit");
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * @test
     */
    public function logged_in_users_can_edit_project()
    {
        $user = User::factory()->create();
        $id = $this->startup()->id;

        $response = $this->actingAs($user)
            ->get("/dashboard/projects/$id/edit");

        $response->assertStatus(200);
        $response->assertSee('Edit Project');
        $response->assertSee('<form method="post" action="'.route('projects.update',['project' => $id]).'">',false);
        $response->assertSee('<input type="hidden" name="_method" value="put">',false);
        $response->assertViewHas('statuses');
        $response->assertSee('<option value="1">Test</option>', false);
        $response->assertSee('<option value="2">Change To</option>', false);
    }

    /**
     * @test
     */
    public function submit_empty_form_returns_validation_errors()
    {
        $user = User::factory()->create();
        $project = $this->startup();

        $data = [
            'id' => '',
            'name' => '',
            'active' => '',
            'status' => '',
        ];

        $response = $this->actingAs($user)
            ->put(route('projects.update',['project' => $project->id]), $data);


        $response->assertStatus(302);
        $response->assertRedirect();
        $response->assertSessionHasErrors();

        $errors = session('errors');

        $this->assertEquals('The id field is required.', ($errors->get('id'))[0]);
        $this->assertEquals('The name field is required.', ($errors->get('name'))[0]);
        $this->assertEquals('The active field is required.', ($errors->get('active'))[0]);
        $this->assertEquals('The status field is required.', ($errors->get('status'))[0]);
    }

    /**
     * @test
     */
    public function required_active_field_must_be_boolean()
    {
        $user = User::factory()->create();
        $project = $this->startup();
        $s = Status::first();
        $active = ['abc', 3];

        foreach($active as $a) {
            $data = [
                'id'=> $project->id,
                'name' => 'Project 1',
                'active' => $a,
                'status' => $s->id,
            ];

            $response = $this->actingAs($user)
            ->put(route('projects.update',['project' => $project->id]), $data);

            $response->assertStatus(302);
            $response->assertRedirect();
            $response->assertSessionHasErrors();

            $errors = session('errors');

            $response->assertSessionDoesntHaveErrors(['status', 'name','id']);
            $this->assertEquals('The active field must be true or false.', ($errors->get('active'))[0]);
        }
    }

    /**
     * @test
     */
    public function required_status_field_must_be_existing_status_integer()
    {
        $user = User::factory()->create();
        $project = $this->startup();
        $status = [
            'abc' => 'The status must be an integer.',
            3 => 'The selected status is invalid.',
        ];

        foreach($status as $a => $error) {
            $data = [
                'id' => $project->id,
                'name' => 'Project 1',
                'active' => 1,
                'status' => $a,
            ];

            $response = $this->actingAs($user)
            ->put(route('projects.update',['project' => $project->id]), $data);

            $response->assertStatus(302);
            $response->assertRedirect();
            $response->assertSessionHasErrors();

            $errors = session('errors');

            $response->assertSessionDoesntHaveErrors(['active', 'name','id']);
            $this->assertEquals($error, ($errors->get('status'))[0]);
        }
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
                'name' => 'Project 1',
                'active' => $project->active,
                'status' => $project->status_id,
            ];

            $response = $this->actingAs($user)
            ->put(route('projects.update',['project' => $project->id]), $data);

            $response->assertStatus(302);
            $response->assertRedirect();
            $response->assertSessionHasErrors();

            $errors = session('errors');

            $response->assertSessionDoesntHaveErrors(['active', 'name','status']);
            $this->assertEquals($error, ($errors->get('id'))[0]);
        }
    }

    /**
     * @test
     */
    public function submit_form_returns_no_validation_errors()
    {
        $user = User::factory()->create();
        $project = $this->startup();

        $data = [
                'id' => $project->id,
                'name' => $project->project,
                'active' => $project->active,
                'status' => $project->status_id,
            ];

        $response = $this->actingAs($user)
            ->put(route('projects.update',['project' => $project->id]), $data);

        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
    }

    /**
     * @test
     */
    public function submit_form_redirects_to_project_list_with_edited_project()
    {
        $user = User::factory()->create();
        $project = $this->startup();
        $status = Status::orderBy('id','asc')->first();

        $data = [
            'id' => $project->id,
            'name' => 'Changed Project',
            'active' => 0,
            'status' => $status->id,
        ];

        $response = $this->actingAs($user)
            ->put(route('projects.update',['project' => $project->id]), $data);

        $response->assertRedirect(route('projects.list'));
        $response->assertSessionHas('success','Updated project successfully.');

        $changed = Project::find($project->id);

        $this->assertNotEquals($project->project, $changed->project);
        $this->assertNotEquals($project->active, $changed->active);
        $this->assertNotEquals($project->status_id, $changed->status_id);

        $this->assertEquals($data['name'],$changed->project);
        $this->assertEquals($data['status'],$changed->status_id);
        $this->assertEquals($data['active'],$changed->active);

    }

}
