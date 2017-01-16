<?php

use App\Profile;
use App\User;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ViewPublicProfileTest extends TestCase
{

    use DatabaseMigrations;


    /** @test */
    public function user_can_create_public_profile()
    {
        $user = factory(User::class)->create();
        $profile = $user::find($user->id)->profile()->create([
            'public' => 1,
            'first_name' => "Austin",
            'last_name' => "Jenkins",
            'username' => "ajenkins198621",
            'biography' => "I love running around Jersey City and Hoboken"
        ]);
        $profiles = Profile::get();
        $this->assertTrue($profiles->contains($profile));
    }

    /** @test */
    public function a_profile_has_a_user()
    {
        $user = factory(User::class)->create();
        $profileA = $user->profile()->create([
            'public' => 1,
            'first_name' => "Austin",
            'last_name' => "Jenkins",
            'username' => "ajenkins198621",
            'biography' => "I love running around Jersey City and Hoboken"
        ]);
        $profile = Profile::find($profileA->id)->first();
        $this->assertTrue($profile->user->email == $user->email);
    }

    /** @test */
    public function users_can_view_public_profile()
    {
        $profile = factory(Profile::class)->states("public")->create();
        $this->visit("/profile/".$profile->username);
        $this->see("Austin Jenkins");
        $this->see("austin_jenkins");
        $this->see("I love running around Jersey City and Hoboken");
    }

    /** @test */
    public function users_cannot_view_nonpublic_profile()
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
