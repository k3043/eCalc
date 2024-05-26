<?php
namespace Tests\Unit\Http\Controllers;

use Tests\TestCase;
use App\Models\User;
use App\Http\Controllers\calcController;
use App\Models\EConsumption;

;

class SignUpTest extends TestCase
{

    public function testSignUpSuccessed()
    {
        //xóa các thông tin liên quan trước khi thêm mới người dùng
        $user =  User::where('email', 'test@gmail.com')->first();
        EConsumption::where('uid', $user->id)->delete();
        User::where('email', 'test@gmail.com')->delete();


        $response = $this->post('/register', ['email' => 'test@gmail.com',
        'password'=>'12345678',
        'password_confirmation'=>'12345678',
        'name'=>'Test'
    ]);
        $response->assertRedirect('/calc');
        $this->followingRedirects()
             ->get('/calc')
             ->assertSee('Test');
    }
    public function testSignUpFailedBecauseOfEmptyField()
    {
        $response = $this->post('/register', ['email' => 'test@gmail.com',
        'password'=>null,
        'password_confirmation'=>'12345678',
        'name'=>'Test'
    ]);
        $response->assertRedirect('/register');
        $this->followingRedirects()
             ->get('/register')
             ->assertSee('required');
    }

}