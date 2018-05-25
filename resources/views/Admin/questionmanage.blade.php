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
                        <th><button type="button" class="btn btn-primary btn-sm delete" data-id="{{$val['id']}}">删除</button><button type="button" onclick="openedit(this)" class="btn btn-primary btn-sm" data-toggle="modal" data-id="{{$val['id']}}" data-target=".addtype">编辑</button></th>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div style="text-align: center" id="test1"></div>
            <span><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target=".addquestion">上传试题</button></span>
            <span><a href="{{asset('file/excel/example.xls')}}">下载模板</a></span>
        </section>
    </section>

    <div class="modal fade addquestion" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <form action="{{route('uploadquestion')}}" method="post" enctype="multipart/form-data">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">添加试题</h4>
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
    <div class="modal fade addtype" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">修改试题</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>内容</label>
                        <input type="text" class="form-control" id="question" placeholder="name">
                    </div>
                    <div id="answerbox">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-primary btn-addtype">修改</button>
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
        function openedit(obj) {
            var id =$(obj).attr('data-id')
            var url = "{{route('editquestion')}}"
            $.post(url,{'_token': '{{ csrf_token() }}',id:id},function (data) {
                data=JSON.parse(data);
                $('#question').val(data.question.title)
                $('#question').attr('data-id',data.question.id)
                var html = ''
                $('#rightitem').val(data.question.right)
                $('#rightitem').attr('data-id',data.question.title)
                data.answer.forEach(function( val, index ) {
                    html+='<div class="form-group">\n' +
                        '                        <label>选项</label>\n' +
                        '                        <input type="text" class="form-control editanswer" data-id="'+val.id+'" placeholder="id" value="'+val.title+'">\n' +
                        '                    </div>'
                });
                $("#answerbox").empty()
                $("#answerbox").append(html)
            })
        }
        $('.btn-addtype').click(function () {
            var questionid = $('#question').attr('data-id')
            var title = $('#question').val();
            var right = $('#rightitem').val();
            var answer = [];
            $('.editanswer').each(function () {
                var index = $(this).attr('data-id')
                answer[index] = $(this).val()
            })
            var url = "{{route('editquestion')}}"
            $.post(url, {
                '_token': '{{ csrf_token() }}',
                questionid: questionid,
                title: title,
                right: right,
                answer: answer,
                type:'edit'
            }, function (data) {
               if(1){
                   window.location.href = '{{route('questionmanage')}}'
               }
            })
        })
        $('.delete').click(function () {
            var id = $(this).attr('data-id')
            var url = "{{route('editquestion')}}"
            $.post(url,{'_token': '{{ csrf_token() }}',id:id,type:'delete'},function (data) {
                window.location.href = '{{route('questionmanage')}}'
            })
        })
    </script>
@endsection