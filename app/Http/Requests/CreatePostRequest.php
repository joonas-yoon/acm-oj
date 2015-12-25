<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

use Sentinel;

class CreatePostRequest extends Request
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
            'title'      => 'required|min:2|max:100',
            'content'    => 'required|min:5|max:2000',
            'problem_id' => 'numeric|exists:problems,id'
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
            'title.required'     => '제목을 입력하세요.',
            'content.required'   => '내용을 입력하세요.',
            'title.min'          => '제목이 너무 짧습니다.',
            'content.min'        => '내용이 너무 짧습니다.',
            'title.max'          => '제목은 :max자를 넘길 수 없습니다.',
            'content.max'        => '내용은 :max자를 넘길 수 없습니다.',
            'problem_id.numeric' => '잘못된 문제번호입니다.'
        ];
    }
}
