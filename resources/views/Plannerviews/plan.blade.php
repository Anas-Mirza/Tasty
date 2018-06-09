@extends('layouts.app')


@section('content')
<h2>{{date_format(date_create($data['date']),'d-m-Y')}} 's Plan</h2>
<h3 align="center">Already planned!</h3>
@if(count($data['already_planned'])<1)
     <p color="red" align="center">No recipes in this plan!</p>
@endif     
@foreach($data['already_planned'] as $meal_array)
     <div class = "well" align="center">
     {{$meal_array['recipe']->name}}
     <br/>
     <img src = {{$meal_array['recipe']->image_url}} class = "img-thumbnail">
     <br/>
     Servings : {{$meal_array['servings']}}
     {!!Form::open(['action' => ['PlannerController@remove',$meal_array['meal_id']], 'method'=>'POST'])!!}
     {{ Form::hidden('_method','DELETE') }}
     {{Form::submit('Remove ')}}
     {!!Form::close()!!}
     <br/>
     </div>
@endforeach

<h3 align="center">Planner Recipes</h3>
@foreach($data['planner_recipes'] as $recipe)
     <div class = "well" align="center">
     {{$recipe->name}}
     <br/>
     <img src = {{$recipe->image_url}} class = "img-thumbnail">
     {!!Form::open(['action' => 'PlannerController@add', 'method'=>'POST'])!!}
     {{ Form::hidden('recipe_id', $recipe->id) }}
     {{ Form::hidden('date', $data['date']) }}
     Servings: {{ Form::text('servings',$recipe->servings)}}
     {{Form::submit('Add ')}}
     {!!Form::close()!!}  
     </div>
@endforeach     

@endsection