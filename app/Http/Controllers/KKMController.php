<?php

namespace App\Http\Controllers;

use App\KKM;
use Illuminate\Http\Request;

class KKMController extends Controller
{

    /**
     * Показать страницу со списком ККМ
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('kkm.index');
    }

    /**
     * Показать конкретный ККМ.
     *
     * @param KKM $kkm
     * @return void
     */
    public function show(KKM $kkm)
    {
        //
    }

}
