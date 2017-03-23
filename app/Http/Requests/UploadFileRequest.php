<?php
/**
 * Created by sublime_text
 * Author: 补中松
 * Data: 2016/09/21 15:34
 * 功能：文件上传表单验证
 */
namespace App\Http\Requests;

use App\Http\Requests\Request;

class UploadFileRequest extends Request
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
            'type' => 'required',
            //'folder' => 'required',
        ];
    }

    /**
     * 定义验证提示信息
     */
    public function messages(){
        return [
            'company_id.required' => trans('common.sys_error'),
            'type.required' => trans('common.sys_error'),

        ];
    }
}