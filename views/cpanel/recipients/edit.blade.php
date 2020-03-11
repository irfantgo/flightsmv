@extends('cpanel.cpanel')
@section('page_title', 'Recipients')
@section('page_content')


<form action="/recipients/patch/{{ $recipient['ID'] }}" class="HFForm" method="post" data-na="success-then-redirect-to-next-screen" data-ns="/recipients/edit/{{ $recipient['ID'] }}">
    <div class="row">
        <div class="col-md-6">
            <div class="card card-default color-palette-box">
                <div class="card-header">
                    Edit Recipient
                </div>
                <div class="card-body">
                    
                    <div class="form-group">
                        <label class="col-form-label" for="full_name">Name</label>
                        <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Enter staff full name" autocomplete="off" value="{{ $recipient['full_name'] }}" >
                    </div>

                    <div class="form-group">
                        <label class="col-form-label" for="email">Email</label>
                        <input type="text" class="form-control" id="email" name="email" placeholder="Email" autocomplete="off" value="{{ $recipient['email'] }}" >
                    </div>

                    <div class="form-group">
                        <label class="col-form-label" for="status">
                            <input {{ ( $recipient['status'] == 'active' ? ' checked ' : '' ) }} type="checkbox" id="status" name="status" value="1">
                             Active</label>
                        
                    </div>
                    
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>

    {{ csrf() }}

    <div class="row">
        <div class="col-sm-12">
            <button type="submit" name="submit" id="submit" class="btn btn-primary">Edit</button>
            <a href="/recipients" class="btn btn-flat">Cancel</a>
        </div>
    </div>

</form>

@endsection