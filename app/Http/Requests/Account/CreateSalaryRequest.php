<?php

namespace App\Http\Requests\Account;

use App\Http\Requests\Request;

class CreateSalaryRequest extends Request
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
            'month'=>'required|date',
        ];
    }
    //返回错误信息
    public function messages(){
        return [
            'month.required'=>array('msgnum'=>'2','message'=>trans('save.common.sys_error')),
            'month.date'=>array('msgnum'=>'2','message'=>trans('save.common.sys_error')),
        ];
    }
}
