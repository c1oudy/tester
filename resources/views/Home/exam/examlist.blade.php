@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">考试列表</div>

                    <div class="panel-body">
                        @foreach($exam as $val)
                            <a href="{{route('exam')}}?id={{$val['userexam']}}">
                                <div class="examlist">
                                    <p>{{$val['title']}}(总分{{$val['total']}}) <span> @if($val['pass']==1) 已通过({{$val['score']}}分) @elseif($val['pass']==0) 截止日期2018-5-6 @elseif($val['pass']==2) 未通过({{$val['score']}}分) @endif</span></p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
    </script>
@endsection