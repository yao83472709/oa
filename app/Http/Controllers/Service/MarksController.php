<?php
/**
 * Created by sublime_text
 * Author: 补中松
 * Data: 2016/09/10 23:56
 * 功能：评分等级数据处理
 */
namespace App\Http\Controllers\Service;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Entity\Mark;

use Log;

class MarksController extends Controller
{
    private $company_id = null;

    public function __construct(Request $request)
    {
        $this->company_id = $request->input('company_id', '');       
    }

    /**
     * 评分等级
     */
    public function store(Requests\Mark\CreateMarkRequest $request)
    {
        Log::error('公司ID:'.$this->company_id.' 添加部门');
        $data = $request->all();
        if(Mark::create($data)) {
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
     * 更新评分等级
     */
    public function update(Requests\Mark\UpdateMarkRequest $request)
    {
        Log::error('公司ID:'.$this->company_id.' 更新评分等级');
        $id = $request->input('id', '');
        $mark = Mark::findOrFail($id);
        if($mark->update($request->all())) {
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
     * 删除评分等级
     */
    public function destroy(Request $request)
    {
        Log::error('公司ID:'.$this->company_id.' 删除评分等级');
        $id = $request->input('id', '');
        if(Mark::where('id',$id)->delete()) {
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
