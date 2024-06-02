<?php

namespace Tests\Unit\Http\Controllers;

use Tests\TestCase;
use App\Models\Ecost;

class ShowCostTest extends TestCase
{
    public function testTc051()
    {
        // Lấy bản ghi Ecost mới nhất
        $ecost = Ecost::latest()->first(); 
        $response = $this->get('/cost');
        $response->assertStatus(200);
        $response->assertViewHas('c1',$ecost->c1)
        ->assertViewHas('c2',$ecost->c2)
        ->assertViewHas('c3',$ecost->c3)
        ->assertViewHas('c4',$ecost->c4)
        ->assertViewHas('c5',$ecost->c5)
        ->assertViewHas('c6',$ecost->c6);
    }
}
