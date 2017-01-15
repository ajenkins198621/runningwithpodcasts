<?php

use App\Profile;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProfileTest extends TestCase
{

    use DatabaseMigrations;

    /** @test */
    public function user_can_view_public_profile()
    {
        $profile = factory(Profile::class)->create([
            "public" => 1
        ]);

        $this->visit("/profile/".$profile->username);
        $this->see("Austin Jenkins");
        $this->see("austin_jenkins");
        $this->see("I love running around Jersey City and Hoboken");
    }

    /** @test */
    public function user_cannot_view_unpublished_profile()
    {
        $profile = factory(Profile::class)->create([
            "public" => 0
        ]);
        $this->visit("/profile/".$profile->username);
        $this->see("Unpublished profile");
    }

}
