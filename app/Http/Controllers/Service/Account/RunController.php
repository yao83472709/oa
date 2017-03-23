<?php

namespace App\Http\Controllers\Service\Account;
/**
 * Created by PhpStorm.
 * User: 胥毅
 * Date: 2016/9/12 0003
 * Time: 10:05
 * 功能：账务流水账，接口controller
 */
use App\Entity\Account\Run;
use App\Entity\System\SysConfig;
use App\Models\M3Result;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\Account\CreateRunRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RunController extends Controller
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
    public function create(CreateRunRequest $request ){

        //获取用户的输入信息
        $company_id=$request->input('company_id');
        if($this->company_id==$company_id){
            $oldRun=Run::where(array('company_id'=>$this->company_id))->select('inventory')->limit(1)->get()->toArray();
            $run=new Run();
            if(empty($oldRun)){
                $run->company_id=$this->company_id;
                $run->date=$request->input('date');
                $run->type=$request->input('type');
                $request->input('account_sys_type')?$run->account_sys_type=$request->input('account_sys_type'):null;
                $request->input('account_type')?$run->account_type=$request->input('account_type'):null;
                $run->money=$request->input('money');
                $run->description=$request->input('description');
                $run->inventory=$request->input('money') ;
            }else{
                $run->company_id=$this->company_id;
                $run->date=$request->input('date');
                $run->type=$request->input('type');
                $request->input('account_sys_type')? $run->account_sys_type=$request->input('account_sys_type'):null;
                $request->input('account_type')?$run->account_type=$request->input('account_type'):null;
                $run->money=$request->input('money');
                $run->description=$request->input('description');
                if( $run->type==1) $run->inventory=$oldRun[0]['inventory']+$request->input('money') ;
                if( $run->type==2) $run->inventory=$oldRun[0]['inventory']-$request->input('money') ;
            }
            if($run->save()){
                //写入日志
                Log::info('公司ID:'.$this->company_id.'；用户ID:'.$this->userId.'；信息：添加流水账。');
                //返回信息
                $m3_result = new M3Result();
                $m3_result->message = trans('account\save.common.add_success');
                $m3_result->state =1;
                $m3_result->msgnum =6;
                return $m3_result->toJson();
            }else{
                //写入日志
                Log::info('公司ID:'.$this->company_id.'；用户ID:'.$this->userId.'；信息：添加流水账失败');
                //返回信息
                $m3_result = new M3Result;
                $m3_result->message = trans('account\save.common.add_failed');
                $m3_result->state =2;
                $m3_result->msgnum =5;
                return $m3_result->toJson();
            }
        };
        $m3_result = new M3Result;
        $m3_result->message = trans('account\save.common.sys_error');
        $m3_result->state =0;
        $m3_result->msgnum =2;
        return $m3_result->toJson();

   }
}
