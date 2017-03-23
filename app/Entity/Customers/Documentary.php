<?php
/**
 * Created by sublime_text
 * Author: 补中松
 * Data: 2016/9/6 11:10
 * 功能：业务类型模型
 */
namespace App\Entity\Customers;

use Illuminate\Database\Eloquent\Model;

class Documentary extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'customers_log';
    protected $fillable =  ['company_id', 'customer_id', 'make_id', 'type', 'sendee_id', 'status', 'examine_id'];
}
