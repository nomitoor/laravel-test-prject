@extends('layouts.master')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-6 offset-3 text-center pt-5">
                <h1 class="display-one mt-5">Create Permissions</h1>
                <div class="text-left"><a href="/permissions" class="btn btn-outline-primary">Permissions List</a></div>

                <form id="edit-frm" method="POST" action="{{ route('permissions.store') }}" class="border p-3 mt-2">
                    <div class="control-group col-12 text-left">
                        <label for="name">Name</label>
                        <div>
                            <input type="text" id="name" class="form-control mb-4" name="name"
                                placeholder="Enter Name" value="{!! old('name') !!}" required>
                        </div>
                    </div>
                    <div class="control-group col-12 text-left">
                        <label for="description">Description</label>
                        <div>
                            <textarea rows="4" cols="50" type="text" id="description" class="form-control mb-4" name="description" required>
                            {!! old('description') !!}
                            </textarea>
                        </div>
                    </div>

                    @csrf
                    @method('POST')
                    <div class="control-group col-12 text-right mt-2">
                        <button class="btn btn-primary">Save Permissions</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
