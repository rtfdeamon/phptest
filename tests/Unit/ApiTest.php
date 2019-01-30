<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function testGetBroadbandProductSuccessful()
    {
        $product = '300MB';
        $provider = 'BSNL';
        $this->assertDatabaseHas('products', [
            'product_name' => $product,
            'provider_name' => $provider,
            'provider_domain' => 'broadband',
            'monthly_price' => '50.00'
        ]);
        $response = $this->get("/api/broadband/$provider/$product");
        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'result' => [
                    'product_name' => $product,
                    'provider_name' => $provider,
                    'monthly_price' => '50.00'
                ]
            ]);
    }

    public function testGetBroadbandProductMissing()
    {
        $product = '400MB';
        $provider = 'BSNL';
        $this->assertDatabaseMissing('products', [
            'product_name' => $product,
            'provider_name' => $provider,
            'provider_domain' => 'broadband',
            'monthly_price' => '50.00'
        ]);
        $response = $this->get("/api/broadband/$provider/$product");
        $response
            ->assertStatus(404)
            ->assertJson([
                'success' => false,
            ]);
    }

    public function testGetEnergyProductSuccessful()
    {
        $product = 'Standard tariff';
        $provider = 'Tata Power';
        $variation = 'Mid';
        $this->assertDatabaseHas('products', [
            'product_name' => $product,
            'provider_name' => $provider,
            'provider_domain' => 'energy',
            'product_variation' => $variation,
            'monthly_price' => '52.00'
        ]);
        $response = $this->get("/api/energy/$provider/$product/$variation");
        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'result' => [
                    'product_name' => $product,
                    'provider_name' => $provider,
                    'monthly_price' => '52.00'
                ]
            ]);
    }

    public function testGetEnergyProductMissing()
    {
        $product = 'Green tariff';
        $provider = 'Tata Power';
        $variation = 'Mid';
        $this->assertDatabaseMissing('products', [
            'product_name' => $product,
            'provider_name' => $provider,
            'provider_domain' => 'energy',
            'product_variation' => $variation,
            'monthly_price' => '52.00'
        ]);
        $response = $this->get("/api/energy/$provider/$product/$variation");
        $response
            ->assertStatus(404)
            ->assertJson([
                'success' => false
            ]);
    }

    public function testSetEnergyProductPriceSuccessful()
    {
        $product = 'Standard tariff';
        $provider = 'Tata Power';
        $variation = 'Mid';
        $this->assertDatabaseHas('products', [
            'product_name' => $product,
            'provider_name' => $provider,
            'provider_domain' => 'energy',
            'product_variation' => $variation,
            'monthly_price' => '52.00'
        ]);
        $response = $this
            ->json('PATCH', "/api/energy/$provider/$product/$variation", ['price' => '100.0']);
        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true
            ]);
        $this->assertDatabaseHas('products', [
            'product_name' => $product,
            'provider_name' => $provider,
            'provider_domain' => 'energy',
            'product_variation' => $variation,
            'monthly_price' => '100.00'
        ]);
        $response = $this
            ->json('PATCH', "/api/energy/$provider/$product/$variation", ['price' => '52.00']);
    }

    public function testSetEnergyProductPriceMissing()
    {
        $product = 'Green tariff';
        $provider = 'Tata Power';
        $variation = 'Mid';
        $this->assertDatabaseMissing('products', [
            'product_name' => $product,
            'provider_name' => $provider,
            'provider_domain' => 'energy',
            'product_variation' => $variation
        ]);
        $response = $this
            ->json('PATCH', "/api/energy/$provider/$product/$variation", ['price' => '100.0']);
        $response
            ->assertStatus(404)
            ->assertJson([
                'success' => false
            ]);
    }

    public function testSetEnergyProductPriceWrongFormat()
    {
        $product = 'Standard tariff';
        $provider = 'Tata Power';
        $variation = 'Mid';
        $this->assertDatabaseHas('products', [
            'product_name' => $product,
            'provider_name' => $provider,
            'provider_domain' => 'energy',
            'product_variation' => $variation
        ]);
        $response = $this
            ->json('PATCH', "/api/energy/$provider/$product/$variation", ['price' => 'price']);
        $response
            ->assertStatus(400)
            ->assertJson([
                'success' => false
            ]);
    }

    public function testSetEnergyProductPriceWrongFormat2()
    {
        $product = 'Standard tariff';
        $provider = 'Tata Power';
        $variation = 'Mid';
        $this->assertDatabaseHas('products', [
            'product_name' => $product,
            'provider_name' => $provider,
            'provider_domain' => 'energy',
            'product_variation' => $variation
        ]);
        $response = $this
            ->json('PATCH', "/api/energy/$provider/$product/$variation", ['monthly_price' => '12.00']);
        $response
            ->assertStatus(400)
            ->assertJson([
                'success' => false
            ]);
    }

}
