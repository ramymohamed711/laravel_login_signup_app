@extends('layouts.master')

@section('content')
  @if (Session::has('message'))
    <div class="alert alert-success">{{ Session::get('message') }}</div>
@endif
  <h3>Home-page for user {{ \Auth::user()->firstname . ' '.\Auth::user()->surname   }}</h3>
@endsection
