<?php

namespace Tests\Unit\Http\Controllers;

use Tests\TestCase;
use App\Models\User;
use App\Models\EConsumption;
use App\Models\Bill;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
class AdminTest extends TestCase
{
    protected $user;
    public function setUp(): void
    {
        parent::setUp();
        // Create a user and log them in
        $this->user = User::factory()->create();
        Auth::login($this->user);
    }

  
    public function testShowAllCustomers()
    {
        $response = $this->actingAs($this->user)->get('/customer');
        $response->assertStatus(200);
        $response->assertViewHas('users');
    }

 
     public function test_redirects_to_login_if_not_authenticated()
     {
         Auth::logout();
         $response = $this->get('/customer');
         $response->assertRedirect('/login');
     }

    public function test_deletes_a_customer()
    {
        $user = User::factory()->create();
        $econ = EConsumption::factory()->create(['uid' => $user->id]);
        $bill = Bill::factory()->create(['uid' => $user->id]);

        $response = $this->actingAs($this->user)->get('/deletecus?uid=' . $user->id);
        // $response->assertRedirect('/customer');
        // $response->assertStatus(200);
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
        $this->assertDatabaseMissing('eConsumptions', ['uid' => $user->id]);
        $this->assertDatabaseMissing('bills', ['uid' => $user->id]);
    }

 
    public function test_changes_user_role()
    {
        $user = User::factory()->create(['role' => 'user']);
        $response = $this->actingAs($this->user)->get('/changerole?uid=' . $user->id);
        // $response->assertRedirect('/customer');
        //$response->assertStatus(200);
        $this->assertDatabaseHas('users', ['id' => $user->id, 'role' => 'admin']);
    }

    public function test_updates_kwh()
    {
        $user = User::factory()->create();
        $econ = EConsumption::factory()->create(['uid' => $user->id, 'econ' => 100]);
        $data = ['kwh' => [$user->id => 150]];

        $response = $this->actingAs($this->user)->post('/updatekwh', $data);
        $response->assertRedirect('/kwh');
        $this->assertDatabaseHas('eConsumptions', ['uid' => $user->id, 'econ' => 150]);
    }

    public function test_sends_notifications_to_users_with_pending_bills()
    {
        Mail::fake();

        $user = User::factory()->create();
        $bill = Bill::factory()->create(['uid' => $user->id, 'status' => 'chờ thanh toán']);

        $response = $this->actingAs($this->user)->get('/noti');
        $response->assertRedirect('/bill');
        //$response->assertStatus(200);
        // Mail::assertSent(function ($mail) use ($user) {
        //     return $mail->hasTo($user->email);
        // });
    }

}
