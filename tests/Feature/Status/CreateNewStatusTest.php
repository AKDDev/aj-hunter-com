<?php

namespace Tests\Feature\Status;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Status;

class CreateNewStatusTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function guests_cannot_see_add_new_status()
    {
        $response = $this->get('/dashboard/statuses/create');
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * @test
     */
    public function logged_in_users_can_add_new_status()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get('/dashboard/statuses/create');

        $response->assertStatus(200);
        $response->assertSee('Add New Status');
        $response->assertSee('<form method="post" action="'.route('statuses.store').'">',false);
    }

    /**
     * @test
     */
    public function submit_empty_form_returns_validation_errors()
    {
        $user = User::factory()->create();

        $data = [
            'status' => '',
        ];

        $response = $this->actingAs($user)
            ->post(route('statuses.store'),$data);

        $response->assertStatus(302);
        $response->assertRedirect();
        $response->assertSessionHasErrors();

        $errors = session('errors');

        $this->assertEquals('The status field is required.', ($errors->get('status'))[0]);
    }

    /**
     * @test
     */
    public function submit_form_returns_no_validation_errors()
    {
        $user = User::factory()->create();

        $data = [
            'status' => 'Test',
        ];

        $response = $this->actingAs($user)
            ->post(route('statuses.store'), $data);

        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
    }

    /**
     * @test
     */
    public function submit_form_redirects_to_status_list_with_new_status()
    {
        $user = User::factory()->create();

        $data = [
            'status' => 'Test',
        ];

        $response = $this->actingAs($user)
            ->post(route('statuses.store'),$data);

        $response->assertRedirect(route('statuses.list'));
        $response->assertSessionHas('success','Created new status successfully.');

        $statuses = Status::where('status','=',$data['status'])
            ->get();

        $this->assertEquals(1,$statuses->count());
    }
}
