@extends('layouts.index')

@php
  $index_title = 'スクリプト「'.$item->name.'」';
@endphp

@section('content_table')
  <a href="/scenario_operation/{{$id}}/add/{{$this_id}}" class="btn btn-primary">操作追加</a>
  <div class="container">
    @foreach($item->scenario_operation as $scenario_operation)
    <div class="card card-default collapsed-card">
      <div class="card-header with-border">
        <h3 class="card-title">{{$scenario_operation->name}}</h3>
        <div class="card-tools pull-right">
          <button class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-plus"></i></button>
          </button>
        </div>
          <!-- /.card-tools -->
      </div>
        <!-- /.card-header -->
      <div class="card-body">
        {{$scenario_operation->make_json()}}
      </div>
        <!-- /.card-body -->
    </div>
    @endforeach
  </div>

@endsection
