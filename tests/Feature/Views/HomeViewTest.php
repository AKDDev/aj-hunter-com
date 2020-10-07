<?php

namespace Tests\Feature\Views;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeViewTest extends TestCase
{
    protected $feed;

    public function __construct()
    {
        parent::__construct();

        $date1 = now()->toDateTimeString();
        $date2 = now()->subDay()->ToDateTimeString();
        $date3 = now()->subDays(2)->ToDateTimeString();

        $this->feed = [
            ['title' => 'Blog 1', 'body' => 'This is test data', 'date' => $date1],
            ['title' => 'Blog 2', 'body' => 'This is test data 2', 'date' => $date2],
            ['title' => 'Blog 3', 'body' => 'This is test data 3', 'date' => $date3],
        ];
    }

    /**
     * @test
     */
    public function home_applys_layout_componenet()
    {
        $feed = $this->feed;
        $response = $this->view('home', ['feed' => $feed]);

        $response->assertSee('id="layout"',false);
    }

    /**
     * @test
     */
    public function home_has_newsletter()
    {
        $feed = $this->feed;
        $response = $this->view('home', ['feed' => $feed]);

        $response->assertSee('id="newsletter"',false);
    }

    /**
     * @test
     */
    public function home_has_wip()
    {
        $feed = $this->feed;
        $response = $this->view('home', ['feed' => $feed]);

        $response->assertSee('id="wip"',false);
    }

    /**
     * @test
     */
    public function home_has_blog()
    {
        $feed = $this->feed;
        $response = $this->view('home', ['feed' => $feed]);

        $response->assertSee('id="blog"',false);
    }

    /**
     * @test
     */
    public function home_has_book_carosel()
    {
        $feed = $this->feed;
        $response = $this->view('home', ['feed' => $feed]);

        $response->assertSee('id="books"',false);
    }
}
