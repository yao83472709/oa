<?php
/**
 * Created by sublime_text
 * Author: 补中松
 * Data: 2016/09/02 17:46
 * 功能：部门表单验证
 */
namespace App\Http\Requests\System;

use App\Http\Requests\Request;

class CreateDepartmentRequest extends Request
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
            'name'=>'bail|required|unique:departments|min:2',
            'bonus' => 'required', 
        ];
    }
    
    /**
     * 定义验证提示信息
     */
    public function messages(){
        return [
            'company_id.required' => trans('save.common.sys_error'),
            'name.required' => trans('company/department/save.name_required'),
            'name.unique' => trans('company/department/save.name_unique'),
            'name.min' => trans('company/department/save.name_min'),
            'bonus.required' => trans('company/department/save.bonus_required'),
        ];
    }
}
