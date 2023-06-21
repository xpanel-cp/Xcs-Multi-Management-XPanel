<!-- [ Main Content ] start -->
<?php
$json = file_get_contents('https://raw.githubusercontent.com/Alirezad07/X-Panel-SSH-User-Management/main/version.json');
$obj = json_decode($json);
if(LANG=='fa-ir'){$github='https://github.com/Alirezad07/X-Panel-SSH-User-Management#%D9%86%D8%B5%D8%A8';}
else {$github='https://github.com/Alirezad07/X-Panel-SSH-User-Management/blob/main/README-EN.md#installation-guide';}
if($obj->last_version>34) {
    echo '
            <div class="p-4 mb-2" style="position: fixed;z-index: 9999;left: 0;">
              <div class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                  <img src="' . path . 'assets/images/xlogo.png" class="img-fluid m-r-5" alt="XPanel" style="width: 17px">
                  <strong class="me-auto">XPanel</strong>
                  <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">' . confirm_last_version_lang . ' <a href="'.$github.'" target="_blank">Github</a> </div>
              </div>
            </div>';
}
?>
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
            <div class="col-6 col-md-3 col-xxl-2">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="my-n4" style="width: 130px">
                                    <div id="total-earning-graph-cpu"></div>
                                </div>
                                <br>
                                <h6 class="mb-1"><?php echo cpu_usage_lang;?></h6>
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
                                <h6 class="mb-1"><?php echo ram_usage_lang;?></h6>
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
                                <h6 class="mb-1"><?php echo disk_usage_lang;?></h6>
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
                                    <h5 style="margin-top: 10px; text-align: center;"><small>Server</small><br><?php echo $data['single']['total'];?></h5>
                                    <h5 style="margin-top: 10px; text-align: center;"><small>Client</small><br><?php echo $data['single']['traffic_total'];?></h5>
                                </div>
                                <br>
                                <br>
                                <h6 class="mb-1"><?php echo bandwidth_usage_lang;?></h6>
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
                                    <p class="text-dark mb-1"><span><?php echo active_user_lang;?></span></p>
                                    <h6 class="mb-0"><?php echo $data['single']['active_user'];?></h6>
                                </div>
                            </div>
                            <div class="col-6 col-lg-4 col-xxl-4">
                                <div class="overview-product-legends">
                                    <p class="text-dark mb-1"><span><?php echo deactive_user_lang;?></span></p>
                                    <h6 class="mb-0"><?php echo $data['single']['deactive_user'];?></h6>
                                </div>
                            </div>
                            <div class="col-6 col-lg-4 col-xxl-4">
                                <div class="overview-product-legends">
                                    <p class="text-secondary mb-1"><span><?php echo online_user_lang;?></span></p>
                                    <h6 class="mb-0"><?php echo substr_count($data['single']['online_user'], "\n");?></h6>
                                </div>
                            </div>
                            <h6><?php echo all_users_lang;?>: <?php echo $data['single']['all_user'];?></h6>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-header pb-0 pt-2">
                        <?php echo high_consumption_lang;?>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12 col-xl-12">
                                <ul class="list-group list-group-flush">
                                    <?php
                                    foreach ($data['for'] as $datum) {

                                        if (1024 < $datum["total"]) {
                                            $to = round($datum["total"] / 1024, 2) .' '.gib_lang;
                                        } else {
                                            $to = $datum["total"] .' '.mib_lang;
                                        }
                                        if(!empty($datum['finishdate'])) {
                                            $finishdate = explode('-', $datum['finishdate']);
                                            $finishdate = gregorian_to_jalali($finishdate[0], $finishdate[1], $finishdate[2]);
                                            if ($finishdate[2] >= 10) {
                                                $finishday = $finishdate[2];
                                            } else {
                                                $finishday = '0' . $finishdate[2];
                                            }
                                            if ($finishdate[1] >= 10) {
                                                $finishmon = $finishdate[1];
                                            } else {
                                                $finishmon = '0' . $finishdate[1];
                                            }
                                            $finishdate = $finishday . '-' . $finishmon . '-' . $finishdate[0];
                                        } else {$finishdate='';}

                                        ?>
                                        <li class="list-group-item">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <div class="avtar avtar-s bg-light-secondary">
                                                        <i class="ti ti-chart-bar f-20"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <div class="row g-1">
                                                        <div class="col-6">
                                                            <p class="text-muted mb-1"><?php echo $datum['user'];?></p>
                                                            <h6 class="mb-0"><?php echo expiration_lang;?>: <?php echo $finishdate;?></h6>
                                                        </div>
                                                        <div class="col-6 text-end">
                                                            <h6 class="mb-1"><?php echo $to;?></h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    <?php }?>
                                </ul>
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
