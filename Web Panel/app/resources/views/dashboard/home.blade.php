@extends('layouts.master')
@section('title','Xcs - Dahboard')
@section('content')
    @if(!empty(session('success')))
        <div class="p-4 mb-2" style="position: fixed;z-index: 9999;left: 0;">
            <div class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <img src="/assets/images/xlogo.png" class="img-fluid m-r-5" alt="Xcs" style="width: 17px">
                    <strong class="me-auto">Xcs</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">{{ session('success') }} </div>
            </div>
        </div>
    @endif

    @if(!empty(session('error')))
        <div class="p-4 mb-2" style="position: fixed;z-index: 9999;left: 0;">
            <div class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <img src="/assets/images/xlogo.png" class="img-fluid m-r-5" alt="Xcs" style="width: 17px">
                    <strong class="me-auto">Xcs</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body"><span style="color:red">{{ session('error') }}</span> </div>
            </div>
        </div>
    @endif
    <div class="pc-container">
        <div class="pc-content">
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0">Dashboard</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->


            <!-- [ Main Content ] start -->
            <div class="row">
                <div class="col-6 col-md-3 col-xxl-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="my-n4" style="width: 130px">
                                        <div id="total-earning-graph-cpu"></div>
                                    </div>
                                    <br>
                                    <h6 class="mb-1">Cpu Usage</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3 col-xxl-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="my-n4" style="width: 130px">
                                        <div id="total-earning-graph-ram"></div>
                                    </div>
                                    <br>
                                    <h6 class="mb-1">Ram Usage</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-md-3 col-xxl-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="my-n4" style="width: 130px">
                                        <div id="total-earning-graph-hard"></div>
                                    </div>
                                    <br>
                                    <h6 class="mb-1">Disk Usage</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-md-3 col-xxl-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="my-n4" style="width: 130px">
                                        <h5 style="margin-top: 10px; text-align: center;"><small>Client</small><br>{{$traffic_total}}</h5>
                                    </div>
                                    <br>
                                    <br>
                                    <h6 class="mb-1">Bandwidth Usage</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xxl-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="my-3">
                                <div id="overview-product-graph"></div>
                            </div>
                            <div class="row g-3 text-center">
                                <div class="col-6 col-lg-4 col-xxl-4">
                                    <div class="overview-product-legends">
                                        <p class="text-dark mb-1"><span>Active User</span></p>
                                        <h6 class="mb-0">{{$active_user}}</h6>
                                    </div>
                                </div>
                                <div class="col-6 col-lg-4 col-xxl-4">
                                    <div class="overview-product-legends">
                                        <p class="text-dark mb-1"><span>Deactive User</span></p>
                                        <h6 class="mb-0">{{$deactive_user}}</h6>
                                    </div>
                                </div>
                                <div class="col-6 col-lg-4 col-xxl-4">
                                    <div class="overview-product-legends">
                                        <p class="text-secondary mb-1"><span>Online User</span></p>
                                        <h6 class="mb-0">{{$online_user}}</h6>
                                    </div>
                                </div>
                                <h6>All User: {{$alluser}}</h6>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
            <div class="row">
                <!-- [ sample-page ] start -->
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Support Us ♥</h5>
                            <small>حمایت از ما ♥</small>
                        </div>
                        <div class="card-body">
                            <p>Your support has brought us joy and enhances the development process.</p>
                            <p>The development of this web application has been free, and the support we receive is entirely voluntary.</p>
                            <p>Those who generate income from this panel can choose to donate a small percentage of their monthly earnings to contribute to the panel's development.
                            </p>
                            <small style="direction: rtl;text-align: right">
                                <p>حمایت شما باعث دلگرمی ما شده و روند توسعه را بهبود می بخشد</p>
                                <p>توسعه  این وب اپلیکیشن رایگان بوده و حمایت هایی که از ما صورت می گیرد کاملا دلی می باشد</p>
                                <p>عزیزانی که از این پنل کسب درآمد دارند می توانند تنها درصدی از درآمد ماهانه خود را برای توسعه پنل دونیت نمایند</p>
                            </small>
                            <br>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item px-0 pt-0">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <p class="mb-1 text-muted">TRX</p>
                                                <p class="mb-0">TYQraQ5JJXKyVD6BpTGoDYNhiLbFRfzVtV</p>
                                            </div>
                                            <div class="col-md-4">
                                                <p class="mb-1 text-muted">ETH</p>
                                                <p class="mb-0">0x6cc08b2057EfAe4d76Af531e145DeEd4B73c9D7e</p>
                                            </div>
                                            <div class="col-md-4">
                                                <p class="mb-1 text-muted">Litecoin</p>
                                                <p class="mb-0">ltc1q6gq4espx74lp6jvhmr0jmxlu4al0uwemmzwdv4</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item px-0">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <p class="mb-1 text-muted"><img src="/assets/images/trx.jpg" alt="trx" style="width:300px"></p>
                                                <p class="mb-0"><a href="https://link.trustwallet.com/send?coin=195&address=TYQraQ5JJXKyVD6BpTGoDYNhiLbFRfzVtV" target="_blank">Pay me via Trust Wallet</a> </p>
                                            </div>
                                            <div class="col-md-4">
                                                <p class="mb-1 text-muted"><img src="/assets/images/eth.jpg" alt="eth" style="width:300px"></p>
                                                <p class="mb-0"><a href="https://link.trustwallet.com/send?coin=60&address=0x6cc08b2057EfAe4d76Af531e145DeEd4B73c9D7e" target="_blank">Pay me via Trust Wallet</a> </p>

                                            </div>
                                            <div class="col-md-4">
                                                <p class="mb-1 text-muted"><img src="/assets/images/ltc.jpg" alt="ltc" style="width:300px"></p>
                                                <p class="mb-0"><a href="https://link.trustwallet.com/send?coin=2&address=ltc1q6gq4espx74lp6jvhmr0jmxlu4al0uwemmzwdv4" target="_blank">Pay me via Trust Wallet</a> </p>

                                            </div>
                                        </div>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- [ sample-page ] end -->
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>
    <!-- [ Main Content ] end -->
    <script>
        'use strict';
        document.addEventListener('DOMContentLoaded', function () {
            setTimeout(function () {
                floatchart();
            }, 500);
        });

        function floatchart() {
            (function () {
                var options = {
                    chart: { type: 'bar', height: 80, sparkline: { enabled: true } },
                    colors: ['#4680FF'],
                    plotOptions: { bar: { columnWidth: '80%' } },
                    series: [
                        {
                            data: [
                                10, 30, 40, 20, 60, 50, 20, 15, 20, 25, 30, 25
                            ]
                        }
                    ],
                    xaxis: { crosshairs: { width: 1 } },
                    tooltip: {
                        fixed: { enabled: false },
                        x: { show: false },
                        y: {
                            title: {
                                formatter: function (seriesName) {
                                    return '';
                                }
                            }
                        },
                        marker: { show: false }
                    }
                };
                var chart = new ApexCharts(document.querySelector("#total-earning-graph-1"), options);
                chart.render();
            })();
            (function () {
                var options = {
                    series: [{{$cpu_free}}],
                    chart: {
                        height: 150,
                        type: 'radialBar',
                    },
                    plotOptions: {
                        radialBar: {
                            hollow: {
                                margin: 0,
                                size: '60%',
                                background: 'transparent',
                                imageOffsetX: 0,
                                imageOffsetY: 0,
                                position: 'front',
                            },
                            track: {
                                background: '#DC262650',
                                strokeWidth: '50%',
                            },

                            dataLabels: {
                                show: true,
                                name: {
                                    show: false,
                                },
                                value: {
                                    formatter: function (val) {
                                        return parseInt(val);
                                    },
                                    offsetY: 7,
                                    color: '#DC2626',
                                    fontSize: '20px',
                                    fontWeight: '700',
                                    show: true,
                                }
                            }
                        }
                    },
                    colors: ['#DC2626'],
                    fill: {
                        type: 'solid',
                    },
                    stroke: {
                        lineCap: 'round'
                    },
                };
                var chart = new ApexCharts(document.querySelector("#total-earning-graph-cpu"), options);
                chart.render();
            })();
            (function () {
                var options = {
                    series: [{{$ram_free}}],
                    chart: {
                        height: 150,
                        type: 'radialBar',
                    },
                    plotOptions: {
                        radialBar: {
                            hollow: {
                                margin: 0,
                                size: '60%',
                                background: 'transparent',
                                imageOffsetX: 0,
                                imageOffsetY: 0,
                                position: 'front',
                            },
                            track: {
                                background: '#DC262650',
                                strokeWidth: '50%',
                            },

                            dataLabels: {
                                show: true,
                                name: {
                                    show: false,
                                },
                                value: {
                                    formatter: function (val) {
                                        return parseInt(val);
                                    },
                                    offsetY: 7,
                                    color: '#DC2626',
                                    fontSize: '20px',
                                    fontWeight: '700',
                                    show: true,
                                }
                            }
                        }
                    },
                    colors: ['#DC2626'],
                    fill: {
                        type: 'solid',
                    },
                    stroke: {
                        lineCap: 'round'
                    },
                };
                var chart = new ApexCharts(document.querySelector("#total-earning-graph-ram"), options);
                chart.render();
            })();
            (function () {
                var options = {
                    series: [{{$disk_free}}],
                    chart: {
                        height: 150,
                        type: 'radialBar',
                    },
                    plotOptions: {
                        radialBar: {
                            hollow: {
                                margin: 0,
                                size: '60%',
                                background: 'transparent',
                                imageOffsetX: 0,
                                imageOffsetY: 0,
                                position: 'front',
                            },
                            track: {
                                background: '#DC262650',
                                strokeWidth: '50%',
                            },

                            dataLabels: {
                                show: true,
                                name: {
                                    show: false,
                                },
                                value: {
                                    formatter: function (val) {
                                        return parseInt(val);
                                    },
                                    offsetY: 7,
                                    color: '#DC2626',
                                    fontSize: '20px',
                                    fontWeight: '700',
                                    show: true,
                                }
                            }
                        }
                    },
                    colors: ['#DC2626'],
                    fill: {
                        type: 'solid',
                    },
                    stroke: {
                        lineCap: 'round'
                    },
                };
                var chart = new ApexCharts(document.querySelector("#total-earning-graph-hard"), options);
                chart.render();
            })();
            (function () {
                var options = {
                    series: [45],
                    chart: {
                        height: 150,
                        type: 'radialBar',
                    },
                    plotOptions: {
                        radialBar: {
                            hollow: {
                                margin: 0,
                                size: '60%',
                                background: 'transparent',
                                imageOffsetX: 0,
                                imageOffsetY: 0,
                                position: 'front',
                            },
                            track: {
                                background: '#DC262650',
                                strokeWidth: '50%',
                            },

                            dataLabels: {
                                show: true,
                                name: {
                                    show: false,
                                },
                                value: {
                                    formatter: function (val) {
                                        return parseInt(val);
                                    },
                                    offsetY: 7,
                                    color: '#DC2626',
                                    fontSize: '20px',
                                    fontWeight: '700',
                                    show: true,
                                }
                            }
                        }
                    },
                    colors: ['#DC2626'],
                    fill: {
                        type: 'solid',
                    },
                    stroke: {
                        lineCap: 'round'
                    },
                };
                var chart = new ApexCharts(document.querySelector("#total-earning-graph-band"), options);
                chart.render();
            })();
            (function () {
                var options = {
                    series: [30],
                    chart: {
                        height: 150,
                        type: 'radialBar',
                    },
                    plotOptions: {
                        radialBar: {
                            hollow: {
                                margin: 0,
                                size: '60%',
                                background: 'transparent',
                                imageOffsetX: 0,
                                imageOffsetY: 0,
                                position: 'front',
                            },
                            track: {
                                background: '#DC262650',
                                strokeWidth: '50%',
                            },

                            dataLabels: {
                                show: true,
                                name: {
                                    show: false,
                                },
                                value: {
                                    formatter: function (val) {
                                        return parseInt(val);
                                    },
                                    offsetY: 7,
                                    color: '#DC2626',
                                    fontSize: '20px',
                                    fontWeight: '700',
                                    show: true,
                                }
                            }
                        }
                    },
                    colors: ['#DC2626'],
                    fill: {
                        type: 'solid',
                    },
                    stroke: {
                        lineCap: 'round'
                    },
                };
                var chart = new ApexCharts(document.querySelector("#total-earning-graph-2"), options);
                chart.render();
            })();
        }

    </script>
@endsection
