<?php
/**
 * Created by sublime_text
 * Author: 补中松
 * Data: 2016/09/10 23:42
 * 功能：评分视图管理
 */
namespace App\Http\Controllers\View;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Entity\System\SysConfig;
use App\Entity\Mark;

use Auth;
class MarksController extends Controller
{
    private $company_id = null;
    private $level = null;

    public function __construct()
    {        
        $this->company_id = Auth::user()->company_id;
        $this->level = Auth::user()->level();
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
        $marks = Mark::where('company_id',$this->company_id)->get();        
        if($marks->count()) {
            foreach ($marks as $key => $value) {
                $value->status = trans('common.show_status_val.'.$value->status);
            }
        }
        return view($GLOBALS['cfg_style'].'.mark.index',compact('marks'));
    }

    public function create()
    {
        return view($GLOBALS['cfg_style'].'.mark.create');
    }

    public function edit($id)
    {
        $mark = Mark::findOrFail($id);
        return view($GLOBALS['cfg_style'].'.mark.edit' ,compact('mark'));
    }
}
