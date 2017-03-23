<?php
/**
 * Created by sublime_text
 * Author: 补中松
 * Data: 2016/09/11 14:20
 * 功能：客户表单验证
 */
namespace App\Http\Requests\Users;

use App\Http\Requests\Request;

class UpdateUserRequest extends Request
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
            'company_id'=>'required',
            'username'=>'bail|required|min:11|max:11',
            'number'=>'bail|required|min:6',
            'name'=>'bail|required|min:2',
            'department_id'=>'required',
            'password'=>'bail|min:6',
        ];
    }
    /**
     * 定义验证提示信息
     */
    public function messages(){
        return [
            'company_id.required' => trans('save.common.sys_error'),
            'number.required' => trans('save.user.number_required'),
            'username.required' => trans('save.user.username_required'),
            'name.required' => trans('save.user.name_required'),
            'name.min' => trans('save.user.name_min'),
            'department_id.required' => trans('save.user.department_required'),
            'password.min' => trans('save.user.password_min'),
        ];
    }
}
