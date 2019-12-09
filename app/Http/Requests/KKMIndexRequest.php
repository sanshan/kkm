<?php

namespace App\Http\Requests;

use App\KKM;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class KKMIndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'per_page'     => 'required|integer',
            'sort_field'   => [
                'required',
                Rule::in(array_keys(KKM::SORTABLE_COLUMNS)),
            ],
            'dir'          => [
                'required',
                Rule::in(['desc', 'asc']),
            ],
            'search_field' => [
                'required',
                Rule::in(array_keys(KKM::SORTABLE_COLUMNS)),
            ],
            'search'       => 'nullable|string',
        ];
    }
}
