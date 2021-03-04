<?php

namespace App\Http\Controllers;

use App\Models\Moneda;
use Illuminate\Http\Request;

class MonedaController extends Controller
{
    function index()
    {
        $monedas = Moneda::all(); //enviamos la monedas al index
        return view('index', ['monedas' => $monedas]);
    }
    
    function fallback()
    {
        $response = ['op' => 'fallback'];
        return redirect('/')->with($response);
    }
}
