<?php
/**
 * Created by sublime_text
 * Author: 补中松
 * Data: 2016/09/11 13:04
 * 功能：员工数据管理
 */
namespace App\Http\Controllers\Service\Users;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Entity\User;

use Hash,Log,DB;

class UsersController extends Controller
{
    private $company_id = null;

    public function __construct(Request $request)
    {
        $this->company_id = $request->input('company_id', '');
    }

    /**
     * 添加员工
     */
    public function store(Requests\Users\CreateUsersRequest $request)
    {
         Log::error('公司ID:'.$this->company_id.' 添加员工');
         $data = $request->all();
         $data['password'] = Hash::make($data['password']);
         if($user = User::register($data)) {
            /*给用户添加角色*/
            $role_ids = $request->input('role_id', '');
            $user->attachRole($data['role_id']);
            return response()->json(array(
                'status' => 0,
                'message' => trans('common.add_success')
            ));
         }else{
            return response()->json(array(
                'status' => 1,
                'message' => trans('common.add_failed')
            ));
         }
    }

    /**
     * 更新员工
     */
    public function update(Requests\Users\UpdateUserRequest $request)
    {
        Log::error('公司ID:'.$this->company_id.' 更新员工');        
        $data = $request->all();
        if($data['password'] == '') {
        	unset($data['password']);
        }else{
        	 $data['password'] = Hash::make($data['password']);
        }
        $user = User::findOrFail($data['id']);
        if($user->update($data)) {
            /*给用户添加角色*/
            $role_ids = $request->input('role_id', '');
            $user->detachAllRoles(); // 为用户删除所有角色
            if($role_ids) {
                foreach ($role_ids as $id) {
                    $user->attachRole($id);
                }
            }
            return response()->json(array(
                'status' => 0,
                'message' => trans('common.update_success')
            ));
        }else{
            return response()->json(array(
                'status' => 1,
                'message' => trans('common.update_failed')
            ));
        }
    }

    /**
     * 获取所有销售人员
     */
    public function getSalesmans($company_id)
    {
        $data = User::where('company_id',$company_id)->where('is_salesman',1)->select('id','name','number','username')->get()->toArray();
        return response()->json(array(
            'status' => 0,
            'value' => $data
        ));
    }

    /**
     * 获取指定部门人员
     */
    public function getUsersByDepartment(Request $request)
    {
        $company_id = $request->input('company_id','');
        $department_id = $request->input('department_id','');
        $users = User::where('company_id',$company_id)->where('department_id',$department_id)->select('id','name','head_portrait')->get()->toArray();
        return $users;
    }
}
