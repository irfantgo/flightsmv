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
        <h4>Attendance - <?php echo $prevmonth; ?> 15th to <?php echo $currmonth; ?> 15th  </h4>

        <div class="card">
            <div class="card-header">
                SQL DUMP
            </div>
            <div class="card-body">
                @while ($row = $results) 
                    <pre>
                        @php
                            print_r($row)
                        @endphp
                    </pre>
                @endwhile
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                A bit cleaner version
            </div>
            <div class="card-body">
                <pre>
                @php
                    print_r($dataset)
                @endphp
                </pre>
            </div>
        </div>

    @endif

@endsection