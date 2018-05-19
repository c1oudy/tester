@extends('layouts.admin')

@section('content')
    <section id="main-content">
        <section class="wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header"><i class="fa fa-table"></i> 考试管理</h3>
                    <ol class="breadcrumb">
                        <li><i class="fa fa-table"></i>考试管理</li>
                        <li><i class="fa fa-th-list"></i>考试列表</li>
                    </ol>
                </div>
            </div>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>考试名</th>
                    <th>总题数</th>
                    <th>专业题比例</th>
                    <th>考试时间</th>
                    <th>结束时间</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($exam as $val)
                        <tr>
                            <td>{{$val['id']}}</td>
                            <td>{{$val['title']}}</td>
                            <td>{{$val['total']}}</td>
                            <td>{{(sprintf("%.2f",$val['major']/$val['total']))*100}}%</td>
                            <td>{{$val['time']/60}}分钟</td>
                            <td>{{$val['last']}}</td>
                            <td><a href="{{route('dowmloadexcel')}}?id={{$val['id']}}"  data-id="{{$val['id']}}">下载成绩</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div style="text-align: center" id="test1"></div>
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
        function dowmloadexcel(obj){
            var url = '{{route('dowmloadexcel')}}'
            var id = $(obj).attr('data-id')
            $.post(url,{'_token': '{{ csrf_token() }}',id:id},function (v) {
                console.log(v)
            })
        }
    </script>
@endsection