<?php

use App\User;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateUserTest extends TestCase
{

    use DatabaseMigrations;

    /** @test */
    public function user_can_create_new_account()
    {
        $user = factory(User::class)->create();
        $users = User::get();
        $this->assertTrue($users->contains($user));
    }

}
