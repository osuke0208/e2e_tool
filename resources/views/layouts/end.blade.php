@section('end')
<script src="{{asset('/js/lib/utf.js')}}"></script>
<script src="{{asset('/js/lib/base64.js')}}"></script>
<script src="{{asset('/js/lib/inflate.js')}}"></script>
<script src="{{asset('/js/lib/deflate.js')}}"></script>
<script src="{{asset('/js/lib/timsort.js')}}"></script>
<script src="{{asset('/js/base/util.js?v=3')}}"></script>
<script src="{{asset('/js/base/fileUI.js')}}"></script>
<script src="{{asset('/js/base/dom.js?v=1')}}"></script>
<script src="{{asset('/js/base/service.js?v=5')}}"></script>
<script src="{{asset('/js/base/front.js')}}"></script>
<script src="{{asset('/js/base/base.js?v=6')}}"></script>
</body>

<script type="text/javascript">
//インプットボックスの動的表示切替
  $(document).on("click",".add",function(){
    $(this).parent().clone(true).insertAfter($(this).parent());
  });
  $(document).on("click", ".del", function() {
  var target = $(this).parent();
  if (target.parent().children().length > 1) {
      target.remove();
  }
});
//ダイアログページの表示
$("a[page_url][page_title][page_form=dialog]").on("click", function(e){
  console.log($(this).attr('page_title'));
  base.showPage("dialog", "subDialog", $(this).attr("page_title"), $(this).attr("page_url"));
});
</script>

</html>
@endsection
