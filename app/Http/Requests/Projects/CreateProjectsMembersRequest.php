<?php
/**
 * Created by sublime_text
 * Author: 补中松
 * Data: 2016/09/26 17:52
 * 功能：项目成员表单验证
 */
namespace App\Http\Requests\Projects;

use App\Http\Requests\Request;

class CreateProjectsMembersRequest extends Request
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
            'project_id'=>'required',
            'make_id'=>'required',
            'mids'=>'required',
        ];
    }

    /**
     * 定义验证提示信息
     */
    public function messages(){
        return [
            'company_id.required' => trans('common.sys_error'),
            'project_id.required' => trans('common.sys_error'),
            'make_id.required' => trans('common.sys_error'),
            'mids.required' => trans('project/member/save.mids_required'),
            
        ];
    }

}
