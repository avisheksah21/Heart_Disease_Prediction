<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Prediction;
use Tests\TestCase;

class ProfileControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_displays_user_predictions()
    {
        $user = User::factory()->create();
        Prediction::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('profile'));

        $response->assertStatus(200);
        $response->assertViewIs('profile');
        $response->assertViewHas('predictions');
    }

    /** @test */
    public function it_displays_profile_edit_form()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('profile.edit'));

        $response->assertStatus(200);
        $response->assertViewIs('profile.edit');
        $response->assertViewHas('user', $user);
    }

    /** @test */
    public function it_updates_user_profile()
    {
        $user = User::factory()->create();
        $newData = [
            'name' => 'New Name',
            'email' => 'newemail@example.com',
        ];

        $response = $this->actingAs($user)->patch(route('profile.update'), $newData);

        $response->assertRedirect(route('profile.edit'));
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'New Name',
            'email' => 'newemail@example.com'
        ]);
    }

    /** @test */
    public function it_deletes_user_account()
    {
        $user = User::factory()->create();
        $data = ['password' => 'password']; // Assuming 'password' is the user's password

        $response = $this->actingAs($user)->delete(route('profile.destroy'), $data);

        $response->assertRedirect('/');
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}