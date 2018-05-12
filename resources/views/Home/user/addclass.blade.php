@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading" >班级审核
                        @if( Auth::user()->statu != 1 )
                        <div class="search-box">
                            <input type="text" id="search-txt" @if(isset($search)) value="{{$search}}" @endif>
                            <img id="btn-search" onclick="search()" src="{{asset('image/search.png')}}" alt="">
                        </div>
                        @endif
                    </div>
                    <div class="panel-body">
                        @if( Auth::user()->statu == 1 )
                            已提交，待审核
                        @else
                            <table class="layui-table">
                                <colgroup>
                                    <col width="150">
                                    <col width="200">
                                    <col>
                                </colgroup>
                                <thead>
                                <tr>
                                    <th>班级名</th>
                                    <th>编号</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($class as $item)
                                    <tr>
                                        <td>{{$item['name']}}</td>
                                        <td>{{$item['tid']}}</td>
                                        <td><button class="layui-btn layui-btn-normal btn-addclass" onclick="addclass(this)" data-id="{{$item['id']}}">提交</button></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script>
        function search(){
            var data = $('#search-txt').val()
            window.location.href= "{{route('addclass')}}"+'?search='+data
        }
        layui.use('layer', function(){
            var layer = layui.layer;
        });
        function addclass(obj) {
            var id = $(obj).attr('data-id')
            var url= "{{route('useroperate')}}"
            $.post(url,{'_token': '{{ csrf_token() }}',operate:'addclass',classid:id},function (data) {
                if(data == 1){
                    layer.msg('等待审核');
                    window.location.reload()
                }
            });
        }
    </script>
@endsection


