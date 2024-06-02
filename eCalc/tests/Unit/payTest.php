<?php

namespace Tests\Unit;

use Tests\TestCase;
use Mockery;
use App\Models\User;
use App\Models\Bill;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PayTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $response = $this->post('/login', [
            'email' => 'hai@gmail.com',
            'password'=>'28042003']);
        $user = Auth::user();
        $bill = Bill::where('uid',$user->id)->get()->first();
        $bill->status = 'chờ thanh toán';
        $bill->save();
    }
    

    
    public function testTc068(){
        $response=$this->followingRedirects()
        ->get('/pay')
        ->assertSee('KH00073')
        ->assertSee('hai')
        ->assertSee('05-2024')
        ->assertSee('0')
        ->assertSee('0')
        ->assertSee('chờ thanh toán');
    }
   
    public function testTc069(){
        $response=$this->followingRedirects()
        ->post('/pay')
        ->assertSee('KH00073')
        ->assertSee('hai')
        ->assertSee('05-2024')
        ->assertSee('0')
        ->assertSee('0')
        ->assertSee('đã thanh toán');
    }
    public function testTc067(){
        Auth::logout();
        $response=$this->get('/login');
        $response->assertStatus(200);
    }
}
