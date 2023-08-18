@extends('layouts.master')
@section('title','Xcs - Edit Server')
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
                                <h2 class="mb-0">Edit Server</h2>
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
                            <div class="row">

                                <form class="validate-me" action="{{route('settings.update.server')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group row">
                                        <div class="col-lg-6">
                                            <input type="text" name="link" id="confirm-password" class="form-control" value="{{$server[0]->link}}" required="">
                                            <small class="form-text text-muted">URL API (http:example.com:8181)</small>
                                        </div>

                                        <div class="col-lg-6">
                                            <input class="form-control" type="hidden" name="id" value="{{$server[0]->id}}" required="">
                                            <input class="form-control" type="text" name="token" value="{{$server[0]->token}}" required="">
                                            <small class="form-text text-muted">Token Api</small>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-lg-4">
                                            <input class="form-control" type="text" name="name" value="{{$server[0]->name}}" required="">
                                            <small class="form-text text-muted">Server Name</small>
                                        </div>

                                        <div class="col-lg-4">
                                            <input class="form-control" type="text" name="port" value="{{$server[0]->port_connection}}" required="">
                                            <small class="form-text text-muted">Port Connection</small>
                                        </div>

                                        <div class="col-lg-4">
                                            <input class="form-control" type="text" name="port_tls" value="{{$server[0]->port_connection_tls}}" required="">
                                            <small class="form-text text-muted">Port Connection TLS</small>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-lg-4 col-form-label"></div>
                                        <div class="col-lg-6">
                                            <input type="submit" class="btn btn-primary" name="submit" value="Save">
                                        </div>
                                    </div>

                                </form>
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