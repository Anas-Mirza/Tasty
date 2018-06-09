<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Listitem extends Model
{
    public function shoplist()
    {
        return $this->belongsTo('App\Shoplist');
    }
}
