<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function getBroadbandProduct($provider, $product)
    {
        $result = Product::select('provider_name', 'product_name', 'monthly_price')
        ->where([
            ['provider_domain', '=', 'broadband'],
            ['provider_name', '=', $provider],
            ['product_name', '=', $product]
        ])
        ->first();
        if($result === null)
        {
            return Response::json([
                'success' => false
            ], 404);
        }
        return Response::json([
            'success' => true,
            'result' => $result
        ], 200);
    }

    public function getEnergyProduct($provider, $product, $variation)
    {
        $result = Product::select('provider_name', 'product_name', 'monthly_price')
        ->where([
            ['provider_domain', '=', 'energy'],
            ['provider_name', '=', $provider],
            ['product_name', '=', $product],
            ['product_variation', '=', $variation]
        ])
        ->first();
        if($result === null)
        {
            return Response::json([
                'success' => false
            ], 404);
        }
        return Response::json([
            'success' => true,
            'result' => $result
        ], 200);
    }

    public function setEnergyProductPrice(Request $request, $provider, $product, $variation)
    {
        $new_price = $request->input('price');
        if(($new_price === null) || (!preg_match('/^[0-9]*\.*[0-9]{0,2}$/', $new_price)))
        {
            return Response::json([
                'success' => false,
                'error' => 'Incorrect request'
            ], 400);
        }
        $product_instance = Product::where([
            ['provider_domain', '=', 'energy'],
            ['provider_name', '=', $provider],
            ['product_name', '=', $product],
            ['product_variation', '=', $variation]
        ])
        ->first();
        if($product_instance === null)
        {
            return Response::json([
                'success' => false,
                'error' => 'Not found'
            ], 404);
        }
        $product_instance->monthly_price = $new_price;
        $product_instance->save();
        return Response::json([
            'success' => true
        ], 200);
    }
}
