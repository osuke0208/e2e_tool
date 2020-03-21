@section('end')
<script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>
<script src="{{asset('vendor/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<script src="{{asset('/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('/vendor/adminlte/dist/js/adminlte.min.js')}}"></script>

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
</script>

</html>
@endsection
