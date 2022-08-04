<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEnterpriseRequest;
use App\Http\Requests\UpdateEnterpriseRequest;
use App\Models\Enterprise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class EnterpriseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $enterprises = Enterprise::all();
        $enterpriseAr = [];

        foreach($enterprises as $enterprise){
            $enterpriseAr[] = [
                'id' => $enterprise->id,
                'name' => $enterprise->name,
                'total' => $enterprise->total,
                'total_cost' => $enterprise->total_cost,
                'products' => $enterprise->products()
            ];
        }

        return view(
            'enterprises',
            [
                'enterprises' => $enterpriseAr
            ]
        );
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
        $enterpriseModel->total = 0;
        $enterpriseModel->total_cost = 0;
        if ($enterpriseModel->save()) {
            return Redirect::to('/enterprise')->withSuccess('Criada a empresa');
        }

        return Redirect::to('/enterprise')->withSuccess('A empresa não pode ser criada, tente novamente mais tarde');
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
            if ($enterprise->save()) {

                return Redirect::to('/enterprise')->withSuccess('Edição da empresa feita');
            }

        }
        return Redirect::to('/enterprise')->withFail('Ocorreu um erro na edição da empresa :(');
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
