@extends('layouts.master')
@section('style')    
    <link href="{{asset('master/plugins/jquery-ui-1.12.1/jquery-ui.css')}}" rel="stylesheet">
@endsection
@section('content')
    @php
        $role = Auth::user()->role->slug;
    @endphp
    <div class="content-header row align-items-center m-0">
        <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
            <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
                <li class="breadcrumb-item"><a href="#"><i class="hvr-buzz-out fas fa-home"></i></a></li>
                <li class="breadcrumb-item active">Unloading</li>
            </ol>
        </nav>
        <div class="col-sm-8 header-title p-0">
            <div class="media">
                <div class="header-icon text-success mr-3"><i class="hvr-buzz-out fas fa-gas-pump"></i></div>
                <div class="media-body">
                    <h1 class="font-weight-bold">Unloading</h1>
                    <small>Unloading Management</small>
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
                            <input type="text" class="form-control form-control-sm mb-2 mb-md-0" name="reference_no" id="search_reference_no" value="{{$reference_no}}" placeholder="Keyword" />                      
                            <select name="tank_id" class="form-control form-control-sm ml-md-2 mb-2 mb-md-0" id="search_tank">
                                <option value="" hidden>Select Tank</option>
                                @foreach ($tanks as $item)                                    
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                            <select name="vehicle_id" class="form-control form-control-sm ml-md-2 mb-2 mb-md-0" id="search_vehicle">
                                <option value="" hidden>Select Vehicle</option>
                                @foreach ($vehicles as $item)                                    
                                    <option value="{{$item->id}}">{{$item->number}}</option>
                                @endforeach
                            </select>
                            <select name="user_id" class="form-control form-control-sm ml-md-2 mb-2 mb-md-0" id="search_user">
                                <option value="" hidden>Select User</option>
                                @foreach ($users as $item)                                    
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                            <input type="text" name="period" class="form-control form-control-sm daterange ml-md-2 mb-2 mb-md-0" id="search_period" value="{{$period}}" style="min-width:200px;" placeholder="Unloading Date" autocomplete="off" />
                            <button type="submit" class="btn btn-sm btn-primary ml-md-2 mb-2 mb-md-0"><i class="fa fa-search"></i>&nbsp;&nbsp;Search</button>
                            <button type="button" class="btn btn-sm btn-info mb-2 mb-md-0 ml-2" id="btn-reset"><i class="fa fa-eraser"></i>&nbsp;&nbsp;Reset</button>
                        </form>
                        @if ($role == 'user')                            
                            <button type="button" class="btn btn-success btn-sm float-right mg-b-5" id="btn-add"><i class="fas fa-plus mr-1"></i> Add New</button>
                        @endif
                    </div>
                    <div class="table-responsive mt-2">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-colored thead-primary">
                                <tr class="bg-blue">
                                    <th style="width:40px">#</th>
                                    <th>Reference Number</th>
                                    <th>Unloading Date</th>
                                    <th>Unit</th>
                                    <th>User</th>
                                    <th>Tank</th>
                                    <th>Vehicle</th>
                                    <th>Amount</th>
                                    <th>Description</th>
                                    <th>Attachment</th>
                                    {{-- <th>Status</th> --}}
                                    <th style="width:150px">{{__('Action')}}</th>
                                </tr>
                            </thead>
                            <tbody>                                
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ (($data->currentPage() - 1 ) * $data->perPage() ) + $loop->iteration }}</td>
                                        <td class="reference_no">{{$item->reference_no}}</td>
                                        <td class="date">@if($item->unloading_date){{$item->unloading_date}}@endif</td>
                                        <td class="unit" data-id="{{$item->unit_id}}">@isset($item->unit->name){{$item->unit->name}}@endisset</td>
                                        <td class="user" data-id="{{$item->user_id}}">@isset($item->user->name){{$item->user->name}}@endisset</td>
                                        <td class="tank" data-id="{{$item->tank_id}}">@isset($item->tank->name){{$item->tank->name}}@endisset</td>
                                        <td class="vehicle" data-id="{{$item->vehicle_id}}">@isset($item->vehicle->number){{$item->vehicle->number}}@endisset</td>
                                        <td class="amount" data-value="{{$item->amount}}">{{number_format($item->amount)}}</td>
                                        <td class="description">{{$item->description}}</td>
                                        <td class="attachment">
                                            @if(file_exists($item->attachment))
                                                <img src="{{asset($item->attachment)}}" class="rounded-circle" height="30" width="30" alt="">
                                            @endif
                                        </td>
                                        {{-- <td class="status" data-id="{{$item->status}}">
                                            @if($item->status == 1)
                                                <span class="badge badge-primary">Approved</span>
                                            @else
                                                <span class="badge badge-danger">Pending</span>
                                            @endif
                                        </td> --}}
                                        <td class="py-1">
                                            <a href="#" class="btn btn-sm btn-primary btn-icon mr-1 btn-edit" data-id="{{$item->id}}" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
                                            <a href="{{route('unloading.delete', $item->id)}}" class="btn btn-sm btn-danger btn-icon mr-1" onclick="return window.confirm('Are you sure?')" data-toggle="tooltip" title="Delete"><i class="fas fa-trash-alt"></i></a>
                                            {{-- <a href="{{route('user.approve', $item->id)}}" class="btn btn-sm btn-info btn-icon mr-1 btn-approve" onclick="return window.confirm('Are you sure?')" data-toggle="tooltip" title="Approve"><i class="fas fa-check-circle"></i></a> --}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="7"></th>
                                    <th>{{number_format($total_amount)}}</th>
                                    <th colspan="3"></th>
                                </tr>
                            </tfoot>
                        </table>                
                        <div class="clearfix mt-2">
                            <div class="float-left" style="margin: 0;">
                                <p>Total <strong style="color: red">{{ $data->total() }}</strong> Items</p>
                            </div>
                            <div class="float-right" style="margin: 0;">
                                {!! $data->appends([
                                    'reference_no' => $reference_no,
                                    'tank_id' => $tank_id,
                                    'vehicle_id' => $vehicle_id,
                                    'user_id' => $user_id,
                                ])->links() !!}
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
                    <h4 class="modal-title">Add Unloading</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <form action="" id="create_form" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label">Reference Number</label>
                            <input class="form-control reference_no" type="text" name="reference_no" placeholder="Reference Number" required>
                            <span class="invalid-feedback reference_no_error">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Date</label>
                            <input class="form-control datepicker" type="text" name="date" placeholder="Unloading Date" value="{{date('Y-m-d')}}" autocomplete="off" />
                            <span class="invalid-feedback date_error">
                                <strong></strong>
                            </span>
                        </div>                       
                        <div class="form-group">
                            <label class="control-label">Vehicle</label>
                            <select name="vehicle" id="vehicle" class="form-control vehicle">
                                <option value="" hidden>Select Vehicle</option>
                                @foreach ($user_vehicles as $item)
                                    <option value="{{$item->id}}">{{$item->number}}</option>                                    
                                @endforeach
                            </select>
                            <span class="invalid-feedback vehicle_error">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Amount</label>
                            <input class="form-control amount" type="number" name="amount" min="0" placeholder="Amount" required>
                            <span class="invalid-feedback amount_error">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Attachment</label>
                            <input class="form-control file-input-styled attachment" type="file" name="attachment" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">Description</label>
                            <textarea class="form-control" name="description" rows="2"></textarea>
                        </div>
                    </div>    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-submit"><i class="fas fa-check-circle mr-1"></i>&nbsp;Save</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times mr-1"></i>&nbsp;Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Unloading</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <form action="" id="edit_form" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" class="id" />                        
                        <div class="form-group">
                            <label class="control-label">Reference Number</label>
                            <input class="form-control reference_no" type="text" name="reference_no" placeholder="Reference Number" required>
                            <span class="invalid-feedback reference_no_error">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Date</label>
                            <input class="form-control datepicker date" type="text" name="date" placeholder="Unloading Date" value="{{date('Y-m-d')}}" autocomplete="off" />
                            <span class="invalid-feedback date_error">
                                <strong></strong>
                            </span>
                        </div>                       
                        <div class="form-group">
                            <label class="control-label">Vehicle</label>
                            <select name="vehicle" id="vehicle" class="form-control vehicle">
                                <option value="">Select Vehicle</option>
                                @foreach ($vehicles as $item)
                                    <option value="{{$item->id}}">{{$item->number}}</option>                                    
                                @endforeach
                            </select>
                            <span class="invalid-feedback vehicle_error">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Amount</label>
                            <input class="form-control amount" type="number" name="amount" min="0" placeholder="Amount" required>
                            <span class="invalid-feedback amount_error">
                                <strong></strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Attachment</label>
                            <input class="form-control file-input-styled attachment" type="file" name="attachment" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">Description</label>
                            <textarea class="form-control description" name="description" rows="2"></textarea>
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
    <script src="{{asset('master/plugins/jquery-ui-1.12.1/jquery-ui.min.js')}}"></script>
    <script src="{{asset('master/plugins/styling/uniform.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            $("#search_period").dateRangePicker({
                format: 'YYYY-MM-DD',
                autoClose: false,
            });
            $(".datepicker").datepicker({
                dateFormat: 'yy-mm-dd',
            });
            $('.file-input-styled').uniform({
                fileButtonClass: 'action btn bg-primary text-white'
            });  

            $("#btn-add").click(function(){
                $("#create_form .invalid-feedback strong").text('');
                $("#addModal").modal();
            });
    
            $("#create_form .btn-submit").click(function(){  
                $(".page-loader-wrapper").fadeIn();
                let attachment = $("#create_form .attachment")[0].files[0];
                let form_data = new FormData($("#create_form")[0]);
                form_data.append('attachment', attachment);
                $.ajax({
                    url: "{{route('unloading.create')}}",
                    type: 'post',
                    dataType: 'json',
                    cache: false,                   
                    processData: false,
                    contentType: false,
                    data: form_data,
                    success : function(data) {
                        if(data == 'success') {
                            alert("Created Successfully");
                            window.location.reload();
                        }
                        else if(data.message == 'The given data was invalid.') {
                            alert(data.message)
                        }
                        $(".page-loader-wrapper").fadeOut();
                    },
                    error: function(data) {
                        $("#ajax-loading").hide();
                        if(data.responseJSON.message == 'The given data was invalid.') {
                            let messages = data.responseJSON.errors;
                            if(messages.reference_no) {
                                $('#create_form .reference_no_error strong').text(data.responseJSON.errors.reference_no[0]);
                                $('#create_form .reference_no_error').show();
                                $('#create_form .reference_no').focus();
                            }
                            if(messages.vehicle) {
                                $('#create_form .vehicle_error strong').text(data.responseJSON.errors.vehicle[0]);
                                $('#create_form .vehicle_error').show();
                                $('#create_form .vehicle').focus();
                            }
                            if(messages.amount) {
                                $('#create_form .amount_error strong').text(data.responseJSON.errors.amount[0]);
                                $('#create_form .amount_error').show();
                                $('#create_form .amount').focus();
                            }
                        }
                    }
                });
            });
    
            $(".btn-edit").click(function(){
                let id = $(this).attr("data-id");
                let reference_no = $(this).parents('tr').find(".reference_no").text().trim();
                let date = $(this).parents('tr').find(".date").text().trim();
                let tank = $(this).parents('tr').find(".tank").data('id');
                let vehicle = $(this).parents('tr').find(".vehicle").data('id');
                let amount = $(this).parents('tr').find(".amount").data('value');
                let description = $(this).parents('tr').find(".description").text().trim();
    
                $("#edit_form input.form-control").val('');
                $("#edit_form .id").val(id);
                $("#edit_form .reference_no").val(reference_no);
                $("#edit_form .date").val(date);
                $("#edit_form .tank").val(tank);
                $("#edit_form .vehicle").val(vehicle);
                $("#edit_form .amount").val(amount);
                $("#edit_form .description").val(description);
    
                $("#editModal").modal();
            });
    
            $("#edit_form .btn-submit").click(function(){
                $("#ajax-loading").show();
                let attachment = $("#edit_form .attachment")[0].files[0];
                let form_data = new FormData($("#edit_form")[0]);
                form_data.append('attachment', attachment);
                $.ajax({
                    url: "{{route('unloading.edit')}}",
                    type: 'post',
                    dataType: 'json',
                    cache: false,                   
                    processData: false,
                    contentType: false,
                    data: form_data,
                    success : function(data) {
                        if(data == 'success') {
                            alert("Updated Successfully");
                            window.location.reload();
                        }
                        else if(data.message == 'The given data was invalid.') {
                            alert(data.message);
                        }
                        $("#ajax-loading").hide();
                    },
                    error: function(data) {
                        $("#ajax-loading").hide();
                        if(data.responseJSON.message == 'The given data was invalid.') {
                            let messages = data.responseJSON.errors;
                            if(messages.reference_no) {
                                $('#create_form .reference_no_error strong').text(data.responseJSON.errors.reference_no[0]);
                                $('#create_form .reference_no_error').show();
                                $('#create_form .reference_no').focus();
                            }
                            if(messages.vehicle) {
                                $('#create_form .vehicle_error strong').text(data.responseJSON.errors.vehicle[0]);
                                $('#create_form .vehicle_error').show();
                                $('#create_form .vehicle').focus();
                            }
                            if(messages.amount) {
                                $('#create_form .amount_error strong').text(data.responseJSON.errors.amount[0]);
                                $('#create_form .amount_error').show();
                                $('#create_form .amount').focus();
                            }
                        }
                    }
                });
            });
    
            $("#btn-reset").click(function(){
                $("#search_reference_no").val('');
                $("#search_tank").val('');
                $("#search_user").val('');
                $("#search_vehicle").val('');
                $("#search_period").val('');
            });  
            
            $("#pagesize").change(function(){
                $("#pagesize_form").submit();
            });
        });
    </script>
@endsection
