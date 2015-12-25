<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

use Sentinel;

class CreateProblemRequest extends Request
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
            'title'       => 'required|max:100',
            'description' => 'required|min:2|max:2000',
            'time_limit'  => 'required|numeric|min:1|max:10',
            'memory_limit'=> 'required|numeric|min:64|max:512',
            'input'       => 'required|min:2|max:3000',
            'output'      => 'required|min:2|max:3000'
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
            'title.require'   => '제목을 입력하세요.',
            'description.max' => '내용은 :max자를 넘길 수 없습니다.',
            'time_limit.max'  => '제한 시간은 :max초를 넘길 수 없습니다.',
            'memory_limit.max'=> '메모리 제한은 :max MB를 넘길 수 없습니다.',
        ];
    }
}
