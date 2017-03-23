<?php
/**
 * Created by sublime_text
 * Author: 补中松
 * Data: 2016/09/19 15:53
 * 功能：项目视图管理
 */
namespace App\Http\Controllers\View\Projects;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Entity\Projects\ProjectStatus;
use App\Entity\System\SysConfig;

use Auth;

class ProjectStatusController extends Controller
{
    private $company_id = null;

    public function __construct()
    {
        $this->company_id = Auth::user()->company_id;
        if($this->company_id) {
           //获取配置信息
           $SysConfig = new SysConfig;
           $SysConfig->getConfigs($this->company_id);
           view()->share('cfg_style', $GLOBALS['cfg_style']);
           view()->share('cfg_company', $GLOBALS['cfg_company']);
        }
    }

    public function index()
    {
        $customerstatus = ProjectStatus::where('company_id',$this->company_id)->get();
        if($customerstatus) {
            foreach ($customerstatus as $key => $value) {
                $value->status = trans('list.common.status_val.'.$value->status);
            }
        }
        return view($GLOBALS['cfg_style'].'.project.status.index',compact('customerstatus'));
    }

    /**
     * 添加项目状态
     */
    public function create()
    {
        return view($GLOBALS['cfg_style'].'.project.status.create');
    }

    /**
     * 编辑项目状态
     */
    public function edit($id)
    {
        $projectstatus = ProjectStatus::findOrFail($id);
        return view($GLOBALS['cfg_style'].'.project.status.edit' ,compact('projectstatus'));    
    }

}
