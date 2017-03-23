<?php
namespace App\Http\Controllers\View\Account;
/**
 * Created by PhpStorm.
 * User: 胥毅
 * Date: 2016/9/12 0003
 * Time: 10:05
 * 功能：账务流水账，view显示controller
 */

use App\Entity\Account\Run;
use App\Entity\System\SysConfig;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RunController extends Controller
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
        $datas=Run::where('account_run.company_id',$this->company_id)
            ->select('account_run.id','account_run.updated_at','account_run.date','account_run.type','b.name','c.name as sysName','account_run.money','account_run.description','account_run.inventory')
            ->leftJoin('account_type as b','account_run.account_type','=','b.id')
            ->leftJoin('account_sys_type as c','account_run.account_sys_type','=','c.id')
            ->paginate(10);
        return view($GLOBALS['cfg_style'].'.account.run.index',compact('datas'));
    }
    public function create(){
        $datas['company_id']=$this->company_id;
        return view($GLOBALS['cfg_style'].'.account.run.create',$datas);
    }
    //编辑添加账页面
    public function edit($id)
    {
        $datas=Run::where('account_run.id',$id)
            ->select('account_run.id','account_run.updated_at','account_run.type','b.name','account_run.money','account_run.description','account_run.inventory')
            ->leftJoin('account_type as b','account_run.account_type','=','b.id')
            ->get();
        return view($GLOBALS['cfg_style'].'.account.run.edit',compact('datas'));
    }
}
