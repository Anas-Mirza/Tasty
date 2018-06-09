<?php

namespace App\Library;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Recipe;
use App\Ingredient;
use App\query;
use App\Library\IngredientParser;
use Illuminate\Support\Facades\Log;

class AddDataFromapi {


    private function store_ingredient_of_recipe($ingredient, $recipe_object){
       
        $ingredient_object = new Ingredient;
       
        //validation
        $rules = [
            'ingredient_line' => 'required',
        ];

        $validator = Validator::make($ingredient,$rules);
        if ($validator->fails()) {
            return;
         }

          $ingredient_object->Ingredient_line = $ingredient["ingredient_line"];
          $ingredient_object->is_a_recipe = false;
          $ingredient_object->parsed = false;
          $ingredient_object->quantity = 0.0;
          $ingredient_object->measure = " ";
          $ingredient_object->weight_in_gms = $ingredient["weight_in_gms"];
          $ingredient_object->save();
          $recipe_object->ingredients()->attach($ingredient_object->id);
        
    }

    private function store_recipe($recipe,$ingredients_array){
      $recipe_object = new Recipe;
      //validation
      $rules = [
          'name' => 'required|unique_with:recipes,source_name',
          'source_name' => 'required',
          'source_url' => 'required'
      ];
      $validator = Validator::make($recipe,$rules);
      if($validator->fails()) {
          echo "recipe validation failure";
        return;
      }
      //validation end
      $recipe_object->fill($recipe);
      //$recipe_object->instructions = " ";
      $recipe_object->total_time = 0.0;
      $recipe_object->save();
      
      foreach($ingredients_array as $ingredient){
          $this->store_ingredient_of_recipe($ingredient, $recipe_object);
      }  //if ends
    } 
    
    private function parse_data_from_hits($hits){
        foreach($hits->hits as $hit){
        $recipe = $hit->recipe;
        
        $recipe_array = array();
        $recipe_array["name"] = $recipe->label;
        $recipe_array["image_url"] = $recipe->image;
        $recipe_array["source_name"] = $recipe->source;
        $recipe_array["source_url"] = $recipe->url;
        $recipe_array["servings"] = $recipe->yield;
        $recipe_array["calories"] = $recipe->calories;

        

        $ingredients_array = array();
          foreach($recipe->ingredients as $ingredient){
            $single_ingredient["ingredient_line"] = $ingredient->text;
            $single_ingredient["weight_in_gms"] = $ingredient->weight;
            $ingredients_array[] = $single_ingredient;
          } 
          $this->store_recipe($recipe_array,$ingredients_array);
        }   
      }

      public function update_db(){
          $queries = DB::table('queries')->where('done','false')->get();
          foreach($queries as $query){
            $this->get_results($query->query_to_run);
            DB::table('queries')->where('id', $query->id)->update(['done' => true]);
            break;
          }
      }
      
      private function get_results( $query ){
        $edamam_id = config('app.edamam_id');
        $edamam_key = config('app.edamam_key');
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'https://api.edamam.com/search', [
            'query' => [
                'q'       => $query,
            'app_id'  => $edamam_id,
            'app_key' => $edamam_key,
            ]
            ]);
        $status_code = (string)$response->getStatusCode();
        if($status_code == "200"){ 
        $data = $response->getBody();
        $hits = json_decode($data);
        $this->parse_data_from_hits($hits);
        }
        else
        echo "failure";
    }

} 