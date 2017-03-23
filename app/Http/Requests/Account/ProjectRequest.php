<?php

namespace App\Http\Requests\Account;

use App\Http\Requests\Request;

class ProjectRequest extends Request
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
            'project_id'=>'required|integer|min:1',
            'project_name'=>'required',
            'user_id'=>'required|integer|min:1',
            'payment_ratio'=>'required',
            'total_price'=>'required',
            'price'=>'required',
            'price_time'=>'required|date',
            'price_user_id'=>'required|integer|min:1',
            'total_stage'=>'required|integer|min:1',
            'stage'=>'required|integer|min:1',
            'examine'=>'required|in:1',
        ];
    }
   //返回错误信息
    public function messages(){
        return [
            'company_id.required'=>array('msgnum'=>'2','message'=>'非法操作'),
            'company_id.integer'=>array('msgnum'=>'2','message'=>'非法操作'),
            'company_id.min'=>array('msgnum'=>'2','message'=>'非法操作'),
            'project_id.required'=>array('msgnum'=>'2','message'=>'非法操作'),
            'project_id.integer'=>array('msgnum'=>'2','message'=>'非法操作'),
            'project_id.min'=>array('msgnum'=>'2','message'=>'非法操作'),
            'project_name.required'=>array('msgnum'=>'2','message'=>'非法操作'),
            'user_id.required'=>array('msgnum'=>'2','message'=>'非法操作'),
            'user_id.integer'=>array('msgnum'=>'2','message'=>'非法操作'),
            'user_id.min'=>array('msgnum'=>'2','message'=>'非法操作'),
            'payment_ratio.required' =>array('msgnum'=>'2','message'=>'非法操作'),
            'total_price.required' =>array('msgnum'=>'2','message'=>'非法操作'),
            'price.required' =>array('msgnum'=>'2','message'=>'非法操作'),
            'price_time.required' =>array('msgnum'=>'2','message'=>'时间不能为空'),
            'price_time.date' =>array('msgnum'=>'2','message'=>'时间格式正确'),
            'price_user_id.required'=>array('msgnum'=>'2','message'=>'非法操作'),
            'price_user_id.integer'=>array('msgnum'=>'2','message'=>'非法操作'),
            'price_user_id.min'=>array('msgnum'=>'2','message'=>'非法操作'),
            'total_stage.required'=>array('msgnum'=>'2','message'=>'非法操作'),
            'total_stage.integer'=>array('msgnum'=>'2','message'=>'非法操作'),
            'total_stage.min'=>array('msgnum'=>'2','message'=>'非法操作'),
            'stage.required'=>array('msgnum'=>'2','message'=>'非法操作'),
            'stage.integer'=>array('msgnum'=>'2','message'=>'非法操作'),
            'stage.min'=>array('msgnum'=>'2','message'=>'非法操作'),
            'examine.required' =>array('msgnum'=>'2','message'=>'请确定已经回款'),
            'examine.in' =>array('msgnum'=>'2','message'=>'非法操作'),
        ];
    }
}
