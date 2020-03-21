@extends('layouts.index')

@php
  $index_title = 'スクリプト「'.$item->name.'」';
@endphp

@section('content_table')
<div class="col-3">
  <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#modal_script">
    Script JSON表示
  </button>
</div>
<br/>
<div class="container">
  <div class="card card-outline card-primary">
    <div class="card-header">
      <div class="card-title">
        <h3>
          操作一覧
          <a href="/scenario_operation/{{$id}}/add/{{$this_id}}" class="btn btn-primary">操作追加</a>
        </h3>
      </div>
    </div>
    <div class="card-body">

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
  </div>
</div>
  @component('layouts.modal')
    @slot('modal_id','modal_script')
    @slot('modal_title','Script Json')
    @slot('modal_body')
      <pre>{{$item->make_json()}}</pre>
    @endslot
  @endcomponent
@endsection
