@if ( empty($flights) )
    <p>No flights found</p>
@else
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