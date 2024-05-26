<?php

namespace Tests\Unit\Http\Controllers;

use Tests\TestCase;
use App\Models\Ecost;
use App\Http\Controllers\calcController;

class CalculateTest extends TestCase
{
    public function testIndex()
    {
        $response = $this->get('/calc');
        
        $response->assertStatus(200);
    }

    public function testCalculate()
    {
      
        // Simulate a request to calc method with input kWh = 200
    $response = $this->post('/calc', ['kWh' => 200]);
    
    // Assert the response is successful
    $response->assertStatus(200)
    
        // Assert that the view has the expected value for total
        ->assertViewHas('total', 409200); // Expected total value for kWh = 200
            
    }

    public function testShowCost()
    {
        $response = $this->get('/showcost');
        $response->assertStatus(200);
    }

    public function testSearch_NhapDungThongTin()
    {
        $response = $this->post('/search', ['querry' => 'KH00004']);
        $response->assertViewHas('result', function ($result) {
            return $result->code === 'KH00004' && $result->name === 'Xuan Khanh' && $result->econ === 0;
        });
    }
    public function testSearch_BoTrongMaKH()
    {
        $response = $this->post('/search', ['querry' => '']);
        $response->assertViewHas('result', null);
    }

}
