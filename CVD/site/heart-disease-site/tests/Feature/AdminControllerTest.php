<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Prediction;
use Tests\TestCase;

class AdminControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_access_dashboard()
    {
        $admin = User::factory()->create(['is_admin' => true]);

        // Create a fully populated prediction
        $prediction = Prediction::factory()->create([
            'user_id' => $admin->id // Optionally associate with admin
        ]);

        $response = $this->actingAs($admin)->get(route('admin'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.dashboard');
        $response->assertViewHas('predictions_data');
    }

    /** @test */
    public function non_admin_cannot_access_dashboard()
    {
        $user = User::factory()->create(['is_admin' => false]);

        $response = $this->actingAs($user)->get(route('admin'));

        $response->assertRedirect('/');
    }

    /** @test */
    public function unauthenticated_user_cannot_access_admin_dashboard()
    {
        $response = $this->get(route('admin'));

        $response->assertRedirect(route('login'));
    }
}