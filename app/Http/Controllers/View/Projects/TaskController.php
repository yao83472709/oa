<?php
/**
 * Created by sublime_text
 * Author：补中松
 * Data：2016/10/09  14:18
 * 功能：任务视图管理
 */
namespace App\Http\Controllers\view\Projects;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Entity\System\SysConfig;
use App\Entity\User;
use App\Entity\Projects\Projects;
use App\Entity\Projects\ProjectsMembers;

use Auth,DB;

class TaskController extends Controller
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
        $projects = DB::table('projects_members as m')->where('m.company_id',$this->company_id)->where('m.user_id',$this->user_id)->leftJoin('projects as p','p.id', '=' ,'m.project_id')->get();
        return view($GLOBALS['cfg_style'].'.project.task.index',compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
