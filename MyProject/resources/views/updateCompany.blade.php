@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit COMPANY</h2>
   <form method="post" action="{{ url('editCompany/edit') }}" enctype="multipart/form-data">
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
        <label for="c_name">Company Name:</label>
        <input type="hidden" name="c_id" value="{{ $data->id }}">
        <input type="text" class="form-control" id="c_name" placeholder="Enter Company Name" name="c_name" value="{{ $data->c_name }}">
        @if ($errors->has('c_name'))
        <span class="text-danger">{{ $errors->first('c_name') }}</span>
        @endif
    </div>
    <div class="form-group">
        <label for="c_name">Select Employee:</label>
        <select class="form-control" id="emp_id" name="emp_id">
        <option value=""> Please Select Employee </option> 
        @foreach ($getEmployee as $getEmployees)
        <option value="{{ $getEmployees->id }}" @if($getEmployees->id==$data->emp_id)) selected @endif> {{ $getEmployees->first_name }} {{ $getEmployees->last_name }}</option>  
        @endforeach 
        </select>    
        @if ($errors->has('emp_id'))
        <span class="text-danger">{{ $errors->first('emp_id') }}</span>
        @endif
    </div>
      <div class="form-group">
        <label for="c_email">Company Email:</label>
        <input type="email" class="form-control" id="c_email" placeholder="Enter Company Email" name="c_email" value="{{ $data->c_email }}">
        @if ($errors->has('c_email'))
        <span class="text-danger">{{ $errors->first('c_email') }}</span>
        @endif   
    </div>
      <div class="form-group">
        <label for="c_phone">Company Phone:</label>
        <input type="tel" class="form-control" id="c_phone" placeholder="Enter Company Phone" name="c_phone" value="{{ $data->c_phone }}">
        @if ($errors->has('c_phone'))
        <span class="text-danger">{{ $errors->first('c_phone') }}</span>
        @endif   
    </div>
    <div class="form-group">
        <label for="c_website">Company Website:</label>
        <input type="text" class="form-control" id="c_website" placeholder="Enter Company Website" name="c_website" value="{{ $data->c_website }}">
        @if ($errors->has('c_website'))
        <span class="text-danger">{{ $errors->first('c_website') }}</span>
        @endif
    </div>
    <div class="form-group">
        <label for="c_logo">Company Logo:</label>
        <input type="file" class="form-control" id="c_logo" placeholder="Enter Company Logo" name="c_logo">
        <img src="{{ asset('storage/logo/'.$data->c_logo) }} " height="50px" width="50px" class="img-rounded">
        @if ($errors->has('c_logo'))
        <span class="text-danger">{{ $errors->first('c_logo') }}</span>
        @endif
    </div>
      <button type="submit" class="btn btn-success">ADD COMPANY</button>
   </form>
  </div>
  
@endsection
