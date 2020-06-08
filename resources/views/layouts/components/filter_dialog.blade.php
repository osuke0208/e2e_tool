<div class="modal fade" id="filter_form" role="dialog" aria-labelledby="modal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
          <i class="fa fa-times"></i>
        </button>
        <h4 class="modal-title content-sub-title">フィルター</h4>
      </div>
      <div class="modal-body content-sub-body">
        <form class="filter" method="GET" action="{{request()->fullUrl()}}">
          <div class="row p-2" id="filter_form_item">
            {{$search_form}}
          </div>
          <div class="col-12 mt-2 text-right">
              <button type="button" class="btn btn-submit btn-info mr-2"  accesskey="filter_search">
                <i class="fa fa-search mr-1"></i>
                  フィルター
              </button>
              <button type="reset" class="btn btn-secondary" accesskey="filter_search">
                {{__('labels.clear')}}
              </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>



<script>
$(function(){
  base.pageSettinged('filter_form', null);
  $("a.page-link[accesskey='pager']").on('click', function(){
    var page = $(this).attr("page");
    $("input[name=_page]").val(page);
    //subDialog側にformが残っているとsubmitされる対策
    $("#subDialog .modal-dialog").remove();
    $("#filter_form form.filter").submit();
  });
  $("button[accesskey='filter_search'][type=button]").on('click', function(e){
    $("input[name=_page]").val("1");
    //subDialog側にformが残っているとsubmitされる対策
    $("#subDialog .modal-dialog").remove();
    $("#filter_form form.filter").submit();
  });
  $("button[accesskey='filter_search'][type=reset]").on('click', function(e){
    e.preventDefault();
    $("#filter_form form select option").attr('selected', false);
    front.clearFormValue('filter_form');
    $("input[name=_page]").val("1");
  });
});
</script>
