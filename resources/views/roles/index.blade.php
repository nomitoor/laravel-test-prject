@extends('layouts.master')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 text-center pt-5">
                <h1 class="display-one m-5">Roles</h1>
                <div class="text-left"><a href="roles/create" class="btn btn-outline-primary">Add new Role</a></div>

                <table class="table mt-3  text-left">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Permissions</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($roles as $role)
                            <tr>
                                <td>{!! $role->name !!}</td>
                                <td>
                                    <ul style="list-style:none">
                                        @foreach ($role->permissions as $permission)
                                            <li>{{ $permission->name }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td><a href="roles/{!! $role->id !!}/edit" class="btn btn-outline-primary">Edit</a>
                                    <button type="button" class="btn btn-outline-danger ml-1"
                                        onClick='showModel({!! $role->id !!})'>Delete</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">No roles found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <div class="modal fade" id="deleteConfirmationModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">Are you sure to delete this record?</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" onClick="dismissModel()">Cancel</button>
                    <form id="delete-frm" class="" action="" method="POST">
                        @method('DELETE')
                        @csrf
                        <button class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showModel(id) {
            var frmDelete = document.getElementById("delete-frm");
            frmDelete.action = 'roles/' + id;
            var confirmationModal = document.getElementById("deleteConfirmationModel");
            confirmationModal.style.display = 'block';
            confirmationModal.classList.remove('fade');
            confirmationModal.classList.add('show');
        }

        function dismissModel() {
            var confirmationModal = document.getElementById("deleteConfirmationModel");
            confirmationModal.style.display = 'none';
            confirmationModal.classList.remove('show');
            confirmationModal.classList.add('fade');
        }
    </script>
@endsection
