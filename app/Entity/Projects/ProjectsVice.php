<?php
/**
 * Created by sublime_text
 * Author: 补中松
 * Data：2016.09.09
 * 功能：项目副模型
 */
namespace App\Entity\Projects;

use Illuminate\Database\Eloquent\Model;

class ProjectsVice extends Model
{
    protected $table = 'projects_vice';
    protected $dates = ['start', 'end', 'true_start', 'true_end', 'examine', 'true_examine'];

    protected $fillable = ['company_id', 'project_id', 'leader', 'department_id', 'start', 'end', 'is_start', 'is_examine', 'examine', 'make_id', 'true_start', 'true_end', 'integral', 'finish','project_file','project_file_suffix', 'grade_id', 'description'];
}
