<?php
/**
 * Created by sublime_text
 * Author: 补中松
 * Data: 2016/09/08 15:33
 * 功能：客户状态模型
 */
namespace App\Entity\Customers;

use Illuminate\Database\Eloquent\Model;

class CustomerStatus extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'customers_status';
    protected $fillable =  ['name', 'company_id', 'description' , 'status', 'sort'];
}
