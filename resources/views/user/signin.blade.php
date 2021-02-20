@extends('layouts.master')

@section('content')
  <div class="row">
    <div class="col-md-4 offset-md-4">
      <h1>Sign In</h1>
      @if(count($errors) > 0)
        <div class="alert alert-danger">
          @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
          @endforeach
        </div>
      @endif
      <form action="{{ route('user.signin') }}" method="post">
        <div class="mb-3">
          <label for="email" class="email form-label">Email</label>
          <input type="text" name="email" id="email" class="form-control">
        </div>
        <div class="mb-3">
          <label for="password" class="password form-label">Password</label>
          <input type="password" name="password" id="password" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Sign In</button>
        {{ csrf_field() }}
      </form>
    </div>
  </div>
@endsection