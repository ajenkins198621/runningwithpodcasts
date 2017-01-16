<?php

use App\User;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{

    use DatabaseMigrations;

    /** @test */
    public function user_can_create_new_account()
    {
        $user = factory(User::class)->create();
        $users = User::get();
        $this->assertTrue($users->contains($user));
    }


    /** @test */
    public function user_can_create_runs()
    {
        $user = factory(User::class)->create();

        $run = $user->createRun(400, 1, 2400, "Jersey City", "2017-01-16 12:00:00");

        $this->assertEquals(400, $run->distance);
        $this->assertEquals(1, $run->distance_units_id);
        $this->assertEquals(2400, $run->duration);
        $this->assertEquals("Jersey City", $run->location);
    }
}
