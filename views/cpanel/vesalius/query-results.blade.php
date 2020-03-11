{{-- This view is used to display query results and shows in a modal window --}}

{{-- Show Query --}}
@include('cpanel.alerts.callouts', ['callout_type' => 'info', 'callout_title' => 'Query', 'callout_message' => $query])

@if (!empty($errors))
    @foreach ($errors as $error)
        <p>{{ $error }}</p>
    @endforeach
@else

    @if (empty($results['rows']))
        @include('cpanel.alerts.callouts', ['callout_type' => 'warning', 'callout_title' => 'Results', 'callout_message' => $results['message']])
    @else
        
        @php
            print_r($results)
        @endphp

    @endif
    
@endif

