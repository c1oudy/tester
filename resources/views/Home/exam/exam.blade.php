@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">考试</div>

                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div id="question">
                            <h3>@if($question['qid']==0)(单选题)@elseif($question['qid']==1)<input type="hidden" value="1" class="ismulty">(多选题)@elseif($question['qid']==2)(判断题)@endif{{$question['title']}}</h3>
                            <div id="answer">
                                <ul>
                                    @for($i=0;$i<count($answer);$i++)
                                        <li>{{$answer["$i"]['no']}}.{{$answer["$i"]['title']}}</li>
                                    @endfor
                                </ul>
                            </div>

                            <div id="chose-answer">
                                @foreach($answer as $val)
                                    <li data-answer="{{$val['no']}}" onclick="choseanswer(this)" class="anweritem @if($question['qid']==1) multyquestion @endif @if(isset($right1) && isset($chose1) && !(strpos($right1,$val['no'])!==false)  && (strpos($chose1, $val['no']) !== false))wrong @endif @if(isset($right1) && isset($chose1) && (strpos($right1,$val['no'])!==false)) chose-answer-active @endif">{{$val['no']}}</li>
                                @endforeach
                            </div>
                            {{--<div id="img-box">--}}
                            {{--<img class="question-img" src="{{ asset('image/timg.jpg') }}" alt="">--}}
                            {{--</div>--}}
                        </div>
                            @if($pass == 0)
                                <div id="left-time">
                                    <p><strong>剩余时间</strong></p>
                                    <strong id="hour_show">0时</strong>
                                    <strong id="minute_show">0分</strong>
                                    <strong id="second_show">0秒</strong>
                                </div>
                            @endif
                        <div id="question-list">
                            <ul>
                                @for ($i = 0; $i < count($questionid); $i++)
                                    <li onclick="getquestion(this)" data-chose="@if(isset($chose["$i"])){{$chose["$i"]}}@endif" data-id="{{$questionid[$i]}}" class="@if(isset($right["$i"]) && isset($chose["$i"]) && $right["$i"]!=$chose["$i"])wrong @endif @if($curid==$questionid[$i])question-list-active @endif ">{{($i+1)}}</li>
                                @endfor
                            </ul>
                        </div>
                        <div id="exam-btn">
                            <span class="layui-form" style="line-height: 40px;">
                                <input type="checkbox"  lay-filter="collect" value="" id="collect" name="collect" title="收藏"  @if ($collect)checked @endif>
                            </span>
                            <span onclick="getquestion(this)" class="exam-button pre-question" id="pre-question">上一题</span>
                            <span onclick="getquestion(this)" class="exam-button next-question" id="next-question">下一题</span>
                            @if($pass == 0)<span onclick="submitpaper(this)" class="exam-button submit-paper">交卷</span>@endif
                             <input type="hidden" class="lefttime" @if($pass != 0)value="1"@endif>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        
        $(window).bind('beforeunload',function(){return '离开并提交试题';});

        var intDiff = parseInt({{ $lefttime }});//倒计时总秒数量
        var timestatu = $('.lefttime').val()
        function timer(intDiff){
            window.setInterval(function(){
                if(intDiff == 0 && !timestatu){
                    layui.use('layer', function(){
                        var layer = layui.layer;
                        layer.confirm('时间到', {
                            closeBtn: 0,
                            btn: ['交卷'] //按钮
                        }, function(){
                            var chose = new Array()
                            $('#question-list ul li').each(function () {
                                chose.push($(this).attr('data-chose'))
                            })

                            var url = '{{route('submitpaper')}}'
                            $.post(url,{'_token': '{{ csrf_token() }}',ue:'{{$_GET['id']}}',answer: chose.join(',')},function (data) {
                                if(data == 1){
                                    window.location.href = '{{route('examl')}}'
                                }
                            })
                        });
                    });
                }
                var day=0,
                    hour=0,
                    minute=0,
                    second=0;//时间默认值
                if(intDiff > 0){
                    day = Math.floor(intDiff / (60 * 60 * 24));
                    hour = Math.floor(intDiff / (60 * 60)) - (day * 24);
                    minute = Math.floor(intDiff / 60) - (day * 24 * 60) - (hour * 60);
                    second = Math.floor(intDiff) - (day * 24 * 60 * 60) - (hour * 60 * 60) - (minute * 60);
                }
                if (minute <= 9) minute = '0' + minute;
                if (second <= 9) second = '0' + second;
                $('#hour_show').html('<s id="h"></s>'+hour+'时');
                $('#minute_show').html('<s></s>'+minute+'分');
                $('#second_show').html('<s></s>'+second+'秒');
                intDiff--;
            }, 1000);
        }
        $(function(){
            timer(intDiff);
        });
        function IsInArray(arr,val){

            var testStr=','+arr.join(",")+",";

            return testStr.indexOf(","+val+",")!=-1;

        }
        layui.use('form', function(){
            var form = layui.form;
            form.render();
            form.on('checkbox(collect)', function(data){
                var url = "{{route('changecollect')}}";
                var question = $('.question-list-active').attr('data-id')
                $.post(url,{'_token': '{{ csrf_token() }}','question':question},function (v) {
                    if(v == 1){
                        layer.msg('修改成功');
                    }
                });
            });
        });
        function submitpaper() {
            layui.use('layer', function(){
                var layer = layui.layer;
                layer.confirm('确认交卷？', {
                    btn: ['是','否'] //按钮
                }, function(){
                    var chose = new Array()
                    $('#question-list ul li').each(function () {
                        chose.push($(this).attr('data-chose'))
                    })

                    var url = '{{route('submitpaper')}}'
                    $.post(url,{'_token': '{{ csrf_token() }}',ue:'{{$_GET['id']}}',answer: chose.join(',')},function (data) {
                        if(data == 1){
                            window.location.href = '{{route('examl')}}'
                        }
                    })
                }, function(){
                });
            });

        }
        function choseanswer(obj) {
            if($('.ismulty').val()==1){
                if($(obj).hasClass('chose-answer-active')){
                    $(obj).removeClass('chose-answer-active')
                }else{
                    $(obj).addClass('chose-answer-active');
                }
                var answerlist = new Array()
                $('.chose-answer-active').each(function () {
                    answerlist.push($(this).attr('data-answer'))
                })
                var str=answerlist.join('-')
                console.log(str)
                $('.question-list-active').attr('data-chose',str)
            }else{
                $(obj).siblings().removeClass('chose-answer-active')
                $(obj).addClass('chose-answer-active');
                var chose = $(obj).attr('data-answer');
                $('.question-list-active').attr('data-chose',chose)
            }
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
            var ue = '{{$_GET['id']}}'
            $.post(url,{'_token': '{{ csrf_token() }}',id:id,ue:ue},function (data) {
                data=JSON.parse(data);
                var tx = '';
                if(data.question.qid == 0){
                    tx="(单选题)"
                }else if(data.question.qid == 1){
                    tx='<input type="hidden" value="1" class="ismulty">(多选题)'
                }else if(data.question.qid == 2){
                    tx="(判断题)"
                }
                $('#question h3').html(tx+data.question.title)
                var answerHtml = ''
                var choseHtml = ''
                data.answer.forEach(function( val, index ) {
                    answerHtml+='<li style="font-size: 20px;">'+val.no+'.'+val.title+'</li>'
                    if(data.question.qid == 1){
                        choseHtml+='<li data-answer="'+val.no+'" onclick="choseanswer(this)" class="anweritem multyquestion">'+val.no+'</li>'
                    }else{
                        choseHtml+='<li data-answer="'+val.no+'" onclick="choseanswer(this)" class="anweritem">'+val.no+'</li>'
                    }
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
                if($('.question-list-active').attr('data-chose')){
                    var chose = $('.question-list-active').attr('data-chose')
                    if($('.ismulty').val()==1){
                        var a = chose.split('-')
                        $('.anweritem').each(function () {
                            if(IsInArray(a,$(this).attr('data-answer'))){
                                $(this).addClass('chose-answer-active')
                            }
                        })
                    }else{
                        $('.anweritem').each(function () {
                            if($(this).attr('data-answer') == chose){
                                $(this).addClass('chose-answer-active')
                            }
                        })
                    }
                }
                if(data.right){
                    if(data.right.length>1){
                        var right = data.right.split('-')
                        $('.anweritem').each(function () {
                            $(this).removeClass('chose-answer-active')
                            if(IsInArray(right,$(this).attr('data-answer'))){
                                $(this).addClass('chose-answer-active')
                            }
                        })
                    }else{
                        $('.anweritem').each(function () {
                            if($(this).attr('data-answer') == data.right){
                                $(this).addClass('chose-answer-active')
                            }
                        })
                    }
                }
                if(data.wrong){
                    if(data.wrong.length>1){
                        var wrong = data.wrong.split('-')
                        $('.anweritem').each(function () {
                            if(!IsInArray(right,$(this).attr('data-answer')) && IsInArray(wrong,$(this).attr('data-answer'))){
                                $(this).addClass('wrong')
                            }
                        })
                    }else {
                        $('.anweritem').each(function () {
                            if ($(this).attr('data-answer') == data.wrong) {
                                $(this).addClass('wrong')
                            }
                        })
                    }
                }
            })
        }
    </script>
@endsection

