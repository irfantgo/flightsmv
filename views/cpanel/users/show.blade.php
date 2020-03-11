@extends('cpanel.cpanel')
@section('page_title', 'Users')
@section('page_content')

{{-- Page Controls --}}
@include('cpanel.parts.page-controls', ['navigations' => ['/users/new' => 'New User']])

<div class="card card-default color-palette-box">
    <div class="card-body">
        @if ( empty($users) )
            <p>No users found</p>
        @else
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $data)
                    <tr>
                        <td>{{ $data['display_name'] }}</td>
                        <td>{{ $data['username'] }}</td>
                        <td>{{ $data['email'] }}</td>
                        <td>{!! ( $data['isActive'] ? ' <span class="text-green">Account is Active</span> ' : '<span class="text-red">Account is In-Active</span>' ) !!}</td>
                        <td>
                            <a href="/users/edit/{{ $data['user_id'] }}" class="btn btn-sm btn-primary btn-flat">Edit</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
    <!-- /.card-body -->
</div>

@endsection