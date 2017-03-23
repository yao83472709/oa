<?php
/**
 * Created by sublime_text
 * Author: 补中松
 * Data: 2016/9/3 17:15
 * 功能：业务来源视图管理
 */
namespace App\Http\Controllers\View\Customers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Entity\Customers\BusinessOrigin;
use App\Entity\System\SysConfig;

use Auth;

class BusinessOriginController extends Controller
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
        $origins = BusinessOrigin::where('company_id',$this->company_id)->orderBy('sort', 'asc')->get();
        return view($GLOBALS['cfg_style'].'.customer.businessorigin.index',compact('origins'));
    }

    /**
     * 添加新的业务来源
     */
    public function create()
    {
        return view($GLOBALS['cfg_style'].'.customer.businessorigin.create');
    }


    /**
     * 编辑业务来源
     */
    public function edit($id)
    {
        $type = BusinessOrigin::findOrFail($id);
        return view($GLOBALS['cfg_style'].'.customer.businessorigin.edit' ,compact('type'));
    }

}
