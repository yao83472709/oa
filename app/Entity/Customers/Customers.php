<?php
/**
 * Created by sublime_text
 * Author: 补中松
 * Data: 2016/09/04 21:49
 * 功能：客户模型
 */
namespace App\Entity\Customers;

use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    protected $fillable =  [ 'company', 'name','company_id', 'type', 'number', 'phone', 'email', 'offer', 'type_id', 'developer_id', 'salesman_id', 'customer_status_id', 'origin_id', 'change', 'lose', 'lose_id', 'description', 'province', 'city', 'county', 'address'];
}
