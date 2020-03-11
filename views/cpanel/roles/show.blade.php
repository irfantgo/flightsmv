@extends('cpanel.cpanel')
@section('page_title', 'Roles')
@section('page_content')

{{-- Page Controls --}}
@include('cpanel.parts.page-controls', ['navigations' => ['/roles/new' => 'New Role']])

<div class="card card-default color-palette-box">
    <div class="card-body">
        @if ( empty($roles) )
            <p>No roles found</p>
        @else
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Description</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $data)
                    <tr>
                        <td>{{ $data['code'] }}</td>
                        <td>{{ $data['description'] }}</td>
                        <td>
                            <a href="/roles/edit/{{ $data['ID'] }}" class="btn btn-sm btn-primary btn-flat">Edit</a>
                            <a href="/roles/remove/{{ $data['ID'] }}" class="btn btn-sm btn-danger btn-flat HFActionBtn" data-type="warning" data-title="Remove Role" data-text="Are you sure you want to remove this role?" data-ns="/roles" >Remove</a>
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