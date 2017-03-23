<?php
/**
 * Created by sublime_text
 * Author：补中松
 * Data：2016/10/10  17:36
 * 功能：任务模型管理
 */
namespace App\Entity\Projects;

use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    protected $dates = ['finish_time'];

    protected $fillable = ['company_id', 'project_id', 'user_id', 'make_id', 'type', 'department_id' , 'grade_id', 'integral', 'actual_integral', 'finish_time', 'status', 'is_transfer', 'transfer_id', 'receive_id', 'file','file_suffix', 'description'];
}	
