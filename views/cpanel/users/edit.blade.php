@extends('cpanel.cpanel')
@section('page_title', 'Users')
@section('page_content')


<form action="/users/update/{{ $user['ID'] }}" class="HFForm" method="post" data-na="success-then-redirect-to-next-screen" data-ns="/users/edit/{{ $user['ID'] }}">
    <div class="row">
        <div class="col-md-6">
            <div class="card card-default color-palette-box">
                <div class="card-header">
                    Edit User
                </div>
                <div class="card-body">
                    
                    <div class="form-group">
                        <label class="col-form-label" for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter staff full name" autocomplete="off" value="{{ $user['display_name'] }}" >
                    </div>

                    <div class="form-group">
                        <label class="col-form-label" for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Active Directory Username" autocomplete="off" value="{{ $user['username'] }}" >
                    </div>

                    <div class="form-group">
                        <label class="col-form-label" for="email">Email</label>
                        <input type="text" class="form-control" id="email" name="email" autocomplete="off" value="{{ $user['email'] }}" >
                    </div>

                    <div class="form-group">
                        <label class="col-form-label" for="group_id">Group</label>
                        <select name="group_id" id="group_id" class="form-control select2">
                            @foreach ($groups as $group)
                                <option {{ ( $group['ID'] == $user['group_id'] ) ? ' selected ' : '' }} value="{{ $group['ID'] }}">{{ $group['group_name'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="col-form-label" for="isActive">
                            <input {{ ( $user['isActive'] ? ' checked ' : '' ) }} type="checkbox" id="isActive" name="isActive" value="1">
                            Account is Active</label>
                        
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
                                    <td width="10%"><input type="checkbox" id="dept-{{ $i }}" name="departments[{{$i}}][dept_id]" value="{{ $w['ID'] }}" {{ (in_array($w['ID'], $mapped_depts['dept_id']) ? ' checked="" ' : '' ) }} ></td>
                                    <td width="10%"><input type="checkbox" id="mail-{{ $i }}" name="departments[{{$i}}][send_mail]" value="1" {{ (in_array($w['ID'], $mapped_depts['send_mail']) ? ' checked="" ' : '' ) }} ></td>
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
            <button type="submit" name="submit" id="submit" class="btn btn-primary">Edit</button>
            <a href="/users" class="btn btn-flat">Cancel</a>
        </div>
    </div>

</form>

@endsection