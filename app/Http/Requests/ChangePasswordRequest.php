<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

use Sentinel;

class ChangePasswordRequest extends Request
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
            'old_password' => 'required',
            'new_password' => 'required|min:6|confirmed'
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
            'old_password.require'   => '기존의 비밀번호를 입력하세요.',
            'new_password.require'   => '변경할 비밀번호를 입력하세요.',
            'new_password.min'       => '비밀번호가 너무 짧습니다. (:min자 이상 권장)',
            'new_password.confirmed' => '변경할 비밀번호가 일치하지 않습니다.',
        ];
    }
}
