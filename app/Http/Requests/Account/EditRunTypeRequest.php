<?php

namespace App\Http\Requests\Account;

use App\Http\Requests\Request;

class EditRunTypeRequest extends Request
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
            'name'=>'required',
            'status'=>'required|integer|in:1,2',
            'company_id'=>'required|integer',
        ];
    }
    //返回错误信息
    public function messages(){
        return [
            'id.required' =>array('msgnum'=>'2','message'=>'非法操作'),
            'id.integer' =>array('msgnum'=>'2','message'=>'非法操作'),
            'id.min' =>array('msgnum'=>'2','message'=>'非法操作'),
            'name.required' =>array('msgnum'=>'2','message'=>'名称不能为空'),
            'status.required' =>array('msgnum'=>'2','message'=>'请选择收支类型'),
            'status.integer' =>array('msgnum'=>'2','message'=>'非法操作'),
            'status.in' =>array('msgnum'=>'2','message'=>'非法操作'),
            'company_id.required' =>array('msgnum'=>'2','message'=>'非法操作'),
            'company_id.integer' =>array('msgnum'=>'2','message'=>'非法操作'),
        ];
    }
}
