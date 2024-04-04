<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_the_correct_fillable_properties()
    {
        $user = new User();
        $expectedFillable = [
            'name',
            'email',
            'password',
            'api_token',
        ];
        $this->assertEquals($expectedFillable, $user->getFillable());
    }

    /** @test */
    public function it_hides_sensitive_attributes()
    {
        $user = new User();
        $hiddenAttributes = [
            'password',
            'remember_token',
        ];
        $this->assertEquals($hiddenAttributes, $user->getHidden());
    }

    /** @test */
    public function it_casts_attributes_properly()
    {
        $user = new User();
        $expectedCasts = [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'id' => 'int', // Add this line
        ];
        $this->assertEquals($expectedCasts, $user->getCasts());
    }

    /** @test */
    public function it_dates_attributes_properly()
    {
        $user = new User();
        $expectedDates = ['created_at', 'updated_at']; // Remove 'deleted_at' from the expected dates
        $this->assertEquals($expectedDates, $user->getDates());
    }
}
