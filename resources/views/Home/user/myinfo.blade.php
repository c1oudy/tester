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
        layui.use('form', function(){
            var form = layui.form;
            form.render();
            form.on('checkbox(collect)', function(data){
                var url = "{{route('changecollect')}}";
                var question = $('.question-list-active').attr('data-id')
                $.post(url,{'_token': '{{ csrf_token() }}','question':question},function (v) {
                    if(v == 1){
                        window.location.reload()
                    }
                });
            });
        });
        function choseanswer(obj) {
            $(obj).siblings().removeClass('chose-answer-active')
            $(obj).addClass('chose-answer-active');
            var chose = $(obj).attr('data-answer');
            var question_id=$('.question-list-active').attr('data-id')
            var url = '{{route('questionoperate')}}'
            $.post(url,{'_token': '{{ csrf_token() }}',question_id:question_id,operate:'getanswer'},function (v) {
                if(chose == v){
                }else{
                    $(obj).css('background','red')
                    $('.anweritem').each(function () {
                        if($(this).attr('data-answer')==v){
                            $(this).siblings().removeClass('chose-answer-active')
                            $(this).addClass('chose-answer-active');
                        }
                    })
                }
            });
        }
        function getquestion(obj) {
            var url = '{{route('getquestion')}}'
            var thisid = $(obj).attr('id')
            var id = ''
            if(thisid=='next-question'){
                id = $('.question-list-active').next().attr('data-id')
                if(!id){
                    layui.use('layer', function(){
                        var layer = layui.layer;
                        layer.msg('没有题了');
                    });
                    return false
                }
                $('.question-list-active').next().addClass('question-list-active')
                $('.question-list-active').eq(0).removeClass('question-list-active')
            }else if(thisid=='pre-question'){
                id = $('.question-list-active').prev().attr('data-id')
                if(!id){
                    layui.use('layer', function(){
                        var layer = layui.layer;
                        layer.msg('没有题了');
                    });
                    return false
                }
                $('.question-list-active').prev().addClass('question-list-active')
                $('.question-list-active').eq(1).removeClass('question-list-active')
            }else{
                $(obj).siblings().removeClass('question-list-active')
                $(obj).addClass('question-list-active');
                id = $(obj).attr('data-id')
            }

            $.post(url,{'_token': '{{ csrf_token() }}',id:id},function (data) {
                data=JSON.parse(data);
                $('#question h3').html(data.question.title)
                var answerHtml = ''
                var choseHtml = ''
                data.answer.forEach(function( val, index ) {
                    answerHtml+='<li style="font-size: 20px;">'+val.no+'.'+val.title+'</li>'
                    choseHtml+='<li data-answer="'+val.no+'" onclick="choseanswer(this)" class="anweritem">'+val.no+'</li>'
                });
                if(data.collect.length){
                    $("#collect").attr("checked","checked")
                }else{
                    $("#collect").removeAttr("checked")
                }
                layui.use('form', function() {
                    var form = layui.form;
                    form.render();
                });
                $('#answer ul').empty()
                $('#answer ul').append(answerHtml);
                $('#chose-answer').empty()
                $('#chose-answer').append(choseHtml);
            })
        }
    </script>
@endsection
