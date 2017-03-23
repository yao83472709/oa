<?php

namespace App\Entity\Account;

use Illuminate\Database\Eloquent\Model;

class Run extends Model
{
    protected $table='account_run';
    protected $fillable = ['id','company_id','date','type','account_type','account_type','money','description','inventory', 'created_at', 'updated_at','deleted_at'];

}
