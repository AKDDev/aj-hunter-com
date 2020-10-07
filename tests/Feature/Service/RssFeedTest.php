<?php

namespace Tests\Feature\Service;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Services\RssFeed;

class RssFeedTest extends TestCase
{
    /**
     * @test
     */
    public function read_rss_feed()
    {
        $url = 'https://themindofnox.com/feed/';
        $service = new RssFeed($url);

        $this->assertEquals($service->getTitle(), 'The Mind of Nox');
    }

    /**
     * @test
     */
    public function can_get_feed_items()
    {
        $url = 'https://themindofnox.com/feed/';
        $service = new RssFeed($url);

        $this->assertEquals(count($service->getItems()), 10);
    }
}
