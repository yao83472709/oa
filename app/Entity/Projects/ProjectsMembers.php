<?php
/**
 * Created by sublime_text
 * Author：补中松
 * Data：2016/09/26  17:36
 * 功能：项目成员模型管理
 */
namespace App\Entity\projects;

use Illuminate\Database\Eloquent\Model;

class ProjectsMembers extends Model
{
    protected $table = 'projects_members';
    protected $fillable = ['company_id', 'department_id', 'project_id','user_id', 'is_leader', 'make_id', 'mark', 'replace_user_id', 'bereplace_user_id', 'is_bonus', 'bonus_type', 'bonus', 'is_obtain', 'is_work', 'description', 'updated_at', 'created_at', 'deleted_at'];
}
