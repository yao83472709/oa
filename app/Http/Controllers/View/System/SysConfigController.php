<?php
/**
 * Created by sublime_text
 * Author: 补中松
 * Data: 2016/09/07 11:36
 * 功能：系统配置
 */
namespace App\Http\Controllers\View\System;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Entity\System\SysConfig;

use Auth;

class SysConfigController extends Controller
{
    private $company_id = null;
    private $level = null;
    
    public function __construct()
    {  
        $this->company_id = Auth::user()->company_id;
        $this->level = Auth::user()->level();
        $this->user_id = Auth::user()->id;
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
        $action = 'web';
        $is_highest = Auth::user()->is_highest;
        $company_id = $this->company_id;
        if($this->level==4) {
            $web_configs = SysConfig::where('group_id',1)
                                ->where('company_id',$company_id)
                                ->get();
            $core_configs = SysConfig::where('group_id',2)
                                ->where('company_id',$company_id)
                                ->get();
            $file_configs = SysConfig::where('group_id',3)
                                ->where('company_id',$company_id)
                                ->get();
            $interaction_configs = SysConfig::where('group_id',4)
                                ->where('company_id',$company_id)
                                ->get();
            $other_configs = SysConfig::where('group_id',5)
                                ->where('company_id',$company_id)
                                ->get();
        }else{
            $web_configs = SysConfig::where('group_id',1)
                                ->where('company_id',$company_id)
                                ->where('is_sys',0)
                                ->get();
            $core_configs = SysConfig::where('group_id',2)
                                ->where('company_id',$company_id)
                                ->where('is_sys',0)
                                ->get();
            $file_configs = SysConfig::where('group_id',3)
                                ->where('company_id',$company_id)
                                ->where('is_sys',0)
                                ->get();
            $interaction_configs = SysConfig::where('group_id',4)
                                ->where('company_id',$company_id)
                                ->where('is_sys',0)
                                ->get();
            $other_configs = SysConfig::where('group_id',5)
                                ->where('company_id',$company_id)
                                ->where('is_sys',0)
                                ->get();
        }
        return view($GLOBALS['cfg_style'].'.sysconfig.index',compact('web_configs','core_configs','file_configs','interaction_configs','other_configs','company_id'));
    }

}
