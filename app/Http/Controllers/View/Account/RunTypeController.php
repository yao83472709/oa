<?php

namespace App\Http\Controllers\View\Account;
/**
 * Created by PhpStorm.
 * User: 胥毅
 * Date: 2016/9/12 0003
 * Time: 10:05
 * 功能：账务流水账类型添加页面，view显示controller
 */
use App\Entity\Account\RunType;
use App\Entity\System\SysConfig;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RunTypeController extends Controller
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

    //index显示
    public function index()
    {
        //数据库查询生成实例
        $datas=RunType::where('account_type.company_id',$this->company_id)
            ->select('account_type.id','account_type.name','account_type.status','account_sys_type.name as sysName','account_type.updated_at','account_type.company_id')
            ->leftjoin('account_sys_type','account_sys_type.id','=','account_type.account_sys_type')
            ->paginate(10);
        return view( $GLOBALS['cfg_style'].'.account.runtype.index',compact('datas'));
    }

    //添加流水账类型页面
    public function create()
    {
        $datas['company_id']=$this->company_id;
       return view( $GLOBALS['cfg_style'].'.account.runtype.create',$datas);
    }
    //编辑流水账类型页面
    public function edit($id)
    {
        $datas=RunType::select('id','name','company_id','status','updated_at')->find($id);

        return view($GLOBALS['cfg_style'].'.account.runtype.edit',compact('datas'));
    }
}
