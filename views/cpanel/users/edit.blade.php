@extends('cpanel.cpanel')
@section('page_title', 'Users')
@section('page_content')


<form action="/admin/users/patch/{{ $user['ID'] }}" class="HFForm" method="post" data-na="success-then-redirect-to-next-screen" data-ns="/admin/users/edit/{{ $user['ID'] }}">
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
                    More Information
                </div>
                <div class="card-body">

                    <div class="form-group">
                        <label class="col-form-label" for="dv_name">Name in Dhivehi</label>
                        <input type="text" class="form-control thaana-input" id="dv_name" name="dv_name" autocomplete="off" value="{{ $user_meta['dv_name'] }}" >
                    </div>

                    <div class="form-group">
                        <label class="col-form-label" for="dhi_bio">Bio in Dhivehi</label>
                        <textarea class="form-control thaana-input" id="dhi_bio" name="dhi_bio" row="8" autocomplete="off" >{{ $user_meta['dv_bio'] }}</textarea>
                    </div>

                    <div class="form-group">
                        <label class="col-form-label" for="eng_bio">Bio in English</label>
                        <textarea class="form-control" id="eng_bio" name="eng_bio" row="8" autocomplete="off" >{{ $user_meta['en_bio'] }}</textarea>
                    </div>

                    <div class="form-group">
                        <label class="col-form-label" for="social_media">Social Media Link</label>
                        <input type="text" class="form-control" id="social_media" name="social_media" autocomplete="off" value="{{ $user_meta['social_media'] }}" >
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

    {{ csrf() }}

    <div class="row">
        <div class="col-sm-12">
            <button type="submit" name="submit" id="submit" class="btn btn-primary">Edit</button>
            <a href="/admin/users" class="btn btn-flat">Cancel</a>
            <a class="float-right btn btn-danger HFActionBtn" href="/admin/users/resetpass/{{ $user['ID'] }}" data-title="Reset Password" data-text="A new random password will be generated and emailed to the user." data-type="warning" data-ns="/admin/users/edit/{{ $user['ID'] }}">Reset Password</a>
        </div>
    </div>

</form>

@endsection