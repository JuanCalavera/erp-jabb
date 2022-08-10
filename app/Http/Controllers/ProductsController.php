<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductsRequest;
use App\Http\Requests\UpdateProductsRequest;
use App\Models\Enterprise;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\LogsController;

class ProductsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Products::orderBy('sku')->get();
        $enterprisesId = Enterprise::select('id', 'name')->orderBy('name')->get();
        $returnProducts = [];

        foreach ($products as $product) {
            $returnProducts[] = [
                'id' => $product->id,
                'sku' => $product->sku,
                'quantity' => $product->quantity,
                'cost' => $product->cost,
                'total_cost' => $product->total_cost,
                'enterprise' => $product->enterprise()
            ];
        }

        return view('products', [
            'products' => $returnProducts,
            'enterprises' => $enterprisesId
        ]);
    }

    public function store(Request $request)
    {
        $productModel = new Products;

        $productModel->sku = $request->sku;
        $productModel->quantity = $request->quantity;
        $productModel->enterprise = $request->enterprise;
        $productModel->cost = (double) $request->cost;
        $productModel->total_cost = $productModel->cost * $productModel->quantity;

        if ($productModel->save()) {
            $this->updateEnterprise($productModel->enterprise);
            (new LogsController)->create('success', "{$productModel->sku} criado.");
            return Redirect::route('all.products')->withSuccess("{$productModel->sku} criado.");
        }
        (new LogsController)->create('danger', "Houve um erro ao criar um produto");
        return Redirect::route('all.products')->withSuccess("Houve um erro tente mais tarde");
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
            $product->enterprise = !is_null($request->enterprise) ? $request->enterprise : $product->enterprise;
            $product->cost = !is_null($request->cost) ? $request->cost : $product->cost;
            if ($product->save()) {
                $product->total_cost = 'R$ ' . ($product->quantity + $product->cost);
                $product->save();
                (new LogsController)->create('success', "Produto {$product->sku} com o preço {$product->cost} alterado");
                return Redirect::route('all.products');
            }

            (new LogsController)->create('danger', 'Não foi possivel fazer a edição');
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
        if ($products->delete()) {
            (new LogsController)->create('warning', "O produto {$name} foi deletado");
            return Redirect::route('all.products')->withSuccess("O produto {$name} foi deletado");
        }

        (new LogsController)->create('danger', "O produto {$name} não foi possível ser deletado");
        return Redirect::route('all.products')->withFail("O produto {$name} não foi possível ser deletado");
    }

    public function quantity(Request $request)
    {
        if (!is_null($request->id)) {
            $product = Products::where('id', $request->id)->first();
            $fail = "Não foi possível atualizar a quantidade do produto";
            switch ($request->action) {
                case 'add':
                    $product->quantity += $request->quantity;
                    $product->total_cost = $product->quantity * $product->cost;
                    $stringMessage = "Foi adicionada {$request->quantity} unidades/kits para o produto {$product->sku}";
                    break;

                case 'devolution':
                    $product->quantity += $request->quantity;
                    $product->total_cost = $product->quantity * $product->cost;
                    $stringMessage = "Foi adicionada {$request->quantity} unidades/kits devolvidos do produto {$product->sku}";
                    break;

                case 'exit':
                    $product->quantity -= $request->quantity;
                    $product->total_cost = $product->quantity * $product->cost;
                    $stringMessage = "Foi removido {$request->quantity} unidades/kits do produto {$product->sku}";
                    break;

                default:
                    return Redirect::route('all.products')->withFail($fail);
                    break;
            }
        }
        if ($product->save()) {
            $this->updateEnterprise($product->enterprise);
            (new LogsController)->create('success', $stringMessage);
            return Redirect::route('all.products')->withSuccess($stringMessage);
        }
        (new LogsController)->create('danger', $fail);
        return Redirect::route('all.products')->withFail($fail);
    }

    private function updateEnterprise(int $id): void
    {
        $products = Products::select('total_cost')->where('enterprise', $id)->get();
        $enterpriseModel = Enterprise::where('id', $id)->first();
        $enterpriseModel->total = count($products);
        $totalCost = 0;
        foreach ($products as $product) {
            $totalCost += $product->total_cost;
        }
        $enterpriseModel->total_cost = $totalCost;
    }
}
