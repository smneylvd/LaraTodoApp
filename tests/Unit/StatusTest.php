<?php

namespace Tests\Unit;

use App\Models\Status;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StatusTest extends TestCase
{
    use RefreshDatabase;

    // To reset the database after each test

    /** @test */
    public function it_has_correct_fillable_properties()
    {
        $fillable = ['title', 'slug'];

        $status = new Status();

        $this->assertEquals($fillable, $status->getFillable());
    }

    /** @test */
    public function it_dates_attributes_properly()
    {
        $dates = ['created_at', 'updated_at'];

        $status = new Status();

        $this->assertEquals($dates, $status->getDates());
    }
}
