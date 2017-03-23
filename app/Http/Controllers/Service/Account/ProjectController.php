<?php   
namespace App\Http\Controllers\Service\Account;
/**
 * Created by PhpStorm.
 * User: 胥毅
 * Date: 2016/9/3 0003
 * Time: 11:05
 * 功能：账务项目账，接口controller
 */
use App\Entity\Account\Project as AccountProject;
use App\Entity\Projects\Project ;
use App\Entity\System\SysConfig;
use App\Models\M3Result;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\Account\CreateProjectRequest;



class ProjectController extends Controller
{
    public function __construct()
    {
        $this->company_id = Auth::user()->company_id;
        $this->userId=Auth::user()->id;
        if($this->company_id) {
            //获取配置信息
            $SysConfig = new SysConfig();
            $SysConfig->getConfigs($this->company_id);
            view()->share('cfg_style', $GLOBALS['cfg_style']);
            view()->share('cfg_company', $GLOBALS['cfg_company']);
        }
    }
    //公司的id
    private $company_id;
    private $userId;
    //项目账期
    private function totalStageArr()
    {
        return $array=array("一","二","三","四","五","六","七","八",'九','十');
    }

    //添加项目账
    public function create(CreateProjectRequest $request)
    {
        $payment_ratio=explode(':',$request['payment_ratio']);
        $total_stage=$request['total_stage'];
        $stage=$request['stage'];
        $company_id=$request['company_id'];
        $price_user_id=$request['price_user_id'];
        $project_id=$request->input('project_id');
        if($this->company_id!=$company_id  || $this->userId!=$price_user_id || count($payment_ratio)!=$total_stage || $stage>count($payment_ratio)){
            //返回信息
            $m3_result = new M3Result;
            $m3_result->message = trans('account\save.common.sys_error');
            $m3_result->state =0;
            $m3_result->msgnum =2;
            return $m3_result->toJson();
        };
        $project=Project::find($project_id);
        if($stage==count($payment_ratio)){
            $request['finish']=1;
            //修改项目表期账
            $project->stage=$stage;
            $project->finish=1;
        }
        else{
            $request['finish']=0;
            $project->stage=$stage;
            $project->finish=0;
        }
        $request['created_at']=time();
        //开户事务修改
        DB::beginTransaction();
        if( AccountProject::create($request->all()) && $project->save()){
            DB::commit();
            //写入日志
            Log::info('公司ID:'.$this->company_id.'；用户ID:'.$this->userId.'；项目ID:'.$project_id.'；信息：添加项目账成功。');
            //返回信息
            $m3_result = new M3Result;
            $m3_result->message = trans('account\save.common.add_success');
            $m3_result->state =1;
            $m3_result->msgnum =6;
            return $m3_result->toJson();
        }else{
            DB::rollBack();
            //写入日志
            Log::info('公司ID:'.$this->company_id.'；用户ID:'.$this->userId.'；项目ID:'.$project_id.'；信息：添加项目账失败。');
            //返回信息
            $m3_result = new M3Result;
            $m3_result->message = trans('account\save.common.add_failed');
            $m3_result->state =2;
            $m3_result->msgnum =5;
            return $m3_result->toJson();
        }
        //返回信息
        $m3_result = new M3Result;
        $m3_result->message = trans('account\save.common.sys_error');
        $m3_result->state =0;
        $m3_result->msgnum =2;
        return $m3_result->toJson();
    }
    //获取项目的名
    public function getProject()
    {
        $datas=Project::where(array('company_id'=>$this->company_id,'finish'=>'0'))
            ->select('id','project_name')
            ->get()
            ->toJson();
        print_r($datas);
        exit;
    }
    //获取项目当前分期账的详情
    public function getProjectArr(Request $request)
    {
        $id=$request->input('id');
        $datas=Project::where(array('id'=>$id))
            ->select('company_id','project_name','user_id','agreement_number','total_price','stage','payment_ratio','user_id')
            ->get()
            ->toArray();
        if(!empty($datas)){
            $arr=explode(':',$datas[0]['payment_ratio']);
            $key=$datas[0]['stage'];
            $datas[0]['stage_price']= $arr[$key]*$datas[0]['total_price']*0.1;
            $datas[0]['stagestr']='第'.$this->totalStageArr()[$key].'期账';
            $datas[0]['project_id']=$id;
            $datas[0]['total_stage']=count($arr);
            $datas[0]['stage']=$datas[0]['stage']+1;
            $datas[0]['price_user_id']= $this->userId;
        }
        print_r(json_encode($datas));
        exit;

    }
    //获取项目已到账的分期账的详情
    public  function getAccountProject(Request $request){
        $id=$request->input('id');
        $stage=$request->input('stage');

        $datas=AccountProject::where(array('account_project.project_id'=>$id,'account_project.stage'=>$stage))
            ->select('account_project.price','account_project.price_time','account_project.stage as accountStage','users.name as user_name','account_project.created_at','project.agreement_number','project.total_price','project.payment_ratio','project.project_name')
            ->leftJoin('users', 'users.id', '=', 'account_project.price_user_id')
            ->leftJoin('project','project.id','=','account_project.project_id')
            ->get()
            ->toArray();
        if(!empty($datas)){
            $key=$datas[0]['accountStage'];
            $datas[0]['stagestr']='第'.$this->totalStageArr()[$key-1].'期账';
        }
        print_r(json_encode($datas));
        exit;
    }
}
