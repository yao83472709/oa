<?php

namespace App\Http\Controllers\Service\Account;
/**
 * Created by PhpStorm.
 * User: 胥毅
 * Date: 2016/9/12 0003
 * Time: 10:05
 * 功能：账务流水账类型，接口controller
 */


use App\Entity\Account\Project;
use App\Entity\Account\RunTpyeSys;
use App\Entity\System\SysConfig;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\Account\CreateRunTypeRequest;
use App\Entity\Account\RunType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\M3Result;
use App\Http\Requests\Account\DeleteRunTypeRequest;
use App\Http\Requests\Account\EditRunTypeRequest;

class RunTypeController extends Controller
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
    //添加流水账类型
    public function create(CreateRunTypeRequest $request)
    {
        dd($request->all());
        //获取用户的输入信息
        $company_id=$request->input('company_id');

        if($this->company_id==$company_id){
            if(RunType::create($request->all())){
                //写入日志
                Log::info('公司ID:'.$this->company_id.'；用户ID:'.$this->userId.'；信息：添加流水账类型。');
                //返回信息
                $m3_result = new M3Result;
                $m3_result->message = trans('account\save.common.add_success');
                $m3_result->state =1;
                $m3_result->msgnum =6;
                return $m3_result->toJson();
            }else{
                //写入日志
                Log::info('公司ID:'.$this->company_id.'；用户ID:'.$this->userId.'；信息：添加流水账类型失败');
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
    //修改流水账类型
    public  function edit(EditRunTypeRequest $request){
        $company_id=$request->input('company_id');
        $id=$request->input('id');
        $arr['name']=$request->input('name');
        $arr['status']=$request->input('status');
        $m3_result = new M3Result;
        if($this->company_id==$company_id){
            if(RunType::where('id',$id)->update($arr)){
                //写入日志
                Log::info('公司ID:'.$this->company_id.'；用户ID:'.$this->userId.'；信息：更新流水账类型。');
                //返回信息
                $m3_result->message = trans('account\common.update_success');
                $m3_result->state =1;
                $m3_result->msgnum =6;
                return $m3_result->toJson();
            }else{
                Log::info('公司ID:'.$this->company_id.'更新流水账类型失败');//写入日志
                $m3_result->state =2;
                $m3_result->msgnum =5;
                $m3_result->message = trans('account\common.update_failed');
            }
        }
        $m3_result->message = trans('account\save.common.sys_error');
        $m3_result->state =0;
        $m3_result->msgnum =2;
        return $m3_result->toJson();

    }
    //删除流水账类型
    public function destroy(DeleteRunTypeRequest $request){
        $company_id=$request->input('companyid');
        $id=$request->input('id');
        $m3_result = new M3Result;
        if($company_id==$this->company_id){
            if(RunType::where('id',$id)->delete()) {
                Log::info('公司ID:'.$this->company_id.' 删除流水账类型');//写入日志
                $m3_result->state =1;
                $m3_result->msgnum =6;
                $m3_result->message = trans('account\save.common.del_success');
            }else{
                Log::info('公司ID:'.$this->company_id.' 删除流水账类型失败');//写入日志
                $m3_result->state =2;
                $m3_result->msgnum =5;
                $m3_result->message = trans('account\save.common.del_failed');
            }
            return $m3_result->toJson();
        }
        $m3_result->message = trans('account\save.common.sys_error');
        $m3_result->state =0;
        $m3_result->msgnum =2;
        return $m3_result->toJson();


    }
    //获取系统的支出类型
    public function get_sys_type(){
        $datas=RunTpyeSys::get()->toJson();
        echo $datas;
        exit;
    }

}
