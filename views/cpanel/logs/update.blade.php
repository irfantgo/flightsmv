@extends('cpanel.cpanel')
@section('page_title', 'Groups')
@section('page_content')

@include('cpanel.groups.controls')

<div class="tab-content" >
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Update Group</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fas fa-minus"></i></button>
            </div>
        </div>
        <div class="card-body" style="display: block;">
            
            <form action="/groups/patch/{{ $group['ID'] }}" class="HFForm" data-na="success-then-redirect-to-next-screen" data-ns="/groups" >

                <div class="row">
                    <div class="col-md-3">

                        <div class="form-group">
                            <label for="group_name">Group Name</label>
                            <input type="text" name="group_name" id="group_name" class="form-control" value="{{ $group['group_name'] }}" autocomplete="off"  >
                        </div>

                        <p><b>Choose roles for the groups</b></p>
                        <table class="table">
                            @foreach( $roles as $role )
                            <tr>
                                <td>{{ $role['description'] }}</td>
                                <td><input type="checkbox" name="roles[]" {{ in_array($role['code'], $group['roles']) ? 'checked' : ''  }} id="role-{{ $role['ID'] }}" value="{{ $role['code'] }}"></td>
                            </tr>
                            @endforeach
                        </table>

                        <div class="form-group">
                            {{ csrf() }}
                            <button type="submit" name="submit" id="submit" class="btn btn-primary" >Update Group</button>
                            <a href="/groups" class="btn btn-default" >Cancel</a>
                        </div>

                    </div>
                </div>

            </form>

        </div>
        <!-- /.card-body -->
    </div>
    
</div>

@endsection

