<?php
/**
 * Created by sublime_text
 * Author: 补中松
 * Data: 2016/9/8 14:43
 * 功能：系统配置数据处理
 */
namespace App\Http\Controllers\Service\System;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Entity\System\SysConfig;
use App\Models\M3Result;

use Cache;

class SysConfigController extends Controller
{
    /**
     * 更新配置并生成缓存
     */
    public function update(Request $request)
    {
        $company_id = $request->input('company_id','');
        $action = $request->input('action');
        $m3_result = new M3Result;
        if($company_id == '') {
            $result['status'] = 1;
            $result['message'] = trans('save.common.sys_error');
            return redirect('sysconfig')->with('result', $result)
                                        ->with('action', $action);
        }
        $sysconfig = new SysConfig;
        $data = $request->input('data');
        //dd($data);
        foreach ($data as $key => $value) {
            $config = SysConfig::findOrFail($key);
            $config->update(['value'=> $value]);
        }
        $config_key = 'company_'.$company_id;
        $sysconfig_arr = $sysconfig->getConfigById($company_id,0);
        /*删除缓存*/
        Cache::forget($config_key);
        /*创建永久缓存*/
        Cache::forever($config_key, $sysconfig_arr);
        /*如果是公司总部账号进行操作则更新系统的缓存*/
        if($company_id == 1) {
            //获取配置信息
           $sysconfig_arr = $sysconfig->getConfigById(1,1);
           /*删除缓存*/
           Cache::forget('sys_config');
           /*创建永久缓存*/
           Cache::forever('sys_config', $sysconfig_arr);
        }
        $result['status'] = 0;
        $result['message'] = trans('common.update_success');
        return redirect('sysconfig')->with('result', $result)
                                    ->with('action', $action);
    }

}
