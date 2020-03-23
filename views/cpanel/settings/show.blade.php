@extends('cpanel.cpanel')
@section('page_title', 'Settings')
@section('page_content')

<div class="row">
    <div class="col col-md-6">

        <div class="card">
            <div class="card-body">
                <form action="/settings/update" class="HFForm" method="post" data-na="success-then-redirect-to-next-screen" data-ns="/settings">
                @foreach ($settings as $i => $field)
                    <div class="form-group">
                        <label for="{{ $field['field'] }}">{!! $field['label'] !!}</label>
                        <input type="text" id="{{ $field['field'] }}" name="settings[{{ $field['field'] }}]" value="{{ $field['value'] }}" class="form-control" autocomplete="off">
                    </div>
                @endforeach

                {{ csrf() }}

                <div class="row">
                    <div class="col-sm-12">
                        <button type="submit" name="submit" id="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>

            </form>
    
            </div>
        </div>

    </div>
</div>

@endsection
