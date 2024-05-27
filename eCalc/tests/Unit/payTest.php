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
    public function test_pay_function()
    {
        // Tạo user giả
        $user = User::factory()->create();
        
        // Tạo bill giả
        $bill = Bill::factory()->create([
            'uid' => $user->id,
            'status' => 'chờ thanh toán',
        ]);
        
        // Mock Auth::user() để trả về user giả
        Auth::shouldReceive('user')->once()->andReturn($user);

        // Mock Bill::where()->latest()->first() để trả về bill giả
        Bill::shouldReceive('where')->once()->with('uid', $user->id)->andReturnSelf();
        Bill::shouldReceive('latest')->once()->with('updated_at')->andReturnSelf();
        Bill::shouldReceive('first')->once()->andReturn($bill);

        // Mock Mail::send()
        Mail::shouldReceive('send')->once()->with('mail', compact('user', 'bill'), Mockery::on(function ($closure) use ($user) {
            $mockEmail = Mockery::mock('Illuminate\Mail\Message');
            $mockEmail->shouldReceive('to')->once()->with($user->email);
            $mockEmail->shouldReceive('subject')->once()->with('Ebill thông báo!');
            $closure($mockEmail);
            return true;
        }));

        // Thực thi function pay()
        $response = $this->post('/pay');

        // Kiểm tra bill đã được cập nhật
        $this->assertEquals('đã thanh toán', $bill->fresh()->status);

        // Kiểm tra redirect
        $response->assertRedirect('/pay');
    }
    
    public function test_showpay_function_authenticated_user()
    {
        // Tạo user giả
        $user = User::factory()->create();
        
        // Tạo bill giả
        $bill = Bill::factory()->create([
            'uid' => $user->id,
        ]);

        // Mock Auth::check() và Auth::user()
        Auth::shouldReceive('check')->once()->andReturn(true);
        Auth::shouldReceive('user')->once()->andReturn($user);

        // Mock Bill::where()->latest()->first() để trả về bill giả
        Bill::shouldReceive('where')->once()->with('uid', $user->id)->andReturnSelf();
        Bill::shouldReceive('latest')->once()->with('updated_at')->andReturnSelf();
        Bill::shouldReceive('first')->once()->andReturn($bill);

        // Thực thi function showpay()
        $response = $this->get('/showpay');

        // Kiểm tra view trả về
        $response->assertViewIs('pay');
        $response->assertViewHas('bill', $bill);
        $response->assertViewHas('user', $user);
    }

    public function test_showpay_function_unauthenticated_user()
    {
        // Mock Auth::check()
        Auth::shouldReceive('check')->once()->andReturn(false);

        // Thực thi function showpay()
        $response = $this->get('/showpay');

        // Kiểm tra view trả về
        $response->assertViewIs('login');
    }
}
