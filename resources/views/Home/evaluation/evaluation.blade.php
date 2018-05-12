@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">测评</div>

                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div id="question">
                            <h3>这是标题这是标题这是标题这是标题这是标题这是标题这是标题这是标题这是标题这是标题这是标题这是标题这是标题</h3>
                            <div id="answer">
                                <ul>
                                    <li>A.选项一</li>
                                    <li>B.选项二</li>
                                    <li>C.选项三</li>
                                    <li>D.选项四</li>
                                </ul>
                            </div>
                            <div id="chose-answer">
                                <li>A</li>
                                <li>B</li>
                                <li>C</li>
                                <li>D</li>
                            </div>
                        </div>
                        <div id="left-time">
                            <p><strong>剩余时间</strong></p>
                            <strong id="hour_show">0时</strong>
                            <strong id="minute_show">0分</strong>
                            <strong id="second_show">0秒</strong>
                        </div>
                        <div id="question-list">
                            <ul>
                                <li class="question-list-active">1</li>
                                <li>2</li>
                                <li>3</li>
                                <li>4</li>
                                <li>5</li>
                                <li>6</li>
                                <li>7</li>
                                <li>8</li>
                                <li>9</li>
                                <li>10</li>
                            </ul>
                        </div>
                        <div id="exam-btn">
                            <span class="exam-button pre-question">上一题</span>
                            <span class="exam-button next-question">上一题</span>
                            <span class="exam-button submit-paper">交卷</span>
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
    </script>
@endsection
