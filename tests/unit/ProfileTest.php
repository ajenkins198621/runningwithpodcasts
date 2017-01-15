<?php

use App\Profile;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProfileTest extends TestCase
{

    use DatabaseMigrations;

    /** @test */
    public function can_get_full_name()
    {
        $profile = factory(Profile::class)->create();
        $this->assertEquals("Austin Jenkins", $profile->full_name);
    }
}
