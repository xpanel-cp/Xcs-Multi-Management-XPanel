@extends('layouts.master')
@section('title','Xcs - Edit Package')
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
                                <h2 class="mb-0">Edit Package</h2>
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

                                <form class="modal-content" action="{{route('package.update')}}" method="post" enctype="multipart/form-data" onsubmit="return confirm('Are you sure you want to perform this operation?');">
                                    @csrf

                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group row">
                                                    <div class="col-lg-4">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <input type="text" name="title" value="{{$package[0]->title}}" class="form-control"
                                                                       placeholder="Package Name" required>
                                                                <input type="hidden" name="id" value="{{$package[0]->id}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="input-group">
                                                                    <input type="text" name="amount" value="{{$package[0]->amount}}" class="form-control"
                                                                           placeholder="Amount" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="input-group">
                                                                    <input type="text" name="day" value="{{$package[0]->day}}" class="form-control"
                                                                           placeholder="Expire Day" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group row">
                                                    <div class="col-lg-6">
                                                        <small>Multi Server</small>
                                                        <div class="input-group">

                                                            <div class="form-check form-check-inline">
                                                                <input type="radio" name="multi" value="true" class="form-check-input input-primary" @if($package[0]->multi==true) checked @endif>
                                                                <label class="form-check-label" for="customCheckinl311">True</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input type="radio" name="multi" value="false" class="form-check-input input-primary" @if($package[0]->multi==false) checked @endif>
                                                                <label class="form-check-label" for="customCheckinl311">False</label>
                                                            </div>

                                                        </div>

                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="input-group">
                                                                    <select name="serverid" class="form-select">
                                                                        @foreach($package[0]->servers as $server)

                                                                            <option value="{{$server->id}}">{{$server->name}}</option>
                                                                        @endforeach
                                                                            <optgroup label="Other">
                                                                        @foreach ($servers as $server)
                                                                            <option value="{{$server->id}}">{{$server->name}}</option>
                                                                        @endforeach
                                                                            </optgroup>
                                                                    </select>
                                                                </div>
                                                                <small class="form-text text-muted">Selected Default Server</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-lg-6">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <input type="text" name="multiuser" class="form-control" value="{{$package[0]->multiuser}}"
                                                                       placeholder="Multi User" required>
                                                                <small class="form-text text-muted">Enter number of concurrent users</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <input type="text" name="traffic" class="form-control" value="{{$package[0]->traffic}}" >
                                                                <small class="form-text text-muted">Enter traffic GB (<span style="color:red">0</span> = Traffic Unlimited)</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <div class="flex-grow-1 text-end">

                                            <button type="submit" class="btn btn-primary" value="submit" name="submit">Save</button>
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