<?php
/**
 * Created by sublime_text
 * Author: 补中松
 * Data: 2016/09/14 16:13
 * 功能：任务等级表单验证
 */
namespace App\Http\Requests\Projects;

use App\Http\Requests\Request;

class CreateWorkGradeRequest extends Request
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
            'name'=>'bail|required|unique:customers_status|min:2',
            'company_id'=>'required',
        ];
    }
    
    /**
     * 定义验证提示信息
     */
    public function messages(){
        return [
            'name.required' => trans('project/work/grade.name_required'),
            'name.unique' => trans('project/work/grade.name_unique'),
            'name.min' => trans('project/work/grade.name_min'),
            'company_id.required' => trans('common.sys_error'),
        ];
    }
}
