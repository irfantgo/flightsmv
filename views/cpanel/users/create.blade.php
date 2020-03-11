@extends('cpanel.cpanel')
@section('page_title', 'Users')
@section('page_content')


<form action="/admin/users/store" class="HFForm" method="post" data-na="success-then-redirect-to-next-screen" data-ns="/admin/users">
    <div class="row">
        <div class="col-md-6">
            <div class="card card-default color-palette-box">
                <div class="card-header">
                    Create New User
                </div>
                <div class="card-body">
                    
                    <div class="form-group">
                        <label class="col-form-label" for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" autocomplete="off" >
                    </div>

                    <div class="form-group">
                        <label class="col-form-label" for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Username" autocomplete="off" >
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
                    More Information
                </div>
                <div class="card-body">

                    <div class="form-group">
                        <label class="col-form-label" for="name">Name in Dhivehi</label>
                        <input type="text" class="form-control thaana-input" id="name" name="name" autocomplete="off" >
                    </div>

                    <div class="form-group">
                        <label class="col-form-label" for="dhi_bio">Bio in Dhivehi</label>
                        <textarea class="form-control thaana-input" id="dhi_bio" name="dhi_bio" row="8" autocomplete="off" ></textarea>
                    </div>

                    <div class="form-group">
                        <label class="col-form-label" for="eng_bio">Bio in English</label>
                        <textarea class="form-control" id="eng_bio" name="eng_bio" row="8" autocomplete="off" ></textarea>
                    </div>
                    
                </div>
            </div>
        </div>

    </div>

    {{ csrf() }}

    <div class="row">
        <div class="col-sm-12">
            <button type="submit" name="submit" id="submit" class="btn btn-primary">Create</button>
            <a href="/admin/users" class="btn btn-flat">Cancel</a>
        </div>
    </div>

</form>

@endsection