<?php
/**
 * Created by sublime_text
 * Author: 补中松
 * Data: 2016/09/09 17:36
 * 功能：用户视图管理
 */
namespace App\Http\Controllers\View\Users;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Entity\System\SysConfig;
use App\Entity\System\Department;
use App\Entity\Area;
use App\Entity\User;

use Bican\Roles\Models\Role;

use Auth;

class UsersController extends Controller
{
    private $company_id = null;
    private $level = null;

    public function __construct()
    {   
        $this->company_id = Auth::user()->company_id;
        $this->level = Auth::user()->level();
        $this->user_id = Auth::user()->id;
        
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
        $users = User::where('company_id',$this->company_id)->orderBy('created_at', 'asc')->paginate(12);
        foreach ($users as $key => $value) {
            if($value->department_id) {
                $value->department = Department::find($value->department_id, ['name'])->name;
            }
            $value->role = implode(' ', User::findOrFail($value->id)->getRoles()->lists(['name'])->toArray());
            $value->created = $value->created_at->diffForHumans();
        }
        return view($GLOBALS['cfg_style'].'.users.index',compact('users'));
    }

    /**
     * 新建员工
     */
    public function create()
    {
        if($this->level < 3) {
            return view('errors.error_msg');
        }
        $roles = Role::where('status',0)->select('name', 'id')->get();//职位
        $departments = Department::where('company_id',$this->company_id)->where('status',0)->orderBy('sort', 'asc')->lists('name', 'id');//部门
        /*如果当前部门有子部门则不显示 只显示子级部门*/
        foreach ($departments as $key => $value) {
            if(Department::where('company_id',$this->company_id)->where('parent_id',$key)->count()) {
                $departments = $departments->except([$key]);
            }
        }
        $provinces = Area::where('reid',0)->lists('name', 'id');//省份
        return view($GLOBALS['cfg_style'].'.users.create',compact('roles','provinces','departments'));
    }

    /**
     * 查看员工信息
     */
    public function show($id)
    {
        //
    }

    /**
     * 编辑员工
     */
    public function edit($id)
    {
        if($this->level < 2) {
            return view('errors.error_msg');
        }
        $user = User::findOrFail($id);
        $roles = Role::where('status',0)->select('name', 'id')->get();//职位
        /*用户已存在的职位为选中状态*/
        $users_roles = $user->getRoles();
        foreach ($users_roles as $k) {
            foreach ($roles as $j) {
                if($k->id == $j->id) {
                    $j->selected = 1;
                }
            }
        }
        $departments = Department::where('company_id',$this->company_id)->where('status',0)->lists('name', 'id');//部门
        /*如果当前部门有子部门则不显示 只显示子级部门*/
        foreach ($departments as $key => $value) {
            if(Department::where('company_id',$this->company_id)->where('parent_id',$key)->count()) {
                $departments = $departments->except([$key]);
            }
        }
        $provinces = Area::where('reid',0)->lists('name', 'id');//省份
        return view($GLOBALS['cfg_style'].'.users.edit' ,compact('roles','user','provinces','departments'));
    }
}
