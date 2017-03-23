<?php
/**
 * Created by sublime_text
 * Author: 补中松
 * Data: 2016/9/6 10:38
 * 功能：客户操作记录数据处理
 */
namespace App\Http\Controllers\Service\Customers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Entity\Customers\Documentary;
use App\Entity\Customers\Customers;

use Log,DB;

class DocumentaryController extends Controller
{
    private $company_id = null;

    public function __construct(Request $request)
    {
        $this->company_id = $request->input('company_id', '');
    }
    
    /**
     * 添加客户操作记录
     */
    public function store(Requests\Customers\CreateDocumentaryRequest $request)
    {
        Log::error('公司ID:'.$this->company_id.'添加客户操作记录');//写入日志
        $data = $request->all();
        $log = Documentary::where('company_id',$this->company_id)
                            ->where('customer_id', $data['customer_id'])
                            ->where('type', $data['type'])
                            ->where('make_id', $data['make_id'])
                            ->count();
        $m3_result = new M3Result;
        if($log) {
            return response()->json(array(
                'status' => 1,
                'message' => trans('save.documentary.aready')
            ));
        }
        if( Documentary::create($data)) {
            return response()->json(array(
                'status' => 0,
                'message' => trans('common.add_success')
            ));
        }else{
            return response()->json(array(
                'status' => 2,
                'message' => trans('common.add_failed')
            ));
        }
    }

    /**
     * 更新跟单申请的状态，分配客户给当前申请人
     */
    public function Distribution(Request $request)
    {
        $id = $request->input('id');        
        $documentary = Documentary::findOrFail($id);
        $status = $request->input('info.status');
        if($status == 0 || $status == 2) {//申请人id
            $make_id = 0;
        }else {
            $make_id = $documentary->make_id;
        }        
        $customer_id = $documentary->customer_id;//客户id
        $customers = Customers::findOrFail($customer_id);//客户
        $customers->salesman_id = $make_id;
        DB::beginTransaction();
        if($documentary->update($request->input('info')) && $customers->save()){
            DB::commit();
            return response()->json(array(
                'status' => 0,
                'message' => trans('common.update_success')
            ));
        }else{
            DB::rollBack();
            return response()->json(array(
                'status' => 1,
                'message' => trans('common.update_failed')
            ));
        }
    }

    /**
     * 添加分配记录，并直接分配给业务员
     */
    public function doDistribution(Request $request)
    {
        $data = $request->all();
        $customer = Customers::findOrFail($data['customer_id']);//客户
        $customer->salesman_id = $data['salesman_id'];
        $data['company_id'] = $customer->company_id;
        $data['sendee_id'] = $data['salesman_id'];
        $data['type'] = 3;
        $data['status'] = 3;
        DB::beginTransaction();
        if(Documentary::create($data) && $customer->save()){
            DB::commit();
            return response()->json(array(
                'status' => 0,
                'message' => trans('customer/documentary/save.distribution_success')
            ));
        }else{
            DB::rollBack();
            return response()->json(array(
                'status' => 1,
                'message' => trans('customer/documentary/save.distribution_failed')
            ));
        }
    }

}
