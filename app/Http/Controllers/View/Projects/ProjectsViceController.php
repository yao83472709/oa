<?php
/**
 * Created by sublime_text
 * Author: 补中松
 * Data: 2016/09/28 09:46
 * 功能：项目详细视图管理
 */
namespace App\Http\Controllers\View\Projects;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Entity\Projects\Projects;
use App\Entity\Projects\ProjectsVice;
use App\Entity\Projects\ProjectsMembers;
use App\Entity\System\SysConfig;
use App\Entity\System\Department;

use Auth;

class ProjectsViceController extends Controller
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


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
    }

    /**
     * 下载项目文件资料
     */
    public function downloadProjectFile($project_id, $department_id)
    {
        $vice = ProjectsVice::where('company_id',$this->company_id)->where('project_id',$project_id)->where('department_id',$department_id)->first();
        $project_name = Projects::find($project_id, ['name'])->name;//项目名称
        $department_alias = Department::find($department_id, ['alias'])->alias;//部门别名
        $path = $vice->project_file;
        $filename = $project_name.'_'.$department_alias.'.'.$vice->project_file_suffix;
        return response()->download($path,$filename);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
