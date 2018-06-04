<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Creative - Bootstrap 3 Responsive Admin Template">
    <meta name="author" content="GeeksLabs">
    <meta name="keyword" content="Creative, Dashboard, Admin, Template, Theme, Bootstrap, Responsive, Retina, Minimal">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>后台管理</title>

    <!-- Bootstrap CSS -->
    <link href="{{ asset('adminfile/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- bootstrap theme -->
    <link href="{{ asset('adminfile/css/bootstrap-theme.css') }}" rel="stylesheet">
    <!--external css-->
    <!-- font icon -->
    <link href="{{ asset('adminfile/css/elegant-icons-style.css') }}" rel="stylesheet" />
    <link href="{{ asset('adminfile/css/font-awesome.min.css') }}" rel="stylesheet" />
    <!-- full calendar css-->
    <link href="{{ asset('adminfile/assets/fullcalendar/fullcalendar/bootstrap-fullcalendar.css') }}" rel="stylesheet" />
    <link href="{{ asset('adminfile/assets/fullcalendar/fullcalendar/fullcalendar.css') }}" rel="stylesheet" />
    <!-- easy pie chart-->
    <link href="{{ asset('adminfile/assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css') }}" rel="stylesheet" type="text/css" media="screen"/>
    <!-- owl carousel -->
    <link rel="stylesheet" href="{{ asset('adminfile/css/owl.carousel.css') }}" type="text/css">
    <link href="{{ asset('adminfile/css/jquery-jvectormap-1.2.2.css') }}" rel="stylesheet">
    <!-- Custom styles -->
    <link rel="stylesheet" href="{{ asset('adminfile/css/fullcalendar.css') }}">
    <link href="{{ asset('adminfile/css/widgets.css') }}" rel="stylesheet">
    <link href="{{ asset('adminfile/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('adminfile/css/style-responsive.css') }}" rel="stylesheet" />
    <link href="{{ asset('adminfile/css/xcharts.min.css') }}" rel=" stylesheet">
    <link href="{{ asset('adminfile/css/jquery-ui-1.10.4.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 -->
    <!--[if lt IE 9]>
    <script src="{{ asset('adminfile/js/html5shiv.js') }}"></script>
    <script src="{{ asset('adminfile/js/respond.min.js') }}"></script>
    <script src="{{ asset('adminfile/js/lte-ie7.js') }}"></script>
    <![endif]-->

    <!--layer-->
    <script src="{{ asset('js/layui/layui.js') }}"></script>
    <link href="{{ asset('js/layui/css/layui.css') }}" rel="stylesheet">
</head>

<body>
<!-- container section start -->
<section id="container" class="">


    <header class="header dark-bg">
        <div class="toggle-nav">
            <div class="icon-reorder tooltips" data-original-title="Toggle Navigation" data-placement="bottom"></div>
        </div>

        <!--logo start-->
        <a href="{{route("adminhome")}}" class="logo">Exam<span class="lite">后台管理</span></a>
        <!--logo end-->
        <div class="top-nav notification-row">
            <!-- notificatoin dropdown start-->
            <ul class="nav pull-right top-menu">
                <!-- alert notification end-->
                <!-- user login dropdown start-->
                {{--<li class="dropdown">--}}
                    {{--<a data-toggle="dropdown" class="dropdown-toggle" href="#">--}}
                        {{--<span class="username">{{ Session::get('adminuser')->name }}</span>--}}
                        {{--<b class="caret"></b>--}}
                    {{--</a>--}}
                {{--</li>--}}
                <!-- user login dropdown end -->
            </ul>
            <!-- notificatoin dropdown end-->
        </div>
    </header>
    <!--header end-->

    <!--sidebar start-->
    <aside>
        <div id="sidebar"  class="nav-collapse ">
            <!-- sidebar menu start-->
            <ul class="sidebar-menu">
                <li class="active">
                    <a class="" target="_blank" href="{{route('home')}}">
                        <i class="icon_house_alt"></i>
                        <span>网站前台</span>
                    </a>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;" class="">
                        <i class="icon_document_alt"></i>
                        <span>试题管理</span>
                        <span class="menu-arrow arrow_carrot-right"></span>
                    </a>
                    <ul class="sub">
                        <li><a class="menu_item" href="{{route('questionmanage')}}">试题管理</a></li>
                        <li><a class="menu_item" href="{{route('admintype')}}">分类管理</a></li>
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;" class="">
                        <i class="icon_desktop"></i>
                        <span>考试管理</span>
                        <span class="menu-arrow arrow_carrot-right"></span>
                    </a>
                    <ul class="sub">
                        <li><a class="menu_item" href="{{route('examsetting')}}">考试发布</a></li>
                        <li><a class="menu_item" href="{{route('examlist')}}">成绩查询</a></li>
                    </ul>
                </li>

                <li class="sub-menu">
                    <a href="javascript:;" class="">
                        <i class="icon_table"></i>
                        <span>用户管理</span>
                        <span class="menu-arrow arrow_carrot-right"></span>
                    </a>
                    <ul class="sub">
                        <li><a class="menu_item" href="{{route('classlist')}}">学院列表</a></li>
                        <li><a class="menu_item" href="{{route('userlist')}}">用户审核</a></li>
                    </ul>
                </li>

            </ul>
            <!-- sidebar menu end-->
        </div>
    </aside>
    <!--sidebar end-->
    @yield('content')

    <!--main content end-->
</section>
</body>
</html>
