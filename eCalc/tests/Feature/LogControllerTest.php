<?php

namespace Tests\Feature;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LogControllerTest extends TestCase
{
    public function testLoginSuccess()
    {
        // Tạo một người dùng thử
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // Gửi yêu cầu đăng nhập
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        // Kiểm tra chuyển hướng sau khi đăng nhập thành công
        $response->assertRedirect('/customer');
        $this->assertAuthenticatedAs($user);
    }

    public function testLoginFailure()
    {
        // Gửi yêu cầu đăng nhập với thông tin không đúng
        $response = $this->post('/login', [
            'email' => 'wrong@example.com',
            'password' => 'wrongpassword',
        ]);

        // Kiểm tra chuyển hướng sau khi đăng nhập thất bại
        $response->assertRedirect('/login');
        $response->assertSessionHasErrors();
        $this->assertGuest();
    }
    public function testRegisterSuccess()
{
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response->assertRedirect('/calc');
    $this->assertDatabaseHas('users', [
        'email' => 'test@example.com',
    ]);
}

public function testRegisterValidationFailure()
{
    $response = $this->post('/register', [
        'name' => '',
        'email' => 'invalid-email',
        'password' => 'short',
        'password_confirmation' => 'mismatch',
    ]);

    $response->assertRedirect('/register');
    $response->assertSessionHasErrors(['name', 'email', 'password']);
    $this->assertGuest();
}
public function testLogout()
{
    $user = User::factory()->create();

    $this->actingAs($user);
    $response = $this->get('/logout');

    $response->assertRedirect('/');
    $this->assertGuest();
}

}
