<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Moneda;

class BackendMonedaController extends Controller
{

    function main() 
    {
        return view('backend.main');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $array = [  'currencyOpen' => 'menu-open', 
                    'viewOpen' => 'active'
                    ];
        $monedas = Moneda::all(); //Eloquent
        return view('backend.moneda.index', ['monedas' => $monedas], $array);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $array = [  'currencyOpen' => 'menu-open', 
                    'createOpen' => 'active'
                    ];
        return view('backend.moneda.create', $array);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $object = new Moneda($request->all());
        
        try {//si no se crea, el resultado es 0 en vez de un error
            $result = $object->save();
        } catch (\Exception $e) {
            $result = 0;
        }
        //dd($object);
        if ($object->id > 0) {
            $response = ['op' => 'created', 'r' => $result, 'id' => $object->id, 'name'=> $object->name];
            return redirect('backend/moneda')->with($response);
        } else {
            return back()->withInput()->with(['error' => 'error something went wrong']);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Moneda $moneda
     * @return \Illuminate\Http\Response
     */
    public function show(Moneda $moneda)
    {
        return view('backend.moneda.show', ['moneda' => $moneda] );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Moneda $moneda
     * @return \Illuminate\Http\Response
     */
    public function edit(Moneda $moneda)
    {
        $array = ['currencyOpen' => 'menu-open'];
        return view('backend.moneda.edit', ['moneda' => $moneda], $array);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Moneda $moneda
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Moneda $moneda)
    {
        try {
            $result = $moneda->update($request->all());
        } catch (\Exception $e) {
            $result = 0;
        }
        
        if ($result) {
            $response = ['op' => 'updated', 'r' => $result, 'id' => $moneda->id, 'name'=> $moneda->name];
            return redirect('backend/moneda')->with($response);
        } else {
            return back()->withInput()->with(['error' => 'something went wrong']);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Moneda $moneda
     * @return \Illuminate\Http\Response
     */
    public function destroy(Moneda $moneda)
    {
        try {
            $result = $moneda->delete();
        } catch (\Exception $ex) {
            $result = 0; 
        }
        $response = ['op' => 'deleted', 'r' => $result, 'id' => $moneda->id, 'name'=> $moneda->name];
        
        return redirect('backend/moneda')->with($response);
    }
    
}
