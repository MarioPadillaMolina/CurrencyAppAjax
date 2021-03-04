<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AjaxController extends Controller
{
    function index()
    {
        //como esto es ajax, sólo obtengo la vista sin datos adicionales
        return view('backend.ajax.index');
    }
}
