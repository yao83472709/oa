<?php
/**
 * Created by sublime_text
 * Author: 补中松
 * Data: 2016/09/19 10:51
 * 功能：客户动态模型
 */
namespace App\Entity\Customers;

use Illuminate\Database\Eloquent\Model;

class CustomersDynamic extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'customers_dynamic';
    protected $fillable =  ['company_id', 'status_id', 'customer_id', 'user_id', 'content', 'next_time'];
}
