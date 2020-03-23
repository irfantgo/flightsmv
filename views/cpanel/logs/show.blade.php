@extends('cpanel.cpanel')
@section('page_title', 'Logs')

@section('page_content')
@include('cpanel.logs.controls')

<div class="container">

@if( empty($logs) ) 
    @include('cpanel.alerts.data-not-found')
@else

    @foreach ($logs as $log)
        <div class="card row">
            <div class="col l9">{{ $log['remark'] }}<br><small>{{ date('d-F-Y \a\t h:iA', strtotime($log['log_dt'])) }}</small></div>
            <div class="col l3">{{ strtoupper(str_replace('_', ' ', $log['log_type'])) }}</div>
        </div>
    @endforeach

    <p>Top 10 records</p>

@endif

</div>

@endsection