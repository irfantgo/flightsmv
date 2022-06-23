<!DOCTYPE html>
<html style="height: auto;" lang="en">
@include('cpanel.html-head')
<body class="sidebar-mini control-sidebar-slide-open accent-warning">
    
    <div class="wrapper">

        {{-- Top Navigation --}}
        @include('cpanel.parts.topnav')

        {{-- Side Navigation --}}
        @include('cpanel.parts.aside')

        {{-- Main Content Wrapper --}}
        <div class="content-wrapper">

            {{-- Page Header --}}
            @include('cpanel.parts.page-header')

            {{-- Main Content --}}
            <section class="content">
                <div class="container-fluid">
                    @yield('page_content')
                </div>
            </section>
            
            <br>
            <br>
            <br>

        </div>

    </div>

    {{-- Footer --}}
    <footer class="main-footer">
        Copyright © <?= date('Y') ?> <strong><a class="text-danger" href="http://www.codered.mv" target="_blank">CODERED</a>.</strong>
    </footer> 


    @include('cpanel.html-footer')

    @if ( \Heliumframework\Session::exists('user') )
        <script>
            $(document).ready(function(){
                setInterval(function () { 
                    $.get('/checksession', function (data) {
                        if ( data == false ) {
                            window.location.href = '/';
                        }
                    });
                }, 5000);
            });
        </script>
    @endif

</body>
</html>