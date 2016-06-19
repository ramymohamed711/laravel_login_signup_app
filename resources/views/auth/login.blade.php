@extends('layouts.master')

@section('content')

<h2>Login</h2>

@if (Session::has('message'))
    <div class="alert alert-success">{{ Session::get('message') }}</div>
@endif

@if (Session::has('error_message'))
    <div class="alert alert-danger">{{ Session::get('error_message') }}</div>
@endif

  @if(count($errors))
    <div class="alert alert-danger">
      <ul>
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  {!! Form::open(array('route' => 'handleLogin')) !!}
    <div class="form-group">
        {!! Form::label('email') !!}
        {!! Form::text('email', null, array('class' => 'form-control')) !!}
    </div>
    <div class="form-group">
      {!! Form::label('password') !!}
      {!! Form::password('password', array('class' => 'form-control')) !!}
    </div>

    <div class="form-group">
        {!! Form::label('Login type') !!}
        {!! Form::select('user_type', ['','orchestra'=>'orchestra','musician'=>'musician','member'=>'member'],array('class' => 'form-control')) !!}
    </div>
    

    {!! Form::token() !!}
    {!! Form::submit('Login', array('class' => 'btn btn-default')) !!}
  {!! Form::close() !!}
@endsection
