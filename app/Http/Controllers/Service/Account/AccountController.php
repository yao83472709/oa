<?php

namespace App\Http\Controllers\Service\Account;


use App\Entity\Account\Account;
use App\Entity\Account\Project;
use App\Entity\Account\Run;
use App\Entity\System\SysConfig;

use App\Models\M3Result;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
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
    //添加总账表
    public function create(){
        $month='2016-09-01';
        $startMonth=date("Y-m-d",strtotime($month));
        $endMonth=date("Y-m-d",strtotime("$startMonth +1 month"));
        if(strtotime($endMonth)<time()){
            $oldAccount=Account::where(array('company_id'=>$this->company_id,'month'=>$month))->select('id')->limit(1)->get()->toArray();
            if(empty($oldAccount)){
                //项目账
                $project=Project::where('company_id',$this->company_id)
                    ->where('created_at','>',$startMonth)
                    ->where('created_at','<',$endMonth)
                    ->select('price')
                    ->sum('price');
                //流水账
                $run=Run::where(array('company_id'=>$this->company_id))
                    ->where('created_at','>',$startMonth)
                    ->where('created_at','<',$endMonth)
                    ->select('type','account_sys_type','money')
                    ->selectSub('sum(money)','money')
                    ->groupby('type')
                    ->groupby('account_sys_type')
                    ->get()->toArray();
                $account=new Account();
                $account->company_id=$this->company_id;
                $account->month=$month;
                $account->project_account=$project;

                foreach($run as  $k=>$val){
                    if($val['type']==1){
                        $account->run_account=$val['money'];
                        $account->total_in=$val['money']+$project;
                    }
                    elseif($val['type']==2){
                        if($val['account_sys_type']==1)   $account->daily_account=$val['money'];
                        if($val['account_sys_type']==2)   $account->office_account=$val['money'];
                        if($val['account_sys_type']==3)   $account->salary_account=$val['money'];
                        if($val['account_sys_type']==4)   $account->cost_account=$val['money'];
                        if($val['account_sys_type']==5)   $account->taxation_account=$val['money'];
                        if($val['account_sys_type']==6)   $account->other_account=$val['money'];
                    }
                }
                $account->total_out= $account->daily_account+ $account->office_account+$account->salary_account+$account->cost_account+$account->taxation_account+$account->other_account;
                $account->turnover=$account->total_in-$account->total_out;
                DB::beginTransaction();
                $oldAccount=Account::where(array('company_id'=>$this->company_id))->select('inventory')->orderby('id','desc')->limit(1)->get()->toArray();
                if(!empty($oldAccount)) $account->inventory=$oldAccount[0]['inventory']+$account->turnover;
                else  $account->inventory=$account->turnover;
                if($account->save()){
                    DB::commit();
                    Log::info('公司ID:'.$this->company_id.'；用户ID:'.$this->userId.'；总账时间:'.$month.'；信息：添加总账成功。');
                    //返回信息
                    $m3_result = new M3Result;
                    $m3_result->message = trans('account\save.common.add_success');
                    $m3_result->state =1;
                    $m3_result->msgnum =6;
                    return $m3_result->toJson();
                }
            }
            DB::rollBack();
            //写入日志
            Log::info('公司ID:'.$this->company_id.'；用户ID:'.$this->userId.'；总账时间:'.$month.'；信息：添加总账失败。');
        }
        //返回信息
        $m3_result = new M3Result();
        $m3_result->message = trans('account\save.common.sys_error');
        $m3_result->state =0;
        $m3_result->msgnum =2;
        return $m3_result->toJson();

    }
    /*public function create(){
        $month='2016-09-01';
        $startMonth=date("Y-m-d",strtotime($month));
        $endMonth=date("Y-m-d",strtotime("$startMonth +1 month"));

        //项目账
        $project=Project::where('company_id',$this->company_id)
            ->where('created_at','>',$startMonth)
            ->where('created_at','<',$endMonth)
            ->select('price')
            ->sum('price');
        //流水账
        $run=Run::where(array('company_id'=>$this->company_id))
            ->where('created_at','>',$startMonth)
            ->where('created_at','<',$endMonth)
            ->select('type','account_sys_type','money')
            ->selectSub('sum(money)','money')
            ->groupby('type')
            ->groupby('account_sys_type')
            ->get()->toArray();
        $run_account=null;
        $total_in=null;
        $daily_account=null;
        $office_account=null;
        $salary_account=null;
        $cost_account=null;
        $taxation_account=null;
        $other_account=null;
        $total_out=null;
        $turnover=null;
        foreach($run as  $k=>$val){
            if($val['type']==1){
                $run_account=$val['money'];
                $total_in=$val['money']+$project;
            }
            elseif($val['type']==2){
                if($val['account_sys_type']==1)   $daily_account=$val['money'];
                if($val['account_sys_type']==2)   $office_account=$val['money'];
                if($val['account_sys_type']==3)   $salary_account=$val['money'];
                if($val['account_sys_type']==4)   $cost_account=$val['money'];
                if($val['account_sys_type']==5)   $taxation_account=$val['money'];
                if($val['account_sys_type']==6)   $other_account=$val['money'];
               }
        }
        $total_out= $daily_account+ $office_account+$salary_account+$cost_account+$taxation_account+$other_account;
        $turnover=$total_in-$total_out;


        //写入流水账，并对inventory的上次记录值求和
        $sql='';
        $sql="insert into account (company_id, month, project_account, run_account,total_in,daily_account,office_account,salary_account,cost_account,taxation_account,other_account,total_out,turnover,created_at,inventory) SELECT ?,?,?,?,?,?,?,?,?,?,?,?,?,?,IF(count(inventory),inventory,0)+? from account where company_id=? ORDER BY id desc LIMIT 1;";
        //not exists(select id from account where month = '2016-09-01' AND company_id=1 ORDER BY id desc LIMIT 1)
        $sqlArr=array($this->company_id,$month,$project,$run_account,$total_in,$daily_account,$office_account,$salary_account,$cost_account,$taxation_account,$other_account,$total_out,$turnover,time(),$turnover,$this->company_id,);

        if(DB::insert($sql,$sqlArr)) {


        }

    }*/
}
