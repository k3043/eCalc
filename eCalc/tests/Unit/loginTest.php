<?php
namespace Tests\Unit\Http\Controllers;

use Tests\TestCase;
use App\Models\Ecost;
use App\Http\Controllers\calcController;;

class Logintest extends TestCase
{
    public function testLoginSuccessedRoleUser()
    {
        $response = $this->post('/login', ['email' => 'xuankhanh3043@gmail.com','password'=>'12345678']);
        $response->assertRedirect('/calc');
    }
    public function testLoginSuccessedRoleAdmin()
    {
        $response = $this->post('/login', ['email' => 'admin@gmail.com','password'=>'12345678']);
        $response->assertRedirect('/customer');
    }
    public function testLoginFailedBecauseOfWrongPassword()
    {
        $response = $this->post('/login', ['email' => 'xuankhanh3043@gmail.com','password'=>'12345677']);
        $response->assertRedirect('/login');
        $this->followingRedirects()
             ->get('/login')->assertSee('Thông tin đăng nhập không hợp lệ');
    }
    public function testLoginFailedBecauseOfEmailEmpty()
    {
        $response = $this->post('/login', ['email' => null,'password'=>'12345678']);
        $response->assertRedirect('/login');
        $this->followingRedirects()
             ->get('/login')->assertSee('The email field is required');
    }
}