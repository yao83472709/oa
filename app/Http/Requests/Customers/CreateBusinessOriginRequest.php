<?php
/**
 * Created by sublime_text
 * Author: 补中松
 * Data: 2016/09/02 17:46
 * 功能：业务来源表单验证
 */
namespace App\Http\Requests\Customers;

use App\Http\Requests\Request;

class CreateBusinessOriginRequest extends Request
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
            'name'=>'bail|required|unique:business_origin|min:3',
            'company_id'=>'bail|required',
        ];
    }
    
    /**
     * 定义验证提示信息
     */
    public function messages(){
        return [
            'name.required' => trans('save.business_origin.name_required'),
            'name.unique' => trans('save.business_origin.name_unique'),
            'name.min' => trans('save.business_origin.name_min'),
            'company_id.required' => trans('save.common.sys_error'),
        ];
    }
}
