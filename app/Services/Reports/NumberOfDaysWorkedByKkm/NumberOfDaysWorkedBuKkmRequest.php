<?php

namespace App\Services\Reports\NumberOfDaysWorkedByKkm;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NumberOfDaysWorkedBuKkmRequest extends FormRequest
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
            'title' => [
                'required',
                'string',
                Rule::in(config('reports.list')),
            ],
        ];
    }
}
