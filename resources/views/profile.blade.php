@extends('layouts.master')

@section('content')
    @php
        $role = Auth::user()->role->slug;
    @endphp
    <div class="content-header row align-items-center m-0">
        <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
            <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
                <li class="breadcrumb-item"><a href="#"><i class="hvr-buzz-out fas fa-home"></i></a></li>
                <li class="breadcrumb-item active">Profile</li>
            </ol>
        </nav>
        <div class="col-sm-8 header-title p-0">
            <div class="media">
                <div class="header-icon text-success mr-3"><i class="hvr-buzz-out fas fa-user-circle"></i></div>
                <div class="media-body">
                    <h1 class="font-weight-bold">Profile</h1>
                    <small>My Profile</small>
                </div>
            </div>
        </div>
    </div> 
    <div class="body-content">        
        <div class="row">
            <div class="col-md-4">
                <div class="card card-body">
                    <div class="text-center profile-image">
                        <img src="@if($user->picture){{asset($user->picture)}}@else{{asset('images/avatar128.png')}}@endif" width="75%" class="rounded-circle" alt="">
                    </div>
                    <p class="text-info text-center mt-4">{{$user->first_name}} {{$user->last_name}}</p>
                    <h3 class="text-primary text-center"><span class="badge badge-primary">{{$user->role->name}}</span></h3>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card card-body">                        
                    <form class="form-layout form-layout-1" action="{{route('updateuser')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group my-3">
                            <label class="form-control-label">Username: <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="name" value="{{$user->name}}" placeholder="{{__('page.username')}}" required>
                            @error('name')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mb-2">
                            <label class="form-control-label">First Name: <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="first_name" value="{{$user->first_name}}" placeholder="First Name" required>
                            @error('first_name')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mb-2">
                            <label class="form-control-label">Last Name: <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="last_name" value="{{$user->last_name}}" placeholder="Last Name" required>
                            @error('last_name')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mb-2">
                            <label class="form-control-label">Picture:</label>                                
                            <label class="custom-file wd-100p">
                                <input type="file" name="picture" id="file2" class="file-input-styled" accept="image/*">
                            </label>
                        </div> 
                        <div class="form-group mb-2">
                            <label class="form-control-label">Password: <span class="text-danger">*</span></label>
                            <input class="form-control" type="password" name="password" placeholder="Password">
                        </div>
                        <div class="form-group mb-2">
                            <label class="form-control-label">Confirm Password: <span class="text-danger">*</span></label>
                            <input class="form-control" type="password" name="password_confirmation" placeholder="Confirm Password">
                        </div>
                        <div class="form-layout-footer text-right mt-5">
                            <button type="submit" class="btn btn-primary tx-20"><i class="far fa-save mr-2"></i> Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
    

@section('script')
    <script src="{{asset('master/plugins/styling/uniform.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('.file-input-styled').uniform({
                fileButtonClass: 'action btn bg-primary text-white'
            });
        });
    </script>
@endsection
