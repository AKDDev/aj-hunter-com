<?php

namespace Tests\Feature\Goal;

use App\Models\Goal;
use App\Models\Project;
use App\Models\Status;
use App\Models\Type;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShowGoalTest extends TestCase
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
    public function guests_can_view_goal()
    {
        $goal = $this->startup();

        $response = $this->get(route('goals.show', ['goal' => $goal->id]));

        $response->assertStatus(200);
        $response->assertViewHas('goal');
    }

    /**
    * @test
    */
   public function display_error_when_goal_does_not_exist()
   {
       $response = $this->get(route('goals.show', ['goal' => 1]));

       $response->assertStatus(404);
       $response->assertSee('The page you are looking for cannot be found.');
   }

    /**
     * @test
     */
    public function logged_in_user_can_view_goal()
    {
        $user = User::factory()->create();
        $goal = $this->startup();

        $response = $this->actingAs($user)->get(route('goals.show', ['goal' => $goal->id]));

        $response->assertStatus(200);
        $response->assertViewHas('goal');
    }
}
