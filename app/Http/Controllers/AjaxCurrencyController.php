<?php

namespace App\Http\Controllers;

use App\Models\Moneda;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class AjaxCurrencyController extends Controller
{

    public function index(Request $request)
    {
        $token = csrf_token();
        //return response()->json(Moneda::paginate(3));
        $currencies = $this->getPage($request, $request->input('page'));
        return response()->json(['currencies' => Moneda::paginate(3), 'token' => $token]);
    }

    //para resolver cuando se borra en la última página y se queda vacía
    private function getPage(Request $request, $page = 1)
    {
        $currentPage = $page;
        Paginator::currentPageResolver(function () use ($currentPage) {
            return $currentPage;
        });
        $currencies = Moneda::paginate(3);
        $page = $currencies->currentPage();
        $lastPage = $currencies->lastPage();
        if ($page > $lastPage) {
            //$request->merge(['page' => $lastPage]);
            $currentPage = $lastPage;
            Paginator::currentPageResolver(function () use ($currentPage) {
                return $currentPage;
            });
            $currencies = Moneda::paginate(3);
        }
        return $currencies;
    }

    public function store(Request $request)
    {
        $currency = new Moneda($request->all());
        try {
            $result = $currency->save();
        } catch (\Exception $e) {
            $result = false;
        }
        if ($currency->id > 0) {
            $response = ['r' => $result, 'id' => $currency->id];
            $response = ['currency' => $currency];
            return response()->json($response);
        } else {
            return response()->json(['error' => 'algo ha fallado']);
        }
    }

    public function show($id) //nos sirve para mostrar los datos de la moneda en el edit
    {
        //$token = csrf_token();
        $currency = Moneda::find($id);
        return response()->json(['currency' => $currency]);
    }

    public function update(Request $request, $id)
    {
        $currency = Moneda::find($id);
        try {
            $result = $currency->update($request->all());
        } catch (\Exception $e) {
            $result = false;
        }
        return response()->json(['result' => $result, 'currency' => $currency]);
    }

    public function destroy(Request $request, $id)
    {
        try {
            $result = Moneda::destroy($id);
            $currencies = $this->getPage($request, $request->input('_page'));
        } catch (\Exception $e) {
            $result = false;
        }
        //$currencies = Moneda::paginate(3);
        $currencies->setPath(url('ajaxcurrency'));
        return response()->json(['currencies' => $currencies, 'result' => $result]);

        //return response()->json($response);
    }
}
