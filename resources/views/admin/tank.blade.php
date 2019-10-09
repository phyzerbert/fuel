@extends('layouts.master')

@section('content')
    @php
        $role = Auth::user()->role->slug;
    @endphp
    <div class="content-header row align-items-center m-0">
        <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
            <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
                <li class="breadcrumb-item"><a href="#"><i class="hvr-buzz-out fas fa-home"></i></a></li>
                <li class="breadcrumb-item active">Tanks</li>
            </ol>
        </nav>
        <div class="col-sm-8 header-title p-0">
            <div class="media">
                <div class="header-icon text-success mr-3"><i class="hvr-buzz-out fas fa-box"></i></div>
                <div class="media-body">
                    <h1 class="font-weight-bold">Tanks</h1>
                    <small>Tank Management</small>
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
                                    <th>Type Of Fuel</th>
                                    <th>Capacity</th>
                                    <th>Location</th>
                                    <th>User</th>
                                    <th>Filling</th>
                                    <th>Unloading</th>
                                    <th>Balance</th>
                                    <th style="width:150px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $footer_filling = $footer_unloading = $footer_balance = 0;
                                @endphp                               
                                @foreach ($data as $item)
                                    @php
                                        $unloading = $item->unloadings()->sum('amount');
                                        $filling = $item->fillings()->sum('amount');
                                        $balance = $filling - $unloading;
                                        $footer_filling += $filling;
                                        $footer_unloading += $unloading;
                                        $footer_balance += $balance;
                                    @endphp
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td class="name">{{$item->name}}</td>
                                        <td class="fuel" data-id="{{$item->fuel_id}}">{{$item->fuel->name}}</td>
                                        <td class="capacity" data-value="{{$item->capacity}}">{{number_format($item->capacity)}}</td>
                                        <td class="location" data-id="{{$item->location_id}}">@if($item->location){{$item->location->city->name}}, {{$item->location->district}}@endif</td>
                                        <td class="user" data-id="{{$item->user_id}}">@if($item->user){{$item->user->name}}@endif</td>
                                        <td class="filling">{{number_format($filling)}}</td>
                                        <td class="unloading">{{number_format($unloading)}}</td>
                                        <td class="balance">{{number_format($balance)}}</td>
                                        <td class="py-1">
                                            <a href="#" class="btn btn-sm btn-primary btn-icon mr-1 btn-edit" data-id="{{$item->id}}" data-toggle="tooltip" title="Edit"><i class="fas fa-edit"></i></a>
                                            <a href="{{route('tank.delete', $item->id)}}" class="btn btn-sm btn-danger btn-icon" data-id="{{$item->id}}" onclick="return window.confirm('Are you sure?')" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fas fa-trash-alt"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="6"></th>
                                    <th>{{number_format($footer_filling)}}</th>
                                    <th>{{number_format($footer_unloading)}}</th>
                                    <th>{{number_format($footer_balance)}}</th>
                                    <th colspan="3"></th>
                                </tr>
                            </tfoot>
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
                    <h4 class="modal-title">Add Tank</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <form action="{{route('tank.create')}}" id="create_form" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label">Name</label>
                            <input class="form-control name" type="text" name="name" placeholder="Name">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Fuel Type</label>
                            <select name="fuel" id="" class="form-control">
                                <option value="" hidden>Fuel Type</option>
                                @foreach ($fuels as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Capacity</label>
                            <input class="form-control name" type="number" name="capacity" min="0" value="20000" placeholder="Capacity" />
                        </div>

                        <div class="form-group">
                            <label class="control-label">Location</label>
                            <select name="location" class="form-control location">
                                <option value="" hidden>Location</option>
                                @foreach ($locations as $item)
                                    <option value="{{$item->id}}">{{$item->city->name}}, {{$item->district}}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label">User</label>
                            <select name="user" class="form-control user">
                                <option value="" hidden>Select User</option>
                                @foreach ($users as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
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
                    <h4 class="modal-title">Edit Tank</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <form action="{{route('tank.edit')}}" id="edit_form" method="post">
                    @csrf
                    <input type="hidden" name="id" class="id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label">Name</label>
                            <input class="form-control name" type="text" name="name" placeholder="Name">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Fuel Type</label>
                            <select name="fuel" class="form-control fuel">
                                <option value="" hidden>Fuel Type</option>
                                @foreach ($fuels as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Capacity</label>
                            <input class="form-control capacity" type="number" name="capacity" min="0" value="20000" placeholder="Capacity" />
                        </div>

                        <div class="form-group">
                            <label class="control-label">Location</label>
                            <select name="location" class="form-control location">
                                <option value="" hidden>Location</option>
                                @foreach ($locations as $item)
                                    <option value="{{$item->id}}">{{$item->city->name}}, {{$item->district}}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label">User</label>
                            <select name="user" class="form-control user">
                                <option value="" hidden>Select User</option>
                                @foreach ($users as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
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
            $("#create_form input.form-control[type='text']").val('');
            $("#create_form .invalid-feedback strong").text('');
            $("#addModal").modal();
        });

        $(".btn-edit").click(function(){
            let id = $(this).data("id");
            let name = $(this).parents('tr').find(".name").text().trim();
            let fuel = $(this).parents('tr').find(".fuel").data('id');
            let capacity = $(this).parents('tr').find(".capacity").data('value');
            let location = $(this).parents('tr').find(".location").data('id');
            let user = $(this).parents('tr').find(".user").data('id');
            $("#edit_form input.form-control").val('');
            $("#editModal .id").val(id);
            $("#editModal .name").val(name);
            $("#editModal .fuel").val(fuel).change();
            $("#editModal .capacity").val(capacity);
            $("#editModal .location").val(location);
            $("#editModal .user").val(user);
            $("#editModal").modal();
        });
    });
</script>
@endsection

