<?php

namespace Tests\Unit\Http\Controllers;

use Tests\TestCase;
use App\Models\User;
use App\Http\Controllers\calcController;

class CalculateTest extends TestCase
{

    public function testCalculateNegativeKwh()
    {
      
    $response = $this->post('/calc', ['kWh' => -300]);
    $this->followingRedirects()->get('/calc')
        ->assertSee('Số điện phải là số dương');      
    }
    public function testCalculateStringKwh()
    {
    $response = $this->post('/calc', ['kWh' => "fdsd"]);
    $this->followingRedirects()->get('/calc')
        ->assertSee('Số điện phải là số');      
    }
    public function testCalculateEmptyKwh()
    {
    $response = $this->post('/calc', ['kWh' => null]);
    $this->followingRedirects()->get('/calc')
        ->assertSee('Không được để trống số điện');      
    }

    public function testCalculate50kwh()
    {
        
    $response = $this->post('/calc', ['kWh' => 50]);
    $response->assertStatus(200)
      
        ->assertViewHas('total', 92290)
        ->assertViewHas('tax', 8390) 
        ->assertViewHas('cost', 83900);      
    }
    public function testCalculate51kwh()
    {
        
    $response = $this->post('/calc', ['kWh' => 51]);
    $response->assertStatus(200)
      
        ->assertViewHas('total', 94197.4)
        ->assertViewHas('tax', 8563.4) 
        ->assertViewHas('cost', 85634);      
    }
    public function testCalculate49kwh()
    {
        
    $response = $this->post('/calc', ['kWh' => 49]);
    $response->assertStatus(200)
      
        ->assertViewHas('total', 90444.2)
        ->assertViewHas('tax', 8222.2) 
        ->assertViewHas('cost', 82222);      
    }
    
    public function testCalculate100kwh()
    {
    $response = $this->post('/calc', ['kWh' => 100]);
    
    $response->assertStatus(200)
    
        ->assertViewHas('total', 187660)
        ->assertViewHas('tax', 17060) 
        ->assertViewHas('cost', 170600);      
    }
    public function testCalculate101kwh()
    {
    $response = $this->post('/calc', ['kWh' => 101]);
    
    $response->assertStatus(200)
    
        ->assertViewHas('total', 189875.4)
        ->assertViewHas('tax', 17261.4) 
        ->assertViewHas('cost', 172614);      
    }

    public function testCalculate200kwh()
    { 
    $response = $this->post('/calc', ['kWh' => 200]);
    $response->assertStatus(200)
        // Expected total value for kWh = 200
        ->assertViewHas('total', 409200)
        ->assertViewHas('tax', 37200) 
        ->assertViewHas('cost', 372000);      
    }
    public function testCalculate201kwh()
    { 
    $response = $this->post('/calc', ['kWh' => 201]);
    $response->assertStatus(200)
        ->assertViewHas('total', 411989.6)
        ->assertViewHas('tax', 37453.6) 
        ->assertViewHas('cost', 374536);      
    }
    public function testCalculate199kwh()
    { 
    $response = $this->post('/calc', ['kWh' => 199]);
    $response->assertStatus(200)
        ->assertViewHas('total', 406984.6)
        ->assertViewHas('tax', 36998.6) 
        ->assertViewHas('cost', 369986);      
    }

    public function testCalculate300kwh()
    { 
    $response = $this->post('/calc', ['kWh' => 300]);
    $response->assertStatus(200)
        ->assertViewHas('total', 688160)
        ->assertViewHas('tax', 62560) 
        ->assertViewHas('cost', 625600);      
    }
    public function testCalculate301kwh()
    { 
    $response = $this->post('/calc', ['kWh' => 301]);
    $response->assertStatus(200)
        ->assertViewHas('total', 691277.4)
        ->assertViewHas('tax', 62843.4) 
        ->assertViewHas('cost', 628434);      
    }
    public function testCalculate299kwh()
    { 
    $response = $this->post('/calc', ['kWh' => 299]);
    $response->assertStatus(200)
        ->assertViewHas('total', 685370.4)
        ->assertViewHas('tax', 62306.4) 
        ->assertViewHas('cost', 623064);      
    }
   
    public function testCalculate400kwh()
    {
    $response = $this->post('/calc', ['kWh' => 400]);
    $response->assertStatus(200)
    
        ->assertViewHas('total', 999900)
        ->assertViewHas('tax', 90900) 
        ->assertViewHas('cost', 909000);      
    }

    public function testCalculate401kwh()
    {
    $response = $this->post('/calc', ['kWh' => 401]);
    $response->assertStatus(200)
    
        ->assertViewHas('total', 1003119.7)
        ->assertViewHas('tax', 91192.7) 
        ->assertViewHas('cost', 911927);      
    }
    public function testCalculate399kwh()
    {
    $response = $this->post('/calc', ['kWh' => 399]);
    $response->assertStatus(200)
    
        ->assertViewHas('total', 996782.6)
        ->assertViewHas('tax', 90616.6) 
        ->assertViewHas('cost', 906166);      
    }
    public function testCalculateBigkwh()
    {
    $response = $this->post('/calc', ['kWh' => 99999]);
    
    // Assert the response is successful
    $response->assertStatus(200)
       
        ->assertViewHas('total', 321678800.3)
        ->assertViewHas('tax', 29243527.3) 
        ->assertViewHas('cost', 292435273);      
    }
    public function testCalculate0kwh()
    {
    $response = $this->post('/calc', ['kWh' => 0]);
    
    // Assert the response is successful
    $response->assertStatus(200)
       
        ->assertViewHas('total', 0)
        ->assertViewHas('tax', 0) 
        ->assertViewHas('cost', 0);      
    }
}
