<?php

namespace Tests\Feature\Types;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Type;

class CreateNewTypeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function guests_cannot_see_add_new_type()
    {
        $response = $this->get('/dashboard/types/create');
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * @test
     */
    public function logged_in_users_can_add_new_type()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get('/dashboard/types/create');

        $response->assertStatus(200);
        $response->assertSee('Add New Type');
        $response->assertSee('<form method="post" action="'.route('types.store').'">',false);
    }

    /**
     * @test
     */
    public function submit_empty_form_returns_validation_errors()
    {
        $user = User::factory()->create();

        $data = [
            'type' => '',
        ];

        $response = $this->actingAs($user)
            ->post(route('types.store'),$data);

        $response->assertStatus(302);
        $response->assertRedirect();
        $response->assertSessionHasErrors();

        $errors = session('errors');

        $this->assertEquals('The type field is required.', ($errors->get('type'))[0]);
    }

    /**
     * @test
     */
    public function submit_form_returns_no_validation_errors()
    {
        $user = User::factory()->create();

        $data = [
            'type' => 'Test',
        ];

        $response = $this->actingAs($user)
            ->post(route('types.store'), $data);

        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
    }

    /**
     * @test
     */
    public function submit_form_redirects_to_type_list_with_new_type()
    {
        $user = User::factory()->create();

        $data = [
            'type' => 'Test',
        ];

        $response = $this->actingAs($user)
            ->post(route('types.store'),$data);

        $response->assertRedirect(route('types.list'));
        $response->assertSessionHas('success','Created new type successfully.');

        $types = Type::where('type','=',$data['type'])
            ->get();

        $this->assertEquals(1,$types->count());
    }
}
