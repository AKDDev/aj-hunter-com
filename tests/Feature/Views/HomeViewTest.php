<?php

namespace Tests\Feature\Views;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeViewTest extends TestCase
{
    /**
     * @test
     */
    public function home_applys_layout_componenet()
    {
        $response = $this->view('home');

        $response->assertSee('id="layout"',false);
    }

    /**
     * @test
     */
    public function home_has_newsletter()
    {
        $response = $this->view('home');

        $response->assertSee('id="newsletter"',false);
    }

    /**
     * @test
     */
    public function home_has_wip()
    {
        $response = $this->view('home');

        $response->assertSee('id="wip"',false);
    }

    /**
     * @test
     */
    public function home_has_blog()
    {
        $response = $this->view('home');

        $response->assertSee('id="blog"',false);
    }

    /**
     * @test
     */
    public function home_has_book_carosel()
    {
        $response = $this->view('home');

        $response->assertSee('id="books"',false);
    }
}
