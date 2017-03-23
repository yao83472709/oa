<?php
/*
采集猪八戒数据
*/
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Entity\System\SysConfig;
use App\Entity\System\Department;
use App\Entity\Collection;
use App\Entity\CollectionUser;
use App\Entity\User;

use Log,DB;

class CollectionController extends Controller
{
	private $company_id = 1;

    public function __construct()
    {
        if($this->company_id) {
           //获取配置信息
           $SysConfig = new SysConfig;
           $SysConfig->getConfigs($this->company_id);
           view()->share('cfg_style', $GLOBALS['cfg_style']);
           view()->share('cfg_company', $GLOBALS['cfg_company']);
        }
    }

	public function index($type)
	{
		$demands = Collection::where('type',$type)->latest()->paginate(11);
		return view($GLOBALS['cfg_style'].'.collection.index',compact('demands','type'));
	}

	/*邮件通知用户*/
	public function notice($type)
	{
		$collectionUser = CollectionUser::where('type',$type)->lists('user_id')->toArray();
		$departments = Department::where('company_id',$this->company_id)->where('status',0)->where('is_development',1)->select('name','id')->get();//部门
		$users = User::where('is_salesman',1)->get();
		foreach ($users as $user) {
			if(in_array($user->id, $collectionUser)) {
				$user->checked = true;
			}else {
				$user->checked = false;
			}
		}
		return view($GLOBALS['cfg_style'].'.collection.create',compact('users','departments','type'));
	}

	/*修改邮件通知用户*/
	public function noticeUpdate(Request $request)
	{
		$users = $request->input('users');
		$type = $request->input('type');
		$collectionUser = CollectionUser::where('type',$type)->lists('user_id')->toArray();
		if($users) {
			DB::beginTransaction();
			foreach ($users as $uid) {
				 /*如果当前用户已存在就不添加到成员组中*/
				if(in_array($uid, $collectionUser)) {
					/*如果当前用户存在于历史组员中，则从历史组员中删除此元素*/
					$key = array_search($uid, $collectionUser);
	                if ($key !== false) {
	                    array_splice($collectionUser, $key, 1);
	                }
				}else {
					CollectionUser::create(['user_id'=>$uid,'type'=>$type]);
				}
			}
			DB::commit();
		}
		/*删除历史组员中，用户没有选择的用户*/
        if($collectionUser) {
        	CollectionUser::where('type',$type)->whereIn('user_id',$collectionUser)->delete();
        }
        return response()->json(array(
            'status' => 0,
            'message' => trans('common.add_success')
        ));
	}

    public function getData()
    {
    	Log::error('采集数据');//写入日志
    	/*准备采集配置信息*/
    	$configs = array(
		    		'web' => array(
		    			'type' => 0, 
		    			'page' => $GLOBALS['cfg_bajie_url'],
		    			'rules' => array(
										'title' => ['.list-task-title','title'], //文章标题
										'link' => ['.list-task-title','href'], //链接
										'price' => ['.list-task-reward','text'], //价格
										'partake' => ['.normal-p','text'] //参与人数
									),
						'rang' => '.list-task>tr', //列表选择器
		    			'timeSlot' => $GLOBALS['cfg_bajie_time'] ,
		    			'isEmail' => $GLOBALS['cfg_bajie_email']
		    			),
		    		'design' => array(
		    			'type' =>1,
		    			'page' => $GLOBALS['cfg_bajie_design_url'],
		    			'rules' => array(
										'title' => ['.list-task-title','title'], //文章标题
										'link' => ['.list-task-title','href'], //链接
										'price' => ['.list-task-reward','text'], //价格
										'partake' => ['.normal-p','text'] //参与人数
									),
						'rang' => '.list-task>tr', //列表选择器
		    			'timeSlot' => $GLOBALS['cfg_bajie_design_time'],
		    			'isEmail' => $GLOBALS['cfg_bajie_design_email']
		    			),
    				);
		/*开始采集数据*/
    	foreach ($configs as $key => $config) {
    		Collection::getBaJieDate($config);
    	}
		return array(
            'status' => 0,
            'message' =>  trans('collection.success')
        );
    }
}
