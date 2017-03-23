<?php
/**
 * Created by sublime_text
 * Author: 补中松
 * Data: 2016/09/02 17:52
 * 功能：业务来源数据处理
 */
namespace App\Http\Controllers\Service\Customers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Entity\Customers\BusinessOrigin;

use Log,DB;

class BusinessOriginController extends Controller
{
    private $company_id = null;

    public function __construct(Request $request)
    {
        $this->company_id = $request->input('company_id', '');       
    }

    /**
     * 添加业务来源
     */
    public function store(Requests\Customers\CreateBusinessOriginRequest $request)
    {
         Log::error('公司ID:'.$this->company_id.' 添加业务来源');//写入日志
         if(BusinessOrigin::create($request->all())) {
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
     * 更新业务来源
     */
    public function update(Requests\Customers\UpdateBusinessOriginRequest $request)
    {
        Log::error('公司ID:'.$this->company_id.' 更新业务来源');//写入日志
        $id = $request->input('id', '');
        $origin = BusinessOrigin::findOrFail($id);
        if($origin->update($request->all())) {
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
     * 删除业务来源
     */
    public function destroy(Request $request)
    {
        Log::error('公司ID:'.$this->company_id.' 删除业务来源');//写入日志
        $id = $request->input('id', '');
        if(BusinessOrigin::where('id',$id)->delete()) {
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
        $data = $request->input('origins');
        DB::beginTransaction();
        foreach ($data as $key => $value) {
            if(!BusinessOrigin::where('company_id',$this->company_id)->where('id',$key)->update(['sort' => $value])) {
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
