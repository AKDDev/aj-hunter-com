<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoutesTest extends TestCase
{
    /**
     * @test
     */
    public function home_route_exists()
    {
        $response = $this->get(route('home'));

        $response->assertStatus(200);
    }
}
