<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEnterpriseRequest;
use App\Http\Requests\UpdateEnterpriseRequest;
use App\Models\Enterprise;
use Illuminate\Http\Request;

class EnterpriseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Enterprise::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreEnterpriseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $enterpriseModel = new Enterprise;
        $enterpriseModel->name = $request->name;
        $enterpriseModel->total = $request->total;
        $enterpriseModel->total_cost = $request->total_cost;
        if ($enterpriseModel->save()) {
            return ["Criada a empresa"];
        }

        return ["Houve um erro"];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Enterprise  $enterprise
     * @return \Illuminate\Http\Response
     */
    public function show(Enterprise $enterprise)
    {
        return $enterprise;
    }

    public function updateEnterprise(Request $request)
    {
        if (!is_null($request->id)) {
            $enterprise = Enterprise::where('id', $request->id)->first();

            $enterprise->name = !is_null($request->name) ? $request->name : $enterprise->name;
            $enterprise->total = !is_null($request->total) ? $request->total : $enterprise->total;
            $enterprise->total_cost = !is_null($request->total_cost) ? $request->total_cost : $enterprise->total_cost;
            if ($enterprise->save()) {
                return $enterprise;
            }

            return (object) ['error' => 'Não foi possivel fazer a edição'];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Enterprise  $enterprise
     * @return \Illuminate\Http\Response
     */
    public function destroy(Enterprise $enterprise)
    {
        $name = $enterprise->name;
        if($enterprise->delete()){
            return (object) ['success' => "A empresa {$name} foi deletada"];
        }

        return (object) ['error' => "Houve um erro"];
    }
}
