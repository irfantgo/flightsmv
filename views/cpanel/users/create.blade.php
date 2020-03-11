@extends('cpanel.cpanel')
@section('page_title', 'Users')
@section('page_content')


<form action="/users/create" class="HFForm" method="post" data-na="success-then-redirect-to-next-screen" data-ns="/users">
    <div class="row">
        <div class="col-md-6">
            <div class="card card-default color-palette-box">
                <div class="card-header">
                    Create New User
                </div>
                <div class="card-body">
                    
                    <div class="form-group">
                        <label class="col-form-label" for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter staff full name" autocomplete="off" >
                    </div>

                    <div class="form-group">
                        <label class="col-form-label" for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Active Directory Username" autocomplete="off" >
                    </div>

                    <div class="form-group">
                        <label class="col-form-label" for="email">Email</label>
                        <input type="text" class="form-control" id="email" name="email" autocomplete="off" >
                    </div>

                    <div class="form-group">
                        <label class="col-form-label" for="group_id">Group</label>
                        <select name="group_id" id="group_id" class="form-control select2">
                            @foreach ($groups as $group)
                                <option value="{{ $group['ID'] }}">{{ $group['group_name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-default color-palette-box">
                <div class="card-header">
                    User Departments
                </div>
                <div class="card-body" style="min-height: 400px; overflow: scroll;">

                    @if ( empty($departments) )
                        <p>No Departments Found</p>
                    @else    
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th><i class="fas fa-handshake"></th>
                                    <th><i class="fas fa-envelope-open-text"></th>
                                    <th>Department Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($departments as $i => $w)
                                <tr>
                                    <td width="10%"><input type="checkbox" id="dept-{{ $i }}" name="departments[{{$i}}][dept_id]" value="{{ $w['ID'] }}"></td>
                                    <td width="10%"><input type="checkbox" id="mail-{{ $i }}" name="departments[{{$i}}][send_mail]" value="1"></td>
                                    <td>{{ $w['name'] }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif

                    
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>

    {{ csrf() }}

    <div class="row">
        <div class="col-sm-12">
            <button type="submit" name="submit" id="submit" class="btn btn-primary">Create</button>
            <a href="/users" class="btn btn-flat">Cancel</a>
        </div>
    </div>

</form>

@endsection