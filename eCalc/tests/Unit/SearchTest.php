<?php

namespace Tests\Unit\Http\Controllers;

use Tests\TestCase;
use App\Models\User;
use App\Http\Controllers\calcController;

class SearchTest extends TestCase
{
    public function testSearch_NhapDungThongTin()
    {
        $response = $this->post('/search', ['querry' => 'KH00017']);
        $response->assertViewHas('result', function ($result) {
            $user = User::where('cus_code','KH00017')->first();
            return $result->code === 'KH00017' && $result->name == $user->name;
        });
    }
    public function testSearch_MaKhachHangKhongHopLe()
    {
        $response = $this->post('/search', ['querry' => 'KH11111']);
        $response->assertViewHas('result', null);
        $this->followingRedirects()->get('/search')
        ->assertSee('Không có thông tin!');   
    }
    public function testSearch_BoTrongMaKhachHang()
    {
        $response = $this->post('/search', ['querry' => '']);
        $response->assertViewHas('result', null);
        $this->followingRedirects()->get('/search')
        ->assertSee('Không có thông tin!');   
    }

}
