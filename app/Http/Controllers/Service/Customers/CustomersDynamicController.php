<?php
/**
 * Created by sublime_text
 * Author: 补中松
 * Data: 2016/09/19 10:06
 * 功能：客户动态数据处理
 */
namespace App\Http\Controllers\Service\Customers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Entity\Customers\Customers;
use App\Entity\Customers\CustomersDynamic;

use Log,DB;

class CustomersDynamicController extends Controller
{
    public function __construct(Request $request)
    {
        $this->company_id = $request->input('company_id', '');       
    }

    /**
     * 添加客户动态
     */
    public function store(Requests\Customers\CreateCustomersDynamicRequest $request)
    {
         Log::error('公司ID:'.$this->company_id.' 添加客户动态');//写入日志
         $data = $request->all();
         $customer = Customers::findOrFail($data['customer_id']);
         $customer->status_id = $data['status_id'];
         DB::beginTransaction();
         if(CustomersDynamic::create($data) && $customer->save()) {
            DB::commit();
            return response()->json(array(
                'status' => 0,
                'message' => trans('common.add_success')
            ));
         }else{
            DB::rollBack();
            return response()->json(array(
                'status' => 1,
                'message' => trans('common.add_failed')
            ));
         }
    }

}
