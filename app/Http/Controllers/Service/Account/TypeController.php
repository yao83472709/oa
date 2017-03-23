<?php

namespace App\Http\Controllers\Service\Account;

use App\Entity\Account\Type;
use App\Entity\System\SysConfig;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TypeController extends Controller
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
    public function getTppe(Request $request){

        $sysType = DB::table('account_sys_type')
            ->where(array('status'=>$request->input('status')))
            ->select('id','name')
            ->get();

        $type=Type::where(array('company_id'=>$this->company_id,'status'=>$request->input('status')))
            ->select('id','name')
            ->get()
            ->toArray();
        $datas=array('sys'=>$sysType,'user'=>$type);

        print_r(json_encode($datas));
        exit;
    }
}
