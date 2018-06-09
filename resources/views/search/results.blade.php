@extends('layouts.app')

@section('content')
<h1>Search <small>new recipes by name or ingredient</small></h1>
{!!Form::open(['action' => 'SearchController@results', 'method'=>'POST'])!!}
<div class="form-group">
{{Form::label('query', 'Search')}}
{{Form::text('query','',['class'=>'form-control','placeholder'=>'your query'])}}
</div>
{{Form::submit('Submit ',['class'=>'btn btn-primary'])}}
{!!Form::close()!!}
<h2>Recipes</h2>
  @if(count($data['recipe_result'])>0)
     @foreach($data['recipe_result'] as $recipe)
        <div class = "well" align = "center">
             <h3>{{$recipe->name}} by {{$recipe->source_name}}</h3>
             <img src= {{$recipe->image_url}} class="img-thumbnail">
             <br/>
             <br/>
             <a href="/search/{{$recipe->id}}">view</a>
             <br/> 
             <br/>
             <br/>
        </div> 
     @endforeach
  @endif 
  {{$data['message']}}                      
@endsection