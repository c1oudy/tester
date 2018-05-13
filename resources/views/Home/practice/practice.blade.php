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
                                    <li onclick="choseanswer(this)" class="anweritem">{{$val['no']}}</li>
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
        function choseanswer(obj) {
            $(obj).siblings().removeClass('chose-answer-active')
            $(obj).addClass('chose-answer-active');
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
                    choseHtml+='<li onclick="choseanswer(this)" class="anweritem">'+val.no+'</li>'
                });
                $('#answer ul').replaceWith(answerHtml);
                $('#chose-answer').empty()
                $('#chose-answer').append(choseHtml);
            })
        }
    </script>
@endsection
