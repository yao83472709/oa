<?php
/**
 * Created by sublime_text
 * Author: 补中松
 * Data: 2016/9/1 18:37
 * 功能：业务类型视图管理
 */
namespace App\Http\Controllers\View\Customers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Entity\Customers\BusinessType;
use App\Entity\System\SysConfig;

use Auth;

class BusinessTypeController extends Controller
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
        $types = BusinessType::where('company_id',$this->company_id)->orderBy('sort', 'asc')->get();
        return view($GLOBALS['cfg_style'].'.customer.businesstype.index',compact('types'));
    }

    public function create()
    {
        return view($GLOBALS['cfg_style'].'.customer.businesstype.create');
    }

    /**
     * 编辑业务类型页面
     */
    public function edit($id)
    {
        $type = BusinessType::findOrFail($id);
        return view($GLOBALS['cfg_style'].'.customer.businesstype.edit' ,compact('type'));
    }

}
