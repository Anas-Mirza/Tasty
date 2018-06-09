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
@endsection