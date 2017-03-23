<?php
/**
 * Created by sublime_text
 * Author: 补中松
 * Data: 2016/09/29 00:22
 * 功能：评分模型
 */
namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Mark extends Model
{
    protected $fillable =  ['company_id', 'name', 'bonus', 'status', 'sort', 'description'];
}
