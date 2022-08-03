<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductsRequest;
use App\Http\Requests\UpdateProductsRequest;
use App\Models\Products;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Products::all();
        $returnProducts = [];

        foreach($products as $product){
            $returnProducts[] = (object) [
                'sku' => $product->sku,
                'quantity' => $product->quantity,
                'cost' => $product->cost,
                'total_cost' => $product->total_cost,
                'enterprise' => $product->enterprise()
            ];
        }

        return $returnProducts;
    }

    public function store(Request $request)
    {
        $productModel = new Products;

        $productModel->sku = $request->sku;
        $productModel->quantity = $request->quantity;
        $productModel->enterprise = $request->enterprise;
        $productModel->cost = $request->cost;
        $productModel->total_cost = $request->total_cost;

        if($productModel->save()){
            return (object) ['success' => "{$productModel->sku} criado."];
        }

        return (object) ['error' => "Houve um erro tente mais tarde"];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function show(Products $products)
    {
        return [
            'product' => $products,
            'enterprise' => $products->enterprise()
        ];
    }

    public function update(Request $request)
    {
        if (!is_null($request->id)) {
            $product = Products::where('id', $request->id)->first();

            $product->sku = !is_null($request->sku) ? $request->sku : $product->sku;
            $product->quantity = !is_null($request->quantity) ? $request->quantity : $product->quantity;
            $product->enterprise = !is_null($request->enterprise) ? $request->enterprise : $product->enterprise;
            $product->cost = !is_null($request->cost) ? $request->cost : $product->cost;
            if ($product->save()) {
                $product->total_cost = 'R$ ' . ($product->quantity + $product->cost);
                $product->save();
                return $product;
            }

            return (object) ['error' => 'Não foi possivel fazer a edição'];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function destroy(Products $products)
    {
        $name = $products->sku;
        if($products->delete()){
            return (object) ['success' => "A empresa {$name} foi deletada"];
        }

        return (object) ['error' => "Houve um erro"];
    }
}
