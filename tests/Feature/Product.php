<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class Product extends TestCase
{
    /**
     * A basic feature test example.
     * test_Producto
     */
    public function test_example(): void
    {
        $this->get('/api/product')
       ->assetStatus(200)
       ->assertSee('Productos');
    }
    function store(): void
    {
        $this->get('api/products/?description=asdf asdf asdf&stock=54&category_id=88')
       ->assetStatus(200)
       ->assertSee('Productos Creado');
    }
}
