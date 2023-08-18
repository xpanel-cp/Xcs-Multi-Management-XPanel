@extends('layouts.master')
@section('title','Xcs - Edit')
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
                            <h2 class="mb-0">Edit User</h2>
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
                                <form class="modal-content" action="{{route('user.update')}}" method="POST" enctype="multipart/form-data"
                                      onsubmit="return confirm('Are you sure you want to perform this operation?');">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group row">
                                                    <div class="col-lg-6">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <input type="text" class="form-control" placeholder="Username" autocomplete="off" value="{{$show->username}}" disabled>
                                                                <input type="hidden" class="form-control" name="username" autocomplete="off" value="{{$show->username}}">
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
                                                                           value="{{$show->password}}" required>
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
                                                                       placeholder="Email" value="{{$show->email}}">
                                                                <small class="form-text text-muted">Enter Email</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="input-group">
                                                                    <input type="text" name="mobile" class="form-control"
                                                                           placeholder="Mobile" value="{{$show->mobile}}">
                                                                </div>
                                                                <small class="form-text text-muted">Enter Mobile</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Description</label>
                                                    <textarea class="form-control" rows="3" name="desc"
                                                              placeholder="Description">{{$show->desc}}</textarea>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <div class="flex-grow-1 text-end">
                                            <button type="submit" class="btn btn-primary" value="submit"
                                                    name="submit">Save</button>
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
