@extends('cpanel.cpanel')
@section('page_title', 'Profile')
@section('page_content')

<div class="content">
    <div class="row">
        <div class="col-md-3">
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle" src="{{ assets('assets/dummy-user/dummy1.jpg') }}" alt="User profile picture">
                    </div>
  
                    <h3 class="profile-username text-center">{{ $user['display_name'] }}</h3>

                    <p class="text-muted text-center">With us since {{ date('F Y', strtotime($user['joined_dt'])) }}</p>
  
                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>Unpublished</b> <a class="float-right">{{ $articles['unpublished']['count'] }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Published</b> <a class="float-right">{{ $articles['published']['count'] }}</a>
                        </li>
                    </ul>
                    
                    @if ( $user_meta['social_media'] != NULL )
                        <a href="{{ $user_meta['social_media'] }}" target="_blank" class="btn btn-primary btn-block"><b>Follow on Social Media</b></a>
                    @endif

                </div>
                <!-- /.card-body -->
            </div>

            <div class="card">
                <div class="card-header">
                    Account Password
                </div>
                <div class="card-body">
                    <form action="/admin/profile/update" class="HFForm" method="post" data-na="success-then-redirect-to-next-screen" data-ns="/admin/profile">
                        <div class="form-group">
                            <label class="col-form-label" for="cur_pass">Current Password</label>
                            <input type="password" class="form-control" id="cur_pass" name="cur_pass" autocomplete="off" >
                        </div>

                        <div class="form-group">
                            <label class="col-form-label" for="new_pass">New Password</label>
                            <input type="password" class="form-control" id="new_pass" name="new_pass" autocomplete="off" >
                        </div>

                        <div class="form-group">
                            <label class="col-form-label" for="re_new_pass">Re-type New Password</label>
                            <input type="password" class="form-control" id="re_new_pass" name="re_new_pass" autocomplete="off" >
                        </div>
                    
                        {{ csrf() }}
                    
                        <button type="submit" name="submit" id="submit" class="btn btn-primary btn-block">Update Password</button>
                    
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection