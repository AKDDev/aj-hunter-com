<?php

namespace Tests\Feature\Goal;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Goal;
use App\Models\Status;

class DeleteGoalTest extends TestCase
{
    use RefreshDatabase;

    protected function startup()
    {
        $status = Status::create(['status' => 'Test']);

        return Goal::create([
            'goal' => 'Goal 1',
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

        $response = $this->delete("/dashboard/goals/$id");
        $response->assertStatus(302);
        $response->assertRedirect('/login');
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
            ];

            $response = $this->actingAs($user)
            ->delete(route('goals.delete',['goal' => $goal->id]), $data);

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
    public function logged_in_user_can_delete_goal()
    {
        $user = User::factory()->create();
        $id = $this->startup()->id;

        $data = [
            'id' => $id,
        ];

        $response = $this->actingAs($user)
            ->delete(route('goals.delete',['goal' => $id]), $data);

        $response->assertStatus(302);
        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
    }

    /**
     * @test
     */
    public function soft_delete_goal_valid()
    {
        $user = User::factory()->create();
        $id = $this->startup()->id;

        $data = [
            'id' => $id,
        ];

        $response = $this->actingAs($user)
            ->delete(route('goals.delete',['goal' => $id]), $data);

        $goal = Goal::find($id);
        $this->assertEmpty($goal);

        $goal = Goal::withTrashed()->find($id);
        $this->assertNotEmpty($goal->deleted_at);
    }
}
