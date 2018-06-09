<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $fillable = ['name','image_url','source_name','source_url','servings','calories'];

    public function ingredients(){
        return $this->belongsToMany('App\Ingredient','ingredient_recipe','recipe_id','ingredient_id');
    }

    public function users(){
        return $this->belongsToMany('App\User','recipe_user','recipe_id','user_id');
    }
}
