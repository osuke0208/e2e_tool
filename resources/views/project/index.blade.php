@extends('layouts.index')

@php
  $index_title = 'プロジェクト一覧';
@endphp

@section('content_table')
<div class="container">
  <div class="row">
    <a href="/{{$domain}}/{{$id}}/add/" class="btn btn-primary">プロジェクト登録</a>
  </div>
</div>
<br/>

@foreach($items as $item)
  <div class="container">
    <div class="card card-outline card-primary">
      <div class="card-header">
        <h3 class="card-title">
          {{$item->name}}
          <a href="/scenario/{{$id}}/add/{{$item->id}}" class="btn btn-primary">シナリオ追加</a>
        </h3>
      </div>
        <div class="card-body no-padding">
          <div class="row">
            @foreach($item->scenario as $scenario)
              <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-blue">
                 <div class="inner">
                   <h4>{{$scenario->name}}</h4>
                   <p>{{$scenario->description}}</p>
                 </div>
                 <div class="icon">
                   <i class="ion ion-stats-bars"></i>
                 </div>
                 <a href="/scenario/{{$id}}/detail/{{$scenario->id}}/" class="small-box-footer">詳細<i class="fa fa-arrow-circle-right"></i></a>
                </div>
              </div>
            @endforeach
          </div>
        </div>
    </div>
  </div>
@endforeach

@endsection