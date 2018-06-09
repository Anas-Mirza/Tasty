<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mealplan extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function meals()
    {
        return $this->hasMany('App\Meal');
    }
}
