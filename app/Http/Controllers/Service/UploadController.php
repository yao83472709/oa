<?php
/**
 * Created by sublime_text
 * Author: 补中松
 * Data: 2016/09/21 18:13
 * 功能：文件上传
 */
namespace App\Http\Controllers\Service;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\UploadFileRequest;
use Illuminate\Support\Facades\File;

use App\Entity\System\SysConfig;
use App\Models\UploadsManager;

class UploadController extends Controller
{
    private $company_id = null;
    private $dir = array(
            '/record_files', /* 0 上传备案资料*/
            '/relevant_files', /* 1 上传开发资料*/
    		'/project_files' /* 2 上传项目作品文件*/
    	);
    private $filename = array(
            'record', /* 0 备案资料键名*/
            'relevant', /* 1 开发资料键名*/
    		'project_' /* 2 开发资料键名*/
    	);
	protected $manager;

    public function __construct(Request $request, UploadsManager $manager)
    {
        $this->company_id = $request->input('company_id', '');
        $this->manager = $manager;
        if($this->company_id) {
           //获取配置信息
           $SysConfig = new SysConfig;
           $SysConfig->getConfigs($this->company_id);
        }
    }

    /**
     * 上传文件
     */
    public function fileUpload(UploadFileRequest $request)
    {
    	$type = $request->input('type','');
        $fileName = $request->input('fileName','');
        if($type == 2) {
            $department_id = $request->input('department_id','');
            if($department_id == '') {
                return response()->json(array(
                    'status' => 1,
                    'message' => trans('common.sys_error')
                ));
            }
            $file = $_FILES[$this->filename[$type].$department_id]; 
            $fileName .= '_d'.$department_id;
        }else{
            $file = $_FILES[$this->filename[$type]];
        }
        if(!$file && $type == '') {
        	 return response()->json(array(
                'status' => 1,
                'message' => trans('common.sys_error')
            ));
        }
    	$path = str_finish('company_'.$this->company_id.$this->dir[$type], '/');

        $nameArr = explode('.',$file['name']);
        $fileArr['suffix'] = $nameArr[1];
        $fileName = $fileName ? $fileName .'.'. $fileArr['suffix'] : $file['name'];
        $path = $path . $fileName;
        $content = File::get($file['tmp_name']);
        $fileArr['path'] = public_path('uploads'.'/'.$path);

        $result = $this->manager->saveFile($path, $content);
        if ($result) {
            return response()->json(array(
                'status' => 0,
                'message' => trans('common.upload_success'),
                'value' => $fileArr
            ));
        }else {
            return response()->json(array(
                'status' => 2,
                'message' => trans('common.upload_failed')
            ));
        }
    }
}
