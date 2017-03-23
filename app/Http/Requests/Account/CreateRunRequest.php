<?php

namespace App\Http\Requests\Account;

use App\Http\Requests\Request;

class CreateRunRequest extends Request
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
            'company_id'=>'required|integer|min:1',
            'account_type'=>'integer|min:1',
            'account_sys_type'=>'integer|min:1',
            'money'=>'required',
            'date'=>'required|date',
            'type'=>'required|in:1,2',
        ];
    }
    //返回错误信息
    public function messages(){
        return [
            'company_id.required'=>array('msgnum'=>'2','message'=>trans('account\save.common.sys_error')),
            'company_id.integer'=>array('msgnum'=>'2','message'=>trans('account\save.common.sys_error')),
            'company_id.min'=>array('msgnum'=>'2','message'=>trans('account\save.common.sys_error')),
            //'account_type.required'=>array('msgnum'=>'2','message'=>trans('account\save.common.sys_error')),
            'account_type.integer'=>array('msgnum'=>'2','message'=>trans('account\save.common.sys_error')),
            'account_type.min'=>array('msgnum'=>'2','message'=>trans('account\save.common.sys_error')),
            //'account_sys_type.required'=>array('msgnum'=>'2','message'=>trans('account\save.common.sys_error')),
            'account_sys_type.integer'=>array('msgnum'=>'2','message'=>trans('account\save.common.sys_error')),
            'account_sys_type.min'=>array('msgnum'=>'2','message'=>trans('account\save.common.sys_error')),
            'money.required'=>array('msgnum'=>'2','message'=>trans('account\save.run.validate.money_required')),
            'date.required'=>array('msgnum'=>'2','message'=>trans('account\save.run.validate.date')),
            'date.date'=>array('msgnum'=>'2','message'=>trans('account\save.run.validate.date_type')),
            'type.required'=>array('msgnum'=>'2','message'=>trans('account\save.run.validate.status')),
            'type.in'=>array('msgnum'=>'2','message'=>trans('account\save.common.sys_error')),
        ];
    }
}
