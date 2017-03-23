<?php

namespace App\Entity\Account;

use Illuminate\Database\Eloquent\Model;

class RunType extends Model
{
    protected $table='account_type';
    protected $fillable =  [ 'company_id','name', 'status','account_sys_type', 'created_at', 'updated_at','deleted_at'];

}
