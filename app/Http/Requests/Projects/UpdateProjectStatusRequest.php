<?php
/**
 * Created by sublime_text
 * Author: 补中松
 * Data: 2016/09/19 15:34
 * 功能：项目状态表单验证
 */
namespace App\Http\Requests\Projects;

use App\Http\Requests\Request;

class UpdateProjectStatusRequest extends Request
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
            'name'=>'bail|required|min:3',
        ];
    }

    /**
     * 定义验证提示信息
     */
    public function messages(){
        return [
            'company_id.required' => trans('common.sys_error'),
            'name.required' => trans('project/projectstatus/save.name_required'),
            'name.min' => trans('project/projectstatus/save.name_min'),
        ];
    }

}
