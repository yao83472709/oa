<?php
/**
 * Created by sublime_text
 * Author: 补中松
 * Data: 2016/9/4 21:34
 * 功能：客户表单验证
 */
namespace App\Http\Requests\Customers;

use App\Http\Requests\Request;

class CreateCustomersRequest extends Request
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
            'name'=>'bail|required|min:2',
            'company'=>'bail|required',
            'phone'=>'required|unique:customers',
            'origin_id'=>'required',
            'type_id'=>'required',
            'developer_id'=>'required',
        ];
    }

    /**
     * 定义验证提示信息
     * @return array
     */
    public function messages(){
        return [
            'company_id.required' => trans('save.common.sys_error'),
            'name.required' => trans('save.customer.name_required'),
            'name.min' => trans('save.customer.name_min'),
            'company.required' => trans('save.customer.company_required'),
            'phone.required' => trans('save.customer.phone_required'),
            'phone.unique' => trans('save.customer.phone_unique'),
            'business_origin_id.required' => trans('save.customer.origin_required'),
            'type_id.required' => trans('save.customer.type_required'),
            'developer_id.required' => trans('save.common.sys_error')            
        ];
    }
}
