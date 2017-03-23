<?php
/**
 * Created by sublime_text
 * Author: 补中松
 * Data: 2016/09/26 17:05
 * 功能：项目成员数据处理
 */
namespace App\Http\Controllers\Service\Projects;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

use App\Entity\Projects\ProjectsMembers;

use Log,DB;

class ProjectsMembersController extends Controller
{
    private $company_id = null;

    public function __construct(Request $request)
    {
        $this->company_id = $request->input('company_id', '');
    }

    /**
     * 添加项目成员
     */
    public function store(Requests\projects\CreateProjectsMembersRequest $request)
    {
        Log::error('公司ID:'.$this->company_id.'添加项目成员');
        $project_id = $request->input('project_id','');
        $mids = $request->input('mids','');
        $department_id = $request->input('department_id','');
        $make_id = $request->input('make_id','');
        $members = ProjectsMembers::where('company_id',$this->company_id)->where('department_id',$department_id)->where('project_id',$project_id)->lists('user_id')->toArray();
        DB::beginTransaction();
        foreach ($mids as $mid) {
            /*如果当前用户已存在就不添加到成员组中*/
            if(in_array($mid, $members)) {
                /*如果当前用户存在于历史组员中，则从历史组员中删除此元素*/
                $key = array_search($mid, $members);
                if ($key !== false) {
                    array_splice($members, $key, 1);
                }
            }else{
                $data['company_id'] = $this->company_id;
                $data['department_id'] = $department_id;
                $data['project_id'] = $project_id;
                $data['user_id'] = $mid;
                $data['make_id'] = $make_id;
                ProjectsMembers::create($data);                
            }
        }
        /*删除历史组员中，用户没有选择的用户*/
        if($members) {
            foreach ($members as $mid) {
                ProjectsMembers::where('company_id',$this->company_id)->where('project_id',$project_id)->where('user_id',$mid)->delete();
            }
        }
        DB::commit();
        return response()->json(array(
            'status' => 0,
            'message' => trans('common.add_success')
        ));
    }

    /**
     * 添加小组组长
     */
    public function addLeadr(Request $request)
    {
        Log::error('公司ID:'.$this->company_id.'添加小组组长');
        $replaced_id = $request->input('replaced_id','');
        $project_id = $request->input('project_id','');
        $leader_id = $request->input('leader','');
        /*取消旧的组长*/
        if($replaced_id) {
            $replaced = ProjectsMembers::where('company_id',$this->company_id)->where('project_id',$project_id)->where('user_id',$replaced_id)->first();
            $replaced->is_leader = 0;
            $replaced->save();
        }
        $leader = ProjectsMembers::where('company_id',$this->company_id)->where('project_id',$project_id)->where('user_id',$leader_id)->first();
        $leader->is_leader = 1;
        if($leader->save()) {
            return response()->json(array(
                'status' => 0,
                'message' => trans('common.add_success')
            ));
        }else{
            return response()->json(array(
                'status' => 0,
                'message' => trans('common.add_failed')
            ));
        }
    }

    /**
     * 更新项目成员
     */
    public function update(Request $request)
    {
        Log::error('公司ID:'.$this->company_id.' 更新项目成员');//写入日志
        $data = $request->all();
        $member = ProjectsMembers::where('id',$data['id'])->where('company_id',$this->company_id)->first();
        if($member->update($data)) {
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
     * 替换项目成员
     */
    public function replace(Request $request)
    {
        Log::error('公司ID:'.$this->company_id.' 替换项目成员');
        $data = $request->all();
        $member = ProjectsMembers::where('id',$data['id'])->where('company_id',$this->company_id)->first();
        /*是否选择要替换的成员*/
        if(!isset($data['bereplace_id'])){
            return response()->json(array(
                'status' => 1,
                'message' => trans('project/member/save.bereplace_required')
            ));
        }
        $member->bereplace_id = $data['bereplace_id'];
        $member->description = $data['description'];
        /*新成员*/
        $new_member['company_id'] = $this->company_id;
        $new_member['department_id'] = $member->department_id;
        $new_member['project_id'] = $member->project_id;
        $new_member['user_id'] = $data['bereplace_id'];
        $new_member['replace_id'] = $member->user_id;

        DB::beginTransaction();
        if($member->save() && ProjectsMembers::create($new_member)) {
            DB::commit();
            return response()->json(array(
                'status' => 0,
                'message' => trans('common.add_success')
            ));
        }else{
            DB::rollBack();
            return response()->json(array(
                'status' => 2,
                'message' => trans('common.add_failed')
            ));
        }
    }

}
