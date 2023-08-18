@extends('layouts.master')
@section('title','Xcs - Users')
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
    <!-- [ Main Content ] start -->
    <div class="pc-container">
        <div class="pc-content">
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0">Users</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->


            <!-- [ Main Content ] start -->
            <div class="row">
                <!-- [ sample-page ] start -->
                <div class="col-sm-12">
                    <div class="card table-card">
                        <div class="card-body">
                            <form action="{{route('user.delete.bulk')}}" method="post" enctype="multipart/form-data">
                                @csrf

                                <div class="text-end p-4 pb-0">
                                    <a href="javascript:void(0);" class="btn btn-primary d-inline-flex align-items-center"
                                       style="margin-bottom: 5px;" data-bs-toggle="modal" data-bs-target="#customer_add-modal">
                                        <i class="ti ti-plus f-18"></i>New User
                                    </a>

                                    <button type="submit" class="btn btn-danger d-inline-flex align-items-center"
                                            value="delete" name="delete">Delete
                                    </button>
                                </div>


                                <div class="table-responsive">
                                    <table class="table table-hover" id="pc-dt-simple">
                                        <thead>
                                        <tr>
                                            <th>#ID</th>
                                            <th>Server</th>
                                            <th>Customer</th>
                                            <th>Username</th>
                                            <th>Password</th>
                                            <th>Traffic</th>
                                            <th>Limit User</th>
                                            <th>Contacts</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php
                                            $uid = 0;
                                        @endphp
                                        @foreach ($users as $user)
                                            @php
                                                $uid++
                                            @endphp
                                            @if ($user->traffic > 0)
                                                @if (1024 <= $user->traffic)
                                                    @php
                                                        $trafficValue = floatval($user->traffic);
                                                        $traffic_user = round($trafficValue / 1024,3) . ' GB';
                                                    @endphp
                                                @else
                                                    @php
                                                        $traffic_user = $user->traffic . ' MB';
                                                    @endphp
                                                @endif
                                            @else
                                                @php
                                                    $traffic_user = 'Unlimited';
                                                @endphp
                                            @endif

                                            @foreach($user->traffics as $traffic)
                                                @if (1024 <= $traffic->total)

                                                    @php
                                                        $trafficValue = floatval($traffic->total);
                                                        $total = round($trafficValue / 1024, 3) . ' GB';  @endphp
                                                @else
                                                    @php $total = $traffic->total . ' MB'; @endphp
                                                @endif
                                            @endforeach

                                            @if ($user->status == "active" or $user->status == "true")
                                                @php $status = "<span class='badge bg-light-success rounded-pill f-12'>Active</span>"; @endphp
                                            @endif
                                            @if ($user->status == "deactive" or $user->status == "false")
                                                @php $status = "<span class='badge bg-light-danger rounded-pill f-12'>Deactive</span>"; @endphp
                                            @endif
                                            @if ($user->status == "expired")
                                                @php $status = "<span class='badge bg-light-warning rounded-pill f-12'>Expired</span>"; @endphp
                                            @endif
                                            @if ($user->status == "traffic")
                                                @php $status = "<span class='badge bg-light-primary rounded-pill f-12'>Traffic</span>"; @endphp
                                            @endif
                                            @if (empty($user->customer_user) OR $user->customer_user=='NULL')
                                                @php $customer_user = env('DB_USERNAME'); @endphp
                                            @else
                                                @php $customer_user = $user->customer_user; @endphp
                                            @endif

                                            @if (empty($settings->tls_port) || $settings->tls_port == 'NULL')
                                                @php $tls_port = '444'; @endphp
                                            @else
                                                @php $tls_port=$settings->tls_port; @endphp
                                            @endif
                                            @if (empty($user->start_date) || $user->start_date == 'NULL')
                                                @php $startdate = ''; @endphp
                                            @else
                                                @php $startdate=$user->start_date; @endphp
                                            @endif
                                            @if (empty($user->end_date) || $user->end_date == 'NULL')
                                                @php $finishdate = ''; @endphp
                                            @else
                                                @php $finishdate=$user->end_date; @endphp
                                            @endif


                                            <tr>
                                                <td><input name="usernamed[]" id="checkItem" type="checkbox"
                                                           class="checkItem form-check-input"
                                                           value="{{$user->username}}"/> {{$uid}}
                                                </td>
                                                <td>

                                                        @foreach($user->servers as $server)
                                                            {{$server->name}}
                                                        @endforeach
                                                   <br> <small>
                                                        @foreach($user->packages as $package)
                                                                Pack: {{$package->title}}
                                                        @endforeach
                                                    </small>
                                                </td>
                                                <td>{{$customer_user}}</td>
                                                <td>{{$user->username}}</td>
                                                <td>{{$user->password}}</td>
                                                <td>{{$traffic_user}}
                                                    <br>
                                                    <small>

                                                <span
                                                    style="background: #4a9afe; padding: 2px; color: #fff; border-radius: 5px;"><i
                                                        class="ti ti-cloud-download"></i> {{$total}}</span>
                                                    </small></td>
                                                <td>{{$user->multiuser}}</td>
                                                <td>{{$user->mobile}}<br>
                                                    <small>{{$user->email}}</small></td>
                                                <td><small>
                                                        Register: {{$startdate}}
                                                        <br>
                                                        Expired: {{$finishdate}}
                                                    </small></td>
                                                <td>{!! $status !!}</td>
                                                <td class="text-center">
                                                    <ul class="list-inline me-auto mb-0">
                                                        <li class="list-inline-item align-bottom">
                                                            <button class="avtar avtar-xs btn-link-success btn-pc-default"
                                                                    style="border:none" type="button"
                                                                    data-bs-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false"><i
                                                                    class="ti ti-adjustments f-18"></i></button>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item"
                                                                   href="{{ route('user.active', ['username' => $user->username]) }}">Active</a>
                                                                <a class="dropdown-item"
                                                                   href="{{ route('user.deactive', ['username' => $user->username]) }}">Deactive</a>
                                                                <a class="dropdown-item"
                                                                   href="{{ route('user.reset', ['username' => $user->username]) }}">Reset Traffic</a>
                                                                <a href="{{ route('user.edit', ['username' => $user->username]) }}"
                                                                   class="dropdown-item">
                                                                   Edit
                                                                </a>
                                                                <a class="dropdown-item"
                                                                   href="{{ route('user.delete', ['username' => $user->username]) }}">Delete</a>
                                                            </div>
                                                        </li>

                                                        <li class="list-inline-item align-bottom" data-bs-toggle="tooltip"
                                                            title="Change Server">
                                                            <a href="javascript:void(0);" data-user="{{$user->username}}" data-bs-toggle="modal"
                                                               data-bs-target="#server-modal"
                                                               class="re_user avtar avtar-xs btn-link-success btn-pc-default">
                                                                <i class="ti ti-server f-18"></i>
                                                            </a>
                                                        </li>
                                                        <li class="list-inline-item align-bottom" data-bs-toggle="tooltip"
                                                            title="Renewal">
                                                            <a href="{{ route('new.renewal.edit', ['username' => $user->username]) }}" class="re_user avtar avtar-xs btn-link-success btn-pc-default">
                                                                <i class="ti ti-calendar-plus f-18"></i>
                                                            </a>
                                                        </li>
                                                        <li class="list-inline-item align-bottom">
                                                            <button class="avtar avtar-xs btn-link-success btn-pc-default"
                                                                    style="border:none" type="button"
                                                                    data-bs-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false"><i class="ti ti-share f-18"></i>
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                @php $encode=base64_encode($user->id.'#'.$user->username.'#'.$user->created_at);@endphp
                                                                <a href="/detail/{{$encode}}" class="dropdown-item" style="border:none">Link Detail
                                                                </a>
                                                                <a href="javascript:void(0);" class="dropdown-item" style="border:none"
                                                                   data-clipboard="true" data-clipboard-text="@foreach($user->servers as $server)
@php
$link=explode('://',$server->link);
$link=explode(':',$link[1]);
@endphp
Host:{{$link[0]}}&nbsp;
Port:{{$server->port_connection}}&nbsp;
TLS Port:{{$server->port_connection_tls}}&nbsp;
Username:{{$user->username}}&nbsp;
Password:{{$user->password}}&nbsp;
@if (!empty($startdate))
StartTime:{{$startdate}}&nbsp;
@endif
@if (!empty($finishdate))
EndTime:{{$finishdate}}
@endif @endforeach">Copy Config</a>

@php
$at="@";
@endphp


                                                                <a href="javascript:void(0);" class="dropdown-item" style="border:none"
                                                                   data-clipboard="true"
                                                                   data-clipboard-text="@foreach($user->servers as $server) @php $link=explode('://',$server->link); $link=explode(':',$link[1]); @endphp ssh://{{$user->username}}:{{$user->password}}{{$at}}{{$link[0]}}:{{$server->port_connection}}/#{{$user->username}} @endforeach">Link SSH
                                                                </a>
                                                                <a href="javascript:void(0);" class="dropdown-item" style="border:none"
                                                                   data-clipboard="true"
                                                                   data-clipboard-text="@foreach($user->servers as $server) @php $link=explode('://',$server->link); $link=explode(':',$link[1]); @endphp ssh://{{$user->username}}:{{$user->password}}{{$at}}{{$link[0]}}:{{$server->port_connection_tls}}/#{{$user->username}} @endforeach">Link SSH TLS
                                                                </a>
                                                                <a href="javascript:void(0);" class="qrs dropdown-item"
                                                                   data-tls="@foreach($user->servers as $server) @php $link=explode('://',$server->link); $link=explode(':',$link[1]); @endphp ssh://{{$user->username}}:{{$user->password}}{{$at}}{{$link[0]}}:{{$server->port_connection_tls}}/#{{$user->username}} @endforeach"
                                                                   data-id="@foreach($user->servers as $server) @php $link=explode('://',$server->link); $link=explode(':',$link[1]); @endphp ssh://{{$user->username}}:{{$user->password}}{{$at}}{{$link[0]}}:{{$server->port_connection}}/#{{$user->username}} @endforeach"
                                                                   data-bs-toggle="modal"
                                                                   data-bs-target="#qr-modal">
                                                                    QR
                                                                </a>

                                                            </div>
                                                        </li>

                                                    </ul>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- [ sample-page ] end -->
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>

    <!-- qr -->
    <div class="modal fade" id="qr-modal" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content" style="display: -webkit-inline-box; text-align: center;width: 600px;">
                <div><br>
                    SSH DIRECT<br><span id="idHolderSSH"></span>
                </div>
                <div><br>
                    SSH TLS<br><span id="idHolderTLS"></span>
                </div>
            </div>
        </div>
    </div>

    <!-- server -->
    <div class="modal fade" id="server-modal" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <form class="modal-content" action="{{route('new.server')}}" method="POST" enctype="multipart/form-data"
                  onsubmit="return confirm('Are you sure you want to perform this operation?');">
                <div class="modal-header">
                    <h5 class="mb-0">Change Server</h5>
                    <a href="javascript:void(0);" class="avtar avtar-s btn-link-danger btn-pc-default" data-bs-dismiss="modal">
                        <i class="ti ti-x f-20"></i>
                    </a>
                </div>
                <div class="modal-body" >
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="input-group">

                                        @csrf
                                        <input type="hidden" name="username_re" id="input_user" value="" class="input_user form-control" placeholder="30">
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
                                    <small class="form-text text-muted" style="font-weight: bold;">Selected Server Username: <span style="color: red;" id="us"></span></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <div class="flex-grow-1 text-end">
                        <button type="button" class="btn btn-link-danger btn-pc-default"
                                data-bs-dismiss="modal">Cancell
                        </button>
                        <button type="submit" class="btn btn-primary" value="submit"
                                name="renewal_date">Change</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    @if($permission=='admin')
        <div class="modal fade" id="customer_add-modal" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <form class="modal-content" action="{{route('new.user')}}" method="post" enctype="multipart/form-data"
                      onsubmit="return confirm('Are you sure you want to perform this operation?');">
@csrf
                    <div class="modal-header">
                        <h5 class="mb-0">New User </h5>
                        <a href="#" class="avtar avtar-s btn-link-danger btn-pc-default" data-bs-dismiss="modal">
                            <i class="ti ti-x f-20"></i>
                        </a>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="input-group">
                                                    @php
                                                        $pid=1;
                                                    @endphp
                                                    @foreach($packages as $package)
                                                        @php
                                                            $pid++;
                                                        @endphp
                                                        <div class="card_plan">
                                                            <input type="radio" class="card_p" value="{{$package->id}}" name="pack" id="card{{$pid}}">
                                                            <label class="card_p" for="card{{$pid}}">
                                                                <h5 class="prevent-select">{{$package->title}}</h5>
                                                                <div class="prevent-select">
                                                                    <span>Price: {!! number_format($package->amount) !!}</span>
                                                                    <span> | {{$package->day}} Day</span>
                                                                </div>
                                                                <div class="prevent-select">
                                                                    <span>Traffic: {{$package->traffic}} GB</span>
                                                                </div>
                                                                <div class="prevent-select">
                                                                    <span>Multi User: {{$package->multiuser}}</span>
                                                                </div>
                                                                <hdiv class="prevent-select">
                                                                    <span>Multi Server: {{$package->multi}}</span>
                                                                </hdiv>
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <small class="form-text text-muted">Select the desired package</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <input type="text" name="username" class="form-control"
                                                       placeholder="Username" autocomplete="off"
                                                       onkeyup="if (/[^|a-z0-9]+/g.test(this.value)) this.value = this.value.replace(/[^|a-z0-9]+/g,'')"
                                                       required>
                                                <small class="form-text text-muted">Enter Username</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="feather icon-lock"></i></span>
                                                    <input type="text" name="password" class="form-control"
                                                           placeholder="Password" autocomplete="off"
                                                           value="{{$password_auto}}" required>
                                                </div>
                                                <small class="form-text text-muted">Enter Password</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <input type="text" name="email" class="form-control"
                                                       placeholder="Email">
                                                <small class="form-text text-muted">Enter Email</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="input-group">
                                                    <input type="text" name="mobile" class="form-control"
                                                           placeholder="Mobile">
                                                </div>
                                                <small class="form-text text-muted">Enter Mobile</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control" rows="3" name="desc"
                                              placeholder="Description"></textarea>
                                </div>


                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <div class="flex-grow-1 text-end">
                            <button type="button" class="btn btn-link-danger btn-pc-default"
                                    data-bs-dismiss="modal">Cancell
                            </button>
                            <button type="submit" class="btn btn-primary" value="submit"
                                    name="submit">Add</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    @else
    <div class="modal fade" id="customer_add-modal" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <form class="modal-content" action="{{route('new.user')}}" method="post" enctype="multipart/form-data"
                  onsubmit="return confirm('Are you sure you want to perform this operation?');">
                @csrf
                <div class="modal-header">
                    <h5 class="mb-0">New User </h5>
                    <a href="#" class="avtar avtar-s btn-link-danger btn-pc-default" data-bs-dismiss="modal">
                        <i class="ti ti-x f-20"></i>
                    </a>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="input-group">
                                                @php
                                                $pid=1;
                                                @endphp
                                               @foreach($packages as $package)
                                                   @php
                                                   $pid++;
                                                   @endphp
                                                <div class="card_plan">
                                                    <input type="radio" class="card_p" value="{{$package->id}}" name="pack" id="card{{$pid}}">
                                                    <label class="card_p" for="card{{$pid}}">
                                                        <h5 class="prevent-select">{{$package->title}}</h5>
                                                        <div class="prevent-select">
                                                            <span>Price: {!! number_format($package->amount) !!}</span>
                                                            <span> | {{$package->day}} Day</span>
                                                        </div>
                                                        <div class="prevent-select">
                                                            <span>Traffic: {{$package->traffic}} GB</span>
                                                        </div>
                                                        <div class="prevent-select">
                                                            <span>Multi User: {{$package->multiuser}}</span>
                                                        </div>
                                                        <hdiv class="prevent-select">
                                                            <span>Multi Server: {{$package->multi}}</span>
                                                        </hdiv>
                                                    </label>
                                                </div>
                                                @endforeach
                                            </div>
                                            <small class="form-text text-muted">Select the desired package</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <input type="text" name="email" class="form-control"
                                                   placeholder="Email">
                                            <small class="form-text text-muted">Enter Email</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="input-group">
                                                <input type="text" name="mobile" class="form-control"
                                                       placeholder="Mobile">
                                            </div>
                                            <small class="form-text text-muted">Enter Mobile</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" rows="3" name="desc"
                                          placeholder="Description"></textarea>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <div class="flex-grow-1 text-end">
                        <button type="button" class="btn btn-link-danger btn-pc-default"
                                data-bs-dismiss="modal">Cancell
                        </button>
                        <button type="submit" class="btn btn-primary" value="submit"
                                name="submit">Add</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endif
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
    <script type="text/javascript">
        $(document).on("click", ".re_user", function () {
            var username = $(this).data('user');
            $('input[name=username_re]').val(username);
            document.getElementById("us").innerHTML = username

        });
    </script>
    <script>
        $(document).ready(function () {
            document.getElementById("btndl").disabled = true;
        });
        $(document).on("click", ".checkItem", function () {

            document.getElementById("btndl").disabled = false;

        });
    </script>

@endsection
