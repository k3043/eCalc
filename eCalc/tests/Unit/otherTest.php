<?php

namespace Tests\Unit\Http\Controllers;

use Tests\TestCase;
use App\Models\User;
use App\Http\Controllers\calcController;

class OtherTest extends TestCase
{
    public function testShowCost()
    {
        $response = $this->get('/showcost');
        $response->assertStatus(200);
    }

}
