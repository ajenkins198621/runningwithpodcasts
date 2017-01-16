<?php

use App\Runs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ViewRunTest extends TestCase
{

    use DatabaseMigrations;

    /** @test */
    public function user_can_view_public_individual_run()
    {
        $run = factory(Runs::class)->states("public")->create();
        $this->visit("/runs/".$run->id);

        $this->see("5.00 miles");
        $this->see("40:00");
        $this->see("Jersey City");
    }

    /** @test */
    public function user_cannot_view_unpublished_individual_run()
    {
        $run = factory(Runs::class)->states("unpublished")->create();
        $this->visit("/runs/".$run->id);
        $this->see("Unpublished content");
    }

    /** @test */
    public function runs_with_public_set_to_zero_cannot_be_viewed()
    {
        $runA = factory(Runs::class)->states("public")->create();
        $runB = factory(Runs::class)->states("unpublished")->create();

        $runs = Runs::isPublic()->get();

        $this->assertTrue($runs->contains($runA));
        $this->assertFalse($runs->contains($runB));
    }

}
