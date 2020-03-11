@extends('cpanel.cpanel')
@section('page_title', 'Documents')
@section('page_content')

{{-- Page Controls --}}
@include('cpanel.attendance.controls')

@if ( empty($documents) )
    @include('cpanel.alerts.callouts', ['callout_title' => 'No Documents Found', 'callout_message' => 'There are no reports for this department', 'callout_type' => 'info'])
@else
    <div class="card card-default color-palette-box">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Document Name</th>
                        <th width="20%">Created On</th>
                        <th width="25%">Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($documents as $data)
                    <tr>
                        <td>{{ $data['doc_name'] }}</td>
                        <td>{{ date('d F Y \a\t h:iA', strtotime($data['created_dt'])) }}</td>
                        <td>{!! ( $data['acknowledged'] ? ' <span class="text-green">Acknowledged by '.$data['ack_display_name'].'</span> <br><small>on '.date('d F Y \a\t h:iA', strtotime($data['acknowledged_dt'])).'</small> </span> ' : '<span class="text-red">Waiting for acknowledgement' ) !!}</td>
                        <td>
                            <a target="_blank" href="/department/documents-view/{{ $data['ID'] }}" class="btn btn-sm btn-default btn-flat">View Report</a>
                            @if ($data['acknowledged'] == false)
                                <a href="/department/document-ack/{{ $data['ID'] }}" class="btn btn-sm btn-primary btn-flat HFActionBtn" data-title="Acknowledgement" data-text="Are you sure you want to continue? You cannot undo this action." data-type="warning" data-ns="/department/documents/{{ $department['ID'] }}">Acknowledge</a>
                            @endif
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