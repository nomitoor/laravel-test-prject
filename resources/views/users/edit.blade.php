@extends('layouts.master')
@section('content')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <div class="container">
        <div class="row">
            <div class="col-6 offset-3 text-center pt-5">
                <h1 class="display-one mt-5">Create Users</h1>
                <div class="text-left"><a href="/users" class="btn btn-outline-primary">Users List</a></div>

                <form id="edit-frm" method="POST" action="{{ route('users.update', ['user' => $user->id]) }}" class="border p-3 mt-2">
                    <div class="control-group col-12 text-left">
                        <label for="name">Name</label>
                        <div>
                            <input type="text" id="name" class="form-control mb-4" name="name"
                                placeholder="Enter Name" value="{!! $user->name !!}" required>
                        </div>
                    </div>
                    <div class="control-group col-12 text-left">
                        <label for="email">Email</label>
                        <div>
                            <input type="email" id="email" class="form-control mb-4" name="email"
                                placeholder="Enter Email" value="{!! $user->email !!}" required>
                        </div>
                    </div>
                    <div class="control-group col-12 text-left">
                        <label for="roles">Roles</label>
                        <div>
                            <select name="roles[]" id="select2" multiple class="form-control mb-4 select2">
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}"
                                        {{ $user->roles->contains($role->id) ? 'selected' : '' }}>
                                        {{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    @csrf
                    @method('PUT')
                    <div class="control-group col-12 text-right mt-2"><button class="btn btn-primary">Save Role</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.3.slim.min.js"
        integrity="sha256-ZwqZIVdD3iXNyGHbSYdsmWP//UBokj2FHAxKuSBKDSo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@endsection
