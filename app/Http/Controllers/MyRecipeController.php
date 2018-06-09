<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Recipe;
use App\Ingredient;
use App\User;

class MyRecipeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        //$user_id = auth()->user('id');
        //$user = User::with('recipes')->find($user_id);
        //$user_recipes = $user[0]['recipes'];
        $user = Auth::user();
        $user_recipes = $user->recipes;
        return view('personalrecipes.index')->with('user_recipes',$user_recipes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {  
        //$validated_data = $request->validate(['recipe_id'=>'required|unique_with:recipe_user,user_id']);
        $recipe_id = $request->input('recipe_id');
        $user_id = auth()->id();
        $recipe = Recipe::find($recipe_id);
        $user = $recipe->users()->where('user_id','=',$user_id)->first();
        if($user!=null)
          return back();
        else
          $recipe->users()->attach($user_id);
          return redirect()->route('myrecipes');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user_id = auth()->user('id');
        $recipe = Recipe::find($id);
        $ingredients = $recipe->ingredients;
        
        //$recipe_added = false;
        return view('personalrecipes.show')->with('data',['recipe' => $recipe, 'ingredients' => $ingredients ]);
    }

    public function remove($recipe_id)
    {
        $user = Auth::user();
        $user->recipes()->detach($recipe_id);
        return redirect()->route('myrecipes');
    }

}
