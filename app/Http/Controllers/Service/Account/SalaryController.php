<?php

namespace App\Http\Controllers\Service\Account;

use App\Entity\Account\Bonus;
use App\Entity\Account\Project;
use App\Entity\Account\Salary;
use App\Entity\Account\SalaryReward;
use App\Entity\Projects\ProjectUser;
use App\Entity\System\SysConfig;
use App\Entity\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Account\CreateSalaryRequest;

class SalaryController extends Controller
{
    public function __construct()
    {
        $this->company_id = Auth::user()->company_id;
        $this->userId=Auth::user()->id;
        if($this->company_id) {
            //获取配置信息
            $SysConfig = new SysConfig();
            $SysConfig->getConfigs($this->company_id);
            view()->share('cfg_style', $GLOBALS['cfg_style']);
            view()->share('cfg_company', $GLOBALS['cfg_company']);
        }
    }
    //公司的id
    private $company_id;
    private $userId;
    //统计工资
    public function index(CreateSalaryRequest $request){

            $startMonth=date("Y-m-d",strtotime($request->get('month')));
            $endMonth=date("Y-m-d",strtotime("$startMonth +1 month"));
            if(strtotime($endMonth)<time()){
                //底薪
                $basicArr=User::where(array('users.company_id'=>$this->company_id))
                    ->select('users.id','users.name','users.basic_salary','users.safe_deduct','users.bonus','b.name as bname')
                    ->leftJoin('departments as b','b.id','=','users.department_id')
                    ->get()
                    ->toArray();
                foreach($basicArr as $key=>$user){
                    //提成
                    $bouns=Bonus::where(array('company_id'=>$this->company_id,'user_id'=>$user['id']))
                        ->where('created_at','>',$startMonth)
                        ->where('created_at','<',$endMonth)
                        ->select('salary')
                        ->sum('salary');
                    //奖励
                    $reward=SalaryReward::where(array('company_id'=>$this->company_id,'user_id'=>$user['id'],'type'=>'1'))
                        ->where('month','>',$startMonth)
                        ->where('month','<',$endMonth)
                        ->select('money')
                        ->sum('money');
                    //扣除
                    $deduct=SalaryReward::where(array('company_id'=>$this->company_id,'user_id'=>$user['id'],'type'=>'2'))
                        ->where('month','>',$startMonth)
                        ->where('month','<',$endMonth)
                        ->select('money')
                        ->sum('money');
                    $salary=new Salary();
                    $salary->company_id=$this->company_id;
                    $salary->user_id=$user['id'];
                    $salary->month=$startMonth;
                    $salary->name=$user['name'];
                    $salary->department=$user['bname'];
                    $salary->basic_salary=$user['basic_salary'];
                    $salary->integral_salary=$bouns;
                    $salary->safe_deduct=$user['safe_deduct'];
                    $salary->reward=$reward;
                    $salary->deduct=$deduct;
                    $salary->total_salary=$salary->basic_salary + $salary->integral_salary + $salary->reward - $salary->safe_deduct - $salary->deduct;
                    $salary->created_at=time();
                    $salary->save();
                }
           }



    }
    //工资奖励
    public function reward(Request $request){
        $startMonth=date("Y-m-d",strtotime($request->get('month')));
        $endMonth=date("Y-m-d",strtotime("$startMonth +1 month"));
        $datas=SalaryReward::where(array('account_salary_reward.company_id'=>$this->company_id,'account_salary_reward.user_id'=>$request->input('id'),'account_salary_reward.type'=>'1'))
            ->where('account_salary_reward.created_at','>',$startMonth)
            ->where('account_salary_reward.created_at','<',$endMonth)
            ->select('account_salary_reward.money','account_salary_reward.content','users.name')
            ->leftJoin('users', 'users.id', '=', 'account_salary_reward.examine_id')
            ->get()
            ->toJson();
        print_r($datas);
        exit;
    }
    //工资扣除
    public function deduct(Request $request){
        $startMonth=date("Y-m-d",strtotime($request->get('month')));
        $endMonth=date("Y-m-d",strtotime("$startMonth +1 month"));
        $datas=SalaryReward::where(array('account_salary_reward.company_id'=>$this->company_id,'account_salary_reward.user_id'=>$request->input('id'),'account_salary_reward.type'=>'2'))
            ->where('account_salary_reward.created_at','>',$startMonth)
            ->where('account_salary_reward.created_at','<',$endMonth)
            ->select('account_salary_reward.money','account_salary_reward.content','users.name')
            ->leftJoin('users', 'users.id', '=', 'account_salary_reward.examine_id')
            ->get()
            ->toJson();
        print_r($datas);
        exit;
    }
}
