<!-- [ Main Content ] start -->
<div class="pc-container">
    <div class="pc-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0"><?php echo dashboard_lang;?></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->


        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12 col-xl-12">
                                <h5><?php echo dashboard_desc1_lang;?></h5>
                                <div><?php echo dashboard_desc2_lang;?></div>
                                <div><?php echo dashboard_desc3_lang;?></div><br>
                                <div class="bg-light-danger f-12 p-3"><?php echo dashboard_desc4_lang;?></div><br>
                                <div class="bg-light-primary f-12 mt-2 p-3"><?php echo dashboard_desc5_lang;?></div>
                                <div class="row">
                                    <div class=" col-lg-3 bg-body p-3 rounded mt-2" style="margin-right: 4px;margin-left: 4px">
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="flex-grow-1 ms-2">
                                                <p class="mb-0">TRX <a href="javascript:void(0)" data-clipboard="true" data-clipboard-text="TYQraQ5JJXKyVD6BpTGoDYNhiLbFRfzVtV">copy</a>
                                                </p>

                                            </div>
                                        </div>
                                        <div class="mb-0 f-12">TYQraQ5JJXKyVD6BpTGoDYNhiLbFRfzVtV</div>
                                    </div>
                                    <div class=" col-lg-4 bg-body p-3 rounded mt-2"  style="margin-right: 4px;margin-left: 4px">
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="flex-grow-1 ms-2">
                                                <p class="mb-0">ETH <a href="javascript:void(0)" data-clipboard="true" data-clipboard-text="0x6cc08b2057EfAe4d76Af531e145DeEd4B73c9D7e">copy</a>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="mb-0 f-12">0x6cc08b2057EfAe4d76Af531e145DeEd4B73c9D7e</div>
                                    </div>
                                    <div class=" col-lg-4 bg-body p-3 rounded mt-2"  style="margin-right: 4px;margin-left: 4px">
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="flex-grow-1 ms-2">
                                                <p class="mb-0">Litecoin <a href="javascript:void(0)" data-clipboard="true" data-clipboard-text="ltc1q6gq4espx74lp6jvhmr0jmxlu4al0uwemmzwdv4">copy</a>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="mb-0 f-12">ltc1q6gq4espx74lp6jvhmr0jmxlu4al0uwemmzwdv4</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
                series: [<?php echo $data['single']['cpu_free'];?>],
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
                series: [<?php echo $data['single']['ram_free'];?>],
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
                series: [<?php echo $data['single']['disk_free'];?>],
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
