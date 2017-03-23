<?php
/**
 * Created by sublime_text
 * Author: 补中松
 * Data: 2016/09/08 15:26
 * 功能：客户状态数据处理
 */
namespace App\Http\Controllers\Service\Customers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Entity\Customers\CustomerStatus;

use Log,DB;

class CustomerStatusController extends Controller
{
    public function __construct(Request $request)
    {
        $this->company_id = $request->input('company_id', '');       
    }

    /**
     * 添加客户状态
     */
    public function store(Requests\Customers\CreateCustomerStatusRequest $request)
    {
         Log::error('公司ID:'.$this->company_id.' 添加添加客户状态');//写入日志
         if(CustomerStatus::create($request->all())) {
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
     * 更新客户状态
     */
    public function update(Requests\Customers\UpdateCustomerStatusRequest $request)
    {
        Log::error('公司ID:'.$this->company_id.' 更新客户状态');//写入日志
        $id = $request->input('id', '');
        $CustomerStatus = CustomerStatus::findOrFail($id);
        if($CustomerStatus->update($request->all())) {
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
     * 删除客户状态
     */
    public function destroy(Request $request)
    {
        Log::error('公司ID:'.$this->company_id.' 删除客户状态');//写入日志
        $id = $request->input('id', '');
        if(CustomerStatus::where('id',$id)->delete()) {
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
        $data = $request->input('status');
        DB::beginTransaction();
        foreach ($data as $key => $value) {
            if(!CustomerStatus::where('company_id',$this->company_id)->where('id',$key)->update(['sort' => $value])) {
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
