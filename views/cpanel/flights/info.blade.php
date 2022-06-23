@if ( empty($dataset) )
    <p>No flights found</p>
@else

@foreach ($dataset as $date => $directions)
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-plane mr-2"></i> {{ date('d F Y', strtotime($date)) }}</h3>
        </div>
        <div class="card-body">
            <div class="row">
                @foreach ($directions as $direction => $flights)
                    <div class="col-md-6">
                        <h4 class="mb-4">{{ ucwords($direction) }}</h4>
                        <div class="row">
                            @foreach ($flights as $data)
                                <div class="col-lg-6">
                                    @include('cpanel.flights._card', ['flight' => $data])
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endforeach

@php
    echo '<pre>'; print_r($dataset); echo '</pre>';
@endphp


@foreach ($dataset as $date => $flights)
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-plane mr-2"></i> {{ date('d F Y', strtotime($date)) }}</h3>
        </div>
        <div class="card-body">
            <div class="row">
                @foreach ($flights as $data)
                <div class="col-md-6 col-lg-4">
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
                        </div>
                    </div>    
                </div>
                @endforeach
            </div>
        </div>
    </div>
@endforeach


    <table class="table table-bordered">
        <thead>
            <tr>
                <th colspan="2">Airline</th>
                <th>Flight No</th>
                <th>Scheduled Date</th>
                <th>Scheduled Time</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($flights as $data)
            <tr>
                <td width="120"><img src="{{ $data['airline_img'] }}" alt="{{ $data['airline_id'] }}"></td>
                <td>{{ $data['airline_name'] }} <br> <small>{{ $data['airline_id'] }}</small></td>
                <td>{{ $data['flight_no'] }}</td>
                <td>{{ date('d F Y', strtotime($data['scheduled_d'])) }}</td>
                <td>{{ date('H:i', strtotime($data['scheduled_t'])) }}</td>
                <td>
                    <span class="{{ $data['status_flag'] }}">
                        {{ $data['flight_status'] }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endif