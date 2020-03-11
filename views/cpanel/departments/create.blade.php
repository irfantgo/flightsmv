@extends('cpanel.cpanel')
@section('page_title', 'Departments')
@section('page_content')


<form action="/departments/store" class="HFForm" method="post" data-na="success-then-redirect-to-next-screen" data-ns="/departments">
    <div class="row">
        <div class="col-md-6">
            <div class="card card-default color-palette-box">
                <div class="card-header">
                    Create New Department
                </div>
                <div class="card-body">
                    
                    <div class="form-group">
                        <label class="col-form-label" for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Offical Name of the Department" autocomplete="off" >
                    </div>

                    <div class="form-group">
                        <label class="col-form-label" for="email">Email</label>
                        <input type="text" class="form-control" id="email" name="email" placeholder="Designated email for the department" autocomplete="off" >
                    </div>

                    <div class="form-group">
                        <label class="col-form-label" for="attendance_view">Attendance View Name</label>
                        <input type="text" class="form-control" id="attendance_view" name="attendance_view" placeholder="Eg: dbo.example" autocomplete="off" >
                    </div>
                    
                    <div class="form-group">
                        <label class="col-form-label" for="schedule_view">Schedule View Name</label>
                        <input type="text" class="form-control" id="schedule_view" name="schedule_view" placeholder="Eg: dbo.example" autocomplete="off" >
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
            <a href="/departments" class="btn btn-flat">Cancel</a>
        </div>
    </div>

</form>

@endsection