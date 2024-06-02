<?php

namespace Tests\Unit\Http\Controllers;

use Tests\TestCase;
use App\Models\User;
use App\Models\EConsumption;
use App\Models\Bill;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
class UpdateCostTest extends TestCase
{
    protected $user;
    public function setUp(): void
    {
        parent::setUp();
        $response = $this->post('/login', [
            'email' => 'admin@gmail.com',
            'password'=>'12345678']);
        // Auth::login($this->user);
    }
    
    public function testTc057(){
        $data = [
            'c1' => 100,
            'c2' => 200,
            'c3' => 300,
            'c4' => 400,
            'c5' => 500,
            'c6' => 600,
        ];
        $response = $this->post('/updatecost', $data);
        $response->assertRedirect('/showcost');
        $this->assertDatabaseHas('ecosts', $data);
    }

    public function testTc058(){
       
        $data = [
            'c1' => 'sdahd',
            'c2' => 200,
            'c3' => 300,
            'c4' => 400,
            'c5' => 500,
            'c6' => 600,
        ];
        $response = $this->post('/updatecost', $data);
        $this->followingRedirects()->get('/showcost')
                    ->assertSee("Số điện phải là số");

    }
    public function testTc059(){
       
        $data = [
            'c1' => -3000,
            'c2' => 200,
            'c3' => 300,
            'c4' => 400,
            'c5' => 500,
            'c6' => 600,
        ];
        $response = $this->post('/updatecost', $data);
        $this->followingRedirects()->get('/showcost')
                    ->assertSee("Số điện phải lớn hơn hoặc bằng 0");

    }
    public function testTc060(){
       
        $data = [
            'c1' => null,
            'c2' => 200,
            'c3' => 300,
            'c4' => 400,
            'c5' => 500,
            'c6' => 600,
        ];
        $response = $this->post('/updatecost', $data);
        $this->followingRedirects()->get('/showcost')
                    ->assertSee("Số điện bậc 1 không được để trống");

    }
    public function testTc062(){
       
        $data = [
            'c1' => 'sdahd',
            'c2' => '‘3;4’12’;',
            'c3' => 300,
            'c4' => 400,
            'c5' => 500,
            'c6' => 600,
        ];
        $response = $this->post('/updatecost', $data);
        $this->followingRedirects()->get('/showcost')
                    ->assertSee("Số điện phải là số");

    }
    public function testTc063(){
       
        $data = [
            'c1' => null,
            'c2' => null,
            'c3' => 300,
            'c4' => 400,
            'c5' => 500,
            'c6' => 600,
        ];
        $response = $this->post('/updatecost', $data);
        $this->followingRedirects()->get('/showcost')
                    ->assertSee("Số điện bậc 1 không được để trống")
                    ->assertSee("Số điện bậc 2 không được để trống");

    }
    public function testTc064(){
       
        $data = [
            'c1' => null,
            'c2' => 'sdahd',
            'c3' => 300,
            'c4' => 400,
            'c5' => 500,
            'c6' => 600,
        ];
        $response = $this->post('/updatecost', $data);
        $this->followingRedirects()->get('/showcost')
                    ->assertSee("Số điện bậc 1 không được để trống")
                    ->assertSee("Số điện phải là số");

    }
    public function testTc065(){
       
        $data = [
            'c1' => null,
            'c2' => null,
            'c3' => null,
            'c4' => null,
            'c5' => null,
            'c6' => null,
        ];
        $response = $this->post('/updatecost', $data);
        $this->followingRedirects()->get('/showcost')
                    ->assertSee("Số điện bậc 1 không được để trống")
                    ->assertSee("Số điện bậc 2 không được để trống")
                    ->assertSee("Số điện bậc 3 không được để trống")
                    ->assertSee("Số điện bậc 4 không được để trống")
                    ->assertSee("Số điện bậc 5 không được để trống")
                    ->assertSee("Số điện bậc 6 không được để trống");

    }
    public function testTc066()
    {
       
        $data = [
            'c1' => 100,
            'c2' => 200,
            'c3' => 300,
            'c4' => 400,
            'c5' => 500,
            'c6' => 'dsgfsf',
        ];
        $response = $this->post('/updatecost', $data);
        $this->followingRedirects()->get('/showcost')
                    ->assertSee("Số điện phải là số");

    }
    public function testReset()
    {
        $basedata = [
            'c1' => 1678,
            'c2' => 1734,
            'c3' => 2014,
            'c4' => 2536,
            'c5' => 2834,
            'c6' => 2927,
        ];
        $response = $this->post('/updatecost', $basedata);
        $response->assertRedirect('/showcost');
    }
}