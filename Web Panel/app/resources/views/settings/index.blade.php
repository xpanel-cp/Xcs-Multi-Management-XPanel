@extends('layouts.master')
@section('title','Xcs - Settings')
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
                                <h2 class="mb-0">Settings - Multi Server</h2>
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
                        @include('layouts.setting_menu')
                        <div class="tab-content" id="myTabContent">
                            <div class="card-body">


                                    <div class="form-group row">
                                        <div class="col-lg-12">
                                            <form class="validate-me" action="{{route('settings.addserver')}}" method="post" enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-group row">
                                                    <div class="col-lg-6">
                                                        <input type="text" name="link" id="confirm-password"  class="form-control" required="">
                                                        <small class="form-text text-muted">URL API (http://example.com:8181)</small>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <input class="form-control" type="text" name="token" required="">
                                                        <small class="form-text text-muted">Token Api</small>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-lg-4">
                                                        <input class="form-control" type="text" name="name" required="">
                                                        <small class="form-text text-muted">Server Name</small>
                                                    </div>

                                                    <div class="col-lg-4">
                                                        <input class="form-control" type="text" name="port" required="">
                                                        <small class="form-text text-muted">Port Connection</small>
                                                    </div>

                                                    <div class="col-lg-4">
                                                        <input class="form-control" type="text" name="port_tls" required="">
                                                        <small class="form-text text-muted">Port Connection TLS</small>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-lg-4 col-form-label"></div>
                                                    <div class="col-lg-6">
                                                        <input type="submit" class="btn btn-primary" name="submit" value="Add">
                                                    </div>
                                                </div>

                                            </form>
                                            <hr>
                                            <div class="col-sm-12">
                                                <div class="card table-card">
                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-hover" id="pc-dt-simple">
                                                                <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Server Name</th>
                                                                    <th>URL API</th>
                                                                    <th>Token Api</th>
                                                                    <th>Port Connection</th>
                                                                    <th>Port Connection TLS</th>
                                                                    <th class="text-center">Action</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @foreach ($servers as $server)
                                                                <tr>
                                                                    <td>#</td>
                                                                    <td>{{$server->name}}</td>
                                                                    <td>{{$server->link}}</td>
                                                                    <td>{{$server->token}}</td>
                                                                    <td>{{$server->port_connection}}</td>
                                                                    <td>{{$server->port_connection_tls}}</td>
                                                                    <td class="text-center"><ul class="list-inline me-auto mb-0">
                                                                            <li class="list-inline-item align-bottom" data-bs-toggle="tooltip" aria-label="Delete" data-bs-original-title="Delete">
                                                                                <a href="{{ route('settings.delete.server', ['id' => $server->id]) }}" class="avtar avtar-xs btn-link-danger btn-pc-default">
                                                                                    <i class="ti ti-trash f-18"></i>
                                                                                </a>
                                                                            </li>
                                                                            <li class="list-inline-item align-bottom" data-bs-toggle="tooltip"
                                                                                title="Edit">
                                                                                <a href="{{ route('settings.edit.server', ['id' => $server->id]) }}"
                                                                                   class="avtar avtar-xs btn-link-success btn-pc-default">
                                                                                    <i class="ti ti-edit-circle f-18"></i>
                                                                                </a>
                                                                            </li>
                                                                        </ul></td>
                                                                </tr>
                                                                @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
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
    <!-- [ Main Content ] end -->


@endsection