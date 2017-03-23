<?php
/**
 * Created by sublime_text
 * Author: 补中松
 * Data: 2016/09/13 10:42
 * 功能：职位/角色 视图管理
 */
namespace App\Http\Controllers\View\Roles;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Bican\Roles\Models\Role;

use App\Entity\System\Department;
use App\Entity\System\SysConfig;
use App\Entity\User;

use Auth;

class RolesController extends Controller
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
        /*创建职位/角色 use Bican\Roles\Models\Role;*/
        /*$adminRole = Role::create([
            'name' => 'Admin',
            'slug' => 'admin',
            'description' => '', // optional
            'level' => 1, // optional, set to 1 by default
        ]);*/

        /*给用户添加角色*/
        /*$user = User::find(1);
        $user->attachRole(1); // 角色的id*/

        //$user->detachRole($adminRole); // 为用户删除角色
        //$user->detachAllRoles(); // 为用户删除所有角色

        /*判断用户是否是amin角色 返回bool*/
        /*$user = User::find(1);
        dd($user->is('admin'));
        或者
        if ($user->isAdmin()) {
            //
        }
        一次检测多个角色
        if ($user->is('admin|moderator')) { 
        }
        可以判断角色对应的等级
        if ($user->level() > 4) {
            //
        }
        */


        /*创建权限 use Bican\Roles\Models\Permission;*/
        /*$createUsersPermission = Permission::create([
            'name' => 'Create users',
            'slug' => 'create.users',
            'description' => '', // optional
        ]);

        $deleteUsersPermission = Permission::create([
            'name' => 'Delete users',
            'slug' => 'delete.users',
        ]);*/

        /*给角色添加权限 use Bican\Roles\Models\Role; */
        /*$role = Role::find($roleId);
        $role->attachPermission($createUsersPermission);*/ // permission attached to a role

        /*给用户添加权限*/
        /*$user = User::find($userId);
        $user->attachPermission($deleteUsersPermission); */// permission attached to a user

        /*给角色删除权限*/
        //$role->detachPermission($createUsersPermission); // in case you want to detach permission
        //$role->detachAllPermissions(); // in case you want to detach all permissions

        /*给用户删除权限*/
        //$user->detachPermission($deleteUsersPermission);
        //$user->detachAllPermissions();

        /*检测用户的权限 canOne() canAll() hasPermission*/
        /*if ($user->can('create.users') { // you can pass an id or slug
            //
        }

        if ($user->canDeleteUsers()) {
            //
        }*/


        $roles = Role::where('company_id',$this->company_id)->get();
        return view($GLOBALS['cfg_style'].'.roles.index',compact('roles'));
    }

    /**
     * 添加职位/角色
     */
    public function create()
    {
        $departments = Department::where('company_id',$this->company_id)->where('status',0)->lists('name', 'id');//部门
        return view($GLOBALS['cfg_style'].'.roles.create' ,compact('departments'));
    }

    /**
     * 编辑职位/角色
     */
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $departments = Department::where('company_id',$this->company_id)->where('status',0)->lists('name', 'id');//部门
        return view($GLOBALS['cfg_style'].'.roles.edit' ,compact('role','departments'));
    }

}
