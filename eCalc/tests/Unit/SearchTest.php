<?php

namespace Tests\Unit\Http\Controllers;

use Tests\TestCase;
use App\Models\User;
use App\Http\Controllers\calcController;

class SearchTest extends TestCase
{
    public function testSearch_tc052()
    {
        $response = $this->post('/search', ['querry' => 'KH00075']);
        $response->assertViewHas('result', function ($result) {
            $user = User::where('cus_code','KH00075')->first();
            return $result->code === 'KH00075' && $result->name == $user->name;
        });
    }
    public function testSearch_tc053()
    {
        $response = $this->post('/search', ['querry' => null]);
        $this->followingRedirects()->get('/search')
        ->assertSee('Không được để trống mã khách hàng');   
    }
    public function testSearch_tc054()
    {
        $response = $this->post('/search', ['querry' => 'K423']);
        $this->followingRedirects()->get('/search')
        ->assertSee('Mã khách hàng phải là chuỗi có 7 ký tự');   
    }

    public function testSearch_tc055()
    {
        $response = $this->post('/search', ['querry' => 'KH00071']);
        $response->assertViewHas('result', function ($result) {
            $user = User::where('cus_code','KH00071')->first();
            return $result->code === 'KH00071' && $result->name == $user->name;
        });  
    }
    public function testSearch_tc056()
    {
        $response = $this->post('/search', ['querry' => 'KH00088']);
        $this->followingRedirects()->get('/search')
        ->assertSee('Không có thông tin!');   
    }
}
