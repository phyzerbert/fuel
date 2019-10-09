@extends('layouts.master')

@section('content')
    @php
        $role = Auth::user()->role->slug;
    @endphp
    <div class="content-header row align-items-center m-0">
        <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
            <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
                <li class="breadcrumb-item"><a href="#"><i class="hvr-buzz-out fas fa-home"></i></a></li>
                <li class="breadcrumb-item active">Drivers</li>
            </ol>
        </nav>
        <div class="col-sm-8 header-title p-0">
            <div class="media">
                <div class="header-icon text-success mr-3"><i class="hvr-buzz-out fas fa-layer-group"></i></div>
                <div class="media-body">
                    <h1 class="font-weight-bold">Drivers</h1>
                    <small>Driver Management</small>
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
                                    <th>Name</th>
                                    <th>Surname</th>
                                    <th>National ID</th>
                                    <th>Social Number</th>
                                    <th>Mobile</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>                                
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td class="name">{{$item->name}}</td>
                                        <td class="surname">{{$item->surname}}</td>
                                        <td class="national_id">{{$item->national_id}}</td>
                                        <td class="social_number">{{$item->social_number}}</td>
                                        <td class="mobile">{{$item->mobile}}</td>
                                        <td class="py-1">
                                            <a href="#" class="btn btn-sm btn-primary btn-icon mr-1 btn-edit" data-id="{{$item->id}}" data-toggle="tooltip" title="Edit"><i class="fas fa-edit"></i></a>
                                            <a href="{{route('driver.delete', $item->id)}}" class="btn btn-sm btn-danger btn-icon" data-id="{{$item->id}}" onclick="return window.confirm('Are you sure?')" data-toggle="tooltip" title="Delete"><i class="fas fa-trash-alt"></i></a>
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
                    <h4 class="modal-title">Add Unit</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <form action="{{route('driver.create')}}" id="create_form" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label">Name</label>
                            <input class="form-control name" type="text" name="name" placeholder="Name">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Surname</label>
                            <input class="form-control surname" type="text" name="surname" placeholder="Surame">
                        </div>
                        <div class="form-group">
                            <label class="control-label">National ID</label>
                            <input class="form-control national_id" type="text" name="national_id" placeholder="Natianal ID">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Social Number</label>
                            <input class="form-control social_number" type="text" name="social_number" placeholder="Social Number">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Mobile</label>
                            <input class="form-control mobile" type="text" name="mobile" placeholder="Mobile">
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
                    <h4 class="modal-title">Edit Unit</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <form action="{{route('driver.edit')}}" id="edit_form" method="post">
                    @csrf
                    <input type="hidden" name="id" class="id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label">Name</label>
                            <input class="form-control name" type="text" name="name" placeholder="Name">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Surname</label>
                            <input class="form-control surname" type="text" name="surname" placeholder="Surame">
                        </div>
                        <div class="form-group">
                            <label class="control-label">National ID</label>
                            <input class="form-control national_id" type="text" name="national_id" placeholder="Natianal ID">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Social Number</label>
                            <input class="form-control social_number" type="text" name="social_number" placeholder="Social Number">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Mobile</label>
                            <input class="form-control mobile" type="text" name="mobile" placeholder="Mobile">
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
            let name = $(this).parents('tr').find(".name").text().trim();
            let surname = $(this).parents('tr').find(".surname").text().trim();
            let national_id = $(this).parents('tr').find(".national_id").text().trim();
            let social_number = $(this).parents('tr').find(".social_number").text().trim();
            let mobile = $(this).parents('tr').find(".mobile").text().trim();
            $("#edit_form input.form-control").val('');
            $("#editModal .id").val(id);
            $("#editModal .name").val(name);
            $("#editModal .surname").val(surname);
            $("#editModal .national_id").val(national_id);
            $("#editModal .social_number").val(social_number);
            $("#editModal .mobile").val(mobile);
            $("#editModal").modal();
        });

    });
</script>
@endsection

