
<div class="card">
  <div class="card-header">
    <div class="row">
      <div class="col-12">
        <h3 class="card-title">
          <i class="fa fa-list-alt mr-1"></i>{{$title}}
        </h3>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="float-right">
        @component('layouts.components.list_buttons',$list_buttons_param)
        @endcomponent
        </div>
      </div>
    </div>

    <div class="card-tools">
      <div class="row">
        @if($card_tool_param['_pager'])
        <div class="col-9">
          {{$items->appends(Request::query())->links('layouts.components.paginate')}}
        </div>
        @endif
        @if($card_tool_param['_filter'])
        <div class="col-3">
          @include('layouts.components.filter')
        </div>
        @endif
      </div>
    </div>
  </div>
  <div class="card-body p-0">
    <form method="POST" action="/{{$domain}}/">
    @if(count($items)> 0)
      <ul class="products-list product-list-in-card pl-2 pr-2">
        @foreach($items as $item)
        <li class="item">
          <div class="row">
            <div class="col-12">
              <div class="row">
                <div class="col-12 col-md-4 text-truncate">
                  @if($_checkbox)
                  <input type="checkbox" name="{{$domain}}_ids[]" value="{{$item->id}}" >
                  @endif
                  <a href="javascript:void(0)" title="{{$item->name}}" page_form="dialog" page_title="{{$item->name}}" page_url="/{{$domain}}/{{$item->id}}/detail" role="button">
                    {{$item->name}}
                  </a>
                </div>
                <div class="col-12 col-md-4 text-truncate">
                  <small class="text-muted">
                    {{$item->description}}
                  </small>
                </div>
                <div id="buttons_area" class="col-12 col-md-4">
                  @component('layouts.components.item_buttons',[
                    'item' => $item,
                    'domain' => $domain,
                    'item_buttons_param' => $item_buttons_param,
                  ])
                  @endcomponent
                </div>
              </div>
            </div>
          </div>
          <div class="col-12">
            <small class="text-muted float-right">
              <i class="fa fa-clock"></i>
              {{$item->created_at}}
            </small>
          </div>
        </li>
        @endforeach
      </ul>
    </form>
    @else
    <div class="alert">
      <h4><i class="icon fa fa-exclamation-triangle"></i>データがありません</h4>
    </div>
    @endif
  </div>
</div>
