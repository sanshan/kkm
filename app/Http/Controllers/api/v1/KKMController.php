<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\KKMIndexRequest;
use App\Http\Resources\KKMCollection;
use App\KKM;

class KKMController extends Controller
{
    /**
     * Получить JSON с коллекцией ККМ
     *
     * @param KKMIndexRequest $request
     * @return KKMCollection
     */
    public function index(KKMIndexRequest $request)
    {
        return new KKMCollection(KKM::index($request->validated()));
    }
}


