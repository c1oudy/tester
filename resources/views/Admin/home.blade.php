@extends('layouts.admin')
@section('content')
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Raleway', sans-serif;
            font-weight: 100;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
<section id="main-content">
    <section class="wrapper">
        <div class="flex-center position-ref full-height">

            <div class="content">
                <div class="title m-b-md">
                    Welcome
                </div>

            </div>
        </div>
    </section>
</section>
<!--main content end-->
</section>
<!-- container section start -->

<!-- javascripts -->
<script src="{{ asset('adminfile/js/jquery.js') }}"></script>
<script src="{{ asset('adminfile/js/jquery-ui-1.10.4.min.js') }}"></script>
<script src="{{ asset('adminfile/js/jquery-1.8.3.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('adminfile/js/jquery-ui-1.9.2.custom.min.js') }}"></script>
<!-- bootstrap -->
<script src="{{ asset('adminfile/js/bootstrap.min.js') }}"></script>
<!-- nice scroll -->
<script src="{{ asset('adminfile/js/jquery.scrollTo.min.js') }}"></script>
<script src="{{ asset('adminfile/js/jquery.nicescroll.js') }}" type="text/javascript"></script>
<!-- charts scripts -->
<script src="{{ asset('adminfile/assets/jquery-knob/js/jquery.knob.js') }}"></script>
<script src="{{ asset('adminfile/js/jquery.sparkline.js') }}" type="text/javascript"></script>
<script src="{{ asset('adminfile/assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js') }}"></script>
<script src="{{ asset('adminfile/js/owl.carousel.js') }}" ></script>
<!-- jQuery full calendar -->
<script src="{{ asset('adminfile/js/fullcalendar.min.js') }}"></script> <!-- Full Google Calendar - Calendar -->
<script src="{{ asset('adminfile/assets/fullcalendar/fullcalendar/fullcalendar.js') }}"></script>
<!--script for this page only-->
<script src="{{ asset('adminfile/js/calendar-custom.js') }}"></script>
<script src="{{ asset('adminfile/js/jquery.rateit.min.js') }}"></script>
<!-- custom select -->
<script src="{{ asset('adminfile/js/jquery.customSelect.min.js') }}" ></script>
<script src="{{ asset('adminfile/assets/chart-master/Chart.js') }}"></script>

<!--custome script for all page-->
<script src="{{ asset('adminfile/js/scripts.js') }}"></script>
<!-- custom script for this page-->
<script src="{{ asset('adminfile/js/sparkline-chart.js') }}"></script>
<script src="{{ asset('adminfile/js/easy-pie-chart.js') }}"></script>
<script src="{{ asset('adminfile/js/jquery-jvectormap-1.2.2.min.js') }}"></script>
<script src="{{ asset('adminfile/js/jquery-jvectormap-world-mill-en.js') }}"></script>
<script src="{{ asset('adminfile/js/xcharts.min.js') }}"></script>
<script src="{{ asset('adminfile/js/jquery.autosize.min.js') }}"></script>
<script src="{{ asset('adminfile/js/jquery.placeholder.min.js') }}"></script>
<script src="{{ asset('adminfile/js/gdp-data.js') }}"></script>
<script src="{{ asset('adminfile/js/morris.min.js') }}"></script>
<script src="{{ asset('adminfile/js/sparklines.js') }}"></script>
<script src="{{ asset('adminfile/js/charts.js') }}"></script>
<script src="{{ asset('adminfile/js/jquery.slimscroll.min.js') }}"></script>
<script>

    //knob
    $(function() {
        $(".knob").knob({
            'draw' : function () {
                $(this.i).val(this.cv + '%')
            }
        })
    });

    //carousel
    $(document).ready(function() {
        $("#owl-slider").owlCarousel({
            navigation : true,
            slideSpeed : 300,
            paginationSpeed : 400,
            singleItem : true

        });
    });

    //custom select box

    $(function(){
        $('select.styled').customSelect();
    });

    /* ---------- Map ---------- */
    $(function(){
        $('#map').vectorMap({
            map: 'world_mill_en',
            series: {
                regions: [{
                    values: gdpData,
                    scale: ['#000', '#000'],
                    normalizeFunction: 'polynomial'
                }]
            },
            backgroundColor: '#eef3f7',
            onLabelShow: function(e, el, code){
                el.html(el.html()+' (GDP - '+gdpData[code]+')');
            }
        });
    });
</script>
@endsection