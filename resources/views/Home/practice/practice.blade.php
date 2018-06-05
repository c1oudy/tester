@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">练习</div>

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
                                    @foreach($answer as $val)
                                    <li>{{$val['no']}}.{{$val['title']}}</li>
                                    @endforeach
                                </ul>
                            </div>

                            <div id="chose-answer">
                                @foreach($answer as $val)
                                    <li data-answer="{{$val['no']}}" onclick="choseanswer(this)" class="anweritem @if($question['qid']==1) multyquestion @endif">{{$val['no']}}</li>
                                @endforeach
                            </div>
                            {{--<div id="img-box">--}}
                                {{--<img class="question-img" src="{{ asset('image/timg.jpg') }}" alt="">--}}
                            {{--</div>--}}
                        </div>

                        <div id="question-list">
                            <ul>
                                @for ($i = 0; $i < count($questionid); $i++)
                                    <li onclick="getquestion(this)" data-id="{{$questionid[$i]}}" @if($curid==$questionid[$i])class="question-list-active" @endif>{{($i+1)}}</li>
                                @endfor
                            </ul>
                        </div>
                        <div id="exam-btn">
                            <span class="layui-form">
                                <input type="checkbox"  lay-filter="collect" value="" id="collect" name="collect" title="收藏"  @if ($collect)checked @endif>
                            </span>
                            <span onclick="getquestion(this)" class="exam-button pre-question" id="pre-question">上一题</span>
                            <span onclick="getquestion(this)" class="exam-button next-question" id="next-question">下一题</span>
                            {{--<span class="exam-button submit-paper">交卷</span>--}}
                        </div>
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
                        layer.msg('修改成功');
                    }
                });
            });
        });
        function choseanswer(obj) {
            var question_id=$('.question-list-active').attr('data-id')
            var url = '{{route('questionoperate')}}'
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
                $.post(url,{'_token': '{{ csrf_token() }}',question_id:question_id,operate:'getanswer'},function (v) {
                    var right = v.split('-');
                    if(right.length == answerlist.length){
                        if(right.sort().toString() == answerlist.sort().toString()){
                            layui.use('layer', function(){
                                var layer = layui.layer;
                                layer.msg('回答正确');
                            });
                        }else{
                            $('.anweritem').each(function () {
                                if(IsInArray(answerlist,$(this).attr('data-answer')) && !IsInArray(right,$(this).attr('data-answer')) ){
                                    layer.msg('回答错误');
                                    $(this).css('background','red')
                                }
                                if( IsInArray(right,$(this).attr('data-answer')) ){
                                    $(this).addClass('chose-answer-active');
                                }
                            })
                        }
                    }
                });
            }else{
                $(obj).siblings().removeClass('chose-answer-active')
                $(obj).addClass('chose-answer-active');
                var chose = $(obj).attr('data-answer');

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
        }
        function IsInArray(arr,val){
            var testStr=','+arr.join(",")+",";
            return testStr.indexOf(","+val+",")!=-1;
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
            })
        }
    </script>
@endsection
