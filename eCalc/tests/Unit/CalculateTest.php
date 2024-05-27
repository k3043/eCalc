<?php

namespace Tests\Unit\Http\Controllers;

use Tests\TestCase;
use App\Models\User;
use App\Http\Controllers\calcController;

class CalculateTest extends TestCase
{
    public function testIndex()
    {
        $response = $this->get('/calc');
        
        $response->assertStatus(200);
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
    public function testCalculate50kwh()
    {
      
        
    $response = $this->post('/calc', ['kWh' => 50]);
    
    // Assert the response is successful
    $response->assertStatus(200)
      
        ->assertViewHas('total', 92290)
        ->assertViewHas('tax', 8390) 
        ->assertViewHas('cost', 83900);      
    }
    public function testCalculate100kwh()
    {
      
    $response = $this->post('/calc', ['kWh' => 100]);
    
    $response->assertStatus(200)
    
        ->assertViewHas('total', 187660)
        ->assertViewHas('tax', 17060) 
        ->assertViewHas('cost', 170600);      
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

   
    public function testCalculate450kwh()
    {
      
    $response = $this->post('/calc', ['kWh' => 450]);
    
    $response->assertStatus(200)
    
        ->assertViewHas('total', 1160885)
        ->assertViewHas('tax', 105535) 
        ->assertViewHas('cost', 1055350);      
    }

    public function testCalculateNegativeKwh()
    {
      
    $response = $this->post('/calc', ['kWh' => -300]);
    $this->followingRedirects()->get('/calc')
        ->assertSee('must be at least 0');      
    }

    public function testCalculateEmptyKwh()
    {
    $response = $this->post('/calc', ['kWh' => null]);
    $this->followingRedirects()->get('/calc')
        ->assertSee('required');      
    }
    
}
