<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class CollectionUser extends Model
{
    protected $table = 'collection_user';
    
    protected $fillable = ['type','user_id'];
}
