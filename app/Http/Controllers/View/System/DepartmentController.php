<?php
/**
 * Created by sublime_text
 * Author: 补中松
 * Data: 2016/09/10 23:42
 * 功能：部门视图管理
 */
namespace App\Http\Controllers\View\System;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Entity\Customers\BusinessOrigin;
use App\Entity\System\Department;
use App\Entity\System\SysConfig;

use Auth;

class DepartmentController extends Controller
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
        $departments = Department::where('company_id',$this->company_id)->orderBy('sort', 'asc')->get();
        return view($GLOBALS['cfg_style'].'.sysconfig.department.index',compact('departments'));
    }


    public function create()
    {
        $departments = Department::where('company_id',$this->company_id)->where('parent_id',0)->orderBy('sort', 'asc')->lists('name','id');
        $departments->prepend('请选择上级部门', '0');
        return view($GLOBALS['cfg_style'].'.sysconfig.department.create',compact('departments'));
    }

    public function edit($id)
    {
        $department = Department::findOrFail($id);
        $departments = Department::where('company_id',$this->company_id)->where('parent_id',0)->orderBy('sort', 'asc')->lists('name','id');
        $departments->prepend('请选择上级部门', '0');
        return view($GLOBALS['cfg_style'].'.sysconfig.department.edit' ,compact('department','departments'));
    }
}
