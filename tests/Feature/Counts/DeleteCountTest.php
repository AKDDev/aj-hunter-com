<?php

namespace Tests\Feature\Counts;

use App\Models\Goal;
use App\Models\Project;
use App\Models\Status;
use App\Models\Type;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Count;

class DeleteCountTest extends TestCase
{
    use RefreshDatabase;

    protected function startup()
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
            'start' => now()->startOfMonth()->toDateString(),
            'end' => now()->endOfMonth()->toDateString(),
        ]);

        return Count::create([
            'goal_id' => $goal->id,
            'value' => 1000,
            'when' => now()->toDateTimeString(),
            'comment' => '',
        ]);
    }

    /**
     * @test
     */
    public function cannot_delete_if_guest()
    {
        $id = $this->startup()->id;

        $response = $this->delete("/dashboard/counts/$id");
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * @test
     */
    public function required_id_field_must_be_existing_count_integer()
    {
        $user = User::factory()->create();
        $count = $this->startup();
        $ids = [
            'abc' => 'The id must be an integer.',
            3 => 'The selected id is invalid.',
        ];

        foreach($ids as $a => $error) {
            $data = [
                'id' => $a,
            ];

            $response = $this->actingAs($user)
            ->delete(route('counts.delete',['count' => $count->id]), $data);

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
    public function logged_in_user_can_delete_count()
    {
        $user = User::factory()->create();
        $id = $this->startup()->id;

        $data = [
            'id' => $id,
        ];

        $response = $this->actingAs($user)
            ->delete(route('counts.delete',['count' => $id]), $data);

        $response->assertStatus(302);
        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
    }
}
