@extends('layouts.master')

@section('content')
<div class="content-header row align-items-center m-0">
        <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
            <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
                <li class="breadcrumb-item"><a href="#"><i class="hvr-buzz-out fas fa-home"></i></a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
        <div class="col-sm-8 header-title p-0">
            <div class="media">
                <div class="header-icon text-success mr-3"><i class="hvr-buzz-out fas fa-tachometer-alt"></i></div>
                <div class="media-body">
                    <h1 class="font-weight-bold">Dashboard</h1>
                    <small></small>
                </div>
            </div>
        </div>
    </div>
    <!--/.Content Header (Page header)--> 
    <div class="body-content">
        <div class="row">
            <div class="col-md-12">
                @php
                    $vehicle_array = $vehicle_data_array = array();
                    foreach ($vehicles_data as $vehicle) {                        
                        array_push($vehicle_array, $vehicle->number);
                        $vehicle_mod = $vehicle->unloadings();
                        if($period != '') {
                            $from = substr($period, 0, 10);
                            $to = substr($period, 14, 10);
                            $period_range = [$from, $to];
                            $vehicle_mod = $vehicle_mod->whereBetween('unloading_date', $period_range);
                        }
                        $vehicle_amount = $vehicle_mod->sum('amount');
                        array_push($vehicle_data_array, $vehicle_amount);
                    }
                @endphp
                <div class="card">
                    <div class="card-header clearfix">
                        <h4 class="float-left"><i class="fas fa-truck mr-1"></i>Fuel Consumtion</h4>
                        <form action="" method="POST" class="form-inline float-right" id="searchForm">
                            @csrf
                            <input type="text" name="period" class="form-control form-control-sm daterange ml-md-2 mb-2 mb-md-0" id="search_period" value="{{$period}}" style="min-width:200px;" placeholder="Unloading Date" autocomplete="off" />
                            <button type="submit" class="btn btn-sm btn-primary ml-md-2 mb-2 mb-md-0"><i class="fa fa-search"></i>&nbsp;&nbsp;Search</button>
                            <button type="button" class="btn btn-sm btn-info mb-2 mb-md-0 ml-2" id="btn-reset"><i class="fa fa-eraser"></i>&nbsp;&nbsp;Reset</button>
                        </form>
                    </div>
                    <div class="card-body">
                        <div id="vehicle_chart" style="width: 100%; height:500px;""></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript" src="{{asset('master/plugins/echarts/echarts-en.js')}}"></script>
    <script src="{{asset('master/plugins/daterangepicker/jquery.daterangepicker.min.js')}}"></script>
    <script>
        
        var dashboardCharts = function() {

            var vehicle_chart = function() {
                if (typeof echarts == 'undefined') {
                    console.warn('Warning - echarts.min.js is not loaded.');
                    return;
                }

                // Define elements
                var vehicle_element = document.getElementById('vehicle_chart');

                // Basic columns chart
                if (vehicle_element) {

                    // Initialize chart
                    var columns_vehicle = echarts.init(vehicle_element);

                    // Options
                    columns_vehicle.setOption({

                        // Define colors
                        color: ['#2ec7c9','#b6a2de','#5ab1ef','#ffb980','#d87a80'],

                        // Global text styles
                        textStyle: {
                            fontFamily: 'Roboto, Arial, Verdana, sans-serif',
                            fontSize: 13
                        },

                        // Chart animation duration
                        animationDuration: 750,

                        // Setup grid
                        grid: {
                            left: 0,
                            right: 40,
                            top: 35,
                            bottom: 0,
                            containLabel: true
                        },
                        
                        // legend: {
                        //     data: ['expense', 'incoming'],
                        //     itemHeight: 8,
                        //     itemGap: 20,
                        //     textStyle: {
                        //         padding: [0, 5]
                        //     }
                        // },

                        // Add tooltip
                        tooltip: {
                            trigger: 'axis',
                            backgroundColor: 'rgba(0,0,0,0.75)',
                            padding: [10, 15],
                            textStyle: {
                                fontSize: 13,
                                fontFamily: 'Roboto, sans-serif'
                            }
                        },

                        // Horizontal axis
                        xAxis: [{
                            type: 'category',
                            data: {!! json_encode($vehicle_array) !!},
                            axisLabel: {
                                color: '#333'
                            },
                            axisLine: {
                                lineStyle: {
                                    color: '#999'
                                }
                            },
                            splitLine: {
                                show: true,
                                lineStyle: {
                                    color: '#eee',
                                    type: 'dashed'
                                }
                            }
                        }],

                        // Vertical axis
                        yAxis: [{
                            type: 'value',
                            axisLabel: {
                                color: '#333'
                            },
                            axisLine: {
                                lineStyle: {
                                    color: '#999'
                                }
                            },
                            splitLine: {
                                lineStyle: {
                                    color: ['#eee']
                                }
                            },
                            splitArea: {
                                show: true,
                                areaStyle: {
                                    color: ['rgba(250,250,250,0.1)', 'rgba(0,0,0,0.01)']
                                }
                            }
                        }],

                        // Add series
                        series: [
                            {
                                type: 'bar',
                                data: {!! json_encode($vehicle_data_array) !!},
                                itemStyle: {
                                    normal: {
                                        label: {
                                            show: true,
                                            position: 'top',
                                            textStyle: {
                                                fontWeight: 500
                                            }
                                        }
                                    }
                                },
                                markLine: {
                                    data: [{type: 'average', name: 'Average'}]
                                }
                            }
                        ]
                    });
                }

                var triggerChartResize = function() {
                    vehicle_element && columns_vehicle.resize();
                };

                // On sidebar width change
                $(document).on('click', '.sidebar-control', function() {
                    setTimeout(function () {
                        triggerChartResize();
                    }, 0);
                });

                // On window resize
                var resizeCharts;
                window.onresize = function () {
                    clearTimeout(resizeCharts);
                    resizeCharts = setTimeout(function () {
                        triggerChartResize();
                    }, 200);
                };
            };

            return {
                init: function() {
                    vehicle_chart();
                }
            }
        }();

        document.addEventListener('DOMContentLoaded', function() {
            dashboardCharts.init();
        });
    </script>
    <script>
        $("#search_period").dateRangePicker({
            format: 'YYYY-MM-DD',
            autoClose: false,
        });
        $("#btn-reset").click(function(){
            $("#search_period").val('');
        })
    </script>
@endsection
