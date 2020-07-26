<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    protected $hidden = ['pivot'];
    
    protected $fillable = [
        'name', 'description', 'url', 'category_id', 'user_id'
    ];
    
    public function tags()
    {
        return $this->belongsToMany('App\Tag');
    }

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
