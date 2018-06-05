@extends('layouts.admin')

@section('content')
    <section id="main-content">
        <section class="wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header"><i class="fa fa-table"></i> 用户管理</h3>
                    <ol class="breadcrumb">
                        <li><i class="fa fa-table"></i>用户管理</li>
                        <li><i class="fa fa-th-list"></i>用户审核</li>
                    </ol>
                </div>
            </div>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>姓名</th>
                    <th>学号</th>
                    <th>邮箱</th>
                    <th>班级</th>
                    <th>审核状态</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($user as $item)
                    <tr>
                        <td>{{$item['id']}}</td>
                        <td>{{$item['name']}}</td>
                        <td>{{$item['stuid']}}</td>
                        <td>{{$item['email']}}</td>
                        <td>
                            <p style="display: none">{{$id=$item['class_id']}}</p>
                            {{$class["$id"]['tid']}}
                        </td>
                        <td>@if($item['statu']==0)未提交审核 @elseif($item['statu']==1)待审核@elseif($item['statu']==2)已通过@elseif($item['statu']==3)未通过@endif</td>
                        <td style="padding: 0px">
                             @if($item['statu']==1)
                            <div class="layui-btn-group">
                                <button type="button" data-id="{{$item['id']}}" class="layui-btn layui-btn-normal layui-btn-sm pass">通过</button>
                                <button type="button" data-id="{{$item['id']}}" class="layui-btn layui-btn-danger layui-btn-sm unpass">拒绝</button>
                            </div>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div style="text-align: center" id="test1"></div>
            <span><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target=".excelbox">上传用户</button></span>
            <span><a href="{{asset('file/excel/example.xls')}}">下载模板</a></span>
        </section>
    </section>

    <div class="modal fade excelbox" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <form action="{{route('uploaduser')}}" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">添加用户</h4>
                </div>
                <div class="modal-body">
                    {{ csrf_field() }}
                    <input type="file" name="excel">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="submit" class="btn btn-primary btn-addclass">添加</button>
                </div>
                </form>
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
        layui.use('laypage', function(){
            var laypage = layui.laypage;
            //执行一个laypage实例
            laypage.render({
                elem: 'test1'
                ,count: {{$count}}
                ,limit: 10
                ,curr: {{isset($_GET['page'])?$_GET['page']:1}}
                ,jump: function(obj, first) {
                    if (!first) {
                        @if(isset($_GET['class']))
                            window.location.href = "{{route('userlist')}}"+'?class={{$_GET['class']}}&page='+obj.curr
                        @else
                            window.location.href = "{{route('userlist')}}"+'?page='+obj.curr
                        @endif
                    }
                }
            });
        });
        $('.pass').click(function () {
            var id = $(this ).attr('data-id');
            var url = "{{route('homeuseroperate')}}";
            $.post(url,{'_token': '{{ csrf_token() }}',uid:id,operate:'pass'},function (v) {
                window.location.reload();
            });
        })
        $('.unpass').click(function () {
            var id = $(this ).attr('data-id');
            var url = "{{route('homeuseroperate')}}";
            $.post(url,{'_token': '{{ csrf_token() }}',uid:id,operate:'unpass'},function (v) {
                // window.location.reload();
            });
        })
    </script>
@endsection