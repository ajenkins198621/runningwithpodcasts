<?php

use App\Profile;

use App\Runs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RunTest extends TestCase
{

    use DatabaseMigrations;

    /** @test */
    public function can_get_distance_in_text_format()
    {
        $run = factory(Runs::class)->states("public")->create();
        $this->assertEquals("5.00", $run->distance_in_text);
    }

    /** @test */
    public function can_get_duration_in_text_format()
    {
        $run = factory(Runs::class)->states("unpublished")->create();
        $this->assertEquals("40:00", $run->duration_in_text);
    }

}
