<?php
/**
 * Created by sublime_text
 * Author: 补中松
 * Data: 2016/09/0  9 17:20
 * 功能：员工表单验证
 */
namespace App\Http\Requests\Users;

use App\Http\Requests\Request;

class CreateUsersRequest extends Request
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
            'username'=>'bail|required|unique:users|min:11|max:11',
            'number'=>'bail|required|unique:users|min:6',
            'name'=>'bail|required|min:2',
            'department_id'=>'required',
            'password'=>'bail|required|min:6|max:32',
        ];
    }

    /**
     * 定义验证提示信息
     */
    public function messages(){
        return [
            'company_id.required' => trans('common.sys_error'),
            'number.required' => trans('user/save.number_required'),
            'number.unique' => trans('user/save.number_unique'),
            'username.required' => trans('user/save.username_required'),
            'username.unique' => trans('user/save.username_unique'),
            'name.required' => trans('user/save.name_required'),
            'name.min' => trans('user/save.name_min'),
            'department_id.required' => trans('user/save.department_required'),
            'password.required' => trans('user/save.name_required'),
            'password.min' => trans('user/save.password_min'),
        ];
    }
}
