<?php
/**
 * Created by sublime_text
 * Author: 补中松
 * Data: 2016/09/19 10:17
 * 功能：客户动态表单验证
 */
namespace App\Http\Requests\Customers;

use App\Http\Requests\Request;

class CreateCustomersDynamicRequest extends Request
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
            'status_id'=>'required',
            'customer_id'=>'required',
            'user_id'=>'required',
            'content'=>'required',
        ];
    }

    /**
     * 定义验证提示信息
     */
    public function messages(){
        return [
            'company_id.required' => trans('customer/customersdynamic/save.sys_error'),
            'status_id.required' => trans('customer/customersdynamic/save.status_required'),
            'customer_id.required' => trans('customer/customersdynamic/save.sys_error'),
            'user_id.required' => trans('customer/customersdynamic/save.sys_error'),
            'content.required' => trans('customer/customersdynamic/save.content_required'),
            
        ];
    }
}
