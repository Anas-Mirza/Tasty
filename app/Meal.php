<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    public function mealplan()
    {
        return $this->belongsTo('App\Mealplan');
    }
}
