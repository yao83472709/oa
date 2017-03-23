<?php

namespace App\Entity;

use QL\QueryList,Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
	protected $table = 'collection';

    protected $fillable = ['type','title','link','price','partake'];

    /**
     * 获取指定类型的猪八戒采集数据
     * @param  $configArr array  采集所需的参数数组 包含以下具体参数
     * @param  $type      int    数据的类型： 0 网建 1 品牌设计;
     * @param  $page      vachar 获取页面的地址;
     * @param  $timeSlote vachar 获取数据的时间段;
     * @param  $isEmail   int    是否发送邮件通知;
     * @return array
     */
    public static function getBaJieDate($configArr)
    {
    	if($configArr) {
			/*采集*/
			$data = QueryList::Query($configArr['page'],$configArr['rules'],$configArr['rang'])->data;
			if($data) {
				$oldData = Collection::where('type',$configArr['type'])->lists('link')->toArray();
				foreach ($data as $val) {
					if(!in_array($val['link'],$oldData)) {
						$val['type'] = $configArr['type'];
						$newData[] = $val;
						Collection::create($val);
					}
				}
				$hour = Carbon::now()->hour;
				$timeSlot = explode('至',str_replace(array("点"),"",$configArr['timeSlot']));
				if(isset($newData) && $hour >= $timeSlot[0] && $hour < $timeSlot[1] && $configArr['isEmail']) {
					$usersId = CollectionUser::where('type',$configArr['type'])->lists('user_id')->toArray();
					$email = User::whereIn('id',$usersId)->get()->lists('email')->toArray();
					if($email) {
						/*发送邮件*/
						$demand = trans('collection.demand.'.$configArr['type']);
						$subject = trans('collection.email_title', ['count' => count($newData),'demand'=>$demand]);
						$view = 'email.demand';
						$data['newData'] = $newData;
						sentTo($email,$subject,$view,$data);
					}
				}
			}
			return true;
    	}
    }
}
