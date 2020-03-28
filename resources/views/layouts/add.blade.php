@extends('layouts.dashBoard')

@section('title')
  {{$add_title}}
@endsection

@section('content_header')
  <h1>{{$add_title}}</h1>
@endsection

@section('content')
  <form method="POST" action="/{{$domain}}/{{$id}}/{{$action}}">
    @csrf
    <div class="form-group">
      <div class="row">
        <div class="col-3">
          <input type="submit" class="btn btn-primary" value="登録">
        </div>
      </div>
      @yield('input_field')
    </div>
  </form>


@endsection
