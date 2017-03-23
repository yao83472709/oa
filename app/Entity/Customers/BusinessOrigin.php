<?php
/**
 * Created by sublime_text
 * Author: 补中松
 * Data: 2016/09/02 10:20
 * 功能：业务来源模型
 */
namespace App\Entity\Customers;

use Illuminate\Database\Eloquent\Model;

class BusinessOrigin extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'business_origin';
    protected $fillable =  ['name', 'company_id', 'status', 'sort', 'description' ];
}
