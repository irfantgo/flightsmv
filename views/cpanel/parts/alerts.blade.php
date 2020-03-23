@if( !empty(\Heliumframework\Notifications::get()) )
    @foreach (\Heliumframework\Notifications::get() as $msg )
        <div class="alert {{ $msg->type }} alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            {{-- <h5><i class="icon fas fa-ban"></i> Alert!</h5> --}}
            {{ $msg->msg }}
        </div>
    @endforeach
    {{ \Heliumframework\Notifications::clear() }}
@endif