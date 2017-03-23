<?php

namespace App\Http\Requests\Account;

use App\Http\Requests\Request;

class DeleteRunTypeRequest extends Request
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
            'id'=>'required|integer|min:1',
            'companyid'=>'required|integer|min:1',
        ];
    }
    //返回错误信息
    public function messages(){
        return [

            'id.required' =>array('msgnum'=>'2','message'=>'请选择收支类型'),
            'id.integer' =>array('msgnum'=>'2','message'=>'非法操作'),
            'id.min' =>array('msgnum'=>'2','message'=>'非法操作'),
            'companyid.required' =>array('msgnum'=>'2','message'=>'非法操作'),
            'companyid.integer' =>array('msgnum'=>'2','message'=>'非法操作'),
            'companyid.min' =>array('msgnum'=>'2','message'=>'非法操作'),
        ];
    }
}
