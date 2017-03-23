<?php
/**
 * Created by sublime_text
 * Author: 补中松
 * Data: 2016/09/19 15:34
 * 功能：项目表单验证
 */
namespace App\Http\Requests\Projects;

use App\Http\Requests\Request;

class CreateProjectRquest extends Request
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
            'company_id' => 'required',
            'departments' => 'required',
            'name' => 'bail|required|min:2|unique:projects',
            'start' => 'required|after:tomorrow',
            'end' => 'required|after:tomorrow',
            'deal_price' => 'required',
            'bonus' => 'required', 
            'payment_ratio' => 'required',
            
        ];
    }

    /**
     * 定义验证提示信息
     */
    public function messages(){
        return [
            'company_id.required' => trans('common.sys_error'),
            'departments.required' => trans('project/save.departments_required'),
            'name.required' => trans('project/save.name_required'),
            'name.min' => trans('project/save.name_min'),
            'name.unique' => trans('project/save.name_unique'),
            'start.required' => trans('project/save.start_required'),
            'end.required' => trans('project/save.end_required'),
            'deal_price.required' => trans('project/save.deal_price_required'),
            'bonus.required' => trans('project/save.bonus_required'),
            'payment_ratio.required' => trans('project/save.payment_ratio_required'),
        ];
    }
}
