<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shoplist extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function listitem()
    {
        return $this->hasMany('App\Listitem');
    }
}
