@extends('layouts.master')

@section('content')
  <h2>Register</h2>
  @if (Session::has('message'))
    <div class="alert alert-success">{{ Session::get('message') }}</div>
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
  @if (Session::has('error_message'))
    <div class="alert alert-danger">{{ Session::get('error_message') }}</div>
@endif
  {!! Form::open(array('route' => 'users.store')) !!}
    <div class="form-group">
        {!! Form::label('firstname', 'First name') !!}
        {!! Form::text('firstname', null, array('class' => 'form-control')) !!}
    </div>
       <div class="form-group">
        {!! Form::label('surname', 'Surname') !!}
        {!! Form::text('surname', null, array('class' => 'form-control')) !!}
    </div>
    <div class="form-group">
        {!! Form::label('email') !!}
        {!! Form::text('email', null, array('class' => 'form-control')) !!}
    </div>
    <div class="form-group">
        {!! Form::label('gender') !!}
        {!! Form::select('gender', ['','male', 'female'],array('class' => 'form-control')) !!}
    </div>
    
    <div class="form-group">
        {!! Form::label('User type') !!}
          @if( \Auth::check() && \Auth::user()->user_type == 'orchestra' )
         {!! Form::select('user_type', ['','orchestra'=>'orchestra','musician'=>'musician','member'=>'member'],array('class' => 'form-control')) !!}
         @else
         {!! Form::select('user_type', ['','orchestra'=>'orchestra','musician'=>'musician'],array('class' => 'form-control')) !!}
         @endif
    </div>

    <div class="form-group">
      {!! Form::label('password') !!}
      {!! Form::password('password', array('class' => 'form-control')) !!}
    </div>

<div class="form-group">
      {!! Form::label('confirm password') !!}
      {!! Form::password('password_confirmation', array('class' => 'form-control')) !!}
    </div>

    {!! Form::token() !!}
    {!! Form::submit('Register', array('class' => 'btn btn-default')) !!}
  {!! Form::close() !!}
@endsection
