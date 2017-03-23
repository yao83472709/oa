<?php

namespace App\Http\Requests\Customers;

use App\Http\Requests\Request;

class CreateDocumentaryRequest extends Request
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
            'customer_id'=>'required',
            'make_id'=>'required',
            'type'=>'required',
        ];
    }

    /**
     * 定义验证提示信息
     * @return array
     */
    public function messages(){
        return [
            'company_id.required' => trans('save.common.sys_error'),
            'customer_id.required' => trans('save.common.sys_error'),
            'make_id.required' => trans('save.common.sys_error'), 
            'type.required' => trans('save.common.sys_error'),
        ];
    }
}
