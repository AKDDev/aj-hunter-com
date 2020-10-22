<?php

namespace Tests\Feature\Status;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Status;
use App\Models\User;

class EditStatusTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function guests_cannot_see_edit_status()
    {
        $status = Status::create(['status' => 'Test']);

        $response = $this->get("/dashboard/statuses/$status->id/edit");
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * @test
     */
    public function logged_in_users_can_edit_status()
    {
        $user = User::factory()->create();
        $status = Status::create(['status' => 'Test']);

        $response = $this->actingAs($user)
            ->get("/dashboard/statuses/$status->id/edit");

        $response->assertStatus(200);
        $response->assertSee('Edit Status');
        $response->assertSee('<form method="post" action="'.route('statuses.update',['status' => $status->id]).'">',false);
        $response->assertSee('<input type="hidden" name="_method" value="put">',false);
        $response->assertViewHas('status');
    }

    /**
     * @test
     */
    public function submit_empty_form_returns_validation_errors()
    {
        $user = User::factory()->create();
        $status = Status::create(['status' => 'Test']);

        $data = [
            'status' => '',
        ];

        $response = $this->actingAs($user)
            ->put(route('statuses.update',['status' => $status->id]), $data);


        $response->assertStatus(302);
        $response->assertRedirect();
        $response->assertSessionHasErrors();

        $errors = session('errors');

        $this->assertEquals('The status field is required.', ($errors->get('status'))[0]);
    }

    /**
     * @test
     */
    public function required_id_field_must_be_existing_status_integer()
    {
        $user = User::factory()->create();
        $status = Status::create(['status' => 'Test']);

        $ids = [
            'abc' => 'The id must be an integer.',
            3 => 'The selected id is invalid.',
        ];

        foreach($ids as $a => $error) {
            $data = [
                'id' => $a,
                'status' => $status->status,
            ];

            $response = $this->actingAs($user)
            ->put(route('statuses.update',['status' => $status->id]), $data);

            $response->assertStatus(302);
            $response->assertRedirect();
            $response->assertSessionHasErrors();

            $errors = session('errors');

            $response->assertSessionDoesntHaveErrors(['status']);
            $this->assertEquals($error, ($errors->get('id'))[0]);
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
                'id' => $status->id,
                'status' => $status->status,
            ];

        $response = $this->actingAs($user)
            ->put(route('statuses.update',['status' => $status->id]), $data);

        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
    }

    /**
     * @test
     */
    public function submit_form_redirects_to_status_list_with_edited_status()
    {
        $user = User::factory()->create();
        $status = Status::create(['status' => 'Test']);
        $status = Status::orderBy('id','asc')->first();

        $data = [
            'id' => $status->id,
            'status' => 'Changed Status',
        ];

        $response = $this->actingAs($user)
            ->put(route('statuses.update',['status' => $status->id]), $data);

        $response->assertRedirect(route('statuses.list'));
        $response->assertSessionHas('success','Updated status successfully.');

        $changed = Status::find($status->id);

        $this->assertNotEquals($status->status, $changed->status);

        $this->assertEquals($data['status'],$changed->status);

    }
}
