<li class="nav-item has-treeview">
    <a href="{{ $link->url }}" class="{{ (isActiveTab( $link->url, 0 ) ? ' active ' : '') }} nav-link">
        <i class="nav-icon fas {{ $link->icon }}"></i>
        <p>{{ $link->label }}</p>
    </a>
</li>