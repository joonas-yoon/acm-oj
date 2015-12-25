<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

use Sentinel;

class CreateCommentRequest extends Request
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
            'content'    => 'required|min:2|max:1000',
            'problem_id' => 'numeric|exists:problems,id',
            'parent_id'  => 'required|numeric'
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
            'content.required'   => '내용을 입력하세요.',
            'content.min'        => '내용이 너무 짧습니다.',
            'content.max'        => '내용은 :max자를 넘길 수 없습니다.',
            'problem_id.numeric' => '잘못된 문제번호입니다.',
            'parent_id.required' => '잘못된 댓글입니다.',
        ];
    }
}
