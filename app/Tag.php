<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $hidden = ['pivot'];
    
    protected $fillable = [
        'name', 'user_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function resources()
    {
        return $this->belongsToMany('App\Resource');
    }
}
