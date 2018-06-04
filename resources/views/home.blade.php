@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">练习分类</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <ul id="menu_list">
                        @foreach($type as $item)
                        <li data-type="{{$item['id']}}" onclick="practice_type(this)"><a href="javascript:;">{{$item['name']}}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function practice_type(obj) {
        var type_id = $(obj).attr('data-type');
        window.location.href="{{route('practice')}}"+'?type='+type_id
    }
</script>
@endsection
