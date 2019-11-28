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
            'length'=> 'integer',
            'draw' => 'integer',
            'column' => 'between:0,'.(count(KKM::SORTABLE_COLUMNS)-1),
            'dir' => [
                'string',
                Rule::in(['desc', 'asc'])
            ],
            'search' => 'nullable|string',
        ];
    }
}
