@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default" style="height: 300px">
                    <div class="panel-heading">我的信息</div>
                    <form class="layui-form" action="{{'addexam'}}" style="margin-top: 40px">
                        <div class="layui-form-item">
                            <label class="layui-form-label" style="width: 137px;text-align: left;">学号</label>
                            <div class="layui-input-block">
                                <input type="text" name="stuid" value="@if($stu_id) {{$stu_id}}@endif" id="stuid" placeholder="暂未添加学号" @if($stu_id) disabled="disabled" {{$stu_id}}@endif autocomplete="off" class="layui-input" style="width: 200px">
                                <button type="button"  class="btn btn-primary btn-sm editstuid" style="margin-top: 10px">编辑</button>
                                <button type="button"  class="btn btn-primary btn-sm savestuid" style="display: none; margin-top: 10px">保存</button>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label" style="width: 137px;text-align: left;">班级</label>
                            <div class="layui-input-block">
                                <lable style="display: inline-block;line-height: 39px;">@if($class) {{$class}} @else 暂未添加班级信息 @endif</lable>
                            </div>
                        </div>
                    </form>
                    <div class="panel-body">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
            $('.editstuid').click(function () {
                $(this).hide()
                $('.savestuid').show()
                $('#stuid').attr("disabled",false);
            })
            $('.savestuid').click(function () {
                var url = "{{route('stuidoperate')}}";
                var stuid = $('#stuid').val()
                var that = $(this)
                $.post(url,{'_token': '{{ csrf_token() }}',stuid:stuid,operate:'edit'},function (data) {
                    if(data == 2){
                        layui.use('layer', function(){
                            var layer = layui.layer;
                            layer.msg('学号已存在');
                        });
                    }
                    if(data == 1){
                        layui.use('layer', function(){
                            var layer = layui.layer;
                            layer.msg('修改成功');
                            $('#stuid').attr("disabled",true);
                            that.hide()
                            $('.editstuid').show()
                        });
                    }
                });
            })
    </script>
@endsection
