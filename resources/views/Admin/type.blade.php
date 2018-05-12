@extends('layouts.admin')
@section('content')
<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header"><i class="fa fa-table"></i> 试题管理</h3>
                <ol class="breadcrumb">
                    <li><i class="fa fa-table"></i>试题管理</li>
                    <li><i class="fa fa-th-list"></i>分类管理</li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-7">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target=".addtype">+</button></th>
                        <th>分类名</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($type as $item)
                        <tr>
                            <td>{{$item['id']}}</td>
                            <td class="name-box">
                                <div class="form-group">
                                    <input type="text" disabled="disabled" value="{{$item['name']}}" class="form-control" placeholder="Password">
                                </div>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" data-id="{{$item['id']}}" class="btn btn-primary btn-sm edittype">编辑</button>
                                    <button type="button" data-id="{{$item['id']}}" class="btn btn-primary btn-sm submittype">提交</button>
                                    <button type="button" data-id="{{$item['id']}}" class="btn btn-primary btn-sm deletetype">删除</button>
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

<div class="modal fade addtype" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">添加分类</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">分类名称</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="typename" placeholder="name">
                    </div>
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

<!-- javascripts -->
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
<script>
    //knob
    $('.btn-addtype').click(function () {
        var name = $('#typename').val();
        var url = "{{route('addtype')}}";
        $.post(url,{'_token': '{{ csrf_token() }}',operate:'add',name:name},function (data) {
            window.location.reload()
        });
    })
    $('.deletetype').click(function () {
        var url = "{{route('addtype')}}";
        $.post(url,{'_token': '{{ csrf_token() }}',typeid:$(this).attr('data-id'),operate:'delete'},function (data) {
            window.location.reload()
        });
    })
    $('.edittype').click(function () {
        $(this).parent().parent().siblings('.name-box').children().children().attr('disabled',false);
        $(this).hide();
        $(this).siblings('.submittype').show();
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
    $(function() {
        $(".knob").knob({
            'draw' : function () {
                $(this.i).val(this.cv + '%')
            }
        })
    });

    //carousel
    $(document).ready(function() {
        $("#owl-slider").owlCarousel({
            navigation : true,
            slideSpeed : 300,
            paginationSpeed : 400,
            singleItem : true

        });
    });

    //custom select box

    $(function(){
        $('select.styled').customSelect();
    });

    /* ---------- Map ---------- */
    $(function(){
        $('#map').vectorMap({
            map: 'world_mill_en',
            series: {
                regions: [{
                    values: gdpData,
                    scale: ['#000', '#000'],
                    normalizeFunction: 'polynomial'
                }]
            },
            backgroundColor: '#eef3f7',
            onLabelShow: function(e, el, code){
                el.html(el.html()+' (GDP - '+gdpData[code]+')');
            }
        });
    });
</script>
@endsection