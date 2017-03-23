<?php
/**
 * Created by sublime_text
 * Author: 补中松
 * Data: 2016/09/04 14:35
 * 功能：配置模型
 */
namespace App\Entity\System;

use Illuminate\Database\Eloquent\Model;
use Cache;

class SysConfig extends Model
{
     /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'sysconfig';
    protected $fillable =  ['is_sys', 'company_id', 'varname', 'info', 'group_id', 'value'];

    /**
     * Data: 2016/8/17 10:30
     * 功能：通过公司ID获取系统配置数据
     * @param integer $company_id int 公司ID; integer $is_sys 是否是系统配置 1 是 0 不是
     */
    public function getConfigById($company_id, $is_sys)
    {
        $configInfo = SysConfig::where('company_id',$company_id)
						       ->where('is_sys',$is_sys)
						       ->get()->toArray();
        return $configInfo;
    }

    /**
     * Data: 2016/8/17 14:00
     * 功能：从缓存中获取当前公司的系统配置并转换成$GLOBALS 数组
     * @param array $sysConfig_arr 配置信息
     */
    public function getConfigs($company_id)
    {
        $config_key = 'company_'.$company_id;
        $configs = Cache::get($config_key);
        if($configs) {
            foreach ($configs as $value) {
                $GLOBALS[$value['varname']] = $value['value'];
            }
        }
    }

}
