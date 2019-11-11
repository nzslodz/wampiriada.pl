<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WampiriadaFrontendTest extends TestCase
{
    //use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $this->get('/')
            ->assertStatus(200);

        //

        $this->get('/reminder/283')
            ->assertStatus(200);

    }
}
