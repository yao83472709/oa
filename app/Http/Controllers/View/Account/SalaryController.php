<?php

namespace App\Http\Controllers\View\Account;

use App\Entity\Account\Bonus;
use App\Entity\Account\Salary;
use App\Entity\System\SysConfig;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SalaryController extends Controller
{
    public function __construct()
    {
        $this->company_id = Auth::user()->company_id;
        if($this->company_id) {
            //获取配置信息
            $SysConfig = new SysConfig();
            $SysConfig->getConfigs($this->company_id);
            view()->share('cfg_style', $GLOBALS['cfg_style']);
            view()->share('cfg_company', $GLOBALS['cfg_company']);
        }
    }
    //公司的id
    protected $company_id;
    public function index(){
        $datas=Salary::where('company_id',$this->company_id)
            ->select('id','user_id','month','name','department','basic_salary','integral_salary','safe_deduct','reward','deduct','total_salary')
            ->paginate(10);
        return view($GLOBALS['cfg_style'].'.account.salary.index',compact('datas'));
    }
    //项目详情显示页面
    public function show($id,Request $request)
    {
        $startMonth=date("Y-m-d",strtotime($request->get('month')));
        $endMonth=date("Y-m-d",strtotime("$startMonth +1 month"));

        //此处应该还有其他join查询
        $datas=Bonus::where('account_bonus.user_id',$id)
            ->where('account_bonus.created_at','>',$startMonth)
            ->where('account_bonus.created_at','<',$endMonth)
            ->select('account_bonus.type','account_bonus.price','account_bonus.bonus','account_bonus.salary','project.project_name','integral_log.integral')
            ->leftJoin('project', 'project.id', '=', 'account_bonus.project_id')
            ->leftJoin('integral_log', 'account_bonus.integral_log_id', '=', 'integral_log.id')
            ->get();
        $arr['user_id']=$id;
        $arr['month']=$request->get('month');
        //此处应该还有其他join查询
        return view($GLOBALS['cfg_style'] .'.account.salary.show',compact('datas'),$arr);
    }
}
