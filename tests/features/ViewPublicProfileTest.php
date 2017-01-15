<?php

use App\Profile;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ViewPublicProfileTest extends TestCase
{

    use DatabaseMigrations;

    /** @test */
    public function user_can_view_public_profile()
    {
        $profile = factory(Profile::class)->states("public")->create();

        $this->visit("/profile/".$profile->username);

        $this->see("Austin Jenkins");
        $this->see("austin_jenkins");
        $this->see("I love running around Jersey City and Hoboken");
    }

    /** @test */
    public function user_cannot_view_nonpublic_profile()
    {
        $profile = factory(Profile::class)->states("unpublished")->create();

        $this->visit("/profile/".$profile->username);

        $this->see("Unpublished content");
    }

    /** @test */
    public function profiles_with_public_set_to_zero_are_hidden()
    {
        $publicProfileA = factory(Profile::class)->states("public")->create();
        $publicProfileB = factory(Profile::class)->states("unpublished")->create();

        $publicProfiles = Profile::isPublic()->get();

        $this->assertTrue($publicProfiles->contains($publicProfileA));
        $this->assertFalse($publicProfiles->contains($publicProfileB));
    }
}
