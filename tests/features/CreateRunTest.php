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
            "location" => "Jersey City",
            "date" => "2017-01-16 12:00:00"
        ]);
        $runs = Runs::get();
        $this->assertTrue($runs->contains($run));
    }

    /** @test */
    public function run_can_be_created_through_post_request()
    {
        $user = factory(User::class)->create();

        $this->json("POST","/runs/create",[
            "user_id" => $user->id,
            "distance" => 400,
            "distance_units_id" => 1,
            "duration" => 2400,
            "location" => "Hoboken",
            "date" => "2017-01-16 12:00:00"
        ]);

        // Make sure they can post to
        $this->assertResponseOk();

        // Make sure any new run is created
        $this->assertGreaterThan(0,$user->runs()->count());

        // Make sure specific new run is created
        $this->assertEquals(2400,$user->runs()->first()->duration);
    }


    private function createRun($params)
    {
        $this->json("POST","/runs/create",$params);
    }

    private function assertValidationError($field)
    {
        $this->assertResponseStatus(422);
        $this->assertArrayHasKey($field,$this->decodeResponseJson());
    }


    /** @test */
    public function user_id_is_required_to_create_run()
    {
        $user = factory(User::class)->create();
        $this->createRun([
            "distance" => 400,
            "distance_units_id" => 1,
            "duration" => 2400,
        ]);
        $this->assertValidationError("user_id");
    }
    /** @test */
    public function user_id_is_numeric_to_create_run()
    {
        $user = factory(User::class)->create();
        $this->createRun([
            "user_id" => "ABC",
            "distance" => 400,
            "distance_units_id" => 1,
            "duration" => 2400,
        ]);
        $this->assertValidationError("user_id");
    }
    /** @test */
    public function user_id_is_greater_than_zero_to_create_run()
    {
        $user = factory(User::class)->create();
        $this->createRun([
            "user_id" => 0,
            "distance" => 400,
            "distance_units_id" => 1,
            "duration" => 2400,
        ]);
        $this->assertValidationError("user_id");
    }
    /** @test */
    public function distance_is_required_to_create_run()
    {
        $user = factory(User::class)->create();
        $this->createRun([
            "user_id" => $user->id,
            "distance_units_id" => 1,
            "duration" => 2400,
        ]);
        $this->assertValidationError("distance");
    }
    /** @test */
    public function distance_is_numeric_to_create_run()
    {
        $user = factory(User::class)->create();
        $this->createRun([
            "user_id" => $user->id,
            "distance" => "ABC",
            "distance_units_id" => 1,
            "duration" => 2400,
        ]);
        $this->assertValidationError("distance");
    }
    /** @test */
    public function distance_is_greater_than_zero_to_create_run()
    {
        $user = factory(User::class)->create();
        $this->createRun([
            "user_id" => $user->id,
            "distance" => 0,
            "distance_units_id" => 1,
            "duration" => 2400,
        ]);
        $this->assertValidationError("distance");
    }
    /** @test */
    public function distance_units_id_is_required_to_create_run()
    {
        $user = factory(User::class)->create();
        $this->createRun([
            "user_id" => $user->id,
            "distance" => 400,
            "duration" => 2400,
        ]);
        $this->assertValidationError("distance_units_id");
    }
    /** @test */
    public function distance_units_id_is_numeric_to_create_run()
    {
        $user = factory(User::class)->create();
        $this->createRun([
            "user_id" => $user->id,
            "distance" => 400,
            "distance_units_id" => "ABC",
            "duration" => 2400,
        ]);
        $this->assertValidationError("distance_units_id");
    }
    /** @test */
    public function distance_units_id_is_greater_than_zero_to_create_run()
    {
        $user = factory(User::class)->create();
        $this->createRun([
            "user_id" => $user->id,
            "distance" => 400,
            "distance_units_id" => 0,
            "duration" => 2400,
        ]);
        $this->assertValidationError("distance_units_id");
    }
    /** @test */
    public function duration_is_required_to_create_run()
    {
        $user = factory(User::class)->create();
        $this->createRun([
            "user_id" => $user->id,
            "distance" => 400,
            "distance_units_id" => 1,
        ]);
        $this->assertValidationError("duration");
    }
    /** @test */
    public function duration_is_numeric_to_create_run()
    {
        $user = factory(User::class)->create();
        $this->createRun([
            "user_id" => $user->id,
            "distance" => 400,
            "distance_units_id" => 1,
            "duration" => "ABC",
        ]);
        $this->assertValidationError("duration");
    }
    /** @test */
    public function duration_is_greater_than_zero_to_create_run()
    {
        $user = factory(User::class)->create();
        $this->createRun([
            "user_id" => $user->id,
            "distance" => 400,
            "distance_units_id" => 1,
            "duration" => 0,
        ]);
        $this->assertValidationError("duration");
    }
}
