@extends('admin.layouts.app')
@section('pageHeader')
缓存
@stop
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="box box-primary">
            <div class="box-header with-border">&nbsp;</div>
            <div class="box-body">
                 <button class="btn btn-danger" id="clear-all-cache">清除所有缓存</button>
            </div>
            <div class="box-footer">&nbsp;</div>
        </div>
    </div>
</div>
@stop
@section('script')
    <script>
        $('#clear-all-cache').on('click',function () {
            var _item = $(this);
            $.ajax({
                url:'{{ route('option.clearcache') }}',
                type:'post',
                dataType: 'html',
                data:'',
                headers : {
                    'X-CSRF-TOKEN':'{{ csrf_token() }}',
                },
                beforeSend : function(){
                    _item.attr('disabled','true');
                },
                success:function (data) {
                    alert(data);
                }
            }).fail(function(response) {

            }).always(function () {
                _item.removeAttr('disabled');
            });
        })
    </script>
@stop
