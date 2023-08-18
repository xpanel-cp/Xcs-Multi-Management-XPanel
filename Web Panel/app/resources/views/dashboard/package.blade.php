@extends('layouts.master')
@section('title','Xcs - Packages')
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
                                <h2 class="mb-0">Packages</h2>
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
                                <div class="text-end p-4 pb-0">
                                    <a href="javascript:void(0);" class="btn btn-primary d-inline-flex align-items-center"
                                       style="margin-bottom: 5px;" data-bs-toggle="modal" data-bs-target="#customer_add-modal">
                                        <i class="ti ti-plus f-18"></i>New Package
                                    </a>
                                </div>


                                <div class="table-responsive">
                                    <table class="table table-hover" id="pc-dt-simple">
                                        <thead>
                                        <tr>
                                            <th>#ID</th>
                                            <th>Name</th>
                                            <th>Amount</th>
                                            <th>Day</th>
                                            <th>Traffic</th>
                                            <th>Server</th>
                                            <th>Multi User</th>
                                            <th>Multi Server</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php
                                            $uid = 0;
                                        @endphp
                                        @foreach ($packages as $package)
                                            @php
                                                $uid++
                                            @endphp

                                            @if ($package->multi == "true")
                                                @php $multiserver = "<span class='badge bg-light-success rounded-pill f-12'>Active</span>"; @endphp
                                            @endif
                                            @if ($package->multi == "false")
                                                @php $multiserver = "<span class='badge bg-light-danger rounded-pill f-12'>Deactive</span>"; @endphp
                                            @endif



                                            <tr>
                                                <td> {{$uid}}
                                                </td>
                                                <td>{{$package->title}}</td>
                                                <td>{!! number_format($package->amount) !!}</td>
                                                <td>{{$package->day}}</td>
                                                <td>{{$package->traffic}} GB</td>
                                                <td>{{$package->server}}</td>
                                                <td>{{$package->multiuser}}</td>
                                                <td>{!! $multiserver !!}</td>
                                                <td class="text-center">
                                                    <ul class="list-inline me-auto mb-0">
                                                        <li class="list-inline-item align-bottom" data-bs-toggle="tooltip" aria-label="Delete" data-bs-original-title="Delete">
                                                            <a href="{{ route('package.delete', ['id' => $package->id]) }}" class="avtar avtar-xs btn-link-danger btn-pc-default">
                                                                <i class="ti ti-trash f-18"></i>
                                                            </a>
                                                        </li>
                                                        <li class="list-inline-item align-bottom" data-bs-toggle="tooltip"
                                                            title="Edit">
                                                            <a href="{{ route('package.edit', ['id' => $package->id]) }}"
                                                               class="avtar avtar-xs btn-link-success btn-pc-default">
                                                                <i class="ti ti-edit-circle f-18"></i>
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

    <div class="modal fade" id="customer_add-modal" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <form class="modal-content" action="{{route('package.insert')}}" method="post" enctype="multipart/form-data" onsubmit="return confirm('Are you sure you want to perform this operation?');">
                @csrf
                <div class="modal-header">
                    <h5 class="mb-0">Add Package</h5>
                    <a href="#" class="avtar avtar-s btn-link-danger btn-pc-default" data-bs-dismiss="modal">
                        <i class="ti ti-x f-20"></i>
                    </a>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group row">
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <input type="text" name="title" class="form-control"
                                                   placeholder="Package Name" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="input-group">
                                                <input type="text" name="amount" class="form-control"
                                                       placeholder="Amount" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="input-group">
                                                <input type="text" name="day" class="form-control"
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
                                            <input type="radio" name="multi" value="true" class="form-check-input input-primary" checked>
                                            <label class="form-check-label" for="customCheckinl311">True</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" name="multi" value="false" class="form-check-input input-primary" >
                                            <label class="form-check-label" for="customCheckinl311">False</label>
                                        </div>

                                    </div>

                                </div>
                                <div class="col-lg-6">
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
                                            <small class="form-text text-muted">Selected Default Server</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <input type="text" name="multiuser" class="form-control" value="1"
                                                   placeholder="Multi User" required>
                                            <small class="form-text text-muted">Enter number of concurrent users</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <input type="text" name="traffic" class="form-control" value="0">
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
                        <button type="button" class="btn btn-link-danger btn-pc-default" data-bs-dismiss="modal">Cancell
                        </button>
                        <button type="submit" class="btn btn-primary" value="submit" name="submit">Add</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
