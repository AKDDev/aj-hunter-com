<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\View\Components\Blog;

class BlogTest extends TestCase
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
    public function blog_has_two_entries()
    {
        $view = $this->component(Blog::class, ['feed' => $this->feed]);

        $view->assertSee('<div id="blog1"', false);
        $view->assertSee('<div id="blog2"', false);
    }

    /**
     * @test
     */
    public function blog_has_rss_data()
    {
        $view = $this->component(Blog::class, ['feed' => $this->feed]);

        $view->assertSee('<h3>Blog 1</h3>', false);
        $view->assertSee('<h3>Blog 2</h3>', false);
        $view->assertDontSee('<h3>Blog 3</h3>', false);

    }

}
