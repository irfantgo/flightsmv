<nav class="main-header navbar navbar-expand navbar-dark navbar-danger">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a></li>
        {{-- <li class="nav-item d-none d-sm-inline-block"><a href="/reports-attendance" class="nav-link">Attendance Reports</a></li> --}}
        {{-- <li class="nav-item d-none d-sm-inline-block"> --}}
            {{-- <a href="#"  class="nav-link">Call for Help</a> --}}
        {{-- </li> --}}
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        @if (\Heliumframework\Auth::hasPermission('UP_SETTINGS'))
            <li class="nav-item"><a class="nav-link" href="/settings"><i class="fas fa-cog"></i></a></li>
        @endif
        {{-- <li class="nav-item"><a class="nav-link" href="#" onclick="alert('Help is on the way')"><i class="fas fa-headset"></i></a></li> --}}
        <li class="nav-item"><a class="nav-link" href="/logout"><i class="fas fa-power-off"></i></a></li>
    </ul>
</nav>
<!-- /.navbar -->