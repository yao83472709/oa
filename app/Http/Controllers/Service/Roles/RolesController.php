<?php
/**
 * Created by sublime_text
 * Author: 补中松
 * Data: 2016/09/13 11:28
 * 功能：职位/角色 数据管理
 */
namespace App\Http\Controllers\Service\Roles;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Bican\Roles\Models\Role;

use App\Models\pinyin;

use Log;

class RolesController extends Controller
{
	private $company_id = null;

    public function __construct(Request $request)
    {
        $this->company_id = $request->input('company_id', '');       
    }

	/**
     * 添加职位/角色
     */
    public function store(Request $request)
    {
    	Log::error('公司ID:'.$this->company_id.' 添加业务来源');//写入日志
    	$data = $request->all();
    	$pinyin = new Pinyin;
    	$data['slug'] = $pinyin->getPinyin($data['name']);
	    if(Role::create($data)) {
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
     * 更新职位/角色
     */
    public function update(Request $request)
    {
    	Log::error('公司ID:'.$this->company_id.' 更新职位');//写入日志
        $id = $request->input('id', '');
        $role = Role::findOrFail($id);
        if($role->update($request->all())) {
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
     * 删除职位/角色
     */
    public function destroy(Request $request)
    {
        Log::error('公司ID:'.$this->company_id.' 删除职位');
        $id = $request->input('id', '');
        if(Role::where('id',$id)->delete()) {
            return response()->json(array(
                'status' => 0,
                'message' => trans('common.del_success')
            ));
        }else{
            return response()->json(array(
                'status' => 1,
                'message' => trans('common.del_failed')
            ));
        } 
    }
}
