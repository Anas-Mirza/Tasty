@extends('layouts.app')

@section('content')
<div class="container">
 <div class="row">
  <div class="col-xs-6">
   @if($data['recipe']!=null)
     <h1>{{$data['recipe']->name}} by {{$data['recipe']->source_name}}</h1>
     <br/>
     <br/>
     <br/>
     <br/>
     <img src= {{$data['recipe']->image_url}} class="img-thumbnail">
     <br/>
     <br/>
     <br/>
     <h4>view recipe instructions:</h4>
          <a href= {{$data['recipe']->source_url}} >see recipe here</a>
          <br/>
          <br/>
          </div>
          <div class="col-xs-6">
          <div align = "right">
          <br/>
          <br/>
          <br/>
          <br/>
          <br/>
          <br/>
          <h5>Ingredients</h5>
          <ul>
          @foreach($data['ingredients'] as $ingredient)
             <li>{{$ingredient->Ingredient_line}}</li>
          @endforeach 
          </ul>
          <h6>Serving size : {{$data['recipe']->servings}} </h6>
          <h7>Calories : {{$data['recipe']->calories}}</h7>

             {!!Form::open(['action' => 'MyRecipeController@store', 'method'=>'POST'])!!}
             {{ Form::hidden('recipe_id', $data['recipe']->id) }}
             {{Form::submit('Add ',['class'=>'btn btn-primary'])}}
             {!!Form::close()!!}  
          </div>
          </div>
   @endif  
 </div>
</div>     
@endsection