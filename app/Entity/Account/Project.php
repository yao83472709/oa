<?php
namespace App\Entity\Account;
/**
 * Created by PhpStorm.
 * User: 胥毅
 * Date: 2016/9/3 0003
 * Time: 11:05
 * 功能：账务项目账，Model
 */

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Project extends Model
{
    protected $table='account_project as a';
    protected $fillable =  [ 'company_id','project_id', 'project_name','user_id','payment_ratio','total_price', 'price','price_time','total_stage','stage','finish','price_user_id','created_at', 'updated_at','deleted_at'];

    //关联关系
    public function ProjectToUsername()
    {
        return $this->hasOne('App\User','id','user_id');
    }

}
