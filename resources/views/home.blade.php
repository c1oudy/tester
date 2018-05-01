@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <ul id="menu_list">
                        <li>分类练习</li>
                        <li>随机练习</li>
                        <li>随机组题</li>
                        <li>考试系统</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    
</script>
@endsection
