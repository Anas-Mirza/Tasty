@extends('layouts.app')

@section('content')
@if(count($user_recipes)>0)
     @foreach($user_recipes as $recipe)
        <div class = "well" align = "center">
             <h3>{{$recipe->name}} by {{$recipe->source_name}}</h3>
             <img src= {{$recipe->image_url}} class="img-thumbnail">
             <br/>
             <br/>
             <a href="/myrecipes/{{$recipe->id}}">view</a>
             <br/> 
             <br/>
             <br/>
        </div> 
     @endforeach
  @endif                       
@endsection