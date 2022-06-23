<div class="card {{ ($data['status_int'] == 'CA' ? ' card-danger ' : ' card-success ') }} card-outline">
    <div class="card-body">
        <img class="float-right" src="{{ $data['airline_img'] }}" alt="{{ $data['airline_id'] }}">
        <h4>{{ $data['flight_no'] }}</h4>
        <p>
            <span class="mr-3"><i class="far fa-calendar-alt mr-2"></i> {{ date('d F Y', strtotime($data['scheduled_d'])) }} </span>

            {{-- If Delayed --}}
            @if ( $data['status_int'] == 'DE' )
                <span class="mr-3"><i class="far fa-clock mr-2"></i> <del>{{ date('h:iA', strtotime($data['scheduled_t'])) }}</del> <span class="text-danger">{{ date('h:iA', strtotime($data['estimated_t'])) }}</span></span>
            @else
                <span class="mr-3"><i class="far fa-clock mr-2"></i> {{ date('h:iA', strtotime($data['scheduled_t'])) }}</span>
            @endif

            <span class="{{ $data['status_flag'] }}">
                {{ $data['flight_status'] }}
            </span>
        </p>
    </div>
</div> 