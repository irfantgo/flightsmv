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

@endif