<?php
/**
 * Created by sublime_text
 * Author: 补中松
 * Data: 2016/09/02 10:25
 * 功能：业务类型数据处理
 */
namespace App\Http\Controllers\Service\Customers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

use App\Entity\Customers\BusinessType;

use Log,DB;

class BusinessTypeController extends Controller
{
    private $company_id = null;

    public function __construct(Request $request)
    {
        $this->company_id = $request->input('company_id', '');
       
    }

    /**
     * 添加业务类型
     */
    public function store(Requests\Customers\CreateBusinessTypeRequest $request)
    {
    	Log::error('公司ID:'.$this->company_id.' 添加业务类型');//写入日志
        if(BusinessType::create($request->all())) {
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
     * 更新业务类型
     */
    public function update(Requests\Customers\UpdateBusinessTypeRequest $request)
    {
    	Log::error('公司ID:'.$this->company_id.' 更新业务类型');//写入日志
    	$id = $request->input('id', '');
        $type = BusinessType::findOrFail($id);
        if($type->update($request->all())) {
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
     * 删除业务类型
     */
    public function destroy(Request $request)
    {
        Log::error('公司ID:'.$this->company_id.' 删除业务类型');//写入日志
        $id = $request->input('id', '');
        if(BusinessType::where('id',$id)->delete()) {
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
        $data = $request->input('types');
        DB::beginTransaction();
        foreach ($data as $key => $value) {
            if(!BusinessType::where('company_id',$this->company_id)->where('id',$key)->update(['sort' => $value])) {
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
