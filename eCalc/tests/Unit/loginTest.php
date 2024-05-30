<?php
namespace Tests\Unit\Http\Controllers;

use Tests\TestCase;
use App\Models\Ecost;
use App\Http\Controllers\calcController;;

class Logintest extends TestCase
{
    public function testLoginTc021()
    {
        $response = $this->post('/login', [
            'email' => 'trang@gmail.com',
            'password'=>'12345678']);
        $this->followingRedirects()
        ->get('/calc')
        ->assertSee('Quỳnh Trang');
    }
    public function testLoginTc022()
    {
        $response = $this->post('/login', [
            'email' => 'trang%gmail.com',
            'password'=>'12345678']);
        $this->followingRedirects()
        ->get('/login')
        ->assertSee('Email phải đúng định dạng');
    }
    public function testLoginTc023()
    {
        $response = $this->post('/login', [
            'email' => null,
            'password'=>'12345678']);
        $this->followingRedirects()
        ->get('/login')
        ->assertSee('Không được để trống email');
    }
    public function testLoginTc024()
    {
        $response = $this->post('/login', [
            'email' => 'abc@gmail.com',
            'password'=>'12345678']);
        $this->followingRedirects()
        ->get('/login')
        ->assertSee('Thông tin đăng nhập không hợp lệ');
    }
    public function testLoginTc025()
    {
        $response = $this->post('/login', [
            'email' => 'trang@gmail.com',
            'password'=>null]);
        $this->followingRedirects()
        ->get('/login')
        ->assertSee('Không được để trống mật khẩu');
    }
    public function testLoginTc026()
    {
        $response = $this->post('/login', [
            'email' => 'trang@gmail.com',
            'password'=>'12345']);
        $this->followingRedirects()
        ->get('/login')
        ->assertSee('Mật khẩu phải có ít nhất 8 ký tự');
    }
    public function testLoginTc027()
    {
        $response = $this->post('/login', [
            'email' => 'trang@gmail.com',
            'password'=>'12345897']);
        $this->followingRedirects()
        ->get('/login')
        ->assertSee('Thông tin đăng nhập không hợp lệ');
    }
    public function testLoginTc028()
    {
        $response = $this->post('/login', [
            'email' => null,
            'password'=>null]);
        $this->followingRedirects()
        ->get('/login')
        ->assertSee('Không được để trống email')
        ->assertSee('Không được để trống mật khẩu');
    }
    public function testLoginTc029()
    {
        $response = $this->post('/login', [
            'email' => null,
            'password'=>'12345']);
        $this->followingRedirects()
        ->get('/login')
        ->assertSee('Không được để trống email')
        ->assertSee('Mật khẩu phải có ít nhất 8 ký tự');
    }
    public function testLoginTc030()
    {
        $response = $this->post('/login', [
            'email' => 'trang”gmail.com',
            'password'=>'12345']);
        $this->followingRedirects()
        ->get('/login')
        ->assertSee('Email phải đúng định dạng')
        ->assertSee('Mật khẩu phải có ít nhất 8 ký tự');
    }
}