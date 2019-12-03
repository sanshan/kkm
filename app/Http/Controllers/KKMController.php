<?php

namespace App\Http\Controllers;

use App\Http\Requests\KKMIndexRequest;
use App\Http\Resources\KKMCollection;
use App\KKM;
use Illuminate\Http\Request;

class KKMController extends Controller
{
    /**
     * Показать список ККМ.
     *
     * @param KKMIndexRequest $request
     * @return mixed
     */
    public function index(KKMIndexRequest $request)
    {
        $perPage = $request->input('per_page') ?? 15;
        $field = $request->input('field') ?? 'id';
        $searchField = $request->input('search_field') ?? 'id';
        $dir = $request->input('dir') ?? 'desc';
        $searchValue = $request->input('search');

        $query = KKM::select(KKM::SELECTABLE_COLUMNS)
        ->join('azs', 'azs.skladID', '=', 'kkm.azs');



        if (isset(KKM::SORTABLE_COLUMNS[$field])) {
            $query->orderBy($field, $dir);
        }

        if ($searchValue) {
            $query->where($searchField, 'like', '%' . $searchValue . '%');
        }
        $collection = $query->paginate($perPage);

//        dd($collection);

        if (request()->wantsJson()) {
            return new KKMCollection(0, $collection);
        }

        return view('kkm.index', compact('collection'));
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
