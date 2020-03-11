@extends('cpanel.cpanel')
@section('page_title', 'Departments')
@section('page_content')

{{-- Page Controls --}}
@include('cpanel.parts.page-controls', ['navigations' => ['/departments/new' => 'New Department']])

<div class="card card-default color-palette-box">
    <div class="card-body">
        @if ( empty($departments) )
            <p>No departments found</p>
        @else
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Attendance View</th>
                        <th>Schedule View</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($departments as $data)
                    <tr>
                        <td>{{ $data['name'] }}</td>
                        <td>{!! ($data['email'] == '' ? '<em>NA</em>' : $data['email']) !!}</td>
                        <td>{!! ($data['attendance_view'] == '' ? '<em>NA</em>' : $data['attendance_view']) !!}</td>
                        <td>{!! ($data['schedule_view'] == '' ? '<em>NA</em>' : $data['schedule_view']) !!}</td>
                        <td>{!! ( $data['isActive'] ? ' <span class="text-green">Active</span> ' : '<span class="text-red">In-Active</span>' ) !!}</td>
                        <td>
                            <a href="/departments/edit/{{ $data['ID'] }}" class="btn btn-sm btn-primary btn-flat">Edit</a>
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