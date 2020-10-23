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

    public function startup()
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
        $response->assertSee('<option value="1">Test</option>', false);
        $response->assertSee('<option value="2">Change To</option>', false);
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
            'name' => '',
            'active' => '',
            'status' => '',
        ];

        $response = $this->actingAs($user)
            ->put(route('goals.update',['goal' => $goal->id]), $data);


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
        $goal = $this->startup();
        $s = Status::first();
        $active = ['abc', 3];

        foreach($active as $a) {
            $data = [
                'id'=> $goal->id,
                'name' => 'Goal 1',
                'active' => $a,
                'status' => $s->id,
            ];

            $response = $this->actingAs($user)
            ->put(route('goals.update',['goal' => $goal->id]), $data);

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
        $goal = $this->startup();
        $status = [
            'abc' => 'The status must be an integer.',
            3 => 'The selected status is invalid.',
        ];

        foreach($status as $a => $error) {
            $data = [
                'id' => $goal->id,
                'name' => 'Goal 1',
                'active' => 1,
                'status' => $a,
            ];

            $response = $this->actingAs($user)
            ->put(route('goals.update',['goal' => $goal->id]), $data);

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
                'name' => 'Goal 1',
                'active' => $goal->active,
                'status' => $goal->status_id,
            ];

            $response = $this->actingAs($user)
            ->put(route('goals.update',['goal' => $goal->id]), $data);

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
        $goal = $this->startup();

        $data = [
                'id' => $goal->id,
                'name' => $goal->goal,
                'active' => $goal->active,
                'status' => $goal->status_id,
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
        $status = Status::orderBy('id','asc')->first();

        $data = [
            'id' => $goal->id,
            'name' => 'Changed Goal',
            'active' => 0,
            'status' => $status->id,
        ];

        $response = $this->actingAs($user)
            ->put(route('goals.update',['goal' => $goal->id]), $data);

        $response->assertRedirect(route('goals.list'));
        $response->assertSessionHas('success','Updated goal successfully.');

        $changed = Goal::find($goal->id);

        $this->assertNotEquals($goal->goal, $changed->goal);
        $this->assertNotEquals($goal->active, $changed->active);
        $this->assertNotEquals($goal->status_id, $changed->status_id);

        $this->assertEquals($data['name'],$changed->goal);
        $this->assertEquals($data['status'],$changed->status_id);
        $this->assertEquals($data['active'],$changed->active);

    }

}
