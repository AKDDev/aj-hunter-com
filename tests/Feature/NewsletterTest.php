<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NewsletterTest extends TestCase
{
    /**
     * @test
     */
    public function newsletter_has_needed_elements()
    {
        $view = $this->blade(
            '<x-newsletter />'
        );

        $view = $this->blade(
            '<x-newsletter />'
        );

        $view->assertSee('<input type="email"', false);
        $view->assertSee('<button type="submit"', false);
        $view->assertSee('<form', false);
        $view->assertSee('method="post"', false);
        $view->assertSee('https://themindofnox.us15.list-manage.com/subscribe/post?u=fd49bfb92a90f9fe9866a1473&amp;id=d691ad1f28', false);
    }
}
