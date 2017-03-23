<?php
/**
 * Created by sublime_text
 * Author: 补中松
 * Data: 2016/9/1 14:50
 * 功能：客户状态管理
 */
namespace App\Http\Controllers\View\Customers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Entity\Customers\CustomerStatus;
use App\Entity\System\SysConfig;

use Auth;

class CustomerStatusController extends Controller
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
        $allstatus = CustomerStatus::where('company_id',$this->company_id)->orderBy('sort', 'asc')->get();
        return view($GLOBALS['cfg_style'].'.customer.status.index',compact('allstatus'));
    }

    /**
     * 添加客户状态
     */
    public function create()
    {
        return view($GLOBALS['cfg_style'].'.customer.status.create');
    }

    /**
     * 编辑客户状态
     */
    public function edit($id)
    {
        $customerstatus = CustomerStatus::where('id',$id)->where('company_id',$this->company_id)->first();
        return view($GLOBALS['cfg_style'].'.customer.status.edit' ,compact('customerstatus'));
    }

}
