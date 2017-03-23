<?php
/**
 * Created by sublime_text
 * Author: 补中松
 * Data: 2016/09/04 21:30
 * 功能：客户数据处理
 */
namespace App\Http\Controllers\Service\Customers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Entity\Customers\Customers;

use Log;

class CustomersController extends Controller
{
    private $company_id = null;

    public function __construct(Request $request)
    {
        $this->company_id = $request->input('company_id', '');
    }

    /**
     * 添加客户
     */
    public function store(Requests\Customers\CreateCustomersRequest $request)
    {
         Log::error('公司ID:'.$this->company_id.' 添加客户');
         $data = $request->all();
         if($data['is_salesman']) {
            $data['salesman_id'] = $data['developer_id'];
         }
         $data['number'] = time();
         if(Customers::create($data)) {
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
     * 更新客户
     */
    public function update(Requests\Customers\UpdateCustomersRequest $request)
    {
        Log::error('公司ID:'.$this->company_id.' 更新客户');
        $id = $request->input('id', '');
        $customer = Customers::findOrFail($id);
        if($customer->update($request->all())) {
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

}
