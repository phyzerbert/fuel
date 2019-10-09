@extends('layouts.master')

@section('content')
    @php
        $role = Auth::user()->role->slug;
    @endphp
    <div class="content-header row align-items-center m-0">
        <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
            <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
                <li class="breadcrumb-item"><a href="#"><i class="hvr-buzz-out fas fa-home"></i></a></li>
                <li class="breadcrumb-item">Setting</li>
                <li class="breadcrumb-item active">Location</li>
            </ol>
        </nav>
        <div class="col-sm-8 header-title p-0">
            <div class="media">
                <div class="header-icon text-success mr-3"><i class="hvr-buzz-out fas fa-layer-group"></i></div>
                <div class="media-body">
                    <h1 class="font-weight-bold">Location</h1>
                    <small>Location Management</small>
                </div>
            </div>
        </div>
    </div> 
    <div class="body-content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-body card-fill">
                    <div class="">
                        <button type="button" class="btn btn-success btn-sm float-right mg-b-5" id="btn-add"><i class="fas fa-plus mr-1"></i>Add New</button>
                    </div>
                    <div class="table-responsive mt-2">
                        <table class="table table-bordered table-hover">
                            <thead class="">
                                <tr class="bg-blue">
                                    <th style="width:40px;">#</th>
                                    <th>City</th>
                                    <th>District</th>
                                    <th>Distance To HQ</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>                                
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td class="city" data-id="{{$item->city_id}}">{{$item->city->name}}</td>
                                        <td class="district">{{$item->district}}</td>
                                        <td class="distance_to_hq">{{$item->distance_to_hq}}</td>
                                        <td class="py-1">
                                            <a href="#" class="btn btn-sm btn-primary btn-icon mr-1 btn-edit" data-id="{{$item->id}}" data-toggle="tooltip" title="Edit"><i class="fas fa-edit"></i></a>
                                            <a href="{{route('location.delete', $item->id)}}" class="btn btn-sm btn-danger btn-icon" data-id="{{$item->id}}" onclick="return window.confirm('Are you sure?')" data-toggle="tooltip" title="Delete"><i class="fas fa-trash-alt"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
                    <h4 class="modal-title">Add Location</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <form action="{{route('location.create')}}" id="create_form" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label">City</label>
                            <select class="form-control city" name="city" placeholder="City" required>
                                <option value="" hidden>Select City</option>
                                @foreach ($cities as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach                                
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">District</label>
                            <input class="form-control district" type="text" name="district" placeholder="District">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Distance To Hq</label>
                            <input class="form-control distance_to_hq" type="text" name="distance_to_hq" placeholder="Distance To Hq">
                        </div>
                    </div>    
                    <div class="modal-footer">
                        <button type="submit" id="btn_create" class="btn btn-primary btn-submit"><i class="fas fa-check-circle mr-1"></i>&nbsp;Save</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times mr-1"></i>&nbsp;Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Location</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <form action="{{route('location.edit')}}" id="edit_form" method="post">
                    @csrf
                    <input type="hidden" name="id" class="id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label">City</label>
                            <select class="form-control city" name="city" placeholder="City" required>
                                <option value="" hidden>Select City</option>
                                @foreach ($cities as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach                                
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">District</label>
                            <input class="form-control district" type="text" name="district" placeholder="District">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Distance To Hq</label>
                            <input class="form-control distance_to_hq" type="text" name="distance_to_hq" placeholder="Distance To Hq">
                        </div>
                    </div> 
                    <div class="modal-footer">
                        <button type="submit" id="btn_update" class="btn btn-primary btn-submit"><i class="fa fa-check mg-r-10"></i>&nbsp;Save</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times mg-r-10"></i>&nbsp;Close</button>
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

        $(".btn-edit").click(function(){
            let id = $(this).data("id");
            let city = $(this).parents('tr').find(".city").data('id');
            let district = $(this).parents('tr').find(".district").text().trim();
            let distance_to_hq = $(this).parents('tr').find(".distance_to_hq").text().trim();
            $("#edit_form input.form-control").val('');
            $("#editModal .id").val(id);
            $("#editModal .city").val(city);
            $("#editModal .district").val(district);
            $("#editModal .distance_to_hq").val(distance_to_hq);
            $("#editModal").modal();
        });

    });
</script>
@endsection

