<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Ecost;
use App\Models\Bill;
use App\Http\Controllers\calcController;
use App\Models\EConsumption;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class CalcControllerTest extends TestCase
{

    public function testIndex()
    {
        // Tạo dữ liệu giả
        Ecost::create([
            'c1' => 1678,
            'c2' => 1734,
            'c3' => 2014,
            'c4' => 2536,
            'c5' => 2834,
            'c6' => 2927,
        ]);

        // Gửi request đến route
        $response = $this->get('/');

        // Kiểm tra xem có trả về view đúng hay không
        $response->assertStatus(200);
        $response->assertViewIs('calc');
        $response->assertViewHasAll([
            'c1' => 1678,
            'c2' => 1734,
            'c3' => 2014,
            'c4' => 2536,
            'c5' => 2834,
            'c6' => 2927,
        ]);
    }

    public function testCalc()
    {
        // Tạo dữ liệu giả
        Ecost::create([
            'c1' => 1678,
            'c2' => 1734,
            'c3' => 2014,
            'c4' => 2536,
            'c5' => 2834,
            'c6' => 2927,
        ]);

        // Gửi request đến route
        $response = $this->post('/calc', [
            'kWh' => 150,
        ]);

        // Kiểm tra xem có trả về view đúng hay không
        $response->assertStatus(200);
        $response->assertViewIs('calc');
        $response->assertViewHas('total');
    }

    public function testShowCost()
    {
        // Gửi request đến route
        $response = $this->get('/showcost');

        // Kiểm tra xem có trả về view đúng hay không
        $response->assertStatus(200);
        $response->assertViewIs('cost');
        $response->assertViewHasAll([
            'c1' => 1678,
            'c2' => 1734,
            'c3' => 2014,
            'c4' => 2536,
            'c5' => 2834,
            'c6' => 2927,
        ]);
    }

    public function testSearch()
    {
        // Tạo dữ liệu giả
        $user = User::factory()->create([
            'cus_code' => 'KH00001',
        ]);

        EConsumption::create([
            'uid' => $user->id,
            'econ' => 100,
            'updated_at' => Carbon::now(),
            'period' => Carbon::now()->subMonths(1)->endOfMonth(),
        ]);

        // Gửi request đến route
        $response = $this->post('/search', [
            'querry' => 'KH00001',
        ]);

        // Kiểm tra xem có trả về view đúng hay không
        $response->assertStatus(200);
        $response->assertViewIs('search');
        $response->assertViewHas('result');
    }

    public function testPay()
    {
        // Tạo dữ liệu giả
        $user = User::factory()->create();
        Auth::login($user);

        $bill = Bill::create([
            'uid' => $user->id,
            'status' => 'chưa thanh toán',
            'updated_at' => Carbon::now(),
        ]);

        // Gửi request đến route
        Mail::fake();
        $response = $this->post('/pay');

        // Kiểm tra xem có trả về view đúng hay không
        $response->assertStatus(302);
        $response->assertRedirect('/pay');

        // Kiểm tra trạng thái của hóa đơn
        $this->assertEquals('đã thanh toán', $bill->fresh()->status);

        // Kiểm tra email đã được gửi đi
        Mail::assertSent(function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });
    }

    public function testShowPay()
    {
        // Tạo dữ liệu giả
        $user = User::factory()->create();
        Auth::login($user);

        Bill::create([
            'uid' => $user->id,
            'status' => 'chưa thanh toán',
            'updated_at' => Carbon::now(),
        ]);

        // Gửi request đến route
        $response = $this->get('/pay');

        // Kiểm tra xem có trả về view đúng hay không
        $response->assertStatus(200);
        $response->assertViewIs('pay');
        $response->assertViewHas('bill');
    }

    public function testShowBill()
    {
        // Tạo dữ liệu giả
        $user = User::factory()->create();
        Auth::login($user);

        Bill::create([
            'uid' => $user->id,
            'status' => 'chưa thanh toán',
            'updated_at' => Carbon::now(),
        ]);

        // Gửi request đến route
        $response = $this->get('/bill');

        // Kiểm tra xem có trả về view đúng hay không
        $response->assertStatus(200);
        $response->assertViewIs('bill');
        $response->assertViewHas('bill');
    }

    public function testCalculateStaticMethod()
    {
        // Tạo dữ liệu giả
        Ecost::create([
            'c1' => 1678,
            'c2' => 1734,
            'c3' => 2014,
            'c4' => 2536,
            'c5' => 2834,
            'c6' => 2927,
        ]);

        $total = calcController::caculate(150);

        $this->assertEquals(248.49, $total); // Giá trị này có thể thay đổi tùy theo logic tính toán của bạn
    }
}
