<?php
/**
 * Created by sublime_text
 * Author: 补中松
 * Data: 2016/09/28 01:26
 * 功能：项目详细信息数据处理
 */
namespace App\Http\Controllers\Service\Projects;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

use App\Entity\Projects\Projects;
use App\Entity\Projects\ProjectsMembers;
use App\Entity\Projects\ProjectsVice;
use App\Entity\Projects\Work;
use App\Entity\IntegralLog;
use App\Entity\Mark;
use App\Entity\User;

use Carbon\Carbon;
use Log,DB;

class ProjectsViceController extends Controller
{    
    private $company_id = null;
    
    public function __construct(Request $request)
    {
        $this->company_id = $request->input('company_id', '');       
    }

    public function update(Request $request)
    {
        Log::error('公司ID:'.$this->company_id.' 更新项目详细信息');//写入日志
        $data = $request->all();
        $vice = ProjectsVice::where('id',$data['vice_id'])
                                    ->where('company_id',$this->company_id)
                                    ->where('project_id',$data['project_id'])
                                    ->where('department_id',$data['department_id'])->first();
        //所有项目成员
        $members = ProjectsMembers::where('company_id',$this->company_id)
                                    ->where('project_id',$vice->project_id)
                                    ->where('department_id',$vice->department_id)
                                    ->get();
        if(!$members->count()) {
            return response()->json(array(
                'status' => 1,
                'message' => trans('project/vice/save.no_member')
            ));
        }
        DB::beginTransaction();
        $work['company_id'] =  $this->company_id;
        $work['project_id'] =  $data['project_id'];
        $work['department_id'] =  $vice->department_id;
        $work['make_id'] =  $data['make_id'];
        foreach ($members as $member) {
            /*可以获取提成 并且还未获取提成的项目成员 所有成员都已打分 并设置了提成比例*/
            if($data['is_examine'] && $vice->is_examine == 0 && $member->is_obtain == 0) {
                if($member->is_bonus ==0 && $member->mark && $member->bonus) {
                    /*当前成员总提成*/
                    $mark = Mark::findOrFail($member->mark,['bonus']);
                    $integral = $vice->integral * $member->bonus * $mark->bonus;
                    /*添加积分获取纪录*/
                    $integral_log['company_id'] = $this->company_id;
                    $integral_log['user_id'] = $member->user_id;
                    $integral_log['origin'] = $member->project_id;
                    $integral_log['integral'] = $integral;
                    IntegralLog::create($integral_log);
                    /*当前成员增加积分*/
                    if(User::where('company_id',$this->company_id)->where('id',$member->user_id)->increment('integral', $integral)) {
                        /*修改当前成员为已获取提成*/
                        ProjectsMembers::where('company_id',$this->company_id)
                                   ->where('project_id',$member->project_id)
                                   ->where('user_id',$member->user_id)
                                   ->update(['is_obtain' => 1]);
                        /*任务记录实际积分添加*/
                        Work::where('company_id',$this->company_id)->where('project_id',$member->project_id)->where('user_id',$member->user_id)->where('department_id',$member->department_id)->update(['actual_integral' => $integral]);
                    }
                }else{
                    return response()->json(array(
                        'status' => 1,
                        'message' => trans('project/vice/save.not_mark')
                    ));
                }
            }
            /*为当前项目成员生成任务并通知 */
            if(!$member->is_work) {
                if($member->bonus == 0) {
                    return response()->json(array(
                        'status' => 1,
                        'message' => trans('project/vice/save.not_bonus')
                    ));
                }
                $work['user_id'] =  $member->user_id;
                $work['integral'] = $vice->integral * $member->bonus;
                Work::create($work);
                ProjectsMembers::where('company_id',$this->company_id)
                           ->where('project_id',$member->project_id)
                           ->where('user_id',$member->user_id)
                           ->update(['is_work' => 1]);
            }
        }
        /*为当前部门的项目 设置当前时间为实际开发周期的开始时间*/
        if($data['is_examine'] && $vice->is_examine == 0 ) {
            $data['true_start'] = Carbon::now();
        }
        /*确定验收后 修改状态 添加验收时间*/
        if($data['is_examine'] && $vice->is_examine == 0) {
            $data['examine'] = Carbon::now();
            $data['true_end'] = Carbon::now();
        }
        if($vice->update($data)) {
            DB::commit();
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


}
