<?php
/**
 * Created by sublime_text
 * Author：补中松
 * Data：2016/09/02  15:24
 * 功能：项目视图管理
 */
namespace App\Http\Controllers\View\Projects;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Entity\User;
use App\Entity\System\Department;
use App\Entity\Projects\Projects;
use App\Entity\Projects\ProjectsMembers;
use App\Entity\Projects\ProjectsVice;
use App\Entity\Projects\WorkGrade;
use App\Entity\Customers\Customers;
use App\Entity\Customers\BusinessType;
use App\Entity\System\SysConfig;
use App\Entity\Area;

use Auth,DB;

class ProjectsController extends Controller
{
    private $company_id = null;
    private $level = null;

    public function __construct()
    {
        $this->company_id = Auth::user()->company_id;
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
        $projects = Projects::where('company_id',$this->company_id)->latest()
                    ->where('is_finish',0)
                    ->paginate(11);
        if($projects) {
            foreach ($projects as $project) {
                if($project->customer_id) {
                    $project->customer = Customers::find($project->customer_id, ['id','name','company','type_id','salesman_id']);
                    $project->type = BusinessType::find($project->customer->type_id, ['name'])->name;//业务类型
                    $project->salesman = User::find($project->customer->salesman_id, ['id', 'name' ,'head_portrait']);//业务员
                }
                if($project->status_id) {
                    $project->status = Department::find($project->status_id, ['name'])->name;//项目状态
                }
            }
        }
        return view($GLOBALS['cfg_style'].'.project.index',compact('projects'));
    }

    /**
     * 创建新项目
     */
    public function create()
    {
        $business_types = BusinessType::where('company_id',$this->company_id)->where('status',0)->lists('name', 'id');//业务类型
        $number = $GLOBALS['cfg_prefix'].'-'.time();//准备编号
        //所有开发部门
        $departments = Department::where('company_id',$this->company_id)->where('status',0)->where('is_development',0)->orderBy('sort', 'asc')->get();
        foreach ($departments as &$value) {
            $value->checked = 1;
        }
        return view($GLOBALS['cfg_style'].'.project.create',compact('business_types','business_orgins','number','departments'));
    }

    /**
     * 创建新项目
     */
    public function saleManCreate($customer_id)
    {
        $business_types = BusinessType::where('company_id',$this->company_id)->where('status',0)->lists('name', 'id');//业务类型
        $number = $GLOBALS['cfg_prefix'].'-'.time();//准备编号
        $departments = Department::where('company_id',$this->company_id)->where('status',0)->where('is_development',0)->get();//所有部门
        return view($GLOBALS['cfg_style'].'.project.create',compact('customer_id','business_types','business_orgins','number','departments'));
    }
    
    /**
     * 下载备案资料
     */
    public function downloadRecordFile($project_id)
    {
        $project = Projects::findOrFail($project_id);
        $path = $project->record_file;
        $filename = $project->name.'备案资料.'.$project->record_file_suffix;
        return response()->download($path,$filename);
    }

    /**
     * 下载开发资料
     */
    public function downloadRelevantFile($project_id)
    {
        $project = Projects::findOrFail($project_id);
        $path = $project->relevant_file;
        $filename = $project->name.'开发资料.'.$project->relevant_file_suffix;
        return response()->download($path,$filename);
    }

    /**
     * 项目详情
     */
    public function show($id)
    {
        /*当前用户所管辖的部门*/
        $user_departments = Auth::user()->getRoles()->pluck('department_id')->toArray();
        $project = Projects::findOrFail($id);
        /*参与部门*/
        $departments = Department::whereIn('id', explode(",", $project->departments))->orderBy('sort', 'asc')->get();
        /*参与部门详情*/
        foreach ($departments as $key => $department) {
            $department->vice = ProjectsVice::where('company_id', $this->company_id)
                                            ->where('project_id', $project->id)
                                            ->where('department_id', $department->id)->first();
            $department->vice->start_time = $department->vice->start->format('Y') > 1 ? $department->vice->start->format('Y年m月d日') : '';
            $department->vice->end_time = $department->vice->end->format('Y') > 1 ? $department->vice->end->format('Y年m月d日') : '';
            $department->vice->true_start_time = $department->vice->true_start->format('Y') > 1 ? $department->vice->true_start->format('Y年m月d日') : '';
            $department->vice->true_end_time = $department->vice->true_end->format('Y') > 1 ? $department->vice->true_end->format('Y年m月d日') : '';
            $department->vice->examine_time = $department->vice->is_examine ? $department->vice->examine->format('Y年m月d日'): '' ;
            $department->members = DB::table('projects_members as members')
                                    ->where('members.company_id',$this->company_id)
                                    ->where('members.project_id',$project->id)
                                    ->where('users.department_id',$department->id)
                                    ->leftJoin('users', 'users.id', '=', 'members.user_id')
                                    ->select('users.id','users.name','users.head_portrait','members.is_leader','members.id as pmid','members.bereplace_id')
                                    ->get();
            $department->vice->leader = '';
            /*将用户对象数组转换成json数组*/
            if($department->members) {
                $current_members = null;
                foreach ($department->members as $member) {
                    /*组长*/
                    if($member->is_leader) {
                        $department->vice->leader = User::find($member->id, ['id', 'name' ,'head_portrait']);
                    }
                    $members[] = $member->id;
                    $member = get_object_vars($member);
                    $current_members[] = $member;
                     
                }
                $department->json_members = json_encode($members);//当前小组成员 只含 id
                $department->josn_current_members = json_encode($current_members);//当前小组成员 只含信息
            }

            $department->allow  = 0;
            $department->allow_download  = 0;            
            if($department->id == Auth::user()->department_id || in_array($department->id, $user_departments)  || Auth::user()->level() > 2) {
                /*如果当前用户是当前部门人员 并且是部长级别 则可以上传文件和修改资料*/
                if($this->level >=2) {
                    if($department->vice->is_examine == 0) {
                        $department->allow = 1;
                    }
                    $department->allow_download = 1;
                }
                /*如果当前用户是当前部门人员 并且是当前开发小组人员 可以下载上一个部门的文件*/
                if($key) {
                    $departments[$key-1]->allow_download = 1;
                }
            }
        }
        /*业务情况*/
        if($project->customer_id) {
            $customer = Customers::findOrFail($project->customer_id);
            if($customer->developer_id) {
                $customer->developer = User::findOrFail($customer->developer_id, ['id', 'name' ,'head_portrait']);//业务开发人员
            }
            $customer->salesman = User::findOrFail($customer->salesman_id, ['id', 'name' ,'head_portrait']);//业务员
            $customer->business_type = BusinessType::find($customer->type_id, ['name'])->name;//业务类型
        }
        /*获取评分等级*/
        $grades = WorkGrade::where('company_id',$this->company_id)->where('status',0)->orderBy('sort', 'asc')->lists('name','id');
        return view($GLOBALS['cfg_style'].'.project.show',compact('departments','project','customer','grades'));
    }

    /**
     * 编辑项目
     */
    public function edit($id)
    {
        $project = Projects::findOrFail($id);
        $business_types = BusinessType::where('company_id',$this->company_id)->where('status',0)->lists('name', 'id');//业务类型
        //所有开发部门
        $departments = Department::where('company_id',$this->company_id)->where('status',0)->where('is_development',0)->orderBy('sort', 'asc')->get();
        $already_departments = explode(",", $project->departments);
        foreach ($departments as &$value) {
            if(in_array($value->id, $already_departments)){
                $value->checked = 1;
            }
        }
        return view($GLOBALS['cfg_style'].'.project.edit' ,compact('business_types','business_orgins','project','departments'));    
    }

}
