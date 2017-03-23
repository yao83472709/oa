<?php
/**
 * Created by sublime_text
 * Author：补中松
 * Data：2016/10/13  15:14
 * 功能：项目/任务视图管理
 */
namespace App\Http\Controllers\View\Projects;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Entity\System\SysConfig;
use App\Entity\User;

use App\Entity\Projects\Projects;
use App\Entity\Projects\Work;
use App\Entity\Projects\WorkGrade;
use App\Entity\Projects\ProjectsVice;

use Auth,DB;

class WorkController extends Controller
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
        $works = Work::where('company_id',$this->company_id)->where('user_id',$this->user_id)->paginate(11);
        if($works->count()) {
            foreach ($works as $work) {
                if($work->type == 0) {
                    $work->name = Projects::find($work->project_id)->name;
                    $work->maker = User::find($work->make_id, ['id', 'name' ,'head_portrait']);
                    $vice =  ProjectsVice::where('company_id',$this->company_id)->where('department_id',$work->department_id)->where('project_id',$work->project_id)->select('end','grade_id')->first();
                    $work->grade = $vice->grade_id ? WorkGrade::find($vice->grade_id)->name : trans('project/work/fields.grade_val');
                    $work->finish_time = $vice->end;
                }
            }
        }
        return view($GLOBALS['cfg_style'].'.project.work.index',compact('works'));
    }

    public function create()
    {
        //
    }

    public function show($id)
    {
        
    }

    public function edit($id)
    {
        //
    }

}
