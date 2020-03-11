@extends('cpanel.cpanel')
@section('page_title', $department['name'])
@section('page_content')

{{-- Page Controls --}}
@include('cpanel.attendance.controls')

    @if ($status == false)
        @include('cpanel.alerts.callouts', ['callout_type' => 'warning', 'callout_title' => 'An error occured', 'callout_message' => $message])
    @else

        <?php
	  $first = date("d", strtotime("first day of this month")); 
            $first1 = date("S", strtotime("first day of this month"));
	
	  $last = date("d", strtotime("last day of this month"));
	  $last1 = date("S", strtotime("last day of this month"));

            $currmonth = date('F', strtotime('this month'));
        ?>
        <h4>Attendance - <?php echo $first; ?><?php echo $first1; ?>  to <?php echo $last; ?><?php echo $last1; ?> of <?php echo $currmonth; ?></h4>

        <div class="card">
            <div class="card-body">
                <a href="/department/genpdf/{{ $department['ID'] }}/attendance" target="_blank" class="btn btn-default">Generate PDF</a>
            </div>
        </div>
    
        <div class="card">
            <div class="card-body">
                {!! $sheet !!}
            </div>
        </div>

    @endif

@endsection