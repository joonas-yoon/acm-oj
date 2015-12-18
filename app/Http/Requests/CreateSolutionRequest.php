<?php

namespace App\Http\Requests;

use Sentinel;
use App\Http\Requests\Request;

class CreateSolutionRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Sentinel::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'problem_id' => 'required|numeric|exists:problems,id',
            'lang_id'    => 'required|numeric|exists:languages,id',
            'code'       => 'required|min:1'
        ];
    }
    
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'problem_id.required' => '존재하지 않는 문제입니다.',
            'problem_id.exists'   => '존재하지 않는 문제입니다.',
            'lang_id.required'    => '언어를 선택하세요.',
            'lang_id.exists'      => '지원하지 않는 언어입니다.',
            'code.required'       => '소스 코드를 입력하세요.',
            'code.min'            => '소스 코드를 입력하세요.'
        ];
    }
}
