@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit EMPLOYEE</h2>
   <form method="post" action="{{ url('editEmployee/edit') }}">
    @csrf

    @if(Session::has('success'))
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                            @php
                                Session::forget('success');
                            @endphp
                        </div>
                        @endif

      <div class="form-group">
        <label for="first_name">First Name:</label>
        <input type="hidden" name="empID" value="{{ $data->id }}">
        <input type="text" class="form-control" id="first_name" placeholder="Enter First Name" name="first_name" value="{{ $data->first_name }}">
        @if ($errors->has('first_name'))
        <span class="text-danger">{{ $errors->first('first_name') }}</span>
        @endif
    </div>
      <div class="form-group">
        <label for="last_name">Last Name:</label>
        <input type="text" class="form-control" id="last_name" placeholder="Enter Last Name" name="last_name" value="{{ $data->last_name }}">
        @if ($errors->has('last_name'))
        <span class="text-danger">{{ $errors->first('last_name') }}</span>
        @endif  
    </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" class="form-control" id="email" placeholder="Enter Email" name="email" value="{{ $data->email }}">
        @if ($errors->has('email'))
        <span class="text-danger">{{ $errors->first('email') }}</span>
        @endif   
    </div>
      <div class="form-group">
        <label for="phone">Phone:</label>
        <input type="tel" class="form-control" id="phone" placeholder="Enter Phone" name="phone" value="{{ $data->phone }}">
        @if ($errors->has('phone'))
        <span class="text-danger">{{ $errors->first('phone') }}</span>
        @endif   
    </div>
      <button type="submit" class="btn btn-success">Edit EMPLOYEE</button>
   </form>
  </div>
  
@endsection
