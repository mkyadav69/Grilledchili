@extends('theme.layout.base_layout')
@section('title', 'Dashboard')
@section('content')
<style>
.percent-chart{
    display: block;
    width: 600px;
    height: 600px;
    padding-left: 100px;
}
</style>
<div class="row">
    @if (session()->has('customer_message'))
        <div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
            {{ session('customer_message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="col-md-12">
        <h3 class="title-5 m-b-35">Overview </h3>
        <div class="table-data__tool">
            <div class="row table-data__tool-right">
                <div class="col col-6">
                    <select name="trucks" id="trucks" required class="form-control" >
                        @if(!empty($trucks) && count($trucks) > 1)
                                <option value="">Select Trucks</option>
                                @foreach($trucks as $id=>$name)
                                    <option value="{{$id}}" {{ old('trucks') == $id ? "selected" : "" }} >{{$name}}</option>
                                @endforeach
                        @elseif(!empty($trucks) && count($trucks) == 1)
                            @foreach($trucks as $id=>$name)
                                <option value="{{$id}}" {{ old('trucks') == $id ? "selected" : "" }} >{{$name}}</option>
                            @endforeach
                        @else
                            <option value='' >No trucks found</option>
                        @endif
                    </select>

                    @if ($errors->truck_add->has('trucks'))
                        <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                            <span class="badge badge-pill badge-danger">Error</span>
                            {{ $errors->truck_add->first('trucks') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                </div>
                
                <div class="row col-6" id="reportrange">
                    <div class="col-0">
                        <i class="fa fa-calendar"></i>&nbsp;
                    </div>
                    <div class="col-11">
                        <input type="text" name="datefilter" required id="datefilter" class="form-control" value="{{ $ui_date }}" placeholder="DD-MM-YYY" />
                    </div>
                </div>

        </div>
    </div>
 
    <div class="table-responsive table--no-card m-b-30">
        <table id="customer" class="table table-borderless table--no-card m-b-30 table-striped table-earning" style="width:100%">
        </table>
    </div>
                       
</div>
<div class="row m-t-25">
    <div class="col-sm-6 col-lg-3">
        <div class="overview-item overview-item--c1">
            <div class="overview__inner">
                <div class="overview-box clearfix">
                    <div class="icon">
                        <i class="zmdi zmdi-shopping-cart"></i>
                    </div>
                    <div class="text">
                        <h2 class="total_order">{{!empty($response['total_order']) ? $response['total_order'] : 0}}</h2>
                        <span>total order</span>
                    </div>
                </div>
                <div class="overview-chart">
                    <canvas id="widgetChart1"></canvas>
                </div>
                <input type="hidden" name="all_month_data" id="all_month_data">
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="overview-item overview-item--c2">
            <div class="overview__inner">
                <div class="overview-box clearfix">
                    <div class="icon">
                        <i class="zmdi zmdi-shopping-cart"></i>
                    </div>
                    <div class="text">
                    <h2 class="place_order">{{!empty($response['order_placed']) ? $response['order_placed'] : 0}}</h2>
                        <span>order placed</span>
                    </div>
                </div>
                <div class="overview-chart">
                    <canvas id="widgetChart2"></canvas>
                </div>
                <input type="hidden" name="placed" id="placed">
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="overview-item overview-item--c2">
            <div class="overview__inner">
                <div class="overview-box clearfix">
                    <div class="icon">
                        <i class="zmdi zmdi-shopping-cart"></i>
                    </div>
                    <div class="text">
                        <h2 class="accepted_order">{{!empty($response['order_accepted']) ? $response['order_accepted'] : 0}}</h2>
                        <span>order accepted</span>
                    </div>
                </div>
                <div class="overview-chart">
                    <canvas id="widgetChart3"></canvas>
                </div>
                <input type="hidden" name="accepted" id="accepted">
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="overview-item overview-item--c3">
            <div class="overview__inner">
                <div class="overview-box clearfix">
                    <div class="icon">
                        <i class="zmdi zmdi-shopping-cart"></i>
                    </div>
                    <div class="text">
                        <h2 class="rejected_order">{{!empty($response['order_rejected']) ? $response['order_rejected'] : 0}}</h2>
                        <span>order rejected</span>
                    </div>
                </div>
                <div class="overview-chart">
                    <canvas id="widgetChart4"></canvas>
                </div>
                <input type="hidden" name="report" id="rejected">
            </div>
        </div>
    </div>
    

    <div class="col-sm-6 col-lg-3">
        <div class="overview-item overview-item--c2">
            <div class="overview__inner">
                <div class="overview-box clearfix">
                    <div class="icon">
                        <i class="zmdi zmdi-shopping-cart"></i>
                    </div>
                    <div class="text">
                    <h2 class="total_revenue">{{!empty($response['total_revenue']) ? $response['total_revenue'] : 0}}</h2>
                        <span>truck revenue</span>
                    </div>
                </div>
                <div class="overview-chart">
                    <canvas id="widgetChart9"></canvas>
                </div>
                <input type="hidden" name="month_wise_revenue" id="month_wise_revenue">
                
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="overview-item overview-item--c2">
            <div class="overview__inner">
                <div class="overview-box clearfix">
                    <div class="icon">
                        <i class="zmdi zmdi-shopping-cart"></i>
                    </div>
                    <div class="text">
                        <h2 class="delivered_order">{{!empty($response['order_delivered']) ? $response['order_delivered'] : 0}}</h2>
                        <span>order deliverd</span>
                    </div>
                    <input type="hidden" name="report" id="delivered">
                </div>
                <div class="overview-chart">
                    <canvas id="widgetChart6"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="overview-item overview-item--c2">
            <div class="overview__inner">
                <div class="overview-box clearfix">
                    <div class="icon">
                        <i class="zmdi zmdi-shopping-cart"></i>
                    </div>
                    <div class="text">
                        <h2 class="ready_order">{{!empty($response['order_ready']) ? $response['order_ready'] : 0}}</h2>
                        <span>order ready</span>
                    </div>
                </div>
                <div class="overview-chart">
                    <canvas id="widgetChart7"></canvas>
                </div>
                <input type="hidden" name="report" id="ready">
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="overview-item overview-item--c3">
            <div class="overview__inner">
                <div class="overview-box clearfix">
                    <div class="icon">
                        <i class="zmdi zmdi-shopping-cart"></i>
                    </div>
                    <div class="text">
                        <h2 class="cancel_order">{{!empty($response['order_cancelled']) ? $response['order_cancelled'] : 0}}</h2>
                        <span>order cancel</span>
                    </div>
                </div>
                <div class="overview-chart">
                    <canvas id="widgetChart8"></canvas>
                </div>
                <input type="hidden" name="cancel" id="cancel">
            </div>
        </div>
    </div>
</div>
<div class="row col-lg-12">
    <div class="col col-6">
        <div class="au-card recent-report">
            <div class="au-card-inner">
                <h3 class="title-2">Monthly reports</h3>
                <div class="chart-info">
                   
                    <div class="col-xl-4">
                        <div class="chart-note-wrap">
                            <div class="chart-note mr-0 d-block">
                                <span class="dot dot--blue"></span>
                                <span>current month</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4">
                        <div class="chart-note-wrap">
                            <div class="chart-note mr-0 d-block">
                                <span class="dot dot--green"></span>
                                <span>last month</span>
                            </div>
                        </div>
                    </div>
                    <div class="chart-info__right">
                        @if(!empty($ratio['increases_by']))
                            <div class="chart-statis">
                                <span class="index incre">
                                    <i class="zmdi zmdi-long-arrow-up"></i>{{ $ratio['increases_by']}} %</span>
                                <span class="label">{{ $ratio['month']}} </span>
                            </div>
                        @endif
                        @if(!empty($ratio['decreases_by']))
                            <div class="chart-statis mr-0">
                                <span class="index decre">
                                    <i class="zmdi zmdi-long-arrow-down"></i>{{$ratio['decreases_by']}} %</span>
                                <span class="label">{{ $ratio['month']}}</span>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="recent-report__chart">
                    <canvas id="recent-rep-chart"></canvas>
                </div>
                <input type="hidden" value="{{$report}}" name="report", id="report">
            </div>
        </div>
    </div>
    <div class="col col-6">
        <div class="au-card chart-percent-card">
            <div class="au-card-inner">
                <h3 class="title-2 tm-b-5">Sale item report %</h3>
                <div class="row no-gutters">
                        @if(!empty($sale))
                           @foreach($sale['labels'] as $label)
                                <div class="col-xl-6">
                                    <div class="chart-note-wrap">
                                        <div class="chart-note mr-0 d-block">
                                            <span class="dot" style="background: #{{explode('_', $label)[1]}} "></span>
                                            <span>{{explode('_', $label)[0]}}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        <div class="col-xl-6">
                            <div class="percent-chart">
                                <canvas id="percent-chart"></canvas>
                            </div>
                            <input type="hidden" value="{{$sale_data_per}}" name="sale_data_per", id="sale_data_per">
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
$(document).ready(function(){
    var truck_count = "{{$check_truck_count}}";

    $('#datefilter').on('change', function(){
        var date_range = $('#datefilter').val();
        var trucks_id = $("#trucks option:selected").val();
        if(truck_count > 1){
            if(trucks_id != '' && date_range == ''){
                var ajaxcall = ajaxCall('', trucks_id);
            }
        }else{
            var ajaxcall = ajaxCall('', trucks_id, 'single_truck');
        }
    });
    function chart1(){
        //WidgetChart 1
        var ctx = document.getElementById("widgetChart1");
        var all_month_data = document.getElementById("all_month_data").value;
        var decode= JSON.parse(all_month_data);
        var month = Object.keys(decode);
        var value = Object.values(decode);
        if (ctx) {
        ctx.height = 130;
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
            labels: month,
            type: 'line',
            datasets: [{
                data: value,
                label: 'Order',
                backgroundColor: 'transparent',
                borderColor: 'rgba(255,255,255,.55)',
            },]
            },
            options: {

            maintainAspectRatio: false,
            legend: {
                display: false
            },
            responsive: true,
            tooltips: {
                mode: 'index',
                titleFontSize: 12,
                titleFontColor: '#000',
                bodyFontColor: '#000',
                backgroundColor: '#fff',
                titleFontFamily: 'Montserrat',
                bodyFontFamily: 'Montserrat',
                cornerRadius: 3,
                intersect: false,
            },
            scales: {
                xAxes: [{
                gridLines: {
                    color: 'transparent',
                    zeroLineColor: 'transparent'
                },
                ticks: {
                    fontSize: 2,
                    fontColor: 'transparent'
                }
                }],
                yAxes: [{
                display: false,
                ticks: {
                    display: false,
                }
                }]
            },
            title: {
                display: false,
            },
            elements: {
                line: {
                tension: 0.00001,
                borderWidth: 1
                },
                point: {
                radius: 4,
                hitRadius: 10,
                hoverRadius: 4
                }
            }
            }
        });
        }
    }

    function chart2(){
        //WidgetChart 2
        var ctx = document.getElementById("widgetChart2");
        var placed = document.getElementById("placed").value;
        var decode= JSON.parse(placed);
        var month = Object.keys(decode);
        var value = Object.values(decode);
        if (ctx) {
        ctx.height = 130;
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
            labels: month,
            type: 'line',
            datasets: [{
                data: value,
                label: 'Placed order',
                backgroundColor: 'transparent',
                borderColor: 'rgba(255,255,255,.55)',
            },]
            },
            options: {

            maintainAspectRatio: false,
            legend: {
                display: false
            },
            responsive: true,
            tooltips: {
                mode: 'index',
                titleFontSize: 12,
                titleFontColor: '#000',
                bodyFontColor: '#000',
                backgroundColor: '#fff',
                titleFontFamily: 'Montserrat',
                bodyFontFamily: 'Montserrat',
                cornerRadius: 3,
                intersect: false,
            },
            scales: {
                xAxes: [{
                gridLines: {
                    color: 'transparent',
                    zeroLineColor: 'transparent'
                },
                ticks: {
                    fontSize: 2,
                    fontColor: 'transparent'
                }
                }],
                yAxes: [{
                display: false,
                ticks: {
                    display: false,
                }
                }]
            },
            title: {
                display: false,
            },
            elements: {
                line: {
                tension: 0.00001,
                borderWidth: 1
                },
                point: {
                radius: 4,
                hitRadius: 10,
                hoverRadius: 4
                }
            }
            }
        });
        }
    }

    function chart3(){
        //WidgetChart 3
        var ctx = document.getElementById("widgetChart3");
        var accepted = document.getElementById("accepted").value;
        var decode= JSON.parse(accepted);
        var month = Object.keys(decode);
        var value = Object.values(decode);
        if (ctx) {
        ctx.height = 130;
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
            labels: month,
            type: 'line',
            datasets: [{
                data: value,
                label: 'Accepted orders',
                backgroundColor: 'transparent',
                borderColor: 'rgba(255,255,255,.55)',
            },]
            },
            options: {

            maintainAspectRatio: false,
            legend: {
                display: false
            },
            responsive: true,
            tooltips: {
                mode: 'index',
                titleFontSize: 12,
                titleFontColor: '#000',
                bodyFontColor: '#000',
                backgroundColor: '#fff',
                titleFontFamily: 'Montserrat',
                bodyFontFamily: 'Montserrat',
                cornerRadius: 3,
                intersect: false,
            },
            scales: {
                xAxes: [{
                gridLines: {
                    color: 'transparent',
                    zeroLineColor: 'transparent'
                },
                ticks: {
                    fontSize: 2,
                    fontColor: 'transparent'
                }
                }],
                yAxes: [{
                display: false,
                ticks: {
                    display: false,
                }
                }]
            },
            title: {
                display: false,
            },
            elements: {
                line: {
                tension: 0.00001,
                borderWidth: 1
                },
                point: {
                radius: 4,
                hitRadius: 10,
                hoverRadius: 4
                }
            }
            }
        });
        }
    }

    function chart4(){
        var ctx = document.getElementById("widgetChart4");
        var rejected = document.getElementById("rejected").value;
        var decode= JSON.parse(rejected);
        var month = Object.keys(decode);
        var value = Object.values(decode);
        if (ctx) {
        ctx.height = 130;
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
            labels: month,
            type: 'line',
            datasets: [{
                data: value,
                label: 'Rejected orders',
                backgroundColor: 'transparent',
                borderColor: 'rgba(255,255,255,.55)',
            },]
            },
            options: {

            maintainAspectRatio: false,
            legend: {
                display: false
            },
            responsive: true,
            tooltips: {
                mode: 'index',
                titleFontSize: 12,
                titleFontColor: '#000',
                bodyFontColor: '#000',
                backgroundColor: '#fff',
                titleFontFamily: 'Montserrat',
                bodyFontFamily: 'Montserrat',
                cornerRadius: 3,
                intersect: false,
            },
            scales: {
                xAxes: [{
                gridLines: {
                    color: 'transparent',
                    zeroLineColor: 'transparent'
                },
                ticks: {
                    fontSize: 2,
                    fontColor: 'transparent'
                }
                }],
                yAxes: [{
                display: false,
                ticks: {
                    display: false,
                }
                }]
            },
            title: {
                display: false,
            },
            elements: {
                line: {
                borderWidth: 1
                },
                point: {
                radius: 4,
                hitRadius: 10,
                hoverRadius: 4
                }
            }
            }
        });
        }
    }

    function chart6(){
       // WidgetChart 6
        var ctx = document.getElementById("widgetChart6");
        var delivered = document.getElementById("delivered").value;
        var decode= JSON.parse(delivered);
        var month = Object.keys(decode);
        var value = Object.values(decode);
        if (ctx) {
        ctx.height = 130;
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
            labels: month,
            type: 'line',
            datasets: [{
                data: value,
                label: 'Delivered orders',
                backgroundColor: 'transparent',
                borderColor: 'rgba(255,255,255,.55)',
            },]
            },
            options: {

            maintainAspectRatio: false,
            legend: {
                display: false
            },
            responsive: true,
            tooltips: {
                mode: 'index',
                titleFontSize: 12,
                titleFontColor: '#000',
                bodyFontColor: '#000',
                backgroundColor: '#fff',
                titleFontFamily: 'Montserrat',
                bodyFontFamily: 'Montserrat',
                cornerRadius: 3,
                intersect: false,
            },
            scales: {
                xAxes: [{
                gridLines: {
                    color: 'transparent',
                    zeroLineColor: 'transparent'
                },
                ticks: {
                    fontSize: 2,
                    fontColor: 'transparent'
                }
                }],
                yAxes: [{
                display: false,
                ticks: {
                    display: false,
                }
                }]
            },
            title: {
                display: false,
            },
            elements: {
                line: {
                borderWidth: 1
                },
                point: {
                radius: 4,
                hitRadius: 10,
                hoverRadius: 4
                }
            }
            }
        });
        }
    }

    function chart7(){
        //WidgetChart 7
        var ctx = document.getElementById("widgetChart7");
        var ready = document.getElementById("ready").value;
        var decode= JSON.parse(ready);
        var month = Object.keys(decode);
        var value = Object.values(decode);
        if (ctx) {
        ctx.height = 130;
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
            labels: month,
            type: 'line',
            datasets: [{
                data: value,
                label: 'Ready orders',
                backgroundColor: 'transparent',
                borderColor: 'rgba(255,255,255,.55)',
            },]
            },
            options: {

            maintainAspectRatio: false,
            legend: {
                display: false
            },
            responsive: true,
            tooltips: {
                mode: 'index',
                titleFontSize: 12,
                titleFontColor: '#000',
                bodyFontColor: '#000',
                backgroundColor: '#fff',
                titleFontFamily: 'Montserrat',
                bodyFontFamily: 'Montserrat',
                cornerRadius: 3,
                intersect: false,
            },
            scales: {
                xAxes: [{
                gridLines: {
                    color: 'transparent',
                    zeroLineColor: 'transparent'
                },
                ticks: {
                    fontSize: 2,
                    fontColor: 'transparent'
                }
                }],
                yAxes: [{
                display: false,
                ticks: {
                    display: false,
                }
                }]
            },
            title: {
                display: false,
            },
            elements: {
                line: {
                borderWidth: 1
                },
                point: {
                radius: 4,
                hitRadius: 10,
                hoverRadius: 4
                }
            }
            }
        });
        }
    }

    function chart8(){
        //WidgetChart 8
        var ctx = document.getElementById("widgetChart8");
        var cancel = document.getElementById("cancel").value;
        var decode= JSON.parse(cancel);
        var month = Object.keys(decode);
        var value = Object.values(decode);
        if (ctx) {
            ctx.height = 130;
            var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: month,
                type: 'line',
                datasets: [{
                data: value,
                label: 'Cancel orders',
                backgroundColor: 'transparent',
                borderColor: 'rgba(255,255,255,.55)',
                },]
            },
            options: {

                maintainAspectRatio: false,
                legend: {
                display: false
                },
                responsive: true,
                tooltips: {
                mode: 'index',
                titleFontSize: 12,
                titleFontColor: '#000',
                bodyFontColor: '#000',
                backgroundColor: '#fff',
                titleFontFamily: 'Montserrat',
                bodyFontFamily: 'Montserrat',
                cornerRadius: 3,
                intersect: false,
                },
                scales: {
                xAxes: [{
                    gridLines: {
                    color: 'transparent',
                    zeroLineColor: 'transparent'
                    },
                    ticks: {
                    fontSize: 2,
                    fontColor: 'transparent'
                    }
                }],
                yAxes: [{
                    display: false,
                    ticks: {
                    display: false,
                    }
                }]
                },
                title: {
                display: false,
                },
                elements: {
                line: {
                    borderWidth: 1
                },
                point: {
                    radius: 4,
                    hitRadius: 10,
                    hoverRadius: 4
                }
                }
            }
            });
        }
    }

    function chart9(){
        //WidgetChart 9
        var ctx = document.getElementById("widgetChart9");
        var month_wise_revenue = document.getElementById("month_wise_revenue").value;
        var decode= JSON.parse(month_wise_revenue);
        var month = Object.keys(decode);
        var value = Object.values(decode);
        if (ctx) {
            ctx.height = 130;
            var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: month,
                type: 'line',
                datasets: [{
                data: value,
                label: 'Truck revenue',
                backgroundColor: 'transparent',
                borderColor: 'rgba(255,255,255,.55)',
                },]
            },
            options: {

                maintainAspectRatio: false,
                legend: {
                display: false
                },
                responsive: true,
                tooltips: {
                mode: 'index',
                titleFontSize: 12,
                titleFontColor: '#000',
                bodyFontColor: '#000',
                backgroundColor: '#fff',
                titleFontFamily: 'Montserrat',
                bodyFontFamily: 'Montserrat',
                cornerRadius: 3,
                intersect: false,
                },
                scales: {
                xAxes: [{
                    gridLines: {
                    color: 'transparent',
                    zeroLineColor: 'transparent'
                    },
                    ticks: {
                    fontSize: 2,
                    fontColor: 'transparent'
                    }
                }],
                yAxes: [{
                    display: false,
                    ticks: {
                    display: false,
                    }
                }]
                },
                title: {
                display: false,
                },
                elements: {
                line: {
                    borderWidth: 1
                },
                point: {
                    radius: 4,
                    hitRadius: 10,
                    hoverRadius: 4
                }
                }
            }
            });
        }
    }
    var date_range = $('#datefilter').val();
    var trucks_id = $( "#trucks option:selected" ).val();
    
    $('input[name="datefilter"]').daterangepicker({
        autoUpdateInput: false,
        locale: {
            cancelLabel: 'Clear',
            format: 'DD-MM-YYYY'
        }
    });
    
    function ajaxCall(date_range, truck_id, singel_truck){
        var path = "{{route('get_data')}}";
        $.ajax({
                url:path,
                type:'GET',
                dataType: 'json',
                data: {'date_range' : date_range, 'truck_id' : truck_id, 'singel_truck' : singel_truck},
                success: function(response) {
                    if(response.code == 200){
                        var res = response.data;
                        console.log("kk");
                        console.log(res);
                        $('.total_order').html(res.total_order);
                        $('.place_order').html(res.order_placed.count);
                        $('.accepted_order').html(res.order_accepted.count);
                        $('.rejected_order').html(res.order_rejected.count);
                        $('.delivered_order').html(res.order_delivered.count);
                        $('.ready_order').html(res.order_ready.count);
                        $('.cancel_order').html(res.order_cancelled.count);
                        $('.total_revenue').html(res.total_revenue);
                        
                        
                        $('#all_month_data').val(res.all_month_data);
                        $('#placed').val(res.order_placed.monthly_data);
                        $('#accepted').val(res.order_accepted.monthly_data);
                        $('#rejected').val(res.order_rejected.monthly_data);
                        $('#delivered').val(res.order_delivered.monthly_data);
                        $('#ready').val(res.order_ready.monthly_data);
                        $('#cancel').val(res.order_cancelled.monthly_data);
                        $('#month_wise_revenue').val(res.month_wise_revenue);

                        chart1();
                        chart2();
                        chart3();
                        chart4();
                        chart6();
                        chart7();
                        chart8();
                        chart9();
                    } 
                },error: function(error) {
                    console.log(error);
                }
            });
    }
    
    if(truck_count > 1){
        var ajaxcall = ajaxCall(date_range, trucks_id);
        $(function() {
            $('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD-MM-YYYY') + ' | ' + picker.endDate.format('DD-MM-YYYY'));
                var date_range =  $(this).val();
                var trucks_id = $( "#trucks option:selected" ).val();
                if(trucks_id == null || trucks_id ==''){
                    $('#selectTruck').modal({
                        backdrop: 'static'
                    });
                    $('#selectTruck').modal('show');
                }else{
                    var ajaxcall = ajaxCall(date_range, trucks_id);
                }
            });
            $('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
                var date_range =   $(this).val();
                var trucks_id = $( "#trucks option:selected" ).val();
                var ajaxcall = ajaxCall(date_range, trucks_id);
            });

            $('#trucks').on('change', function(){
                var date_range = $('#datefilter').val();
                var trucks_id = $("#trucks option:selected").val();
                if(trucks_id != null && trucks_id != '') {
                    var ajaxcall = ajaxCall(date_range, trucks_id);
                }
                if(trucks_id == '' && date_range == ''){
                    var ajaxcall = ajaxCall(date_range, trucks_id);
                }
                if(trucks_id == '' && date_range != ''){
                    $('#selectTruck').modal({
                        backdrop: 'static'
                    });
                    var ajaxcall = ajaxCall('', trucks_id);
                    $('#selectTruck').modal('show');
                }
            });
        });
    }else{
        $('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD-MM-YYYY') + ' | ' + picker.endDate.format('DD-MM-YYYY'));
            var date_range =  $(this).val();
            var trucks_id = $( "#trucks option:selected" ).val();
            if(date_range != '' && date_range != null){
                var ajaxcall = ajaxCall(date_range, trucks_id);
            }
        });
        $('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            var date_range =   $(this).val();
            var trucks_id = $( "#trucks option:selected" ).val();
            var ajaxcall = ajaxCall(date_range, trucks_id, 'singel_truck');
        });
    }
});
</script>
@endsection

@section('selectTruck')
<!-- Delete-->
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="largeModalLabel">Warning</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form method="post" id="deleteForm">
            @csrf
            <div class="modal-body">
                <p>Please select the truck </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </form>
    </div>
<!-- end modal large -->
@endsection