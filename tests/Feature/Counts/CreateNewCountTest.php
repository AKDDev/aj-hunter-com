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

class CreateNewCountTest extends TestCase
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
    }

    /**
     * @test
     */
    public function guests_cannot_see_add_new_count()
    {
        $response = $this->get('/dashboard/counts/create');
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * @test
     */
    public function logged_in_users_can_add_new_count()
    {
        $user = User::factory()->create();
        $this->startup();

        $response = $this->actingAs($user)
            ->get('/dashboard/counts/create');

        $response->assertStatus(200);
        $response->assertSee('Add New Count');
        $response->assertSee('<form method="post" action="'.route('counts.store').'">',false);
    }

    /**
     * @test
     */
    public function submit_empty_form_returns_validation_errors()
    {
        $user = User::factory()->create();

        $data = [
            'goal_id' => '',
            'value' => '',
            'when' => '',
            'comment' => '',
        ];

        $response = $this->actingAs($user)
            ->post(route('counts.store'),$data);

        $response->assertStatus(302);
        $response->assertRedirect();
        $response->assertSessionHasErrors();

        $errors = session('errors');

        $this->assertEquals('The value field is required.', ($errors->get('value'))[0]);
        $this->assertEquals('The goal id field is required.', ($errors->get('goal_id'))[0]);
        $this->assertEquals('The when field is required.', ($errors->get('when'))[0]);
        $response->assertSessionDoesntHaveErrors(['comment']);
    }

    /**
     * @test
     */
    public function submit_form_returns_no_validation_errors()
    {
        $user = User::factory()->create();
        $this->startup();

        $data = [
            'goal_id' => Goal::first()->id,
            'value' => 1000,
            'when' => now()->toDateString(),
            'comment' => '',
        ];

        $response = $this->actingAs($user)
            ->post(route('counts.store'), $data);

        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
    }

    /**
     * @test
     */
    public function submit_form_redirects_to_count_list_with_new_count()
    {
        $user = User::factory()->create();
        $this->startup();

        $data = [
            'goal_id' => Goal::first()->id,
            'value' => 1000,
            'when' => now()->toDateTimeString(),
            'comment' => '',
        ];

        $response = $this->actingAs($user)
            ->post(route('counts.store'),$data);

        $response->assertRedirect();
        $response->assertSessionHas('success','Created new count successfully.');

        $counts = Count::where('value','=',$data['value'])
            ->where('goal_id','=',$data['goal_id'])
            ->get();

        $this->assertEquals(1,$counts->count());
    }
}
