<?php
namespace Tests\Unit\Http\Controllers;

use Tests\TestCase;
use App\Models\User;
use App\Models\Bill;
use App\Http\Controllers\calcController;
use App\Models\EConsumption;

;

class SignUpTest extends TestCase
{

    public function testSignUpSuccessed()
    {
        $user =  User::where('email', 'trang28@gmail.com')->first();
        if($user){
            EConsumption::where('uid', $user->id)->delete();
            Bill::where('uid', $user->id)->delete();
        }

        User::where('email', 'trang28@gmail.com')->delete();


        $response = $this->post('/register', ['email' => 'trang28@gmail.com',
        'password'=>'14122003',
        'password_confirmation'=>'14122003',
        'name'=>'trang'
    ]);
        $response->assertRedirect('/calc');
        $this->followingRedirects()
             ->get('/calc')
             ->assertSee('trang');
    }

    public function testSignUpTC002()
    {
        $response = $this->post('/register', ['email' => 'trang28@gmail.com',
        'password'=>'14122003',
        'password_confirmation'=>'14122003',
        'name'=>null
    ]);
        $response->assertRedirect('/register');
        $this->followingRedirects()
             ->get('/register')
             ->assertSee('Tên không được để trống');
    }

    public function testSignUpTC003()
    {
        $response = $this->post('/register', [
        'email' => null,
        'password'=>'14122003',
        'password_confirmation'=>'14122003',
        'name'=>'trang'
    ]);
        $response->assertRedirect('/register');
        $this->followingRedirects()
             ->get('/register')
             ->assertSee('Email không được để trống');
    }

    public function testSignUpTC004()
    {
        $response = $this->post('/register', [
        'email' => 'trang28@gmail.com',
        'password'=>null,
        'password_confirmation'=>'14122003',
        'name'=>'trang'
    ]);
        $response->assertRedirect('/register');
        $this->followingRedirects()
             ->get('/register')
             ->assertSee('Mật khẩu không được để trống');
    }
    public function testSignUpTC005()
    {
        $response = $this->post('/register', [
        'email' => 'trang28@gmail.com',
        'password'=>'14122003',
        'password_confirmation'=>null,
        'name'=>'trang'
    ]);
        $response->assertRedirect('/register');
        $this->followingRedirects()
             ->get('/register')
             ->assertSee('Xác nhận mật khẩu không khớp');
    }
    public function testSignUpTC006()
    {
        $response = $this->post('/register', [
        'email' => 'trang28%gmail.com',
        'password'=>'14122003',
        'password_confirmation'=>'14122003',
        'name'=>'trang'
    ]);
        $response->assertRedirect('/register');
        $this->followingRedirects()
             ->get('/register')
             ->assertSee('Email phải đúng định dạng');
    }
    public function testSignUpTC007()
    {
        $response = $this->post('/register', [
        'email' => 'trang12@gmail.com',
        'password'=>'14122003',
        'password_confirmation'=>'14122003',
        'name'=>'trang'
    ]);
        $response->assertRedirect('/register');
        $this->followingRedirects()
             ->get('/register')
             ->assertSee('Email đã tồn tại');
    }
    public function testSignUpTC008()
    {
        $response = $this->post('/register', [
        'email' => 'trang12@gmail.com',
        'password'=>'141220',
        'password_confirmation'=>'141220',
        'name'=>'trang'
    ]);
        $response->assertRedirect('/register');
        $this->followingRedirects()
             ->get('/register')
             ->assertSee('Mật khẩu phải có ít nhất 8 ký tự');
    }

    public function testSignUpTC009()
    {
        $response = $this->post('/register', [
        'email' => 'trang12@gmail.com',
        'password'=>'14122003',
        'password_confirmation'=>'14122000',
        'name'=>'trang'
    ]);
        $response->assertRedirect('/register');
        $this->followingRedirects()
             ->get('/register')
             ->assertSee('Xác nhận mật khẩu không khớp');
    }

    public function testSignUpTC010()
    {
        $response = $this->post('/register', [
        'email' => null,
        'password'=>null,
        'password_confirmation'=>null,
        'name'=>null
    ]);
        $response->assertRedirect('/register');
        $this->followingRedirects()
             ->get('/register')
             ->assertSee('Tên không được để trống')
             ->assertSee('Email không được để trống')
             ->assertSee('Mật khẩu không được để trống');
    }
    public function testSignUpTC011()
    {
        $response = $this->post('/register', [
        'email' => 'trang#gmail.com',
        'password'=>'12345',
        'password_confirmation'=>'1234567',
        'name'=>'trang'
    ]);
        $response->assertRedirect('/register');
        $this->followingRedirects()
             ->get('/register')
             ->assertSee('Email phải đúng định dạng')
             ->assertSee('Mật khẩu phải có ít nhất 8 ký tự')
             ->assertSee('Xác nhận mật khẩu không khớp');
    }
    public function testSignUpTC012()
    {
        $response = $this->post('/register', [
        'email' => 'trang#gmail.com',
        'password'=>'        ',
        'password_confirmation'=>'        ',
        'name'=>'trang'
    ]);
        $response->assertRedirect('/register');
        $this->followingRedirects()
             ->get('/register')
             ->assertSee('Email phải đúng định dạng')
             ->assertSee('Mật khẩu không được để trống');
    }
    public function testSignUpTC013()
    {
        $response = $this->post('/register', [
        'email' => 'trang#gmail.com',
        'password'=>'12345678',
        'password_confirmation'=>'12345678',
        'name'=>null
    ]);
        $response->assertRedirect('/register');
        $this->followingRedirects()
             ->get('/register')
             ->assertSee('Email phải đúng định dạng')
             ->assertSee('Tên không được để trống');
    }
    public function testSignUpTC014()
    {
        $response = $this->post('/register', [
        'email' => null,
        'password'=>null,
        'password_confirmation'=>'12345678',
        'name'=>null
    ]);
        $response->assertRedirect('/register');
        $this->followingRedirects()
             ->get('/register')
             ->assertSee('Email không được để trống')
             ->assertSee('Mật khẩu không được để trống');
    }
    public function testSignUpTC015()
    {
        $response = $this->post('/register', [
        'email' => 'trang#gmail.com',
        'password'=>null,
        'password_confirmation'=>'1234',
        'name'=>null
    ]);
        $response->assertRedirect('/register');
        $this->followingRedirects()
             ->get('/register')
             ->assertSee('Tên không được để trống')
             ->assertSee('Email phải đúng định dạng')
             ->assertSee('Mật khẩu không được để trống');
    }
    public function testSignUpTC016()
    {
        $response = $this->post('/register', [
        'email' => 'trang12@gmail.com',
        'password'=>'12345678',
        'password_confirmation'=>'12345678',
        'name'=>null
    ]);
        $response->assertRedirect('/register');
        $this->followingRedirects()
             ->get('/register')
             ->assertSee('Email đã tồn tại')
             ->assertSee('Tên không được để trống');
    }
    public function testSignUpTC017()
    {
        $response = $this->post('/register', [
        'email' => 'trang12@gmail.com',
        'password'=>'        ',
        'password_confirmation'=>null,
        'name'=>null
    ]);
        $response->assertRedirect('/register');
        $this->followingRedirects()
             ->get('/register')
             ->assertSee('Email đã tồn tại')
             ->assertSee('Mật khẩu không được để trống');
    }
    public function testSignUpTC018()
    {
        $response = $this->post('/register', [
        'email' => 'trang12@gmail.com',
        'password'=>'12312',
        'password_confirmation'=>'123',
        'name'=>null
    ]);
        $response->assertRedirect('/register');
        $this->followingRedirects()
             ->get('/register')
             ->assertSee('Tên không được để trống')
             ->assertSee('Email đã tồn tại')
             ->assertSee('Mật khẩu phải có ít nhất 8 ký tự')
             ->assertSee('Xác nhận mật khẩu không khớp');
    }
    public function testSignUpTC019()
    {
        $response = $this->post('/register', [
        'email' => 'trang#gmail.com',
        'password'=>'123',
        'password_confirmation'=>'123',
        'name'=>null
    ]);
        $response->assertRedirect('/register');
        $this->followingRedirects()
             ->get('/register')
             ->assertSee('Tên không được để trống')
             ->assertSee('Email phải đúng định dạng')
             ->assertSee('Mật khẩu phải có ít nhất 8 ký tự');
    }
    public function testSignUpTC020()
    {
        $response = $this->post('/register', [
        'email' => 'trang@gmail.com',
        'password'=>'123',
        'password_confirmation'=>'12345678',
        'name'=>'trang'
    ]);
        $response->assertRedirect('/register');
        $this->followingRedirects()
             ->get('/register')
             ->assertSee('Xác nhận mật khẩu không khớp')
             ->assertSee('Email đã tồn tại')
             ->assertSee('Mật khẩu phải có ít nhất 8 ký tự');
    }
}