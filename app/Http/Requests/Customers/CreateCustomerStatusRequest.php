<?php
/**
 * Created by sublime_text
 * Author: 补中松
 * Data: 2016/09/08 15:34
 * 功能：客户状态表单验证
 */
namespace App\Http\Requests\Customers;

use App\Http\Requests\Request;

class CreateCustomerStatusRequest extends Request
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
            'name'=>'bail|required|unique:customers_status|min:3',
            'company_id'=>'required',
        ];
    }
    
    /**
     * 定义验证提示信息
     */
    public function messages(){
        return [
            'name.required' => trans('save.customerstatus.name_required'),
            'name.unique' => trans('save.customerstatus.name_unique'),
            'name.min' => trans('save.customerstatus.name_min'),
            'company_id.required' => trans('save.common.sys_error'),
        ];
    }
}
