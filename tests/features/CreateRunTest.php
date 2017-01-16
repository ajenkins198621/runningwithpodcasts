<?php

use App\Runs;
use App\User;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateRunTest extends TestCase
{

    use DatabaseMigrations;

    /** @test */
    public function user_can_create_new_run()
    {
        $user = factory(User::class)->create();
        $run = $user->runs()->create([
            "user_id" => $user->id,
            "public" => 1,
            "distance" => 400,
            "distance_units_id" => 1,
            "duration" => 2400,
            "location" => "Jersey City"
        ]);
        $runs = Runs::get();
        $this->assertTrue($runs->contains($run));
    }
}
