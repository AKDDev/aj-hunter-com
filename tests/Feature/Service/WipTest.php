<?php

namespace Tests\Feature\Service;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WipTest extends TestCase
{
    /**
     * @test
     */
    public function get_current_work_in_progress()
    {
        $service = new WorkInProgress();

        $this->assertEquals($service->getCurrentProject()->title, 'New Project');
    }
}
