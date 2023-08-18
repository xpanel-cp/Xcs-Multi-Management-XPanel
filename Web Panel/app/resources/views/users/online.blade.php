@extends('layouts.master')
@section('title','Xcs - Online User')
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
                                <h2 class="mb-0">Online User</h2>
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
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover" id="pc-dt-simple">
                                    <thead>
                                    <tr>
                                        <th>Username</th>
                                        <th>IP</th>
                                        <th>Server</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $val)
                                        <tr>
                                            <td>{{$val->username}}<i
                                                    style="color:{{$val->color}}!important;"
                                                    class="ti ti-live-photo"></i></td>
                                            <td>{{$val->ip}}<br><small>Protocol:SSH</small></td>
                                            <td>{{$val->server}}</td>
                                            <td class="text-center">
                                                <ul class="list-inline me-auto mb-0">
                                                    <li class="list-inline-item align-bottom">
                                                        <a href="{{ route('online.kill.pid', ['pid' => $val->pid]) }}"
                                                           class="btn btn-light-primary" style="pointer-events: none; cursor: default; color: gray;">
                                                            Kill ID
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item align-bottom">
                                                        <a href="{{ route('online.kill.username', ['username' => $val->username]) }}"
                                                           class="btn btn-light-danger" style="pointer-events: none; cursor: default; color: gray;">
                                                            Kill USER
                                                        </a>
                                                    </li>

                                                </ul>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
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

@endsection
