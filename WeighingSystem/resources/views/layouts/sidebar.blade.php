<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 bg-slate-900 fixed-start " id="sidenav-main">
    <div class="sidenav-header">
        <div class="p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none" aria-hidden="true"
            id="iconSidenav">x</div>
        <div class="navbar-brand d-flex align-items-center m-0">
            <span class="font-weight-bold text-lg">IAN Platform</span>
        </div>
    </div>
    <div class="collapse navbar-collapse px-4  w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="/">
                    <div
                        class="{{ Request::is('/') ? 'text-primary' : '' }} icon icon-shape icon-sm px-0 text-center d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-house"></i>
                    </div>
                    <span class="nav-link-text ms-1">Home</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link  {{ Request::is('setup') ? 'active' : '' }}" href="/setup">
                    <div
                        class="{{ Request::is('setup') ? 'text-primary' : '' }} icon icon-shape icon-sm px-0 text-center d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-cog"></i>
                    </div>
                    <span class="nav-link-text ms-1">Setup</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link  {{ Request::is('sku') ? 'active' : '' }}" href="/sku">
                    <div
                        class="{{ Request::is('sku') ? 'text-primary' : '' }} icon icon-shape icon-sm px-0 text-center d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-box"></i>
                    </div>
                    <span class="nav-link-text ms-1">SKU</span>
                </a>
            </li>
            {{-- <li class="nav-item">
                <a class="nav-link  {{ Request::is('devices*') ? 'active' : '' }}" href="/devices">
                    <div
                        class="{{ Request::is('devices*') ? 'text-primary' : '' }} icon icon-shape icon-sm px-0 text-center d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-hard-drive"></i>
                    </div>
                    <span class="nav-link-text ms-1">Devices</span>
                </a>
            </li> --}}
        </ul>
    </div>
</aside>
