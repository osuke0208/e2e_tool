@extends('layouts.dashBoard')

@section('title','テストシナリオ一覧')

@section('content_header')
  <h1>テストシナリオ一覧</h1>
@endsection

@section('content')

<a href="/scenario/{{$id}}/add">シナリオ追加  </a>

<div class="container">
  @foreach($items as $item)
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">{{$item->name}}</h3>
      <div class="card-tools">
        <!-- Buttons, labels, and many other things can be placed here! -->
        <!-- Here is a label for example -->
      </div>
      <!-- /.card-tools -->
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      {{$item->make_json()}}
    </div>
  </div>
  @endforeach

</div>


@endsection
