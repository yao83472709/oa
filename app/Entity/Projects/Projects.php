<?php
/**
 * Created by sublime_text
 * Author：汪伟
 * Data：2016/09/02  15:24
 * 功能：项目模型管理
 */
namespace App\Entity\Projects;

use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
	protected $dates = ['start', 'end'];
    protected $fillable = ['company_id', 'user_id', 'customer_id', 'number', 'departments', 'name', 'customer_id', 'status_id', 'start', 'end', 'deal_price', 'integral', 'bonus', 'is_invoice', 'payment_ratio', 'stage', 'is_finish', 'is_record', 'record_file', 'record_file_suffix', 'relevant_file', 'relevant_file_suffix', 'description' ];

}
