<?php
/**
 * Created by sublime_text
 * Author: 补中松
 * Data: 2016/09/30 11:46
 * 功能：评分等级表单验证
 */
namespace App\Http\Requests\Mark;

use App\Http\Requests\Request;

class UpdateMarkRequest extends Request
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
            'name'=>'required',
            'bonus' => 'required', 
        ];
    }

    /**
     * 定义验证提示信息
     */
    public function messages(){
        return [
            'company_id.required' => trans('save.common.sys_error'),
            'name.required' => trans('mark/save.name_required'),
            'bonus.required' => trans('mark/save.bonus_required'),
        ];
    }
}
