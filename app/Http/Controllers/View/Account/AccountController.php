<?php

namespace App\Http\Controllers\View\Account;

use App\Entity\Account\Account;
use App\Entity\System\SysConfig;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
    public function index(){
        $datas=Account::where('account.company_id',$this->company_id)
            ->select('id','month','project_account','run_account','total_in','daily_account','office_account','salary_account','cost_account','taxation_account','other_account','total_out','turnover','inventory')
            ->paginate(10);
        return view($GLOBALS['cfg_style'].'.account.account.index',compact('datas'));
    }
    public function show($id){
        $datas=Account::where('id',$id)->get();
        return view($GLOBALS['cfg_style'].'.account.account.show',compact('datas'));
    }
}
