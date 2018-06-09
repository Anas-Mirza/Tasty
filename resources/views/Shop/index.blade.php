@extends('layouts.app')

@section('content')
@if(count($shopping_list)>0)
    <div class = "container">
    <table class = "table table-striped">
    <thead>
    <tr>
    <th>Item Name</th>
    <th>Quantity</th>
    <th>Weigh(in gms)</th>
    <th>Measure</th>
    </tr>
    </thead>
    <tbody>
    @foreach($shopping_list as $list_item)
          <tr>
          <td>{{$list_item['name']}}</td>
          <td>{{$list_item['quantity']}}</td>
          <td>{{$list_item['weight']}}</td>
          <td>{{$list_item['measure']}}</td>
          </tr>
    @endforeach

@else
<h2>No Items in your shopping list!</h2>

@endif          
         
@endsection