<?php

namespace Tests\Unit\Http\Controllers;

use Tests\TestCase;
use App\Models\User;
use App\Http\Controllers\calcController;

class SearchTest extends TestCase
{
    public function testShowCost()
    {
        $response = $this->get('/showcost');
        $response->assertStatus(200);
    }

    public function testSearch_NhapDungThongTin()
    {
        $response = $this->post('/search', ['querry' => 'KH00004']);
        $response->assertViewHas('result', function ($result) {
            $user = User::where('cus_code','KH00004')->first();
            return $result->code === 'KH00004' && $result->name == $user->name;
        });
    }
    public function testSearch_MaKhachHangKhongHopLe()
    {
        $response = $this->post('/search', ['querry' => 'KH11111']);
        $response->assertViewHas('result', null);
    }
    public function testSearch_BoTrongMaKhachHang()
    {
        $response = $this->post('/search', ['querry' => '']);
        $response->assertViewHas('result', null);
    }

}
