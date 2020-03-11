@extends('cpanel.cpanel')
@section('page_title', 'Groups')
@section('page_content')


<form action="/groups/store" class="HFForm" method="post" data-na="success-then-redirect-to-next-screen" data-ns="/groups">
    <h5>Create New Group</h5>
    <div class="row">
        <div class="col-md-6">
            <div class="card card-default color-palette-box">
                <div class="card-body">
                    
                    <div class="form-group">
                        <label class="col-form-label" for="group_name">Group Name</label>
                        <input type="text" class="form-control" id="group_name" name="group_name" placeholder="" autocomplete="off" >
                    </div>

                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-default color-palette-box">
                <div class="card-header">
                    Group Roles
                </div>
                <div class="card-body">
                    
                    @foreach ($roles as $role)
                        <div class="form-group clearfix">
                            <div class="icheck-primary d-inline">
                                <input type="checkbox" name="roles[]" value="{{ $role['code'] }}" id="r_{{ $role['code'] }}">
                                <label for="r_{{ $role['code'] }}">{{ $role['description'] }}</label>
                            </div>
                        </div>
                    @endforeach
                    
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>

    {{ csrf() }}

    <div class="row">
        <div class="col-sm-12">
            <button type="submit" name="submit" id="submit" class="btn btn-primary">Create</button>
            <a href="/groups" class="btn btn-flat hf-alt-btn">Cancel</a>
        </div>
    </div>

</form>

@endsection