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
                                <li class="chose-answer-active">A</li>
                                <li>B</li>
                                <li>C</li>
                                <li>D</li>
                            </div>
                            <div id="img-box">
                                <img class="question-img" src="{{ asset('image/timg.jpg') }}" alt="">
                            </div>
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

    </script>
@endsection
