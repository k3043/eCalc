<?php
use Tests\TestCase;
use App\Models\User;
use App\Models\EConsumption;
use App\Models\Ecost;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
class ShowCostTest extends TestCase
{
    public function testTc051()
    { 
    $ecost = Ecost::latest()->first(); 
    $response = $this->get('/showcost');
    $response->assertStatus(200);
    $response->assertViewHas('ecost', function ($viewEcost) use ($ecost) {
        return $viewEcost->c1 === $ecost->c1 &&
               $viewEcost->c2 === $ecost->c2 &&
               $viewEcost->c3 === $ecost->c3 &&
               $viewEcost->c4 === $ecost->c4 &&
               $viewEcost->c5 === $ecost->c5 &&
               $viewEcost->c6 === $ecost->c6;
    });
    }
}