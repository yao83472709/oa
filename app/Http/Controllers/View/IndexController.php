<?php
/**
 * Created by sublime_text
 * Author: 补中松
 * Data: 2016/09/01 10:44
 * 功能：首页
 */
namespace App\Http\Controllers\View;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Entity\System\SysConfig;
use Bican\Roles\Models\Role;
use Bican\Roles\Models\Permission;
use Auth;

class IndexController extends Controller
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
     * 系统首页
     */
    public function index()
    {
        $roles = Auth::user()->getRoles();
        $ps = array();
        $menu = '';
        $permissions = collect();
        $permissions_arr = array();
        /*获取所有菜单/权限*/
        foreach ($roles as $k) {
            foreach ($k->permissions as $key => $j) {
                /*如果当前菜单的id存在于数组中，则删除该菜单*/
                if(in_array($j->id, $permissions_arr)) {
                    unset($k->permissions[$key]);
                }
                /*将所有菜单的id存如数组*/
                $permissions_arr[] =  $j->id;
            }
            /*将菜单添加至菜单集合中*/
            $permissions = $permissions->merge($k->permissions);
        }
        /*拼接菜单*/
        foreach ($permissions as $j) {//一级菜单
            if($j->parent_id == 0 && $j->level == 1) {
                $menu .= '<li><a><i class="fa fa-home"></i><span class="nav-label">'.$j->name.'</span><span class="fa arrow"></span></a>';
                $second_menu = '';
                $i = 0;
                foreach ($permissions as $v) {//二级菜单
                    if($v->parent_id == $j->id && $v->model == $j->model && $v->level == 2) {
                        $third_menu = '';
                        foreach ($permissions as $f) {//三级菜单
                            if($f->parent_id == $v->id && $f->model == $v->model && $f->level ==3) {
                                $third_menu .= "<li><a class='J_menuItem' href='".$f->url."'>".$f->name."</a></li>";
                            }
                        }
                        if($third_menu) {
                            $third_menu = '<ul class="nav nav-third-level">'.$third_menu.'</ul>';
                        }
                        $second_menu .= "<li><a href='".$v->url."' data-index='".$i."' class='J_menuItem'>".$v->name.($v->url == ''?"<span class='fa arrow'></span>":'')."</a>".$third_menu."</li>";
                        $i++;
                    }
                }
                if($second_menu) {
                    $menu .= '<ul class="nav nav-second-level">'.$second_menu.'</ul>';
                }
                $menu .= '</li>';
            }
        }
        return view($GLOBALS['cfg_style'].'.index.index',compact('menu'));
    }

    /**
     * 系统入口首页
     */
    public function home()
    {
        return view($GLOBALS['cfg_style'].'.index.index_home');
    }

}
