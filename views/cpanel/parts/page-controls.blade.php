<div class="card card-default color-palette-box">
    <div class="card-body">
        @foreach ($navigations as $link => $label)
            <a href="{{ $link }}" class="btn btn-default">{{ $label }}</a>
        @endforeach
    </div>
</div>