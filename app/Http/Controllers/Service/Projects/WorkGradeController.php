<?php
/**
 * Created by sublime_text
 * Author：补中松
 * Data：2016/10/14 16:07
 * 功能：项目/任务等级数据管理
 */
namespace App\Http\Controllers\Service\Projects;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Entity\Projects\WorkGrade;

use Log,DB;

class WorkGradeController extends Controller
{
    private $company_id = null;
    
    public function __construct(Request $request)
    {
        $this->company_id = $request->input('company_id', '');       
    }

    public function store(Requests\projects\CreateWorkGradeRequest $request)
    {
         Log::error('公司ID:'.$this->company_id.' 添加任务等级');
         if(WorkGrade::create($request->all())) {
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

    public function update(Requests\projects\updateWorkGradeRequest $request)
    {
        Log::error('公司ID:'.$this->company_id.' 更新任务等级');
        $id = $request->input('id', '');
        $grade = WorkGrade::findOrFail($id);
        if($grade->update($request->all())) {
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

    public function destroy($id)
    {
        Log::error('公司ID:'.$this->company_id.' 删除任务等级');
        $id = $request->input('id', '');
        if(WorkGrade::where('id',$id)->delete()) {
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

    public function sort(Request $request)
    {
        $data = $request->input('status');
        DB::beginTransaction();
        foreach ($data as $key => $value) {
            if(!WorkGrade::where('company_id',$this->company_id)->where('id',$key)->update(['sort' => $value])) {
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
