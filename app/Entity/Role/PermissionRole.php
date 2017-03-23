<?php

namespace App\Entity\Role;

use Illuminate\Database\Eloquent\Model;

class PermissionRole extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'permission_role';
}
