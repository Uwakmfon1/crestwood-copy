<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_fetch_activity_summary()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user, 'api')
                         ->json('GET', '/api/activity/summary');

        $response->assertStatus(200);
    }

    public function test_fetch_rates()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user, 'api')
            ->json('GET', '/api/rates');

        $response->assertStatus(200);
    }

    public function test_change_password()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user, 'api')
                         ->json('POST', '/api/password/custom/change', [
                             'old_password' => 'password',
                             'new_password' => 'password',
                             'confirm_password' => 'password',
                         ]);

//        $response->dump();
        $response->assertStatus(200);
    }

    public function test_update_profile()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user, 'api')
            ->json('POST', '/api/profile/update', [
                'name' => 'Test',
                'phone' => '2563416513',
                'phone_code' => '254',
                'state' => 'Lagos',
                'country' => 'Test',
                'city' => 'Test',
                'address' => 'Test',
                'bank_name' => 'Test',
                'account_name' => 'Test',
                'account_number' => 'Test',
                'nk_name' => 'Test',
                'nk_phone' => '01234567890',
                'nk_address' => 'Test',
            ]);

//        $response->dump();
        $response->assertStatus(200);
    }
}
