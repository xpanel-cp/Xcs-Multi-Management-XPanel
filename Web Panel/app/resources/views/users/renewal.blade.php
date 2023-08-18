@extends('layouts.master')
@section('title','XPanel - Renewal')
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
                                <h2 class="mb-0">Renewal User</h2>
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
                                <form class="modal-content" action="{{route('new.renewal')}}" method="POST" enctype="multipart/form-data"
                                      onsubmit="return confirm('Are you sure you want to perform this operation?');">
@csrf
                                    <div class="modal-body" >
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
                                                                    <input type="radio" class="card_p" value="{{$package->id}}" name="pack" id="card{{$pid}}" @if($pack==$package->id) checked @endif>
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
                                                    <div class="col-lg-6">
                                                        <small>Registered from today</small>
                                                        <div class="input-group">

                                                            <div class="form-check form-check-inline">
                                                                <input type="hidden" name="username_re" value="{{$username}}">
                                                                <input type="radio" name="re_date" value="yes" class="form-check-input input-primary" checked>
                                                                <label class="form-check-label" for="customCheckinl311">Yes</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input type="radio" name="re_date" value="no" class="form-check-input input-primary" >
                                                                <label class="form-check-label" for="customCheckinl311">No</label>
                                                            </div>

                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <small>Reset the traffic</small>
                                                        <div class="input-group">

                                                            <div class="form-check form-check-inline">
                                                                <input type="radio" name="re_traffic" value="yes" class="form-check-input input-primary" checked>
                                                                <label class="form-check-label" for="customCheckinl311">Yes</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input type="radio" name="re_traffic" value="no" class="form-check-input input-primary" >
                                                                <label class="form-check-label" for="customCheckinl311">No</label>
                                                            </div>

                                                        </div>
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
                                                    name="renewal_date">Registration</button>
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
