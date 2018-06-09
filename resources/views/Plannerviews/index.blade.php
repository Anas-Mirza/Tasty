@extends('layouts.app')

@section('content')
@if($data['has_meal_plan'])
     <h1>Planner<small>   create your meal plans</small></h1>
     <br/>
     <br/>
     {{date_format($data['date'],'d-m-Y')}}
     <a href=/planner/plan/{{date_format($data['date'],'Y-m-d')}}>plan</a> 
     <br/>
     <br/>
     @foreach($data['weekwise_recipes_array'] as $day_recipes_array)
         <div class =  "well">
         <ul class = "list-inline">
         @foreach($day_recipes_array as $recipe)
             <li class = "list-inline-item">{{$recipe->name}}</li>
         @endforeach
         </ul>
             <br/>
             <br/>
             {{date_format(date_add($data['date'],date_interval_create_from_date_string("1 day")),'d-m-Y')}}
             <a href=/planner/plan/{{date_format($data['date'],'Y-m-d')}}>plan</a>
         </div>
     @endforeach
     @for ($i = $data['days'] ; $i > 1 ; $i--)
            <div class = "well">
            <br/>
            {{date_format(date_add($data['date'],date_interval_create_from_date_string("1 day")),'d-m-Y')}}
            <a href=/planner/plan/{{date_format($data['date'],'Y-m-d')}}>plan</a>
            <div/> 
     @endfor                  
<br/> 
<br/> 
@else
      {{"no result"}}
      <div class = "well">
      @for ($i = $data['days'] ; $i > 0 ; $i--)
                {{date_format(date_add($data['date'],date_interval_create_from_date_string("1 day")),'d-m-Y')}}
                <a href=/planner/plan/{{date_format($data['date'],'Y-m-d')}}>plan</a>  
      @endfor
      </div> 
@endif                

@endsection