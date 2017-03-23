<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Entity\System\SysConfig;

use Cache;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /*Carbon时间格式本地化 */
        \Carbon\Carbon::setLocale('zh');
        /*加载所有系统配置文件*/
        $sys_config =  Cache::get('sys_config');   
        if( $sys_config) {
            foreach ($sys_config as $key => $value) {
                view()->share($value['varname'], $value['value']);
            }
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
