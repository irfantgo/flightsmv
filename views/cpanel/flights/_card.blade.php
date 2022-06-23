<div class="card {{ ($data['status_int'] == 'CA' ? ' card-danger ' : ' card-success ') }} card-outline">
    <div class="card-body">
        <img class="float-right" src="{{ $data['airline_img'] }}" alt="{{ $data['airline_id'] }}">
        <h4>{{ $data['flight_no'] }}</h4>
        <p>
            <span class="mr-3"><i class="far fa-calendar-alt mr-2"></i> {{ date('d F Y', strtotime($data['scheduled_d'])) }} </span>
            <span class="mr-3"><i class="far fa-clock mr-2"></i> {{ date('h:iA', strtotime($data['scheduled_t'])) }}</span>
            <span class="{{ $data['status_flag'] }}">
                {{ $data['flight_status'] }}
            </span>
        </p>

        <p>
            <a href="javascript:void(0)" class="card-link">Let Me Know</a>
        </p>
    </div>
</div> 