<?php
/**
 * Created by sublime_text
 * Author: 补中松
 * Data: 2016/09/20 17:31
 * 功能：项目数据处理
 */
namespace App\Http\Controllers\Service\Projects;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

use App\Entity\Projects\Projects;
use App\Entity\Projects\ProjectsVice;
use App\Entity\Projects\ProjectsMembers;
use App\Entity\System\Department;
use App\Entity\System\SysConfig;

use Log,DB;

class ProjectsController extends Controller
{
    private $company_id = null;	

    public function __construct(Request $request)
    {
        $this->company_id = $request->input('company_id', '');
        if($this->company_id) {
           //获取配置信息
           $SysConfig = new SysConfig;
           $SysConfig->getConfigs($this->company_id);
        }
    }

    /**
     * 添加项目
     */
    public function store(Requests\Projects\CreateProjectRquest $request)
    {
        Log::error('公司ID:'.$this->company_id.' 添加项目');//写入日志
        $data = $request->all();
        $departments = $data['departments'];
        $data['departments'] = implode(",",$data['departments']);
        /*项目总积分*/
        $data['integral'] = $data['deal_price'] * $data['bonus'];
        DB::beginTransaction();
        if($project = Projects::create($data)) {
            $project_id = $project->id;            
            foreach ($departments as $value) {
                $vice['project_id'] = $project_id;
                $vice['make_id'] = $data['make_id'];
                $vice['department_id'] = $value;
                $vice['company_id'] = $this->company_id;
                $vice['project_id'] = $project_id;
                /*计算当前部门可获取的积分*/
                $department = Department::where('company_id',$this->company_id)->where('id',$value)->select('bonus')->first();
                $vice['integral'] = $data['integral'] * $department->bonus;
                ProjectsVice::create($vice);
            }
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

    /**
     * 更新项目
     */
    public function update(Requests\Projects\UpdateProjectRquest $request)
    {
        Log::error('公司ID:'.$this->company_id.' 更新项目');//写入日志
        $data = $request->all();
        $project = Projects::findOrFail($data['id']);
        /*历史参与部门*/
        $old_departments = explode(',', $project->departments);
        $departments = $data['departments'];
        /*当前选中的所有参与部门*/
        $data['departments'] = implode(",",$data['departments']);
        /*项目总积分*/
        $data['integral'] = $data['deal_price'] * $data['bonus'];
        DB::beginTransaction();
        foreach ($departments as $value) {
            /*计算当前部门可获取的积分*/
            $department = Department::where('company_id',$this->company_id)->where('id',$value)->select('bonus')->first();
            $vice['integral'] = $data['integral'] * $department->bonus;
            $vice['make_id'] = $data['make_id'];
            $vice['department_id'] = $value;
            /*如果当前部门已存在就不添加到部门组中*/
            if(in_array($value, $old_departments)) {
                $vice['make_id'] = $data['make_id'];
                ProjectsVice::where('company_id',$this->company_id)->where('project_id',$project->id)->where('department_id',$value)->update($vice);
                $key = array_search($value, $old_departments);
                if ($key !== false) {
                    array_splice($old_departments, $key, 1);
                }
            }else{
                $vice['project_id'] = $project->id;
                $vice['company_id'] = $this->company_id;
                ProjectsVice::create($vice);
            }
        }
        /*删除历史部门组中，用户没有选择的部门*/
        if($old_departments) {
            foreach ($old_departments as $id) {
                ProjectsVice::where('company_id',$this->company_id)->where('project_id',$project->id)->where('department_id',$id)->delete();
            }
        }
        if($project->update($data)) {
            DB::commit();
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
