@extends('cpanel.cpanel')
@section('page_title', 'Recipients')
@section('page_content')

{{-- Page Controls --}}
@include('cpanel.parts.page-controls', ['navigations' => ['/recipients/new' => 'New Recipient']])

<div class="card card-default color-palette-box">
    <div class="card-body">
        @if ( empty($recipients) )
            <p>No recipients found</p>
        @else
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recipients as $data)
                    <tr>
                        <td>{{ $data['full_name'] }}</td>
                        <td>{{ $data['email'] }}</td>
                        <td>{!! ( $data['status'] ? ' <span class="text-green">Active</span> ' : '<span class="text-red">In-Active</span>' ) !!}</td>
                        <td>
                            <a href="/recipients/edit/{{ $data['ID'] }}" class="btn btn-sm btn-primary btn-flat">Edit</a>
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