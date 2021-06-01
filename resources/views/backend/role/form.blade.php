@extends('layouts.backend.master')

@section('title-header')
    Role
@endsection

@section('menus')
    User Config
@endsection

@section('submenus')
    Role
@endsection

@section('content')
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">Form Role</h5>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" id="form" action="{{route('admin.role.'. (isset($role) ? 'update' : 'store') )}}" method="POST">
                {{ csrf_field() }}
                <div class="form-group">
                    <input type="hidden" name="id" value="{{(isset($role) ? "$role->id" : '')}}">
                </div>			
                
                <div class="form-group">
                    <label class="control-label col-lg-2">Nama Role</label>
                    <div class="col-lg-10">
                        <input type="text" class="form-control" name="name" id="name" placeholder="Nama Role" value="{{(isset($role) ? "$role->name" : '')}}">
                        <span class="help-block"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-lg-2">Deskripsi</label>
                    <div class="col-lg-10">
                        <input type="text" class="form-control" name="description" id="description" placeholder="Deskripsi" value="{{(isset($role) ? "$role->description" : '')}}">
                        <span class="help-block"></span>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-lg-2">
                        <label for="control-label">Module</label>
                    </div>
                    <div class="col-lg-10">
                        <table class="table datatable-basic table-hover table-bordered striped">
                            <thead>
                                <tr class="bg-teal-400">
                                    <th>No</th>
                                    <th>Module Permission</th>
                                    <th>Read</th>
                                    <th>Create</th>
                                    <th>Update</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

                <div class="form-group" style="margin-top: 50px; margin-left: 10px;">
                    <a class="btn btn-danger" href="{{route('admin.role.index')}}">Kembali</a>
                    <button type="submit" class="btn btn-primary">{{(isset($role) ? 'Update' : 'Simpan')}}</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{asset('assets/admin/js/form-validator/jquery.form-validator.min.js')}}"></script>
    
    <script>
        $(document).ready(function () {
            var config = {
                form : 'form',
                validate : {
                    'name' : {
                        validation : 'required'
                    }
                }
            };
            
            $.validate({
                modules : 'jsconf, security',
                onModulesLoaded : function() {
                    $.setupValidation(config);
                }
            });

            $('.datatable-basic').DataTable({
                processing: true,
                serverside: true,
                autoWidth: false,
                bLengthChange: false,
                pageLength: 10,
                ajax: {
                    url: "{{route('admin.role.create')}}",
                },
                columns: [
                    {data: "id", render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                    },
                    {data: "name", name: "name", orderable: false},
                    {data: "readable", name: "readable", orderable: false},
                    {data: "createable", name: "createable", orderable: false},
                    {data: "updateable", name: "updateable", orderable: false},
                    {data: "deleteable", name: "deleteable", orderable: false}
                ],
                columnDefs: [
                    { width: "5%", "targets": [0, 2, 3, 4, 5] },
                    { className: "text-center", "targets": [2, 3, 4, 5] }
                ]
            });
        });
    </script>
@endsection
