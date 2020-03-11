@extends('cpanel.cpanel')
@section('page_title', 'Roles')
@section('page_content')


<form action="/roles/update/{{ $role['ID'] }}" class="HFForm" method="post" data-na="success-then-redirect-to-next-screen" data-ns="/roles">
    <div class="row">
        <div class="col-md-6">
            <div class="card card-default color-palette-box">
                <div class="card-header">
                    Edit Role
                </div>
                <div class="card-body">
                    
                    <div class="form-group">
                        <label class="col-form-label" for="code">Code</label>
                        <input type="text" class="form-control" id="code" name="code" placeholder="Use BLOCK letters" autocomplete="off" value="{{ $role['code'] }}" >
                    </div>

                    <div class="form-group">
                        <label class="col-form-label" for="description">Description</label>
                        <input type="text" class="form-control" id="description" name="description" placeholder="Something meaningful to remember what this role is about" autocomplete="off" value="{{ $role['description'] }}" >
                    </div>
                    
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>

    {{ csrf() }}

    <div class="row">
        <div class="col-sm-12">
            <button type="submit" name="submit" id="submit" class="btn btn-primary">Update</button>
            <a href="/roles" class="btn btn-flat">Cancel</a>
        </div>
    </div>

</form>

@endsection