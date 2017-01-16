<?php

use App\DistanceUnits;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DistanceUnitsTest extends TestCase
{

    use DatabaseMigrations;

    /** @test */
    public function distance_units_table_has_miles()
    {
        $units = DistanceUnits::byId(1)->first();
        $this->assertTrue($units->name == "miles");
    }

    /** @test */
    public function distance_units_table_has_kilometers()
    {
        $units = DistanceUnits::byId(2)->first();
        $this->assertTrue($units->name == "kilometers");
    }


}
