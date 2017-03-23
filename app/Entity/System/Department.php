<?php
/**
 * Created by sublime_text
 * Author: 补中松
 * Data: 2016/09/22 13:35
 * 功能：公司部门模型
 */
namespace App\Entity\System;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable =  ['company_id', 'parent_id', 'is_development', 'name', 'alias', 'bonus', 'status', 'sort', 'description'];
}
