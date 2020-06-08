
  <a class="btn btn-default btn-sm" data-toggle="modal" data-target="#filter_form" id="filter_button">
    <i class="fa fa-filter"></i>
  </a>
  @component('layouts.components.filter_dialog', )
    @slot('search_form')
    <div class="col-12 mb-2">
        <label for="search_word" class="w-100">
          {{__('labels.search_keyword')}}
        </label>
        <input type="text" name="search_word" class="form-control" placeholder="" inputtype=""
        @isset($filter['search_keyword'])
        value = "{{$filter['search_keyword']}}"
        @endisset
        >
    </div>
    <div class="col-12">
      <label for="search_status" class="w-100">
        ステータス
      </label>
      <div class="row">
        <div class="col-sm-12 col-md-2">
        <input class="frm-check-input icheck flat-green" type="checkbox" name="search_status[]" id="stars" value="hoge">
        <label class="form-check-label">hoge</label>
        </div>
      </div>
    </div>
    @endslot
  @endcomponent
