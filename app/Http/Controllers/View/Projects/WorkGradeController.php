<?php
/**
 * Created by sublime_text
 * Author：补中松
 * Data：2016/10/14 10:09
 * 功能：项目/任务等级视图管理
 */
namespace App\Http\Controllers\View\Projects;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Entity\System\SysConfig;
use App\Entity\User;
use App\Entity\Projects\WorkGrade;

use Auth;

class WorkGradeController extends Controller
{
    private $company_id = null;
    private $user_id = null;
    private $level = null;

    public function __construct()
    {
        $this->company_id = Auth::user()->company_id;
        $this->user_id = Auth::user()->id;
        $this->level = Auth::user()->level();
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
        $grades = WorkGrade::where('company_id',$this->company_id)->orderBy('sort', 'asc')->get();
        return view($GLOBALS['cfg_style'].'.project.work.grade.index',compact('grades'));
    }

    public function create()
    {
        return view($GLOBALS['cfg_style'].'.project.work.grade.create');
    }

    public function edit($id)
    {
        $grade = WorkGrade::findOrFail($id);
        return view($GLOBALS['cfg_style'].'.project.work.grade.edit' ,compact('grade'));
    }

}
