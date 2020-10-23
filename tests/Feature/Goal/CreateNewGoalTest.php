<?php

namespace Tests\Feature\Goal;

use App\Models\Project;
use App\Models\Type;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Goal;
use App\Models\Status;

class CreateNewGoalTest extends TestCase
{
    use RefreshDatabase;

    public function startup()
    {
        $status = Status::create(['status' => 'Test']);
        $project = Project::create([
            'project' => 'Project 1',
            'status_id' => $status->id,
            'active' => 1,
        ]);
        $type = Type::create(['type' => 'Word']);
    }

    /**
     * @test
     */
    public function guests_cannot_see_add_new_goal()
    {
        $response = $this->get('/dashboard/goals/create');
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * @test
     */
    public function logged_in_users_can_add_new_goal()
    {
        $user = User::factory()->create();
        $this->startup();

        $response = $this->actingAs($user)
            ->get('/dashboard/goals/create');

        $response->assertStatus(200);
        $response->assertSee('Add New Goal');
        $response->assertSee('<form method="post" action="'.route('goals.store').'">',false);
        $response->assertViewHas('statuses');
        $response->assertViewHas('types');
        $response->assertViewHas('projects');

    }

    /**
     * @test
     */
    public function submit_empty_form_returns_validation_errors()
    {
        $user = User::factory()->create();
        $this->startup();

        $data = [
            'goal' => '',
            'status_id' => '',
            'project_id' => '',
            'total' => '',
            'type_id' => '',
            'start' => '',
            'end' => '',
        ];

        $response = $this->actingAs($user)
            ->post(route('goals.store'),$data);

        $response->assertStatus(302);
        $response->assertRedirect();
        $response->assertSessionHasErrors();

        $errors = session('errors');

        $this->assertEquals('The goal field is required.', ($errors->get('goal'))[0]);
        $this->assertEquals('The status id field is required.', ($errors->get('status_id'))[0]);
        $this->assertEquals('The project id field is required.', ($errors->get('project_id'))[0]);
        $this->assertEquals('The total field is required.', ($errors->get('total'))[0]);
        $this->assertEquals('The type id field is required.', ($errors->get('type_id'))[0]);
        $this->assertEquals('The start field is required.', ($errors->get('start'))[0]);
        // end is not required
        $response->assertSessionDoesntHaveErrors(['end']);

    }

    /**
     * @test
     */
    public function required_status_id_field_must_be_existing_status_integer()
    {
        $user = User::factory()->create();
        $this->startup();

        $status = [
            'abc' => 'The status id must be an integer.',
            3 => 'The selected status id is invalid.',
        ];

        foreach($status as $a => $error) {
            $data = [
                'goal' => 'Goal 1',
                'status_id' => $a,
                'project_id' => Project::first()->id,
                'total' => 50000,
                'type_id' => Type::first()->id,
                'start' => '2020-11-01',
                'end' => '2020-11-30',
            ];

            $response = $this->actingAs($user)
                ->post(route('goals.store'), $data);

            $response->assertStatus(302);
            $response->assertRedirect();
            $response->assertSessionHasErrors();

            $errors = session('errors');

            $response->assertSessionDoesntHaveErrors(['goal','project_id','total','type_id','start','end']);
            $this->assertEquals($error, ($errors->get('status_id'))[0]);
        }
    }

    /**
     * @test
     */
    public function required_project_id_field_must_be_existing_project_integer()
    {
        $user = User::factory()->create();
        $this->startup();

        $project = [
            'abc' => 'The project id must be an integer.',
            3 => 'The selected project id is invalid.',
        ];

        foreach($project as $a => $error) {
            $data = [
                'goal' => 'Goal 1',
                'status_id' => Status::first()->id,
                'project_id' => $a,
                'total' => 50000,
                'type_id' => Type::first()->id,
                'start' => '2020-11-01',
                'end' => '2020-11-30',
            ];

            $response = $this->actingAs($user)
                ->post(route('goals.store'), $data);

            $response->assertStatus(302);
            $response->assertRedirect();
            $response->assertSessionHasErrors();

            $errors = session('errors');

            $response->assertSessionDoesntHaveErrors(['goal','status_id','total','type_id','start','end']);
            $this->assertEquals($error, ($errors->get('project_id'))[0]);
        }
    }

    /**
     * @test
     */
    public function required_type_id_field_must_be_existing_type_integer()
    {
        $user = User::factory()->create();
        $this->startup();

        $type = [
            'abc' => 'The type id must be an integer.',
            3 => 'The selected type id is invalid.',
        ];

        foreach($type as $a => $error) {
            $data = [
                'goal' => 'Goal 1',
                'status_id' => Status::first()->id,
                'project_id' => Project::first()->id,
                'total' => 50000,
                'type_id' => $a,
                'start' => '2020-11-01',
                'end' => '2020-11-30',
            ];

            $response = $this->actingAs($user)
                ->post(route('goals.store'), $data);

            $response->assertStatus(302);
            $response->assertRedirect();
            $response->assertSessionHasErrors();

            $errors = session('errors');

            $response->assertSessionDoesntHaveErrors(['goal','status_id','total','project_id','start','end']);
            $this->assertEquals($error, ($errors->get('type_id'))[0]);
        }
    }

    /**
     * @test
     */
    public function required_start_field_must_be_a_date()
    {
        $user = User::factory()->create();
        $this->startup();

        $type = [
            'abc' => 'The start is not a valid date.',
            3 => 'The start is not a valid date.',
        ];

        foreach($type as $a => $error) {
            $data = [
                'goal' => 'Goal 1',
                'status_id' => Status::first()->id,
                'project_id' => Project::first()->id,
                'total' => 50000,
                'type_id' => Type::first()->id,
                'start' => $a,
                'end' => '2020-11-30',
            ];

            $response = $this->actingAs($user)
                ->post(route('goals.store'), $data);

            $response->assertStatus(302);
            $response->assertRedirect();
            $response->assertSessionHasErrors();

            $errors = session('errors');

            $response->assertSessionDoesntHaveErrors(['goal','status_id','total','project_id','type_id','end']);
            $this->assertEquals($error, ($errors->get('start'))[0]);
        }
    }

    /**
     * @test
     */
    public function end_field_must_be_a_date_after_start()
    {
        $user = User::factory()->create();
        $this->startup();

        $type = [
            'abc' => 'The end is not a valid date.',
            3 => 'The end is not a valid date.',
            '2020-10-01' => 'The end must be a date after start.',
        ];

        foreach($type as $a => $error) {
            $data = [
                'goal' => 'Goal 1',
                'status_id' => Status::first()->id,
                'project_id' => Project::first()->id,
                'total' => 50000,
                'type_id' => Type::first()->id,
                'start' => '2020-11-01',
                'end' => $a,
            ];

            $response = $this->actingAs($user)
                ->post(route('goals.store'), $data);

            $response->assertStatus(302);
            $response->assertRedirect();
            $response->assertSessionHasErrors();

            $errors = session('errors');

            $response->assertSessionDoesntHaveErrors(['goal','status_id','total','project_id','type_id','start']);
            $this->assertEquals($error, ($errors->get('end'))[0]);
        }
    }

    /**
     * @test
     */
    public function submit_form_returns_no_validation_errors()
    {
        $user = User::factory()->create();
        $this->startup();

        $data = [
            'goal' => 'Goal 1',
            'status_id' => Status::first()->id,
            'project_id' => Project::first()->id,
            'total' => 50000,
            'type_id' => Type::first()->id,
            'start' => '2020-11-01',
            'end' => '2020-11-30',
        ];

        $response = $this->actingAs($user)
            ->post(route('goals.store'),$data);

        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
    }

    /**
     * @test
     */
    public function submit_form_redirects_to_goal_list_with_new_goal()
    {
        $user = User::factory()->create();
        $this->startup();

        $data = [
            'goal' => 'Goal 1',
            'status_id' => Status::first()->id,
            'project_id' => Project::first()->id,
            'total' => 50000,
            'type_id' => Type::first()->id,
            'start' => '2020-11-01',
            'end' => '2020-11-30',
        ];

        $response = $this->actingAs($user)
            ->post(route('goals.store'),$data);

        $response->assertRedirect(route('goals.list'));
        $response->assertSessionHas('success','Created new goal successfully.');

        $goals = Goal::where('goal','=',$data['goal'])
            ->where('project_id','=',$data['project_id'])
            ->where('status_id','=',$data['status_id'])
            ->where('total','=',$data['total'])
            ->where('type_id','=',$data['type_id'])
            ->where('start','=',$data['start'])
            ->where('end','=',$data['end'])
            ->get();

        $this->assertEquals(1,$goals->count());
    }
}
