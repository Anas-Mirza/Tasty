<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Recipe;
use App\query;

class SearchController extends Controller
{
    public function index(){
        return view('search.index');
    }

    public function results(Request $request){
        $query = $request->input('query');
        $message = "succes";
        $recipe_result = Recipe::where('name','LIKE',"%{$query}%")->get();
        if (count($recipe_result)) {
            return view('search.results')->with('data',['recipe_result' => $recipe_result,'message' => $message]);
        }
        else{
          $message = "no result";  
          $query_object = new query;
          $query_array = ['query' => $query];
          $validator = Validator::make($query_array,['query' => 'required|unique:queries,query_to_run']);
          if($validator->fails())
          return view('search.results')->with('message',$message);
          $query_object->query_to_run = $query;
          $query_object->done = false;
          $query_object->save();
          return view('search.results')->with('data',['recipe_result' => $recipe_result,'message' => $message]);
          
        }
    }

    public function show($id){
        $user_id = auth()->user('id');
        $recipe = Recipe::find($id);
        $ingredients = $recipe->ingredients;
        //$recipe_added = false;
        return view('search.show')->with('data',['recipe' => $recipe, 'ingredients' => $ingredients ]);
    }
}
