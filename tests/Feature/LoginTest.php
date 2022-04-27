<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use App\Models\User;

class LoginTest extends TestCase
{
    /** @test */
    public function it_provide_token_on_admin_login()
    {
        $admin = User::factory()->create();
        $response = $this->json('POST', 'api/admin/login', [
            'email' => $admin->email,
            'password' =>  '123456'
        ])->assertStatus(200);
        $this->assertArrayHasKey('token',$response->json()['data']);
       
    }
}