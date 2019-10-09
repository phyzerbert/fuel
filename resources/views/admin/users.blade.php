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
                            <select class="form-control form-control-sm mr-sm-2 mb-2" name="unit_id" id="search_unit">
                                <option value="" hidden>Select Unit</option>
                                @foreach ($units as $item)
                                    <option value="{{$item->id}}" @if ($unit_id == $item->id) selected @endif>{{$item->name}}</option>
                                @endforeach        
                            </select>                        
                            <button type="submit" class="btn btn-sm btn-primary mb-2"><i class="fa fa-search"></i>&nbsp;&nbsp;Search</button>
                            <button type="button" class="btn btn-sm btn-info mb-2 ml-1" id="btn-reset"><i class="fa fa-eraser"></i>&nbsp;&nbsp;Reset</button>
                        </form>
                        @if ($role == 'admin')
                            <button type="button" class="btn btn-success btn-sm float-right mg-b-5" id="btn-add"><i class="fas fa-plus mr-1"></i> Add New</button>
                        @endif
                    </div>
                    <div class="table-responsive mt-2">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-colored thead-primary">
                                <tr class="bg-blue">
                                    <th style="width:40px">#</th>
                                    <th>Username</th>
                                    <th>Unit</th>
                                    <th>Role</th>
                                    <th>Tank</th>
                                    <th>Status</th>
                                    <th style="width:150px">{{__('Action')}}</th>
                                </tr>
                            </thead>
                            <tbody>                                
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ (($data->currentPage() - 1 ) * $data->perPage() ) + $loop->iteration }}</td>
                                        <td class="username">{{$item->name}}</td>
                                        <td class="unit" data-id="{{$item->unit_id}}">@isset($item->unit->name){{$item->unit->name}}@endisset</td>
                                        <td class="role" data-id="{{$item->role_id}}">{{$item->role->name}}</td>
                                        <td class="tank" data-id="{{$item->tank_id}}">@isset($item->tank->name){{$item->tank->name}}@endisset</td>
                                        <td class="status" data-id="{{$item->status}}">
                                            @if($item->status == 1)
                                                <span class="badge badge-primary">Approved</span>
                                            @else
                                                <span class="badge badge-danger">Pending</span>
                                            @endif
                                        </td>
                                        <td class="py-1">
                                            <a href="#" class="btn btn-sm btn-primary btn-icon mr-1 btn-edit" data-id="{{$item->id}}" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
                                            <a href="{{route('user.delete', $item->id)}}" class="btn btn-sm btn-danger btn-icon mr-1 btn-confirm" onclick="return window.confirm('Are you sure?')" data-toggle="tooltip" title="Delete"><i class="fas fa-trash-alt"></i></a>
                                            <a href="{{route('user.approve', $item->id)}}" class="btn btn-sm btn-info btn-icon mr-1 btn-approve" onclick="return window.confirm('Are you sure?')" data-toggle="tooltip" title="Approve"><i class="fas fa-check-circle"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>                
                        <div class="clearfix mt-2">
                            <div class="float-left" style="margin: 0;">
                                <p>Total <strong style="color: red">{{ $data->total() }}</strong> Items</p>
                            </div>
                            <div class="float-right" style="margin: 0;">
                                {!! $data->appends(['name' => $name, 'unit_id' => $unit_id])->links() !!}
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
                            <label class="control-label">Username</label>
                            <input class="form-control" type="text" name="name" id="name" placeholder="Username" required />
                            <span id="name_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Role</label>
                            <select name="role" id="create_role" class="form-control" required>
                                <option value="1">SuperAdmin</option>
                                <option value="2">Admin</option>
                                <option value="3" selected>User</option>
                            </select>
                            <span id="role_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>                        
                        <div class="form-group">
                            <label class="control-label">Unit</label>
                            <select name="unit_id" id="unit_id" class="form-control">
                                <option value="">Select Unit</option>
                                @foreach ($units as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>                                    
                                @endforeach
                            </select>
                            <span id="unit_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="form-group user-tank">
                            <label class="control-label">Tank</label>
                            <select name="tank_id" class="form-control tank">
                                <option value="">Select Tank</option>
                                @foreach ($tanks as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>                                    
                                @endforeach
                            </select>
                            <span id="edit_tank_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="form-group password-field">
                            <label class="control-label">Password</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                            <span id="password_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>    
                        <div class="form-group password-field">
                            <label class="control-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="confirm_password" class="form-control" placeholder="Password Confirm">
                            <span id="confirm_password_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>
                    </div>    
                    <div class="modal-footer">
                        <button type="button" id="btn_create" class="btn btn-primary btn-submit"><i class="fa fa-check-circle-o"></i>&nbsp;Save</button>
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
                            <span id="edit_name_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Unit</label>
                            <select name="unit_id" class="form-control unit">
                                <option value="">Select Unit</option>
                                @foreach ($units as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>                                    
                                @endforeach
                            </select>
                            <span id="edit_unit_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="form-group user-tank">
                            <label class="control-label">Tank</label>
                            <select name="tank_id" class="form-control tank">
                                <option value="">Select Tank</option>
                                @foreach ($tanks as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>                                    
                                @endforeach
                            </select>
                            <span id="edit_tank_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="form-group password-field">
                            <label class="control-label">New Password</label>
                            <input type="password" name="password" class="form-control" placeholder="New Password">
                            <span id="edit_password_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>    
                        <div class="form-group password-field">
                            <label class="control-label">Password Confirmation</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Password Confirm">
                            <span id="edit_confirmpassword_error" class="invalid-feedback">
                                <strong></strong>
                            </span>
                        </div>
                    </div>    
                    <div class="modal-footer">
                        <button type="button" id="btn_update" class="btn btn-primary btn-submit"><i class="fas fa-check-circle"></i>&nbsp;Save</button>
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
    
            $("#btn_create").click(function(){    
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
                                $('#name_error strong').text(data.responseJSON.errors.name[0]);
                                $('#name_error').show();
                                $('#create_form #name').focus();
                            }
                            
                            if(messages.role) {
                                $('#role_error strong').text(data.responseJSON.errors.role[0]);
                                $('#role_error').show();
                                $('#create_form #role').focus();
                            }
                            
                            if(messages.unit_id) {
                                $('#unit_error strong').text(data.responseJSON.errors.unit_id[0]);
                                $('#unit_error').show();
                                $('#create_form #unit_id').focus();
                            }
    
                            if(messages.password) {
                                $('#password_error strong').text(data.responseJSON.errors.password[0]);
                                $('#password_error').show();
                                $('#create_form #password').focus();
                            }
                        }
                    }
                });
            });
    
            $(".btn-edit").click(function(){
                let user_id = $(this).attr("data-id");
                let username = $(this).parents('tr').find(".username").text().trim();
                let unit = $(this).parents('tr').find(".unit").data('id');
                let role = $(this).parents('tr').find(".role").data('id');
                let tank = $(this).parents('tr').find(".tank").data('id');
    
                $("#edit_form input.form-control").val('');
                if(role == '3'){
                    $("#edit_form .tank").val(tank);
                    $("#edit_form .user-tank").show();
                } else {
                    $("#edit_form .user-tank").hide();
                }
                $("#edit_form .id").val(user_id);
                $("#edit_form .name").val(username);
                $("#edit_form .unit").val(unit);
    
                $("#editModal").modal();
            });
    
            $("#btn_update").click(function(){
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
                        $(".page-loader-wrapper").fadeOut();
                    },
                    error: function(data) {
                        $("#ajax-loading").hide();
                        if(data.responseJSON.message == 'The given data was invalid.') {
                            let messages = data.responseJSON.errors;
                            if(messages.name) {
                                $('#edit_name_error strong').text(data.responseJSON.errors.name[0]);
                                $('#edit_name_error').show();
                                $('#edit_form #edit_name').focus();
                            }
        
                            if(messages.password) {
                                $('#edit_password_error strong').text(data.responseJSON.errors.password[0]);
                                $('#edit_password_error').show();
                                $('#edit_form #edit_password').focus();
                            }
                        }
                    }
                });
            });

            $("#create_role").change(function(){
                if($(this).val() == 3){
                    $("#create_form .user-tank").slideDown();
                }else{
                    $("#create_form .user-tank").slideUp();
                }
            })
    
            $("#btn-reset").click(function(){
                $("#search_name").val('');
                $("#search_unit").val('');
            });    
        });
    </script>
@endsection
