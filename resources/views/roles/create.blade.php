@extends('layouts.master')
@section('content')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <div class="container">
        <div class="row">
            <div class="col-6 offset-3 text-center pt-5">
                <h1 class="display-one mt-5">Create Roles</h1>
                <div class="text-left"><a href="/roles" class="btn btn-outline-primary">Roles List</a></div>

                <form id="edit-frm" method="POST" action="{{ route('roles.store') }}" class="border p-3 mt-2">
                    <div class="control-group col-12 text-left">
                        <label for="name">Name</label>
                        <div>
                            <input type="text" id="name" class="form-control mb-4" name="name"
                                placeholder="Enter Name" value="{!! old('name') !!}" required>
                        </div>
                    </div>
                    <div class="control-group col-12 text-left">
                        <label for="permissions">Permissions</label>
                        <div>
                            <select name="permissions[]" id="select2" multiple class="form-control mb-4 select2" name="permissions">
                                @foreach ($permissions as $permission)
                                    <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    @csrf
                    @method('POST')
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
