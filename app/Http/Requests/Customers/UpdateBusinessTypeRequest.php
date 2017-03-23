<?php
/**
 * Created by sublime_text
 * Author: 补中松
 * Data: 2016/9/3 15:20
 * 功能：业务类型表单验证
 */
namespace App\Http\Requests\Customers;

use App\Http\Requests\Request;

class UpdateBusinessTypeRequest extends Request
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
            'name'=>'bail|required|min:3',
            'company_id'=>'bail|required',
        ];
    }

    /**
     * 定义验证提示信息
     * @return array
     */
    public function messages(){
        return [
            'name.required' => trans('save.business_type.name_required'),
            'name.min' => trans('save.business_type.name_min'),
            'company_id.required' => trans('save.common.sys_error'),
        ];
    }
}
