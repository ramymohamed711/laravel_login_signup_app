@extends('layouts.master')

@section('content')

<h2>update password</h2>
  @if(count($errors))
    <div class="alert alert-danger">
      <ul>
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif
{!! Form::open(array('route' => 'updatePassword')) !!}
    <div class="form-group">
      {!! Form::label('password') !!}
      {!! Form::password('password', array('class' => 'form-control')) !!}
    </div>

    <div class="form-group">
      {!! Form::label('confirm password') !!}
      {!! Form::password('password_confirmation', array('class' => 'form-control')) !!}
    </div>
    
    {{ Form::hidden('email', $email) }}
    {{ Form::hidden('password_token', $password_token ) }}


    {!! Form::token() !!}
    {!! Form::submit('Update password', array('class' => 'btn btn-default')) !!}
  {!! Form::close() !!}
@endsection
