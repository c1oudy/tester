@extends('layouts.admin')

@section('content')
<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header"><i class="fa fa-table"></i> 用户管理</h3>
                <ol class="breadcrumb">
                    <li><i class="fa fa-table"></i>用户管理</li>
                    <li><i class="fa fa-th-list"></i>学院列表</li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-7">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target=".addclass">+</button></th>
                        <th>学院名</th>
                        <th>班级编号</th>
                        <th>是否启用</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($class as $item)
                        <tr>
                            <td>{{$item['id']}}</td>
                            <td class="name-box">
                                <div class="form-group">
                                    <input type="text" disabled="disabled" value="{{$item['name']}}" class="form-control" placeholder="Password">
                                </div>
                            </td>
                            <td>{{$item['tid']}}</td>
                            <td>
                                <div class="layui-form">
                                    <input type="checkbox" data-id="{{$item['tid']}}"  lay-filter="statuCB" value="{{$item['id']}}" id="statuCB" name="statuCB" title="启用" @if($item['statu']) checked @endif>
                                </div>
                            </td>
                            <td>
                                <div class="btn-group">
                                    {{--<button type="button" data-id="{{$item['id']}}" class="btn btn-primary btn-sm deleteclass">删除</button>--}}
                                    <button type="button" data-id="{{$item['id']}}" class="btn btn-primary btn-sm userclass">查看</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</section>

<div class="modal fade addclass" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">添加班级</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>班级名</label>
                    <input type="text" class="form-control" id="classname" placeholder="name">
                </div>
                <div class="form-group">
                    <label>编号</label>
                    <input type="text" class="form-control" id="classid" placeholder="id">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-primary btn-addclass">添加</button>
            </div>
        </div>
    </div>
</div>

<!--main content end-->
</section>
<!-- container section start -->
<script src="{{ asset('adminfile/js/jquery.js') }}"></script>
<script src="{{ asset('adminfile/js/jquery-ui-1.10.4.min.js') }}"></script>
<script src="{{ asset('adminfile/js/jquery-1.8.3.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('adminfile/js/jquery-ui-1.9.2.custom.min.js') }}"></script>
<!-- bootstrap -->
<script src="{{ asset('adminfile/js/bootstrap.min.js') }}"></script>
<!-- nice scroll -->
<script src="{{ asset('adminfile/js/jquery.scrollTo.min.js') }}"></script>
<script src="{{ asset('adminfile/js/jquery.nicescroll.js') }}" type="text/javascript"></script>
<!-- charts scripts -->
<script src="{{ asset('adminfile/assets/jquery-knob/js/jquery.knob.js') }}"></script>
<script src="{{ asset('adminfile/js/jquery.sparkline.js') }}" type="text/javascript"></script>
<script src="{{ asset('adminfile/assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js') }}"></script>
<script src="{{ asset('adminfile/js/owl.carousel.js') }}" ></script>
<!-- jQuery full calendar -->
<script src="{{ asset('adminfile/js/fullcalendar.min.js') }}"></script> <!-- Full Google Calendar - Calendar -->
<script src="{{ asset('adminfile/assets/fullcalendar/fullcalendar/fullcalendar.js') }}"></script>
<!--script for this page only-->
<script src="{{ asset('adminfile/js/calendar-custom.js') }}"></script>
<script src="{{ asset('adminfile/js/jquery.rateit.min.js') }}"></script>
<!-- custom select -->
<script src="{{ asset('adminfile/js/jquery.customSelect.min.js') }}" ></script>
<script src="{{ asset('adminfile/assets/chart-master/Chart.js') }}"></script>

<!--custome script for all page-->
<script src="{{ asset('adminfile/js/scripts.js') }}"></script>
<!-- custom script for this page-->
<script src="{{ asset('adminfile/js/sparkline-chart.js') }}"></script>
<script src="{{ asset('adminfile/js/easy-pie-chart.js') }}"></script>
<script src="{{ asset('adminfile/js/jquery-jvectormap-1.2.2.min.js') }}"></script>
<script src="{{ asset('adminfile/js/jquery-jvectormap-world-mill-en.js') }}"></script>
<script src="{{ asset('adminfile/js/xcharts.min.js') }}"></script>
<script src="{{ asset('adminfile/js/jquery.autosize.min.js') }}"></script>
<script src="{{ asset('adminfile/js/jquery.placeholder.min.js') }}"></script>
<script src="{{ asset('adminfile/js/gdp-data.js') }}"></script>
<script src="{{ asset('adminfile/js/morris.min.js') }}"></script>
<script src="{{ asset('adminfile/js/sparklines.js') }}"></script>
<script src="{{ asset('adminfile/js/charts.js') }}"></script>
<script src="{{ asset('adminfile/js/jquery.slimscroll.min.js') }}"></script>
<!-- javascripts -->

<script>
    //knob
    layui.use('layer', function(){
        var layer = layui.layer;
    });
    layui.use('form', function(){
        var form = layui.form;
        form.render();
        form.on('checkbox(statuCB)', function(data){
            var url = "{{route('editclass')}}";
            var id = data.value;
            $.post(url,{'_token': '{{ csrf_token() }}',classid:id,operate:'editstatu'},function (v) {
                if(v == 1){
                    layer.msg('修改成功');
                }
            });
        });
    });
    $('.btn-addclass').click(function () {
        var name = $('#classname').val();
        var id = $('#classid').val();
        var url = "{{route('editclass')}}";
        $.post(url,{'_token': '{{ csrf_token() }}',operate:'add',id:id,name:name},function (data) {
            window.location.reload()
        });
    })
    $('.deleteclass').click(function () {
        var url = "{{route('editclass')}}";
        $.post(url,{'_token': '{{ csrf_token() }}',classid:$(this).attr('data-id'),operate:'delete'},function (data) {
            window.location.reload()
        });
    })
    $('.userclass').click(function () {
        var id = $(this).attr('data-id')
        window.location.href = '{{route('userlist')}}'+'?class='+id
    });
    $('.submittype').click(function () {
        $(this).hide();
        $(this).siblings('.edittype').show();
        var url = "{{route('addtype')}}";
        $(this).parent().parent().siblings('.name-box').children().children().attr('disabled',"disabled");
        var name = $(this).parent().parent().siblings('.name-box').children().children().val();
        $.post(url,{'_token': '{{ csrf_token() }}',typeid:$(this).attr('data-id'),operate:'edit',name:name},function (data) {
            layui.use('layer', function(){
                var layer = layui.layer;
                layer.msg('修改成功');
            });
        });
    });
</script>
@endsection