<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_register()
    {
        $response = $this->json('POST','/api/auth/register', [
            'email' => 'test@example.com',
            'name' => 'Test',
            'password' => 'password',
            'confirm_password' => 'password'
        ]);
        $response->assertStatus(200);
    }

    public function test_user_can_login()
    {
        $user = User::factory()->create();
        $response = $this->json('POST','/api/auth/login', [
            'email' => $user['email'],
            'password' => 'password'
        ]);
        $response->assertStatus(200);
    }

    public function test_user_can_request_email_verification_link()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user, 'api')
                         ->json('POST','/api/auth/email/resend');
//        $response->dump();
        $response->assertStatus(200);
    }

//    public function test_user_can_logout()
//    {
//        $user = User::factory()->create();
//        $response = $this->actingAs($user, 'api')
//            ->json('POST','/api/auth/logout');
//        $response->assertStatus(200);
//    }

    public function test_current_user_details_fetch()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user, 'api')
            ->json('POST','/api/auth/me');
        $response->assertStatus(200);
    }

//    public function test_current_user_refresh_token()
//    {
//        $user = User::factory()->create();
//        $response = $this->actingAs($user, 'api')
//            ->json('POST','/api/auth/refresh');
//        $response->assertStatus(200);
//    }
}
