<?php
/**
 * Created by sublime_text
 * Author: 补中松
 * Data: 2016/09/10 23:56
 * 功能：部门数据处理
 */
namespace App\Http\Controllers\Service\System;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Entity\System\Department;

use Log,DB;

class DepartmentController extends Controller
{
    private $company_id = null;

    public function __construct(Request $request)
    {
        $this->company_id = $request->input('company_id', '');       
    }

    /**
     * 添加部门
     */
    public function store(Requests\System\CreateDepartmentRequest $request)
    {
        Log::error('公司ID:'.$this->company_id.' 添加部门');
        $data = $request->all();
        if(Department::create($data)) {
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
     * 更新部门
     */
    public function update(Requests\System\UpdateDepartmentRequest $request)
    {
        Log::error('公司ID:'.$this->company_id.' 更新部门');
        $data = $request->all();
        $department = Department::findOrFail($data['id']);
        if($data['company_id'] != $department['company_id']) {
            return response()->json(array(
                'status' => 1,
                'message' => trans('common.sys_error')
            ));
        }
        if($department->update($data)) {
            return response()->json(array(
                'status' => 0,
                'message' => trans('common.update_success')
            ));
        }else{
            return response()->json(array(
                'status' => 2,
                'message' => trans('common.update_failed')
            ));
        }
    }

    /**
     * 删除部门
     */
    public function destroy(Request $request)
    {
        Log::error('公司ID:'.$this->company_id.' 删除部门');
        $id = $request->input('id', '');
        if(Department::where('id',$id)->delete()) {
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

    /**
     * 排序
     */
    public function sort(Request $request)
    {
        $data = $request->input('departments');
        DB::beginTransaction();
        foreach ($data as $key => $value) {
            if(!Department::where('company_id',$this->company_id)->where('id',$key)->update(['sort' => $value])) {
                DB::rollBack();
                return response()->json(array(
                    'status' => 1,
                    'message' => trans('common.update_failed')
                ));
            }
        }
        DB::commit();
        return response()->json(array(
            'status' => 0,
            'message' => trans('common.update_success')
        ));
    }    
}
