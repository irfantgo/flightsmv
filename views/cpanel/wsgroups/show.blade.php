@extends('cpanel.cpanel')
@section('page_title', 'Workstation Groups')
@section('page_content')

{{-- Page Controls --}}
@include('cpanel.parts.page-controls', ['navigations' => [
    '/workstations' => 'Workstations',
    '/wsgroups/new' => 'New Workstation Group'
]])

<div class="card card-default color-palette-box">
    <div class="card-body">
        @if ( empty($groups) )
            <p>No workstation groups found</p>
        @else
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Group Name</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($groups as $data)
                    <tr>
                        <td>{{ $data['group_name'] }}</td>
                        <td>
                            <a href="/wsgroups/edit/{{ $data['ID'] }}" class="btn btn-sm btn-primary btn-flat">Edit</a>
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