<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Recipe;
use App\Ingredient;
use App\Mealplan;
use App\Meal;

class ShoppingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
      
        $user = Auth::user();
        $has_meal_plan = true;
        $mealplan = $user->mealplan;
        $mealplan_id = $mealplan->id;
        $mealplan_object = Mealplan::find($mealplan_id);
        $meals = $mealplan_object->meals()->where('plan_date','>=',date('Y-m-d'))->get();
        $shopping_list = array();
       foreach($meals as $meal)
       {
           
           $recipe = Recipe::find($meal->recipe_id);
           $custom_serving = (float)$meal->servings/$recipe->servings;
           foreach($recipe->ingredients as $ingredient){
                $list_item = array();
                $filled = false;
                if(count($shopping_list)>0){
                    for($i=0; $i<count($shopping_list); $i++){
                        if($ingredient->name == $shopping_list[$i]['name']){
                            $shopping_list[$i]['quantity'] += ($ingredient->quantity*$custom_serving);
                            $shopping_list[$i]['weight'] += ($ingredient->weight_in_gms*$custom_serving);
                            $filled = true;
                        }
                    }
                    if($filled == false){
                        $list_item['name'] = $ingredient->name;
                        $list_item['quantity'] = ($ingredient->quantity*$custom_serving);
                        $list_item['weight'] = ($ingredient->weight_in_gms*$custom_serving);
                        $list_item['measure'] = $ingredient->measure;
                        $shopping_list[] = $list_item;
                    }
                }
                else{
                    $list_item['name'] = $ingredient->name;
                    $list_item['quantity'] = ($ingredient->quantity*$custom_serving);
                    $list_item['weight'] = ($ingredient->weight_in_gms*$custom_serving);
                    $list_item['measure'] = $ingredient->measure;
                    $shopping_list[] = $list_item;
                }
           }
       }

        return view('Shop.index')->with('shopping_list',$shopping_list);

    }

    
}
