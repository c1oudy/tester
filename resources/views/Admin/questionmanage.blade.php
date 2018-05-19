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
                    <th>内容</th>
                    <th>正确答案</th>
                    <th>分类</th>
                    {{--<th>难度</th>--}}
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($question as $val)
                    <p style="display: none">{{$id = $val['id']}}</p>
                    <tr class="question_item question_item{{$val['id']}}" data-class="question_item{{$val['id']}}" data-answer="{{$answer["$id"]}}">
                        <th>{{$val['id']}}</th>
                        <th>{{$val['title']}}</th>
                        <th>{{$val['right']}}</th>
                        <th>{{$val['type_id']}}</th>
                        {{--<th>{{$val['dif_id']}}</th>--}}
                        <th><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-id="{{$val['id']}}" data-target=".addtype">编辑</button></th>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div style="text-align: center" id="test1"></div>
            <span><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target=".excelbox">上传试题</button></span>
            <span><a href="{{asset('file/excel/example.xls')}}">下载模板</a></span>
        </section>
    </section>

    <div class="modal fade addtype" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">编辑试题</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>问题</label>
                        <input type="text" class="form-control" id="classname" placeholder="name">
                    </div>
                    <div class="form-group">
                        <label>选项</label>
                        <input type="text" class="form-control" id="classid" placeholder="id">
                    </div>
                    <div class="form-group">
                        <label>选项</label>
                        <input type="text" class="form-control" id="classid" placeholder="id">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-primary btn-addtype">添加</button>
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
        layui.use('laypage', function(){
            var layer = layui.layer;
            var laypage = layui.laypage;
            //执行一个laypage实例
            laypage.render({
                elem: 'test1'
                ,count: {{$count}}
                ,limit: 10
                ,curr: {{isset($_GET['page'])?$_GET['page']:1}}
                ,jump: function(obj, first) {
                    if (!first) {
                        window.location.href = "{{route('questionmanage')}}"+'?page='+obj.curr
                    }
                }
            });
        });
        $('.question_item').hover(function () {
            var index = '.'+$(this).attr('data-class')
            var data = $(this).attr('data-answer');
            layui.use(['layer', 'form'], function() {
                var layer = layui.layer
                layer.tips(data, index, {
                    tips: [1, '#0FA6D8'] //还可配置颜色
                });
            })
        })
        $('.addtype').on('show.bs.modal', function (e) {
            var id =$(this).attr('data-id')
            console.log($(this))
        })
    </script>
@endsection