<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Article extends Model
{
    protected $fillable = ['title','content','published_at'];
    protected $dates = ['published_at'];

    public function setPublishedAtAttribute($data)
    {
    	$this->attributes['published_at'] = Carbon::createFromFormat('Y-m-d',$data);
    }

    public function scopePublished($query)
    {
    	$query->where('published_at','<=',Carbon::now());
    }
}
