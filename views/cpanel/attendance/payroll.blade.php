@extends('cpanel.cpanel')
@section('page_title', $department['name'])
@section('page_content')

{{-- Page Controls --}}
@include('cpanel.attendance.controls')
    
    @if ($status == false)
        @include('cpanel.alerts.callouts', ['callout_type' => 'warning', 'callout_title' => 'An error occured', 'callout_message' => $message])
    @else

        <?php 
            $prevmonth = date('F', strtotime('last month'));
            $currmonth = date('F', strtotime('this month'));
        ?>
        <h4>Payroll Attendance - <?php echo $prevmonth; ?> 15th to <?php echo $currmonth; ?> 15th  </h4>

        <div class="card">
            <div class="card-body">
                <a href="/department/genpdf/{{ $department['ID'] }}/payroll" target="_blank" class="btn btn-default">Generate PDF</a>
            </div>
        </div>
    
        <div class="card">
            <div class="card-body">
                {!! $sheet !!}
            </div>
        </div>

    @endif

@endsection