<aside class="aside is-placed-left is-expanded">
    <div class="aside-tools">
        <div>
            Admin <b class="font-black">One</b>
        </div>
    </div>
    <div class="menu is-menu-main">
        <p class="menu-label">General</p>
        <ul class="menu-list">
            <li class="active">
                <a href="/dashboard">
                    <span class="icon"><i class="mdi mdi-desktop-mac"></i></span>
                    <span class="menu-item-label">Dashboard</span>
                </a>
            </li>
        </ul>
        @if (Auth::user()->role == 'admins')
            <p class="menu-label">Data Master</p>
            <ul class="menu-list">
                <li>
                    <a class="dropdown">
                        <span class="icon"><i class="mdi mdi-view-list"></i></span>
                        <span class="menu-item-label">Data Induk</span>
                        <span class="icon"><i class="mdi mdi-plus"></i></span>
                    </a>
                    <ul>
                        <x-aside-link href="/User"> Data User</x-aside-link>
                        <x-aside-link href="/jabatans"> Data jabatan </x-aside-link>
                        <x-aside-link href="/jobdesks"> Data jobdesk </x-aside-link>
                    </ul>
                </li>
            </ul>
        @endif
        <p class="menu-label">Menu User</p>
        <ul class="menu-list">
            <li>
                <a class="dropdown">
                    <span class="icon"><i class="mdi mdi-view-list"></i></span>
                    <span class="menu-item-label">pengajuan cuti</span>
                    <span class="icon"><i class="mdi mdi-plus"></i></span>
                </a>
                <ul>
                    <x-aside-link href="/cuti">Pengajuan Cuti</x-aside-link>
                    <x-aside-link href="/absensi">Absensi</x-aside-link>
                    <x-aside-link href="/data-absensi">Data Absensi</x-aside-link>
                    @if (Auth::user()->role == 'admins' || Auth::user()->role == 'manager')
                        <x-aside-link href="/jenis-cuti">Data Jenis Cuti</x-aside-link>
                    @endif
                </ul>
            </li>
        </ul>
        @if (Auth::user()->role == 'dokter')
            <p class="menu-label">Data Visitor</p>
            <ul class="menu-list">
                <li>
                    <a class="dropdown">
                        <span class="icon"><i class="mdi mdi-view-list"></i></span>
                        <span class="menu-item-label">Data Visitor</span>
                        <span class="icon"><i class="mdi mdi-plus"></i></span>
                    </a>
                    <ul>
                        <x-aside-link href="/admins"> Data Pengguna</x-aside-link>
                    </ul>
                </li>
            </ul>
        @endif
        <p class="menu-label">Control Postingan</p>
        <ul class="menu-list">
            <li>
                <a class="dropdown">
                    <span class="icon"><i class="mdi mdi-view-list"></i></span>
                    <span class="menu-item-label">Data Postingan</span>
                    <span class="icon"><i class="mdi mdi-plus"></i></span>
                </a>
                <ul>
                    <x-aside-link href="/posts">Data Postingan</x-aside-link>
                </ul>
            </li>
        </ul>
    </div>
</aside>
<section class="is-title-bar">
    <div class="flex flex-col -mb-2 md:flex-row items-center justify-between space-y-6 md:space-y-0">
        <ul>
            <li>Admin</li>
            <li>{{ $slot }}</li>
        </ul>

    </div>
</section>
