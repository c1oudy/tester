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
                            <h3>{{$question['title']}}</h3>
                            <div id="answer">
                                <ul>
                                    @foreach($answer as $val)
                                        <li>{{$val['no']}}.{{$val['title']}}</li>
                                    @endforeach
                                </ul>
                            </div>

                            <div id="chose-answer">
                                @foreach($answer as $val)
                                    <li data-answer="{{$val['no']}}" onclick="choseanswer(this)" class="anweritem">{{$val['no']}}</li>
                                @endforeach
                            </div>
                            {{--<div id="img-box">--}}
                            {{--<img class="question-img" src="{{ asset('image/timg.jpg') }}" alt="">--}}
                            {{--</div>--}}
                        </div>
                        <div id="left-time">
                            <p><strong>剩余时间</strong></p>
                            <strong id="hour_show">0时</strong>
                            <strong id="minute_show">0分</strong>
                            <strong id="second_show">0秒</strong>
                        </div>
                        <div id="question-list">
                            <ul>
                                @for ($i = 0; $i < count($questionid); $i++)
                                    <li onclick="getquestion(this)" data-chose="" data-id="{{$questionid[$i]}}" @if($curid==$questionid[$i])class="question-list-active" @endif>{{($i+1)}}</li>
                                @endfor
                            </ul>
                        </div>
                        <div id="exam-btn">
                            <span class="layui-form" style="line-height: 40px;">
                                <input type="checkbox"  lay-filter="collect" value="" id="collect" name="collect" title="收藏"  @if ($collect)checked @endif>
                            </span>
                            <span onclick="getquestion(this)" class="exam-button pre-question" id="pre-question">上一题</span>
                            <span onclick="getquestion(this)" class="exam-button next-question" id="next-question">下一题</span>
                            <span onclick="submitpaper(this)" class="exam-button submit-paper">交卷</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        var intDiff = parseInt({{ $lefttime }});//倒计时总秒数量
        function timer(intDiff){
            window.setInterval(function(){
                if(intDiff == 0){
                    //时间到
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
            $(obj).siblings().removeClass('chose-answer-active')
            $(obj).addClass('chose-answer-active');
            var chose = $(obj).attr('data-answer');
            $('.question-list-active').attr('data-chose',chose)
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
                if($('.question-list-active').attr('data-chose')){
                    var chose = $('.question-list-active').attr('data-chose')
                    $('.anweritem').each(function () {
                        if($(this).attr('data-answer') == chose){
                            $(this).addClass('chose-answer-active')
                        }
                    })
                }
            })
        }
    </script>
@endsection

