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
        $this->actingAs($user);
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

    /** @test */
    public function logged_in_user_can_view_submit_run_through_form_in_ui()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $this->visit('/run/create/form');
        $this->see("Distance");
        $this->see("Duration");
        $this->see("Location");
        $this->see("Date");
    }

    /** @test */
    public function logged_in_user_cannot_view_submit_run_through_form_in_ui()
    {
        $this->visit('/run/create/form');
        $this->dontSee("Distance");
        $this->dontSee("Duration");
        $this->dontSee("Location");
        $this->dontSee("Date");
    }


    /** @test */
    public function user_can_submit_run_through_form_in_ui()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)
            ->visit("/run/create/form")
            ->type(5000, "distance")
            ->select(1, "distance_units_id")
            ->type(1000, "duration")
            ->type("Jersey City", "location")
            ->type("2017-01-2016 12:00:00", "date")
            ->press("Submit");
        $this->assertGreaterThan(0,$user->runs()->count());
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
