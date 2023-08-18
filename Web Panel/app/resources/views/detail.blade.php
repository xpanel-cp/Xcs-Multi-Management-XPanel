<!DOCTYPE html>
<html lang="fa-IR" class="no-js">

<meta http-equiv="content-type" content="text/html;charset=UTF-8"/>
<meta name="robots" content="noindex, nofollow">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Detail Account</title>
    <!-- [Meta] -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- [Favicon] icon -->
    <link rel="icon" href="/assets/images/xlogo.png" type="image/x-icon">
    <!-- [Font] Family -->
    <link rel="stylesheet" href="/assets/fonts/inter/inter.css" id="main-font-link" />

    <!-- [Tabler Icons] https://tablericons.com -->
    <link rel="stylesheet" href="/assets/fonts/tabler-icons.min.css" />
    <!-- [Feather Icons] https://feathericons.com -->
    <link rel="stylesheet" href="/assets/fonts/feather.css" />
    <!-- [Font Awesome Icons] https://fontawesome.com/icons -->
    <link rel="stylesheet" href="/assets/fonts/fontawesome.css" />
    <!-- [Material Icons] https://fonts.google.com/icons -->
    <link rel="stylesheet" href="/assets/fonts/material.css" />
    <!-- [Template CSS Files] -->
    <link rel="stylesheet" href="/assets/css/style-en-us.css" id="main-style-link" />
    <link rel="stylesheet" href="/assets/css/style-preset.css" />
    <link rel="stylesheet" href="/assets/css/persian-datepicker.css"/>
</head>
<body>
@if(!empty(session('success')))
    <div class="p-4 mb-2" style="position: fixed;z-index: 9999;left: 0;">
        <div class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">{{ session('success') }} </div>
        </div>
    </div>
@endif
<!-- [ Pre-loader ] start -->
<div class="loader-bg">
    <div class="loader-track">
        <div class="loader-fill"></div>
    </div>
</div>

<div style="padding: 20px">
    <div class="pc-content">

        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- [ sample-page ] start -->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body py-0">
                        <ul class="nav nav-tabs profile-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="profile-tab-1" data-bs-toggle="tab" href="#profile-1" role="tab" aria-selected="true">
                                    <i class="ti ti-user me-2"></i>Detail Account
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="tab-content">
                    <div class="tab-pane show active" id="profile-1" role="tabpanel" aria-labelledby="profile-tab-1">
                        <div class="row">
                            <div class="col-lg-4 col-xxl-3">
                                <div class="card">
                                    <div class="card-body position-relative">
                                        @if ($user[0]->traffic > 0)
                                            @if (1024 <= $user[0]->traffic)
                                                @php
                                                    $trafficValue = floatval($user[0]->traffic);
                                                    $traffic_user = round($trafficValue / 1024,3) . ' GB';
                                                @endphp
                                            @else
                                                @php
                                                    $traffic_user = $user[0]->traffic . ' MB';
                                                @endphp
                                            @endif
                                        @else
                                            @php
                                                $traffic_user = 'Unlimited';
                                            @endphp
                                        @endif
                                            @foreach($user[0]->traffics as $traffic)
                                                @if (1024 <= $traffic->total)

                                                    @php
                                                        $trafficValue = floatval($traffic->total);
                                                        $total = round($trafficValue / 1024, 3) . ' GB';  @endphp
                                                @else
                                                    @php $total = $traffic->total . ' MB'; @endphp
                                                @endif
                                            @endforeach

                                            @if($user[0]->multiuser>0)
                                             @php
                                             $limitc=$user[0]->multiuser;
                                             @endphp
                                            @else
                                                @php
                                                    $limitc='Unlimited';
                                                @endphp
                                            @endif
                                            @if ($user[0]->status == "active" or $user[0]->status == "true")
                                                @php $status = "<span class='badge bg-light-success rounded-pill f-12'>Active</span>"; @endphp
                                            @endif
                                            @if ($user[0]->status == "deactive" or $user[0]->status == "false")
                                                @php $status = "<span class='badge bg-light-danger rounded-pill f-12'>Deactive</span>"; @endphp
                                            @endif
                                            @if ($user[0]->status == "expired")
                                                @php $status = "<span class='badge bg-light-warning rounded-pill f-12'>Expired</span>"; @endphp
                                            @endif
                                            @if ($user[0]->status == "traffic")
                                                @php $status = "<span class='badge bg-light-primary rounded-pill f-12'>Traffic</span>"; @endphp
                                            @endif
                                            <div class="position-absolute end-0 top-0 p-3">
                                                {!! $status !!}
                                            </div>
                                        <div class="text-center mt-3">
                                            <h5 class="mb-0">{{$user[0]->username}}</h5>
                                            <p class="text-muted text-sm">Account Username</p>
                                            <hr class="my-3 border border-secondary-subtle">
                                            <div class="row g-3">
                                                <div class="col-4">
                                                    <h5 class="mb-0">{{$traffic_user}}</h5>
                                                    <small class="text-muted">Traffic</small>
                                                </div>
                                                <div class="col-4 border border-top-0 border-bottom-0">
                                                    <h5 class="mb-0">{{$total}}</h5>
                                                    <small class="text-muted">Traffic Usage</small>
                                                </div>
                                                <div class="col-4">
                                                    <h5 class="mb-0">{{$limitc}}</h5>
                                                    <small class="text-muted">Limit Connection</small>
                                                </div>
                                            </div>
                                            <hr class="my-3 border border-secondary-subtle">
                                            <div class="d-inline-flex align-items-center justify-content-start w-100 mb-3">
                                                <i class="ti ti-user me-2"></i>
                                                <p class="mb-0">Username: {{$user[0]->username}}</p>
                                            </div>
                                            <div class="d-inline-flex align-items-center justify-content-start w-100 mb-3">
                                                <i class="ti ti-key me-2"></i>
                                                <p class="mb-0">Password: {{$user[0]->password}}</p>
                                            </div>
                                            @foreach($user[0]->servers as $server)
                                                @php
                                                    $link=explode('://',$server->link);
                                                    $link=explode(':',$link[1]);
                                                @endphp

                                                <div class="d-inline-flex align-items-center justify-content-start w-100 mb-3">
                                                    <i class="ti ti-server me-2"></i>
                                                    <p class="mb-0">Server: {{$link[0]}}</p>
                                                </div>
                                                <div class="d-inline-flex align-items-center justify-content-start w-100 mb-3">
                                                    <i class="ti ti-server me-2"></i>
                                                    <p class="mb-0">Port: {{$server->port_connection}}</p>
                                                </div>
                                            <div class="d-inline-flex align-items-center justify-content-start w-100">
                                                <i class="ti ti-server me-2"></i>
                                                    <p class="mb-0">Port Tls: {{$server->port_connection_tls}}</p>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header">
                                        <h5>Change Server ( @foreach($user[0]->servers as $server)  {{$server->name}} @endforeach )</h5>
                                    </div>
                                    <form class="modal-content" action="{{ route('update', ['key' => $key_org]) }}" method="POST" enctype="multipart/form-data"
                                          onsubmit="return confirm('Are you sure you want to perform this operation?');">

                                        <div class="modal-body" style="padding: 9px">
                                            <div class="form-group row">
                                                <div class="col-lg-6">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="input-group">

                                                                @csrf
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="input-group">
                                                                <select name="serverid" class="form-select">
                                                                    <option value="">Selected</option>
                                                                    @foreach ($servers as $server)
                                                                        <option value="{{$server->id}}">{{$server->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-between" style="padding: 9px">
                                            <div class="flex-grow-1 text-end">
                                                <button type="submit" class="btn btn-primary" value="submit"
                                                        name="renewal_date">Change</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-lg-8 col-xxl-9">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Config</h5>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item px-0 pt-0">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <p class="mb-1 text-muted" style="margin-left: 30px;">SSH-DIRECT</p>
                                                        @foreach($user[0]->servers as $server) @php $at="@"; $sharp='#'; $link=explode('://',$server->link); $link=explode(':',$link[1]);@endphp
                                                        <p class="mb-0"><img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=ssh://{{$user[0]->username}}:{{$user[0]->password}}{{$at}}{{$link[0]}}:{{$server->port_connection}}/{{$sharp}}{{$user[0]->username}}" title="SSH-DIRECT" /></p>
                                                        @endforeach
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p class="mb-1 text-muted" style="margin-left: 30px;">SSH-TLS</p>
                                                        @foreach($user[0]->servers as $server) @php $at="@"; $sharp='#'; $link=explode('://',$server->link); $link=explode(':',$link[1]);@endphp
                                                        <p class="mb-0"><img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=ssh://{{$user[0]->username}}:{{$user[0]->password}}{{$at}}{{$link[0]}}:{{$server->port_connection_tls}}/{{$sharp}}{{$user[0]->username}}" title="SSH-TLS" /></p>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item px-0">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <button class="btn btn-link-primary"
                                                           data-clipboard="true"
                                                           data-clipboard-text="@foreach($user[0]->servers as $server) @php $link=explode('://',$server->link); $link=explode(':',$link[1]); @endphp ssh://{{$user[0]->username}}:{{$user[0]->password}}{{$at}}{{$link[0]}}:{{$server->port_connection}}/#{{$user[0]->username}} @endforeach">Copy Link SSH
                                                        </button>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <button class="btn btn-link-primary"
                                                                data-clipboard="true"
                                                                data-clipboard-text="@foreach($user[0]->servers as $server) @php $link=explode('://',$server->link); $link=explode(':',$link[1]); @endphp ssh://{{$user[0]->username}}:{{$user[0]->password}}{{$at}}{{$link[0]}}:{{$server->port_connection_tls}}/#{{$user[0]->username}} @endforeach">Copy Link SSH TLS
                                                        </button>
                                                    </div>
                                                </div>
                                            </li>
                                           </ul>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- [ sample-page ] end -->
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>

<footer class="pc-footer" style="margin-top:0px;">
    <div class="footer-wrapper container-fluid">
        <div class="row">
            <div class="col my-1">

            </div>
            <div class="col-auto my-1">
                <ul class="list-inline footer-link mb-0">
                    <li class="list-inline-item"><a href="https://github.com/xpanel-cp/XPanel-SSH-User-Management/">GitHub</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>

<!-- [Page Specific JS] start -->
<script src="/assets/js/plugins/apexcharts.min.js"></script>

<!-- [Page Specific JS] end -->
<!-- Required Js -->
<script src="/assets/js/plugins/popper.min.js"></script>
<script src="/assets/js/plugins/simplebar.min.js"></script>
<script src="/assets/js/plugins/bootstrap.min.js"></script>
<script src="/assets/js/fonts/custom-font.js"></script>
<script src="/assets/js/config.js?v=3.7.7"></script>
<script src="/assets/js/pcoded.js"></script>
<script src="/assets/js/plugins/feather.min.js"></script>
<!-- [Page Specific JS] start -->
<script src="/assets/js/plugins/simple-datatables-en-us.js"></script>
<script src="/assets/js/clipboard.min.js"></script>
<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
<script src="/assets/js/persian-date.js"></script>
<script src="/assets/js/persian-datepicker.js"></script>
<script src="https://code.jquery.com/jquery.min.js"></script>

<!-- [ Main Content ] end -->
<script type="text/javascript">
    $(document).on("click", ".qrs", function () {
        var eventId = $(this).data('id');
        var eventIdtls = $(this).data('tls');
        var qr = "<img src=\"https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=" + eventId + "&choe=UTF-8\" title=" + eventId + " />";
        var qrtls = "<img src=\"https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=" + eventIdtls + "&choe=UTF-8\" title=" + eventIdtls + " />";
        $('#idHolderSSH').html(qr);
        $('#idHolderTLS').html(qrtls);
    });
</script>
<script>

    // basic example
    new ClipboardJS('[data-clipboard=true]', function (){
       alert('kkkk');
    });
</script>

<!-- [Page Specific JS] end -->
</body>
<!-- [Body] end -->

</html>

</body>

</html>

