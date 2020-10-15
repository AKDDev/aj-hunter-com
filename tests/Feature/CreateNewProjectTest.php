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
        Status::create(['status' => 'Archived']);

        $response = $this->actingAs($user)
            ->get('/dashboard/projects/create');

        $response->assertStatus(200);
        $response->assertSee('Add New Project');
        $response->assertSee('<form method="post" action="'.route('projects.store').'">',false);
        $response->assertViewHas('statuses');
        $response->assertSee('<option value="1">First Draft</option>', false);
        $response->assertSee('<option value="2">Revising</option>', false);
        $response->assertSee('<option value="3">Published</option>', false);
        $response->assertSee('<option value="4">Archived</option>', false);
    }

    /**
     * @test
     */
    public function submit_empty_form_returns_validation_errors()
    {
        $user = User::factory()->create();

        $data = [
            'name' => '',
            'active' => '',
            'status' => '',
        ];

        $response = $this->actingAs($user)
            ->post(route('projects.store'),$data);

        $response->assertStatus(302);
        $response->assertRedirect();
        $response->assertSessionHasErrors();

        $errors = session('errors');

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
        $s = Status::create(['status' => 'Test']);
        $active = ['abc','3'];

        foreach($active as $a) {
            $data = [
                'name' => 'Project 1',
                'active' => $a,
                'status' => $s->id,
            ];

            $response = $this->actingAs($user)
                ->post(route('projects.store'), $data);

            $response->assertStatus(302);
            $response->assertRedirect();
            $response->assertSessionHasErrors();

            $errors = session('errors');

            $response->assertSessionDoesntHaveErrors(['status', 'name']);
            $this->assertEquals('The active field must be true or false.', ($errors->get('active'))[0]);
        }
    }

    /**
     * @test
     */
    public function required_status_field_must_be_existing_status_integer()
    {
        $user = User::factory()->create();
        $s = Status::create(['status' => 'Test']);
        $status = [
            'abc' => 'The status must be an integer.',
            3 => 'The selected status is invalid.',
        ];

        foreach($status as $a => $error) {
            $data = [
                'name' => 'Project 1',
                'active' => 1,
                'status' => $a,
            ];

            $response = $this->actingAs($user)
                ->post(route('projects.store'), $data);

            $response->assertStatus(302);
            $response->assertRedirect();
            $response->assertSessionHasErrors();

            $errors = session('errors');

            $response->assertSessionDoesntHaveErrors(['active', 'name']);
            $this->assertEquals($error, ($errors->get('status'))[0]);
        }
    }

    /**
     * @test
     */
    public function submit_form_returns_no_validation_errors()
    {
        $user = User::factory()->create();
        $status = Status::create(['status' => 'Test']);

        $data = [
            'name' => 'Project 1',
            'active' => 1,
            'status' => $status->id,
        ];

        $response = $this->actingAs($user)
            ->post(route('projects.store'),$data);

        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
    }

    /**
     * @test
     */
    public function submit_form_redirects_to_project_list_with_new_project()
    {
        $user = User::factory()->create();
        $status = Status::create(['status' => 'Test']);

        $data = [
            'name' => 'Project 1',
            'active' => 1,
            'status' => $status->id,
        ];

        $response = $this->actingAs($user)
            ->post(route('projects.store'),$data);

        $response->assertRedirect(route('projects.list'));
        $response->assertSessionHas('success','Created new project successfully.');

        $projects = Project::where('project','=',$data['name'])
            ->where('active','=',$data['active'])
            ->where('status_id','=',$data['status'])
            ->get();

        $this->assertEquals(1,$projects->count());
    }
}
