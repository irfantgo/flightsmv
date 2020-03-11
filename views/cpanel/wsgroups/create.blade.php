@extends('cpanel.cpanel')
@section('page_title', 'Workstation Groups')
@section('page_content')

<form action="/wsgroups/create" class="HFForm" method="post" data-na="success-then-redirect-to-next-screen" data-ns="/wsgroups">
    <h5>Create New Workstation Group</h5>
    <div class="row">
        <div class="col-md-6">
            <div class="card card-default color-palette-box">
                <div class="card-body">
                    
                    <div class="form-group">
                        <label class="col-form-label" for="group_name">Group Name</label>
                        <input type="text" class="form-control" id="group_name" name="group_name" placeholder="Group Name" autocomplete="off" >
                    </div>
                    
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>

    {{ csrf() }}

    <div class="row">
        <div class="col-sm-12">
            <button type="submit" name="submit" id="submit" class="btn btn-primary">Create</button>
            <a href="/wsgroups" class="btn btn-flat">Cancel</a>
        </div>
    </div>

</form>

@endsection