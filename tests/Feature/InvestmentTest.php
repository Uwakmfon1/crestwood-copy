<?php

namespace Tests\Feature;

use App\Models\Investment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InvestmentTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_fetch_user_investments()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user, 'api')
                         ->get('/api/investments');

//        $response->dump();
        $response->assertStatus(200);
    }
}
