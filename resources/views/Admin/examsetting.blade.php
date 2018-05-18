@extends('layouts.admin')

@section('content')
    <section id="main-content">
        <section class="wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header"><i class="fa fa-table"></i>考试管理</h3>
                    <ol class="breadcrumb">
                        <li><i class="fa fa-table"></i>考试管理</li>
                        <li><i class="fa fa-th-list"></i>考试发布</li>
                    </ol>
                </div>
            </div>
            <form class="layui-form" action="{{'addexam'}}">
                <div class="layui-form-item">
                    <label class="layui-form-label" style="width: 137px;text-align: left;">考试名</label>
                    <div class="layui-input-block">
                        <input type="text" name="title" id="title" required  lay-verify="required" placeholder="请输入考试名" autocomplete="off" class="layui-input" style="width: 200px">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label" style="width: 137px;text-align: left;">总题数</label>
                    <div class="layui-input-block">
                        <input type="text" name="total" id="total" required  lay-verify="required|number" placeholder="总题数" autocomplete="off" class="layui-input" style="width: 200px">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label" style="width: 137px;text-align: left;">专业题数量</label>
                    <div class="layui-input-block">
                        <input type="text" name="major" id="major" required  lay-verify="required|number" placeholder="专业题数量" autocomplete="off" class="layui-input" style="width: 200px">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label" style="width: 137px;text-align: left;">答题时间(分钟)</label>
                    <div class="layui-input-block">
                        <input type="text" name="time" id="time" required  lay-verify="required|number" placeholder="答题时间" autocomplete="off" class="layui-input" style="width: 200px">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label" style="width: 137px;text-align: left;">最晚完成时间</label>
                    <div class="layui-input-block">
                        <input type="text" class="layui-input" id="last"  style="width: 200px">
                        <input type="hidden" name="last" id="lasthd">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label" style="width: 137px;text-align: left;">考试单位</label>
                    <div class="layui-input-block">
                        @foreach($class as $val)
                        <input type="checkbox" lay-filter="class" name="class[{{$val['id']}}]" title="{{$val['name']}}">
                        @endforeach
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
                        <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                    </div>
                </div>
            </form>

            <script>
                //Demo
                layui.use('form', function(){
                    var form = layui.form;
                    //监听提交
                    form.on('checkbox(class)', function(data){
                        console.log(data.elem); //得到checkbox原始DOM对象
                        console.log(data.elem.checked); //是否被选中，true或者false
                        console.log(data.value); //复选框value值，也可以通过data.elem.value得到
                        console.log(data.othis); //得到美化后的DOM对象
                    });
                });
                layui.use('laydate', function(){
                    var laydate = layui.laydate;
                    //执行一个laydate实例
                    laydate.render({
                        elem: '#last' //指定元素
                        ,done: function(value, date, endDate){
                            $('#lasthd').val(value)
                        }
                    });
                });
            </script>
        </section>
    </section>

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
        $('#major').blur(function () {
            if(parseInt($(this).val())>parseInt($('#total').val())){
                $(this).val('');
                layui.use(['layer', 'form'], function(){
                    var layer = layui.layer
                        ,form = layui.form;
                    layer.msg('专业题数量应小于总数量')
                });
            }
        })
        $('#title').blur(function () {
            var url = '{{route('checktitle')}}'
            var title = $(this).val()
            $.post(url,{'_token': '{{ csrf_token() }}','title':title},function (data) {
                if(data == 0){
                    $('#title').val('');
                    layui.use(['layer', 'form'], function(){
                        var layer = layui.layer
                            ,form = layui.form;
                        layer.msg('该标题已存在')
                    });
                }
            })
        })
    </script>
@endsection