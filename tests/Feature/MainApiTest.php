<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use App\Models\User;
use App\Models\Employee;

class MainApiTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_admin_can_access_own_data()
    {
        Sanctum::actingAs(User::factory()->create());

       $this->json('get', 'api/admin')->assertStatus(200);
   
    }
    public function test_the_admin_can_change_employee_bouns_percentage()
    {
       $user  = User::factory()->create();
       $token = $user->createToken($user->email)->plainTextToken;
       $employee = Employee::factory()->create();

       $headers = ['Authorization' => "Bearer $token"];
       $payload = [
           'percentages' => 0.1,
       ];

       $this->json('POST', 'api/admin/changeBounsPercentage/'. $employee->id, $payload, $headers)
           ->assertStatus(200)
           ->assertJson(['status' => 1, 'message' => 'bouns percentages changed successfully']);
    }


  
}
