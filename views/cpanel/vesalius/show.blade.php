@extends('cpanel.cpanel')
@section('page_title', 'Vesalius Reports')
@section('page_content')

{{-- Page Controls --}}
@include('cpanel.parts.page-controls', ['navigations' => ['/reports-ves/new' => 'New Report']])

<div class="card card-default color-palette-box">
    <div class="card-body">
        @if ( empty($queries) )
            <p>No queries found</p>
        @else
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Run Time (24hrs)</th>
                        <th>Recurrance</th>
                        <th>Created By</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($queries as $data)
                    <tr>
                        <td>{{ $data['title'] }} <br> <small>{{ $data['description'] }}</small></td>
                        <td>{{ date("H:i", strtotime($data['run_t'])) }}</td>
                        <td>{{ $data['rec'] }}</td>
                        <td>{{ $data['created_by'] }}</td>
                        <td>
                            <a href="/reports-ves/edit/{{ $data['ID'] }}" class="btn-flat">Edit</a>
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