@extends('layouts.master')

@section('content')
    @php
        $role = Auth::user()->role->slug;
    @endphp
    <div class="content-header row align-items-center m-0">
        <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
            <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
                <li class="breadcrumb-item"><a href="#"><i class="hvr-buzz-out fas fa-home"></i></a></li>
                <li class="breadcrumb-item active">Users</li>
            </ol>
        </nav>
        <div class="col-sm-8 header-title p-0">
            <div class="media">
                <div class="header-icon text-success mr-3"><i class="hvr-buzz-out fas fa-users"></i></div>
                <div class="media-body">
                    <h1 class="font-weight-bold">Users</h1>
                    <small>User Management</small>
                </div>
            </div>
        </div>
    </div> 
    <div class="body-content">
        <div class="row">
            <div class="col-md-12">                
                <div class="card card-body card-fill">
                    <div class="">
                        @include('elements.pagesize')
                        <form action="" method="POST" class="form-inline float-left" id="searchForm">
                            @csrf
                            <input type="text" class="form-control form-control-sm mr-sm-2 mb-2" name="name" id="search_name" value="{{$name}}" placeholder="Name">
                            <select class="form-control form-control-sm mr-sm-2 mb-2" name="location_id" id="search_location">
                                <option value="" hidden>Select Location</option>
                                @foreach ($locations as $item)
                                    <option value="{{$item->id}}" @if ($location_id == $item->id) selected @endif>{{$item->name}}</option>
                                @endforeach        
                            </select>                        
                            <button type="submit" class="btn btn-sm btn-primary mb-2"><i class="fa fa-search"></i>&nbsp;&nbsp;Search</button>
                            <button type="button" class="btn btn-sm btn-info mb-2 ml-1" id="btn-reset"><i class="fa fa-eraser"></i>&nbsp;&nbsp;Reset</button>
                        </form>
                        @if ($role == 'super_admin')
                            <button type="button" class="btn btn-success btn-sm float-right mg-b-5" id="btn-add"><i class="fas fa-plus mr-1"></i> Add New</button>
                        @endif
                    </div>
                    <div class="table-responsive mt-2">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-colored thead-primary">
                                <tr class="bg-blue">
                                    <th style="width:40px">#</th>
                                    <th>Username</th>
                                    <th>Surname</th>
                                    <th>Location</th>
                                    <th>Role</th>
                                    <th>Tank</th>
                                    <th>Status</th>
                                    @if($role == 'admin')
                                        <th style="width:150px">{{__('Action')}}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>                                
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ (($data->currentPage() - 1 ) * $data->perPage() ) + $loop->iteration }}</td>
                                        <td class="username">{{$item->name}}</td>
                                        <td class="surname">{{$item->surname}}</td>
                                        <td class="location" data-id="{{$item->location_id}}">@isset($item->location->city){{$item->location->city->name}}, {{$item->location->district}}@endisset</td>
                                        <td class="role" data-id="{{$item->role_id}}">{{$item->role->name}}</td>
                                        <td class="tank" data-id="@if($item->tank){{$item->tank->id}}@endif">@isset($item->tank->name){{$item->tank->name}}@endisset</td>
                                        <td class="status" data-id="{{$item->status}}">
                                            @if($item->status == 1)
                                                <span class="badge badge-primary">Approved</span>
                                            @else
                                                <span class="badge badge-danger">Pending</span>
                                            @endif
                                        </td>                                        
                                        @if($role == 'admin')
                                            <td class="py-1">
                                                <a href="#" class="btn btn-sm btn-primary btn-icon mr-1 btn-edit" data-id="{{$item->id}}" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
                                                <a href="{{route('user.delete', $item->id)}}" class="btn btn-sm btn-danger btn-icon mr-1 btn-confirm" onclick="return window.confirm('Are you sure?')" data-toggle="tooltip" title="Delete"><i class="fas fa-trash-alt"></i></a>
                                                <a href="{{route('user.approve', $item->id)}}" class="btn btn-sm btn-info btn-icon mr-1 btn-approve" onclick="return window.confirm('Are you sure?')" data-toggle="tooltip" title="Approve"><i class="fas fa-check-circle"></i></a>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>                
                        <div class="clearfix mt-2">
                            <div class="float-left" style="margin: 0;">
                                <p>Total <strong style="color: red">{{ $data->total() }}</strong> Items</p>
                            </div>
                            <div class="float-right" style="margin: 0;">
                                {!! $data->appends(['name' => $name, 'location_id' => $location_id])->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- The Modal -->
    <div class="modal fade" id="addModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add New User</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <form action="" id="create_form" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label">Name</label>
                            <input class="form-control name" type="text" name="name" placeholder="Name" required />
                            <span class="invalid-feedback name_error">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Surname</label>
                            <input class="form-control surname" type="text" name="surname" placeholder="Surname" />
                            <span class="invalid-feedback surname_error">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Role</label>
                            <select name="role" id="create_role" class="form-control role" required>
                                <option value="1">SuperAdmin</option>
                                <option value="2">Admin</option>
                                <option value="3" selected>User</option>
                            </select>
                            <span class="invalid-feedback role_error">
                                <strong></strong>
                            </span>
                        </div>                        
                        <div class="form-group">
                            <label class="control-label">Location</label>
                            <select name="location" class="form-control location">
                                <option value="">Select Location</option>
                                @foreach ($locations as $item)
                                    <option value="{{$item->id}}">{{$item->city->name}}, {{$item->district}}</option>                                    
                                @endforeach
                            </select>
                            <span class="invalid-feedback location_error">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="form-group user-tank">
                            <label class="control-label">Tank</label>
                            <select name="tank" class="form-control tank">
                                <option value="">Select Tank</option>
                                @foreach ($tanks as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>                                    
                                @endforeach
                            </select>
                            <span class="invalid-feedback tank_error">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="form-group password-field">
                            <label class="control-label">Password</label>
                            <input type="password" name="password" class="form-control password" placeholder="Password" required>
                            <span class="invalid-feedback password_error">
                                <strong></strong>
                            </span>
                        </div>    
                        <div class="form-group password-field">
                            <label class="control-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="confirm_password" class="form-control" placeholder="Password Confirm">
                        </div>
                    </div>    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-submit"><i class="fa fa-check-circle-o"></i>&nbsp;Save</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp;Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit User</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <form action="" id="edit_form" method="post">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" class="id" />                    
                        <div class="form-group">
                            <label class="control-label">Username</label>
                            <input class="form-control name" type="text" name="name" placeholder="Username">
                            <span class="invalid-feedback name_error">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Surname</label>
                            <input class="form-control surname" type="text" name="surname" placeholder="Surname" />
                            <span class="invalid-feedback surname_error">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Location</label>
                            <select name="location" class="form-control location">
                                <option value="">Select Location</option>
                                @foreach ($locations as $item)
                                    <option value="{{$item->id}}">{{$item->city->name}}, {{$item->district}}</option>                                    
                                @endforeach
                            </select>
                            <span class="invalid-feedback location_error">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="form-group user-tank">
                            <label class="control-label">Tank</label>
                            <select name="tank" class="form-control tank">
                                <option value="">Select Tank</option>
                                @foreach ($tanks as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>                                    
                                @endforeach
                            </select>
                            <span class="invalid-feedback tank_error">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="form-group password-field">
                            <label class="control-label">New Password</label>
                            <input type="password" name="password" class="form-control password" placeholder="New Password">
                            <span class="invalid-feedback password_error">
                                <strong></strong>
                            </span>
                        </div>    
                        <div class="form-group password-field">
                            <label class="control-label">Password Confirmation</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Password Confirm">
                        </div>
                    </div>    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-submit"><i class="fas fa-check-circle"></i>&nbsp;Save</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp;Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
    
@section('script')
    <script>
        $(document).ready(function () {            
            $("#btn-add").click(function(){
                $("#create_form input.form-control").val('');
                $("#create_form .invalid-feedback strong").text('');
                $("#addModal").modal();
            });
    
            $("#create_form .btn-submit").click(function(){    
                $(".page-loader-wrapper").fadeIn();
                $.ajax({
                    url: "{{route('user.create')}}",
                    type: 'post',
                    dataType: 'json',
                    data: $('#create_form').serialize(),
                    success : function(data) {
                        if(data == 'success') {
                            alert("Created Successfully");
                            window.location.reload();
                        }
                        else if(data.message == 'The given data was invalid.') {
                            alert(data.message)
                        }
                        $("#ajax-loading").hide();
                    },
                    error: function(data) {  
                        $(".page-loader-wrapper").fadeOut();
                        if(data.responseJSON.message == 'The given data was invalid.') {
                            let messages = data.responseJSON.errors;
                            if(messages.name) {
                                $('#create_form .name_error strong').text(data.responseJSON.errors.name[0]);
                                $('#create_form .name_error').show();
                                $('#create_form .name').focus();
                            }
                            
                            if(messages.role) {
                                $('#create_form .role_error strong').text(data.responseJSON.errors.role[0]);
                                $('#create_form .role_error').show();
                                $('#create_form .role').focus();
                            }
                            
                            if(messages.location) {
                                $('#create_form .location_error strong').text(data.responseJSON.errors.location[0]);
                                $('#create_form .location_error').show();
                                $('#create_form .location').focus();
                            }
                            
                            if(messages.tank) {
                                $('#create_form .tank_error strong').text(data.responseJSON.errors.tank[0]);
                                $('#create_form .tank_error').show();
                                $('#create_form .tank').focus();
                            }
    
                            if(messages.password) {
                                $('#create_form .password_error strong').text(data.responseJSON.errors.password[0]);
                                $('#create_form .password_error').show();
                                $('#create_form .password').focus();
                            }
                        }
                    }
                });
            });
    
            $(".btn-edit").click(function(){
                let user_id = $(this).attr("data-id");
                let username = $(this).parents('tr').find(".username").text().trim();
                let surname = $(this).parents('tr').find(".surname").text().trim();
                let location = $(this).parents('tr').find(".location").data('id');
                let role = $(this).parents('tr').find(".role").data('id');
                let tank = $(this).parents('tr').find(".tank").data('id');
    
                $("#edit_form input.form-control").val('');
                if(role == '2'){
                    $("#edit_form .tank").val(tank);
                    $("#edit_form .user-tank").show();
                } else {
                    $("#edit_form .user-tank").hide();
                }
                $("#edit_form .id").val(user_id);
                $("#edit_form .name").val(username);
                $("#edit_form .surname").val(surname);
                $("#edit_form .location").val(location);
                $("#edit_form .tank").val(tank);
    
                $("#editModal").modal();
            });
    
            $("#edit_form .btn-submit").click(function(){
                $(".page-loader-wrapper").fadeIn();
                $.ajax({
                    url: "{{route('user.edit')}}",
                    type: 'post',
                    dataType: 'json',
                    data: $('#edit_form').serialize(),
                    success : function(data) {
                        if(data == 'success') {
                            alert("Updated Successfully");
                            window.location.reload();
                        }
                        else if(data.message == 'The given data was invalid.') {
                            alert(data.message);
                        }
                    },
                    error: function(data) {
                        $(".page-loader-wrapper").fadeOut();
                        if(data.responseJSON.message == 'The given data was invalid.') {
                            let messages = data.responseJSON.errors;
                            if(messages.name) {
                                $('#edit_form .name_error strong').text(data.responseJSON.errors.name[0]);
                                $('#edit_form .name_error').show();
                                $('#edit_form .form .name').focus();
                            }
                            
                            if(messages.location) {
                                $('#edit_form .location_error strong').text(data.responseJSON.errors.location[0]);
                                $('#edit_form .location_error').show();
                                $('#edit_form .location').focus();
                            }
                            
                            if(messages.tank) {
                                $('#edit_form .tank_error strong').text(data.responseJSON.errors.tank[0]);
                                $('#edit_form .tank_error').show();
                                $('#edit_form .tank').focus();
                            }
        
                            if(messages.password) {
                                $('#edit_form .password_error strong').text(data.responseJSON.errors.password[0]);
                                $('#edit_form .password_error').show();
                                $('#edit_form .password').focus();
                            }
                        }
                    }
                });
            });

            $("#create_role").change(function(){
                if($(this).val() == 2){
                    $("#create_form .user-tank").slideDown();
                }else{
                    $("#create_form .user-tank").slideUp();
                }
            })
    
            $("#btn-reset").click(function(){
                $("#search_name").val('');
                $("#search_location").val('');
            });   
            
            $("#pagesize").change(function(){
                $("#pagesize_form").submit();
            });   
        });
    </script>
@endsection
