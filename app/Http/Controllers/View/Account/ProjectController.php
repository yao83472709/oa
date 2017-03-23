<?php   namespace App\Http\Controllers\View\account;
/**
 * Created by PhpStorm.
 * User: 胥毅
 * Date: 2016/9/3 0003
 * Time: 11:05
 * 功能：账务项目账，view显示controller
 */

use App\Entity\System\SysConfig;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Entity\Account\Project as AccountProject;
use App\Entity\Projects\Project ;


class ProjectController extends Controller
{
    public function __construct()
    {
        $this->company_id = Auth::user()->company_id;
        if($this->company_id) {
            //获取配置信息
            $SysConfig = new SysConfig;
            $SysConfig->getConfigs($this->company_id);
            view()->share('cfg_style', $GLOBALS['cfg_style']);
            view()->share('cfg_company', $GLOBALS['cfg_company']);
        }
    }
    //公司的id
    protected $company_id;
    //index显示
    public function index()
    {
        //数据库查询生成实例
        $datas=Project::where('project.company_id',$this->company_id)
            ->select('project.id','project.project_name','project.payment_ratio','project.total_price','project.finish','users.name as user_name')
            ->selectSub('sum(account_project.price)','payment')
            ->selectSub('project.total_price-SUM(account_project.price)','nopayment')
            ->leftJoin('account_project','project.id','=','account_project.project_id')
            ->leftJoin('users', 'users.id', '=', 'project.user_id')
            ->groupby('project.id')
            ->paginate(10);
        return view($GLOBALS['cfg_style'].'.account.project.index',compact('datas'));
    }
    //添加项目页面
    public function create()
    {

    }
    //编辑添加账页面
    public function edit($id)
    {

        $datas=Project::where('id',$id)
            ->select('id','stage','finish')->get();
        return view($GLOBALS['cfg_style'].'.account.project.create',compact('datas'));
    }
    //项目详情显示页面
    public function show($id)
    {
        $datas=AccountProject::where('account_project.project_id',$id)
            ->select('account_project.price','account_project.price_time','account_project.stage','account_project.finish','users.name as user_name','account_project.created_at')
            ->leftJoin('users', 'users.id', '=', 'account_project.price_user_id')
            ->get();
        return view($GLOBALS['cfg_style'] .'.account.project.show',compact('datas'));
    }

}