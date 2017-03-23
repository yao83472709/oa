<?php
/**
 * Created by sublime_text
 * Author: 补中松
 * Data: 2016/09/09 17:15
 * 功能：配置模型
 */
namespace App\Entity;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Bican\Roles\Traits\HasRoleAndPermission;
use Bican\Roles\Contracts\HasRoleAndPermission as HasRoleAndPermissionContract;

use App\Events\UserRegistered;

class User extends Authenticatable implements  HasRoleAndPermissionContract
{
    use HasRoleAndPermission;

    protected $dates = ['birthday'];
    protected $fillable = [
        'company_id' ,'number' ,'username' ,'password' ,'name' ,'nickname' ,'head_portrait' ,'department_id' ,'is_developer' ,'is_salesman' ,'status' ,'integral' ,'experience' ,'grade' ,'safe_deduct' ,'phone' ,'mobile' ,'email' ,'sex' ,'province' , 'city' , 'county' , 'address' ,'birthday' ,'description' ,'is_company' ,'is_highest' ,'company_number' ,'company_true_number' ,'remember_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = [
        'password' , 'remember_token' ,
    ];

    /**
     * 用户注册
     */
    public static function register(array $attributes)
    {
        $user = static::create($attributes);
        //发送邮件通知
        event(new UserRegistered($user));
        return $user;
    }
}
