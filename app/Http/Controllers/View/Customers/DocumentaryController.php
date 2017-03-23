<?php
/**
 * Created by sublime_text
 * Author: 补中松
 * Data: 2016/09/08 17:52
 * 功能：客户记录管理
 */
namespace App\Http\Controllers\View\Customers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Entity\User;
use App\Entity\Customers\Customers;
use App\Entity\Customers\BusinessType;
use App\Entity\Customers\BusinessOrigin;
use App\Entity\Customers\Documentary;
use App\Entity\System\SysConfig;

use Auth;

class DocumentaryController extends Controller
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

    /**
     * 所有跟单申请
     */
    public function Apply()
    {
        $applys = Documentary::where('company_id',$this->company_id)
                                ->where('type',2)
                                ->paginate(12);
        foreach ($applys as $value) {
            $value->maker = User::find($value->make_id, ['id', 'name' ,'head_portrait']);
            $value->customer = Customers::find($value->customer_id, ['id', 'name']);
            $value->created = $value->created_at->diffForHumans();
            $value->text_status = trans('list.customer_log.status.'.$value->status);
        }
        return view($GLOBALS['cfg_style'].'.customer.apply.index',compact('applys'));
    }

}
