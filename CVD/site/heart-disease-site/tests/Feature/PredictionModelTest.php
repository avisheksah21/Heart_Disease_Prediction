<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Prediction;
use Tests\TestCase;

class PredictionModelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_a_user()
    {
        $user = User::factory()->create();
        $prediction = Prediction::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $prediction->user);
        $this->assertEquals($user->id, $prediction->user->id);
    }
}