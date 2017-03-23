<?php
/**
 * Created by sublime_text
 * Author：补中松
 * Data：2016/09/29  21:45
 * 功能：积分纪录模型
 */
namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class IntegralLog extends Model
{
    protected $table = 'integral_log';

    protected $fillable = ['company_id', 'type', 'user_id', 'origin', 'integral'];
}
