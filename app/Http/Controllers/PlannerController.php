<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Recipe;
use App\Mealplan;
use App\Meal;

class PlannerController extends Controller
{
    
    public function __construct()
    {
      $this->middleware('auth');
    }
  
    public function index()
    {
      $user = Auth::user();

      $today=date('Y-m-d');
      $date=date_create($today);
      $has_meal_plan = false;
      $mealplan_id;
      $days = 7;

      if($user->mealplan!=null){
          $has_meal_plan = true;
          $mealplan = $user->mealplan;
          $mealplan_id = $mealplan->id;
          $mealplan_object = Mealplan::find($mealplan_id);
          $max_date_meal = $mealplan_object->meals()->where('plan_date','>=',date('Y-m-d'))->orderBy('plan_date','desc')->first();
          $max_date = $max_date_meal['plan_date'];
      
          
          $weekwise_recipes_array = array();
          $while_date = $today;
          while($while_date <= $max_date){
          
          $meals = $mealplan_object->meals->where('plan_date','=',$while_date);
          $day_recipes_array = array();  
          foreach($meals as $meal){
              $recipe = Recipe::find($meal->recipe_id);
              array_push($day_recipes_array , $recipe);
          }
          $date_inc = date_create($while_date);
          date_add($date_inc,date_interval_create_from_date_string("1 day"));
          $while_date = date_format($date_inc,"Y-m-d");
          array_push($weekwise_recipes_array , $day_recipes_array);
        }
        $days = 7 - count($weekwise_recipes_array);
       return view('Plannerviews.index')->with('data',['weekwise_recipes_array' => $weekwise_recipes_array, 'date' => $date, 'has_meal_plan' => $has_meal_plan, 'mealplan_id' => $mealplan_id, 'days' => $days]);
      }
      else{
          $user_mealplan = new Mealplan;
          $user_mealplan->user_id = Auth::id();
          $user_mealplan->save();
          $mealplan_id = $user_mealplan->id;
          return view('Plannerviews.index')->with('data',['date' => $date, 'has_meal_plan' => $has_meal_plan, 'mealplan_id' => $mealplan_id, 'days' => $days]); 
          }
    }

    public function plan($date){
        
      $user = Auth::user();
      $mealplan = $user->mealplan;
      $mealplan_id = $mealplan->id;
      $mealplan_object = Mealplan::find($mealplan_id);
      $user_recipes = $user->recipes;
      $planner_recipes = array();
      $already_planned = array();

      foreach($user_recipes as $recipe){
            
        $meal = $mealplan_object->meals()->where('plan_date','=',$date)->where('recipe_id','=',$recipe->id)->first();
        
        if($meal != null){

          $meal_array = array();
          $meal_array["recipe"] = $recipe;
          $meal_array["servings"] = $meal['servings'];
          $meal_array["meal_id"] = $meal['id'];
          
          $already_planned[] = $meal_array;
    
        }
        else{
            $planner_recipes[] = $recipe;
        }

      }

      return view('Plannerviews.plan')->with('data',['planner_recipes' => $planner_recipes, 'already_planned' => $already_planned, 'date' => $date]);

    }

    public function add(Request $request)
    {
      $user = Auth::user();
      $mealplan = $user->mealplan;
      $mealplan_id = $mealplan->id;
      $meal = new Meal;
      $meal->mealplan_id = $mealplan_id;
      $meal->recipe_id = $request->recipe_id;
      $meal->plan_date = $request->date;
      $meal->servings = $request->servings;
      $meal->save();
        
      return back();

    } 
    
    public function remove($meal_id)
    {
      $meal_to_delete = Meal::find($meal_id);
      $meal_to_delete->delete();
      return back();
    }

}
