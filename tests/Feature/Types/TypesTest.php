<?php

namespace Tests\Feature\Types;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Type;

class TypesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function guests_cannot_see_type_list()
    {
        $response = $this->get('/dashboard/types');
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * @test
     */
    public function logged_in_users_can_see_type_list()
    {
        $user = User::factory()->create();
        $type = Type::create(['type' => 'Test']);
        $type = Type::create(['type' => 'Completed']);


        $response = $this->actingAs($user)
            ->get('/dashboard/types');

        $response->assertStatus(200);
        $response->assertSee('Types');
        $response->assertViewHas('types');
        $response->assertSee('Completed');
        $response->assertSee('Test');
    }

    /**
     * @test
     */
    public function empty_type_list_displays_message()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get('/dashboard/types');

        $response->assertStatus(200);
        $response->assertSee('There are no types at this time.');
    }
}
