<?php

namespace Tests\Unit\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use App\Models\User;
use App\Models\Bill;
use App\Http\Controllers\calcController;
use Illuminate\Support\Facades\Mail;
use Mockery;

class PayTest extends TestCase
{
    public function test_pay_updates_bill_status_and_sends_email()
    {
        // Tạo người dùng và hóa đơn
        $user = User::factory()->create();
        $bill = Bill::factory()->create(['uid' => $user->id, 'status' => 'chờ thanh toán']);

        // Giả lập Auth::user() và Auth::guard()
        $authMock = Mockery::mock('overload:Illuminate\Support\Facades\Auth');
        $authMock->shouldReceive('guard')->andReturnSelf();
        $authMock->shouldReceive('user')->andReturn($user);

        // Giả lập gửi email
        Mail::fake();

        // Gọi phương thức `pay`
        $response = $this->actingAs($user)->post('/pay');

        // Kiểm tra hóa đơn đã được cập nhật đúng trạng thái
        $this->assertDatabaseHas('bills', [
            'id' => $bill->id,
            'status' => 'đã thanh toán',
        ]);

        // Kiểm tra email đã được gửi
        Mail::assertSent(function ($mail) use ($user, $bill) {
            return $mail->hasTo($user->email) && $mail->subject === 'Ebill thông báo!';
        });

        // Kiểm tra chuyển hướng đúng
        $response->assertRedirect('/pay');
    }

    public function test_showpay_displays_payment_page_if_authenticated()
    {
        // Tạo người dùng và hóa đơn
        $user = User::factory()->create();
        $bill = Bill::factory()->create(['uid' => $user->id]);

        // Giả lập Auth::check() và Auth::user()
        $authMock = Mockery::mock('overload:Illuminate\Support\Facades\Auth');
        $authMock->shouldReceive('check')->andReturn(true);
        $authMock->shouldReceive('guard')->andReturnSelf();
        $authMock->shouldReceive('user')->andReturn($user);

        // Gọi phương thức `showpay`
        $response = $this->actingAs($user)->get('/pay');

        // Kiểm tra view được hiển thị và dữ liệu được truyền đúng
        $response->assertStatus(200);
        $response->assertViewIs('pay');
        $response->assertViewHas('bill', $bill);
        $response->assertViewHas('user', $user);
    }

    public function test_showpay_redirects_to_login_if_not_authenticated()
    {
        // Giả lập Auth::check()
        $authMock = Mockery::mock('overload:Illuminate\Support\Facades\Auth');
        $authMock->shouldReceive('check')->andReturn(false);

        // Gọi phương thức `showpay`
        $response = $this->get('/pay');

        // Kiểm tra view đăng nhập được hiển thị
        $response->assertViewIs('login');
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

}
