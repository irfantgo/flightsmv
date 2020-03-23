<!-- Main Sidebar Container -->
<aside class="main-sidebar elevation-4 sidebar-dark-danger">
    <!-- Brand Logo -->
    <a href="/dashboard" class="brand-link">
        <img src="{{ assets('img/flightmv_v2.jpg') }}" alt="TTH Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{ env('APP_NAME') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ assets('adminlte/img/AdminLTELogo.png') }} " class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ \Heliumframework\Session::get('user')['display_name'] }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                @php
                    $_navigationLinks = json_decode(file_get_contents(dirname(__DIR__) . '/resources/navigation.json'));
                @endphp

                @foreach ($_navigationLinks as $link)
                    @if ( $link->permission == '' )
                        @include('cpanel.parts.navlink', ['link' => $link])
                    @else
                        @if ( \Heliumframework\Auth::hasPermission( $link->permission ) )
                            @include('cpanel.parts.navlink', ['link' => $link])
                        @endif
                    @endif
                @endforeach
                
            </ul>
        </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>