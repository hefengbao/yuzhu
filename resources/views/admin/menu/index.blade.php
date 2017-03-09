@extends('admin.layouts.app')
@section('pageHeader')
菜单
@stop
@section('css')
    <style>
        /**
 * Nestable
 */
        .dd-list { display: block; position: relative; margin: 0; padding: 0; list-style: none; }
        .dd-list .dd-list { padding-left: 30px; }
        .dd-collapsed .dd-list { display: none; }

        .dd-item,
        .dd-empty,
        .dd-placeholder { display: block; position: relative; margin: 0; padding: 0; min-height: 20px; font-size: 13px; line-height: 20px; }

        .dd-handle { display: block; height: 30px; margin: 5px 0; cursor: move; padding: 5px 10px; color: #333; text-decoration: none; font-weight: 400; border: 1px solid #ccc;
            background: #fafafa;
            -webkit-border-radius: 3px;
            border-radius: 3px;
            box-sizing: border-box; -moz-box-sizing: border-box;
        }
        .dd-handle:hover { color: #2ea8e5; background: #fff; }

        .dd-item > button { display: block; position: relative; cursor: pointer; float: left; width: 25px; height: 20px; margin: 7px 0; padding: 0; text-indent: 100%; white-space: nowrap; overflow: hidden; border: 0; background: transparent; font-size: 10px; line-height: 1; text-align: center; font-weight: bold; }
        .dd-item > button:before { content: '\f067'; display: block; position: absolute; width: 100%; text-align: center; text-indent: 0; font-family: 'FontAwesome' }
        .dd-item > button[data-action="collapse"]:before { content: '\f068';  }

        .dd-placeholder,
        .dd-empty {
            margin: 5px 0; padding: 0; min-height: 30px; background: #f2fbff; border: 1px dashed #b6bcbf;
            box-sizing: border-box; -moz-box-sizing: border-box; }
        .dd-empty { border: 1px dashed #bbb; min-height: 100px; background-color: #e5e5e5;
            background-size: 60px 60px;
            background-position: 0 0, 30px 30px;
        }

        .dd-dragel { position: absolute; pointer-events: none; z-index: 9999; }
        .dd-dragel > .dd-item .dd-handle { margin-top: 0; }
        .dd-dragel .dd-handle {
            -webkit-box-shadow: 2px 4px 6px 0 rgba(0,0,0,.1);
            box-shadow: 2px 4px 6px 0 rgba(0,0,0,.1);
        }

        .dd-hover > .dd-handle { background: #2ea8e5 !important; }

        /**
         * Nestable Draggable Handles
         */

        .dd3-content { display: block; height: 30px; margin: 5px 0; padding: 5px 10px 5px 40px; color: #333; text-decoration: none; font-weight: 400; border: 1px solid #e7eaec;
            background: #f5f5f5;
            -webkit-border-radius: 3px;
            border-radius: 3px;
            box-sizing: border-box; -moz-box-sizing: border-box;
        }
        .dd3-content:hover { color: #2ea8e5; background: #f0f0f0; font-weight: bold}

        .dd-dragel > .dd3-item > .dd3-content { margin: 0; }

        .dd3-item > button { margin-left: 30px !important; }

        .dd3-handle { position: absolute; margin: 0 !important; left: 0; top: 0; cursor:move; width: 30px; text-indent: 100%; white-space: nowrap; overflow: hidden;
            border: 1px solid #aaa;
            background: #ddd;
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
            padding: 10px;
        }
        .dd3-handle:before { content: '='; display: block; position: absolute; left: 0; top: 3px; width: 100%; text-align: center; text-indent: 0; color: #23c6c8; font-size: 20px; font-weight: normal; }
        .dd3-handle:hover { background: #ddd; }
    </style>
@stop
@section('content')
<div class="row">
    <div class="col-md-5">
        <div class="box box-warning">
               <div class="box-header with-border">编辑菜单</div>
               <div class="box-body">
                   <div class="box-group" id="accordion">
                       <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                       <div class="panel box box-primary">
                           <div class="box-header with-border">
                               <h4 class="box-title">
                                   <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" class="">
                                       分类目录
                                   </a>
                               </h4>
                           </div>
                           <div id="collapseOne" class="panel-collapse collapse  in" aria-expanded="true">
                               <div class="box-body">
                                   <ul class="list-unstyled" id="category_list">
                                       @foreach($categories as $category)
                                           <li><input type="checkbox" value="category_{{ $category->id }}" name="categories"> <span>{{ $category->category_name }}</span></li>
                                       @endforeach
                                   </ul>
                               </div>
                               <div class="box-footer">
                                   <button class="btn btn-primary" id="btn-category">添加到菜单</button>
                               </div>
                           </div>
                       </div>
                       <div class="panel box box-danger">
                           <div class="box-header with-border">
                               <h4 class="box-title">
                                   <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" class="collapsed" aria-expanded="false">
                                       页面
                                   </a>
                               </h4>
                           </div>
                           <div id="collapseTwo" class="panel-collapse collapse" aria-expanded="false">
                               <div class="box-body">
                                   <ul class="list-unstyled" id="page_list">
                                       @foreach($pages as $page)
                                       <li><input type="checkbox" value="page_{{ $page->id }}" name="pages"> <span>{{ $page->post_title }}</span></li>
                                       @endforeach
                                   </ul>
                               </div>
                               <div class="box-footer">
                                   <div class="box-footer">
                                       <button class="btn btn-primary" id="btn-page">添加到菜单</button>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="box box-danger">
            <div class="box-header with-border">主菜单</div>
            <div class="box-body">
                <div class="dd" id="nestable">
                    <ol class="dd-list">
                         {!! $menu !!}
                    </ol>
                </div>
            </div>
            <div class="box-footer">
                {!! csrf_field() !!}
                <button class="btn btn-primary" id="btn-save">保存</button>
            </div>
        </div>
    </div>
</div>
@stop
@section('script')
    <script src="{{ asset('js/jquery.nestable.js') }}"></script>
    <script>
        $(document).ready(function(){
            $('#nestable').nestable({
                maxDepth:2,
            });

            $('#btn-category').on('click',function () {
                $("#category_list li input[type=checkbox]").each(function () {
                    if (this.checked){
                        var html = '<li class="dd-item dd3-item" data-id="'+$(this).val()+'">'+
                                '<div class="dd-handle dd3-handle"></div><div class="dd3-content"><span>'+$(this).next('span').text()+'</span><span class="pull-right">' +
                                '<a href="javascript:;" class="delete">x</a></span></div> </li>';
                        $('#nestable > .dd-list').append(html);
                    }
                });
            });
            $('#btn-page').on('click',function () {
                $("#page_list li input[type=checkbox]").each(function () {
                    if (this.checked){
                        var html = '<li class="dd-item dd3-item" data-id="'+$(this).val()+'">'+
                                '<div class="dd-handle dd3-handle"></div><div class="dd3-content"><span>'+$(this).next('span').text()+'</span><span class="pull-right">' +
                                '<a href="#" class="delete">x</a></span></div> </li>';
                        $('#nestable > .dd-list').append(html);
                    }
                });
            });

            $("ol.dd-list").on('click','a.delete',function () {
                $(this).parents('.dd-item').remove();
            });

            $('#btn-save').on('click',function () {
                var list = window.JSON.stringify($('#nestable').nestable('serialize'));
                var _item = $(this);
                $.ajax({
                    url:'{{ route('option.menu') }}',
                    type:'post',
                    dataType: 'html',
                    data:'mainmenu='+list,
                    headers : {
                        'X-CSRF-TOKEN': $("input[name='_token']").val()
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
            });
        });
    </script>
@stop
