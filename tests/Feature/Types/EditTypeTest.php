<?php

namespace Tests\Feature\Types;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Type;
use App\Models\User;

class EditTypeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function guests_cannot_see_edit_type()
    {
        $type = Type::create(['type' => 'Test']);

        $response = $this->get("/dashboard/types/$type->id/edit");
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * @test
     */
    public function logged_in_users_can_edit_type()
    {
        $user = User::factory()->create();
        $type = Type::create(['type' => 'Test']);

        $response = $this->actingAs($user)
            ->get("/dashboard/types/$type->id/edit");

        $response->assertStatus(200);
        $response->assertSee('Edit Type');
        $response->assertSee('<form method="post" action="'.route('types.update',['type' => $type->id]).'">',false);
        $response->assertSee('<input type="hidden" name="_method" value="put">',false);
        $response->assertViewHas('type');
    }

    /**
     * @test
     */
    public function submit_empty_form_returns_validation_errors()
    {
        $user = User::factory()->create();
        $type = Type::create(['type' => 'Test']);

        $data = [
            'type' => '',
        ];

        $response = $this->actingAs($user)
            ->put(route('types.update',['type' => $type->id]), $data);


        $response->assertStatus(302);
        $response->assertRedirect();
        $response->assertSessionHasErrors();

        $errors = session('errors');

        $this->assertEquals('The type field is required.', ($errors->get('type'))[0]);
    }

    /**
     * @test
     */
    public function required_id_field_must_be_existing_type_integer()
    {
        $user = User::factory()->create();
        $type = Type::create(['type' => 'Test']);

        $ids = [
            'abc' => 'The id must be an integer.',
            3 => 'The selected id is invalid.',
        ];

        foreach($ids as $a => $error) {
            $data = [
                'id' => $a,
                'type' => $type->type,
            ];

            $response = $this->actingAs($user)
            ->put(route('types.update',['type' => $type->id]), $data);

            $response->assertStatus(302);
            $response->assertRedirect();
            $response->assertSessionHasErrors();

            $errors = session('errors');

            $response->assertSessionDoesntHaveErrors(['type']);
            $this->assertEquals($error, ($errors->get('id'))[0]);
        }
    }

    /**
     * @test
     */
    public function submit_form_returns_no_validation_errors()
    {
        $user = User::factory()->create();
        $type = Type::create(['type' => 'Test']);

        $data = [
                'id' => $type->id,
                'type' => $type->type,
            ];

        $response = $this->actingAs($user)
            ->put(route('types.update',['type' => $type->id]), $data);

        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
    }

    /**
     * @test
     */
    public function submit_form_redirects_to_type_list_with_edited_type()
    {
        $user = User::factory()->create();
        $type = Type::create(['type' => 'Test']);
        $type = Type::orderBy('id','asc')->first();

        $data = [
            'id' => $type->id,
            'type' => 'Changed Type',
        ];

        $response = $this->actingAs($user)
            ->put(route('types.update',['type' => $type->id]), $data);

        $response->assertRedirect(route('types.list'));
        $response->assertSessionHas('success','Updated type successfully.');

        $changed = Type::find($type->id);

        $this->assertNotEquals($type->type, $changed->type);

        $this->assertEquals($data['type'],$changed->type);

    }
}
