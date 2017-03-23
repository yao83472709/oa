<?php
/**
 * Created by sublime_text
 * Author: 补中松
 * Data: 2016/9/2 10:20
 * 功能：业务类型表单验证
 */
namespace App\Http\Requests\Customers;

use App\Http\Requests\Request;

class CreateBusinessTypeRequest extends Request
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
            'company_id'=>'bail|required',
            'name'=>'bail|required|unique:business_type|min:3',
        ];
    }

    /**
     * 定义验证提示信息
     * @return array
     */
    public function messages(){
        return [
            'company_id.required' => trans('save.common.sys_error'),
            'name.required' => trans('save.business_type.name_required'),
            'name.unique' => trans('save.business_type.name_unique'),
            'name.min' => trans('save.business_type.name_min'),
        ];
    }
}
