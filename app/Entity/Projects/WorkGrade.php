<?php
/**
 * Created by sublime_text
 * Author：补中松
 * Data：2016/10/13  15:31
 * 功能：任务模型管理
 */
namespace App\Entity\Projects;

use Illuminate\Database\Eloquent\Model;

class WorkGrade extends Model
{
    protected $table = 'works_grade';

    protected $fillable = ['company_id', 'name', 'status', 'description'];
}
