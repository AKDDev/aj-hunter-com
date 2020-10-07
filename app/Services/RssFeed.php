<?php
namespace App\Services;

use Carbon\Carbon;

class RssFeed
{
    protected $url;
    protected $rss;

    public function __construct($url)
    {
        $this->url = $url;
        $this->rss = simplexml_load_file($url);
    }

    public function getTitle()
    {
        return (string) $this->rss->channel->title;
    }

    public function getItems()
    {
        $items = [];
        foreach($this->rss->channel->item as $item) {
            $items[] = [
                'title' => (string) $item->title,
                'data' => Carbon::parse((string) $item->pubDate)->toDateTimeString(),
                'body' => (string) $item->description,
                'link' => (string) $item->link,
                'comments' => (string) $item->comments,
            ];
        }
        return $items;
    }
}
