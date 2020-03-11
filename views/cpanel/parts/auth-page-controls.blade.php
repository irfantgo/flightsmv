<div class="card card-default color-palette-box">
    <div class="card-body">
        @foreach ($navigations as $nav )
            @if( isset($nav['permission']) )
                @if(\Heliumframework\Auth::hasPermission($nav['permission']))
                    <a href="{{ $nav['link'] }}" class="btn btn-default">{{ $nav['label'] }}</a>
                @endif
            @else 
                <a href="{{ $nav['link'] }}" class="btn btn-default">{{ $nav['label'] }}</a>
            @endif
        @endforeach
    </div>
</div>