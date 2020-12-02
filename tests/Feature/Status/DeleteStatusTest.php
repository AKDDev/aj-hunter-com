<?php

namespace Tests\Feature\Status;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Status;

class DeleteStatusTest extends TestCase
{
    use RefreshDatabase;

    protected function startup()
    {
        return Status::create(['status' => 'Test']);
    }

    /**
     * @test
     */
    public function cannot_delete_if_guest()
    {
        $id = $this->startup()->id;

        $response = $this->delete("/dashboard/statuses/$id");
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * @test
     */
    public function required_id_field_must_be_existing_status_integer()
    {
        $user = User::factory()->create();
        $status = $this->startup();
        $ids = [
            'abc' => 'The id must be an integer.',
            3 => 'The selected id is invalid.',
        ];

        foreach($ids as $a => $error) {
            $data = [
                'id' => $a,
            ];

            $response = $this->actingAs($user)
            ->delete(route('statuses.delete',['status' => $status->id]), $data);

            $response->assertStatus(302);
            $response->assertRedirect();
            $response->assertSessionHasErrors();

            $errors = session('errors');

            $this->assertEquals($error, ($errors->get('status'))[0]);
        }
    }

    /**
     * @test
     */
    public function logged_in_user_can_delete_status()
    {
        $user = User::factory()->create();
        $id = $this->startup()->id;

        $data = [
            'id' => $id,
        ];

        $response = $this->actingAs($user)
            ->delete(route('statuses.delete',['status' => $id]), $data);

        $response->assertStatus(302);
        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
    }

    /**
     * @test
     */
    public function soft_delete_status_valid()
    {
        $user = User::factory()->create();
        $id = $this->startup()->id;

        $data = [
            'id' => $id,
        ];

        $response = $this->actingAs($user)
            ->delete(route('statuses.delete',['status' => $id]), $data);

        $status = status::find($id);
        $this->assertEmpty($status);

        $status = status::withTrashed()->find($id);
        $this->assertNotEmpty($status->deleted_at);
    }
}
