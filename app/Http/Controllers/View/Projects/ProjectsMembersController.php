<?php
/**
 * Created by sublime_text
 * Author: 补中松
 * Data: 2016/09/27 18:01
 * 功能：项目成员视图管理
 */
namespace App\Http\Controllers\View\Projects;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Entity\Projects\ProjectsMembers;
use App\Entity\System\SysConfig;
use App\Entity\Mark;
use App\Entity\User;

use Auth;

class ProjectsMembersController extends Controller
{
    private $company_id = null;
    private $level = null;
    private $department_id = null;

    public function __construct()
    {
        $this->company_id = Auth::user()->company_id;
        $this->department_id = Auth::user()->department_id;
        $this->level = Auth::user()->level();
        if($this->company_id) {
           //获取配置信息
           $SysConfig = new SysConfig;
           $SysConfig->getConfigs($this->company_id);
           view()->share('cfg_style', $GLOBALS['cfg_style']);
           view()->share('cfg_company', $GLOBALS['cfg_company']);
        }
    }

    /**
     * 编辑项目成员
     */
    public function edit($id)
    {
        $member = ProjectsMembers::findOrFail($id);
        /*当前操作人员必须是部长以上级别并与该条信息的基本信息一致*/
        if($this->level < 2 && $this->department_id != $member->department_id || $this->company_id != $member->company_id) {
            return view('errors.error_msg');
        }
        if($member->bereplace_id) {
            $member->bereplace = User::findOrFail($member->bereplace_id,['name' ,'head_portrait']);            
        }
        $user = User::findOrFail($member->user_id,['name' ,'head_portrait']);
        /*所有成员*/
        $members = ProjectsMembers::where('company_id',$this->company_id)
                                      ->where('department_id',$this->department_id)
                                      ->where('project_id',$member->project_id)
                                      ->lists('user_id')->toArray();
        /*所有未分配到该项目的人员*/
        $all_users = User::where('company_id',$member->company_id)
                         ->where('department_id',$member->department_id)
                         ->select('id','name','head_portrait')
                         ->whereNotIn('id',$members)->get();
        /*获取评分等级*/
        $marks = Mark::where('company_id',$this->company_id)->where('status',0)->orderBy('sort', 'asc')->lists('name','id');
        return view($GLOBALS['cfg_style'].'.project.member.edit' ,compact('member','user','all_users','marks'));    
    }

}
