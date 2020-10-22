<?php

namespace Tests\Feature\Types;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Type;

class DeleteTypeTest extends TestCase
{
    use RefreshDatabase;

    protected function startup()
    {
        return Type::create(['type' => 'Test']);
    }

    /**
     * @test
     */
    public function cannot_delete_if_guest()
    {
        $id = $this->startup()->id;

        $response = $this->delete("/dashboard/types/$id");
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * @test
     */
    public function required_id_field_must_be_existing_type_integer()
    {
        $user = User::factory()->create();
        $type = $this->startup();
        $ids = [
            'abc' => 'The id must be an integer.',
            3 => 'The selected id is invalid.',
        ];

        foreach($ids as $a => $error) {
            $data = [
                'id' => $a,
            ];

            $response = $this->actingAs($user)
            ->delete(route('types.delete',['type' => $type->id]), $data);

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
    public function logged_in_user_can_delete_type()
    {
        $user = User::factory()->create();
        $id = $this->startup()->id;

        $data = [
            'id' => $id,
        ];

        $response = $this->actingAs($user)
            ->delete(route('types.delete',['type' => $id]), $data);

        $response->assertStatus(302);
        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
    }

    /**
     * @test
     */
    public function soft_delete_type_valid()
    {
        $user = User::factory()->create();
        $id = $this->startup()->id;

        $data = [
            'id' => $id,
        ];

        $response = $this->actingAs($user)
            ->delete(route('types.delete',['type' => $id]), $data);

        $type = type::find($id);
        $this->assertEmpty($type);

        $type = type::withTrashed()->find($id);
        $this->assertNotEmpty($type->deleted_at);
    }
}
