<?php

namespace Tests\Feature\Goal;

use App\Models\Project;
use App\Models\Type;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Status;
use App\Models\Goal;
use App\Models\User;

class EditGoalTest extends TestCase
{
    use RefreshDatabase;

    protected function startup()
    {
        Status::create(['status' => 'Change To']);
        $status = Status::create(['status' => 'Test']);
        $project = Project::create([
            'project' => 'Project 1',
            'status_id' => $status->id,
            'active' => 1,
        ]);
        $type = Type::create(['type' => 'Word']);
        Type:: create(['type' => 'Hour']);

        $goal = Goal::create([
            'goal' => 'Goal 1',
            'project_id' => $project->id,
            'status_id' => $status->id,
            'total' => 50000,
            'type_id' => $type->id,
            'start' => '2020-11-01',
            'end' => '2020-11-30',
        ]);

        return $goal;
    }

    /**
     * @test
     */
    public function guests_cannot_see_edit_goal()
    {
        $id = $this->startup()->id;

        $response = $this->get("/dashboard/goals/$id/edit");
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * @test
     */
    public function logged_in_users_can_edit_goal()
    {
        $user = User::factory()->create();
        $id = $this->startup()->id;

        $response = $this->actingAs($user)
            ->get("/dashboard/goals/$id/edit");

        $response->assertStatus(200);
        $response->assertSee('Edit Goal');
        $response->assertSee('<form method="post" action="'.route('goals.update',['goal' => $id]).'">',false);
        $response->assertSee('<input type="hidden" name="_method" value="put">',false);
        $response->assertViewHas('statuses');
        $response->assertViewHas('projects');
        $response->assertViewHas('types');
    }

    /**
     * @test
     */
    public function submit_empty_form_returns_validation_errors()
    {
        $user = User::factory()->create();
        $goal = $this->startup();

        $data = [
            'id' => '',
            'goal' => '',
            'project_id' => '',
            'status_id' => '',
            'total' => '',
            'type_id' => '',
            'start' => '',
            'end' => '',
        ];

        $response = $this->actingAs($user)
            ->put(route('goals.update',['goal' => $goal->id]), $data);


        $response->assertStatus(302);
        $response->assertRedirect();
        $response->assertSessionHasErrors();

        $errors = session('errors');

        $this->assertEquals('The id field is required.', ($errors->get('id'))[0]);
        $this->assertEquals('The status id field is required.', ($errors->get('status_id'))[0]);
        $this->assertEquals('The project id field is required.', ($errors->get('project_id'))[0]);
        $this->assertEquals('The type id field is required.', ($errors->get('type_id'))[0]);
        $this->assertEquals('The total field is required.', ($errors->get('total'))[0]);
        $this->assertEquals('The start field is required.', ($errors->get('start'))[0]);
        $response->assertSessionDoesntHaveErrors(['end']);
    }

    /**
     * @test
     */
    public function required_status_id_field_must_be_existing_status_integer()
    {
        $user = User::factory()->create();
        $goal = $this->startup();

        $status = [
            'abc' => 'The status id must be an integer.',
            3 => 'The selected status id is invalid.',
        ];

        foreach($status as $a => $error) {
            $data = [
                'id' => $goal->id,
                'goal' => 'Goal 1',
                'status_id' => $a,
                'project_id' => Project::first()->id,
                'total' => 50000,
                'type_id' => Type::first()->id,
                'start' => '2020-11-01',
                'end' => '2020-11-30',
            ];

            $response = $this->actingAs($user)
                ->put(route('goals.update',['goal' => $goal->id]), $data);

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
        $goal = $this->startup();

        $project = [
            'abc' => 'The project id must be an integer.',
            3 => 'The selected project id is invalid.',
        ];

        foreach($project as $a => $error) {
            $data = [
                'id' => $goal->id,
                'goal' => 'Goal 1',
                'status_id' => Status::first()->id,
                'project_id' => $a,
                'total' => 50000,
                'type_id' => Type::first()->id,
                'start' => '2020-11-01',
                'end' => '2020-11-30',
            ];

            $response = $this->actingAs($user)
                ->put(route('goals.update',['goal' => $goal->id]), $data);

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
        $goal = $this->startup();

        $type = [
            'abc' => 'The type id must be an integer.',
            3 => 'The selected type id is invalid.',
        ];

        foreach($type as $a => $error) {
            $data = [
                'id' => $goal->id,
                'goal' => 'Goal 1',
                'status_id' => Status::first()->id,
                'project_id' => Project::first()->id,
                'total' => 50000,
                'type_id' => $a,
                'start' => '2020-11-01',
                'end' => '2020-11-30',
            ];

            $response = $this->actingAs($user)
                ->put(route('goals.update',['goal' => $goal->id]), $data);

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
        $goal = $this->startup();

        $type = [
            'abc' => 'The start is not a valid date.',
            3 => 'The start is not a valid date.',
        ];

        foreach($type as $a => $error) {
            $data = [
                'id' => $goal->id,
                'goal' => 'Goal 1',
                'status_id' => Status::first()->id,
                'project_id' => Project::first()->id,
                'total' => 50000,
                'type_id' => Type::first()->id,
                'start' => $a,
                'end' => '2020-11-30',
            ];

            $response = $this->actingAs($user)
                ->put(route('goals.update',['goal' => $goal->id]), $data);

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
        $goal = $this->startup();

        $type = [
            'abc' => 'The end is not a valid date.',
            3 => 'The end is not a valid date.',
            '2020-10-01' => 'The end must be a date after start.',
        ];

        foreach($type as $a => $error) {
            $data = [
                'id' => $goal->id,
                'goal' => 'Goal 1',
                'status_id' => Status::first()->id,
                'project_id' => Project::first()->id,
                'total' => 50000,
                'type_id' => Type::first()->id,
                'start' => '2020-11-01',
                'end' => $a,
            ];

            $response = $this->actingAs($user)
                ->put(route('goals.update',['goal' => $goal->id]), $data);

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
    public function required_id_field_must_be_existing_goal_integer()
    {
        $user = User::factory()->create();
        $goal = $this->startup();

        $ids = [
            'abc' => 'The id must be an integer.',
            3 => 'The selected id is invalid.',
        ];

        foreach($ids as $a => $error) {
            $data = [
                'id' => $a,
                'goal' => 'Goal 1',
                'status_id' => Status::first()->id,
                'project_id' => Project::first()->id,
                'total' => 50000,
                'type_id' => Type::first()->id,
                'start' => '2020-11-01',
                'end' => '2020-11-30',
            ];

            $response = $this->actingAs($user)
                ->put(route('goals.update',['goal' => $goal->id]), $data);

            $response->assertStatus(302);
            $response->assertRedirect();
            $response->assertSessionHasErrors();

            $errors = session('errors');

            $response->assertSessionDoesntHaveErrors(['goal','status_id','total','project_id','type_id','start','end']);
            $this->assertEquals($error, ($errors->get('id'))[0]);
        }
    }

    /**
     * @test
     */
    public function submit_form_returns_no_validation_errors()
    {
        $user = User::factory()->create();
        $goal = $this->startup();

        $data = [
            'id' => $goal->id,
            'goal' => 'Goal 1',
            'status_id' => Status::first()->id,
            'project_id' => Project::first()->id,
            'total' => 50000,
            'type_id' => Type::first()->id,
            'start' => '2020-11-01',
            'end' => '2020-11-30',
        ];

        $response = $this->actingAs($user)
            ->put(route('goals.update',['goal' => $goal->id]), $data);

        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
    }

    /**
     * @test
     */
    public function submit_form_redirects_to_goal_list_with_edited_goal()
    {
        $user = User::factory()->create();
        $goal = $this->startup();

        $data = [
            'id' => $goal->id,
            'goal' => 'Goal 2',
            'status_id' => Status::first()->id,
            'project_id' => Project::first()->id,
            'total' => 50000,
            'type_id' => Type::first()->id,
            'start' => '2020-11-01',
            'end' => '2020-11-30',
        ];

        $response = $this->actingAs($user)
            ->put(route('goals.update',['goal' => $goal->id]), $data);

        $response->assertRedirect(route('goals.list'));
        $response->assertSessionHas('success','Updated goal successfully.');

        $changed = Goal::find($goal->id);

        $this->assertNotEquals($goal->goal, $changed->goal);

        $this->assertEquals($data['goal'],$changed->goal);


    }

}
