<?php
/**
 * Created by sublime_text
 * Author: 补中松
 * Data: 2016/09/14 15:23
 * 功能：权限管理
 */
namespace App\Http\Controllers\Service\Roles;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Bican\Roles\Models\Role;
use Bican\Roles\Models\Permission;

class PermissionsController extends Controller
{
	/**
     * 给角色添加权限
     */
    public function Fill(Request $request)
    {
    	$role_id = $request->input('roleid','');
    	$prmissions = $request->input('prmission','');
        $role = Role::findOrFail($role_id);
        $role->detachAllPermissions();
        if($prmissions) {
        	foreach ($prmissions as $value) {
	        	$role->attachPermission($value);
	        }
        }
        return response()->json(array(
            'status' => 0,
            'message' => trans('common.del_success')
        ));
    }
}
