<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateProblemRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'       => 'required',
            'description' => 'required|min:2',
            'time_limit'  => 'required|numeric|min:1',
            'memory_limit'=> 'required|numeric|min:64|max:512',
            'input'       => 'required|min:2',
            'output'      => 'required|min:2'
        ];
    }
}
