<?php

namespace App\Http\Requests\Account;

use App\Http\Requests\Request;

class CreateProjectRequest extends Request
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
            'company_id.required'=>array('msgnum'=>'2','message'=>trans('save.common.sys_error')),
            'company_id.integer'=>array('msgnum'=>'2','message'=>trans('save.common.sys_error')),
            'company_id.min'=>array('msgnum'=>'2','message'=>trans('save.common.sys_error')),
            'project_id.required'=>array('msgnum'=>'2','message'=>trans('save.common.sys_error')),
            'project_id.integer'=>array('msgnum'=>'2','message'=>trans('save.common.sys_error')),
            'project_id.min'=>array('msgnum'=>'2','message'=>trans('save.common.sys_error')),
            'project_name.required'=>array('msgnum'=>'2','message'=>trans('save.common.sys_error')),
            'user_id.required'=>array('msgnum'=>'2','message'=>trans('save.common.sys_error')),
            'user_id.integer'=>array('msgnum'=>'2','message'=>trans('save.common.sys_error')),
            'user_id.min'=>array('msgnum'=>'2','message'=>trans('save.common.sys_error')),
            'payment_ratio.required' =>array('msgnum'=>'2','message'=>trans('save.common.sys_error')),
            'total_price.required' =>array('msgnum'=>'2','message'=>trans('save.common.sys_error')),
            'price.required' =>array('msgnum'=>'2','message'=>trans('save.common.sys_error')),
            'price_time.required' =>array('msgnum'=>'2','message'=>trans('save.project.time')),
            'price_time.date' =>array('msgnum'=>'2','message'=>trans('save.project.time_type')),
            'price_user_id.required'=>array('msgnum'=>'2','message'=>trans('save.common.sys_error')),
            'price_user_id.integer'=>array('msgnum'=>'2','message'=>trans('save.common.sys_error')),
            'price_user_id.min'=>array('msgnum'=>'2','message'=>trans('save.common.sys_error')),
            'total_stage.required'=>array('msgnum'=>'2','message'=>trans('save.common.sys_error')),
            'total_stage.integer'=>array('msgnum'=>'2','message'=>trans('save.common.sys_error')),
            'total_stage.min'=>array('msgnum'=>'2','message'=>trans('save.common.sys_error')),
            'stage.required'=>array('msgnum'=>'2','message'=>trans('save.common.sys_error')),
            'stage.integer'=>array('msgnum'=>'2','message'=>trans('save.common.sys_error')),
            'stage.min'=>array('msgnum'=>'2','message'=>trans('save.common.sys_error')),
            'examine.required' =>array('msgnum'=>'2','message'=>trans('save.project.examine')),
            'examine.in' =>array('msgnum'=>'2','message'=>trans('save.common.sys_error')),
        ];
    }
}
