<aside class="fixed left-0 top-0 h-screen w-sidebar-width bg-surface-container-lowest border-r border-outline-variant flex flex-col py-lg z-50 hidden lg:flex">
    <div class="px-lg mb-xl">
        <h1 class="font-h3 text-h3 font-bold text-primary">{{ config('app.name') }}</h1>
        <p class="text-on-surface-variant text-body-md">Absensi & Payroll</p>
    </div>
    
    <nav class="flex-grow overflow-y-auto space-y-base px-sm">
        @php
            $activeClass = "flex items-center gap-md bg-primary text-on-primary rounded-full px-md py-sm scale-[0.98] transition-transform";
            $inactiveClass = "flex items-center gap-md text-on-surface-variant hover:text-primary hover:bg-surface-container-low transition-colors duration-200 px-md py-sm rounded-full";
            $activeIcon = "material-symbols-outlined active-nav-pill";
            $inactiveIcon = "material-symbols-outlined";
        @endphp

        <div class="text-[11px] font-bold tracking-[0.1em] text-outline px-md mt-sm mb-xs uppercase">Ringkasan</div>
        <a class="{{ request()->routeIs('dashboard') ? $activeClass : $inactiveClass }}" href="{{ route('dashboard') }}">
            <span class="{{ request()->routeIs('dashboard') ? $activeIcon : $inactiveIcon }}">dashboard</span>
            <span class="font-body-md">Dashboard</span>
        </a>

        @hasanyrole('admin|hrd')
            <div class="text-[11px] font-bold tracking-[0.1em] text-outline px-md mt-md mb-xs uppercase">Master Data</div>
            <a class="{{ request()->routeIs('divisions.*') ? $activeClass : $inactiveClass }}" href="{{ route('divisions.index') }}">
                <span class="{{ request()->routeIs('divisions.*') ? $activeIcon : $inactiveIcon }}">domain</span>
                <span class="font-body-md">Divisi</span>
            </a>
            <a class="{{ request()->routeIs('positions.*') ? $activeClass : $inactiveClass }}" href="{{ route('positions.index') }}">
                <span class="{{ request()->routeIs('positions.*') ? $activeIcon : $inactiveIcon }}">badge</span>
                <span class="font-body-md">Jabatan</span>
            </a>
            <a class="{{ request()->routeIs('employees.*') ? $activeClass : $inactiveClass }}" href="{{ route('employees.index') }}">
                <span class="{{ request()->routeIs('employees.*') ? $activeIcon : $inactiveIcon }}">group</span>
                <span class="font-body-md">Karyawan</span>
            </a>

            <div class="text-[11px] font-bold tracking-[0.1em] text-outline px-md mt-md mb-xs uppercase">Operasional</div>
            <a class="{{ request()->routeIs('attendances.index') ? $activeClass : $inactiveClass }}" href="{{ route('attendances.index') }}">
                <span class="{{ request()->routeIs('attendances.index') ? $activeIcon : $inactiveIcon }}">fingerprint</span>
                <span class="font-body-md">Absensi</span>
            </a>
            <a class="{{ request()->routeIs('payroll.*') && !request()->routeIs('salary-components.*') ? $activeClass : $inactiveClass }}" href="{{ route('payroll.runs') }}">
                <span class="{{ request()->routeIs('payroll.*') && !request()->routeIs('salary-components.*') ? $activeIcon : $inactiveIcon }}">payments</span>
                <span class="font-body-md">Penggajian</span>
            </a>
            <a class="{{ request()->routeIs('salary-components.*') ? $activeClass : $inactiveClass }}" href="{{ route('salary-components.index') }}">
                <span class="{{ request()->routeIs('salary-components.*') ? $activeIcon : $inactiveIcon }}">account_balance_wallet</span>
                <span class="font-body-md">Komponen Gaji</span>
            </a>

            <div class="text-[11px] font-bold tracking-[0.1em] text-outline px-md mt-md mb-xs uppercase">Laporan</div>
            <a class="{{ request()->routeIs('reports.attendance') ? $activeClass : $inactiveClass }}" href="{{ route('reports.attendance') }}">
                <span class="{{ request()->routeIs('reports.attendance') ? $activeIcon : $inactiveIcon }}">analytics</span>
                <span class="font-body-md">Laporan Absensi</span>
            </a>
            <a class="{{ request()->routeIs('reports.payroll') ? $activeClass : $inactiveClass }}" href="{{ route('reports.payroll') }}">
                <span class="{{ request()->routeIs('reports.payroll') ? $activeIcon : $inactiveIcon }}">request_quote</span>
                <span class="font-body-md">Laporan Penggajian</span>
            </a>
            <a class="{{ request()->routeIs('leaves.index') ? $activeClass : $inactiveClass }}" href="{{ route('leaves.index') }}">
                <span class="{{ request()->routeIs('leaves.index') ? $activeIcon : $inactiveIcon }}">beach_access</span>
                <span class="font-body-md">Manajemen Cuti</span>
            </a>
        @endhasanyrole

        @role('admin')
            <div class="text-[11px] font-bold tracking-[0.1em] text-outline px-md mt-md mb-xs uppercase">Pengaturan</div>
            <a class="{{ request()->routeIs('settings.work') ? $activeClass : $inactiveClass }}" href="{{ route('settings.work') }}">
                <span class="{{ request()->routeIs('settings.work') ? $activeIcon : $inactiveIcon }}">schedule</span>
                <span class="font-body-md">Jam Kerja</span>
            </a>
            <a class="{{ request()->routeIs('holidays.*') ? $activeClass : $inactiveClass }}" href="{{ route('holidays.index') }}">
                <span class="{{ request()->routeIs('holidays.*') ? $activeIcon : $inactiveIcon }}">event_busy</span>
                <span class="font-body-md">Hari Libur</span>
            </a>
        @endrole

        @role('hrd')
            <div class="text-[11px] font-bold tracking-[0.1em] text-outline px-md mt-md mb-xs uppercase">Pengaturan</div>
            <a class="{{ request()->routeIs('holidays.*') ? $activeClass : $inactiveClass }}" href="{{ route('holidays.index') }}">
                <span class="{{ request()->routeIs('holidays.*') ? $activeIcon : $inactiveIcon }}">event_busy</span>
                <span class="font-body-md">Hari Libur</span>
            </a>
        @endrole

        @role('karyawan')
            <div class="text-[11px] font-bold tracking-[0.1em] text-outline px-md mt-md mb-xs uppercase">Karyawan</div>
            <a class="{{ request()->routeIs('attendances.checkin') ? $activeClass : $inactiveClass }}" href="{{ route('attendances.checkin') }}">
                <span class="{{ request()->routeIs('attendances.checkin') ? $activeIcon : $inactiveIcon }}">how_to_reg</span>
                <span class="font-body-md">Absen Masuk/Pulang</span>
            </a>
            <a class="{{ request()->routeIs('attendances.history') ? $activeClass : $inactiveClass }}" href="{{ route('attendances.history') }}">
                <span class="{{ request()->routeIs('attendances.history') ? $activeIcon : $inactiveIcon }}">history</span>
                <span class="font-body-md">Riwayat Absensi</span>
            </a>
            <a class="{{ request()->routeIs('leaves.my') ? $activeClass : $inactiveClass }}" href="{{ route('leaves.my') }}">
                <span class="{{ request()->routeIs('leaves.my') ? $activeIcon : $inactiveIcon }}">beach_access</span>
                <span class="font-body-md">Cuti Saya</span>
            </a>
            <a class="{{ request()->routeIs('payroll.slip') ? $activeClass : $inactiveClass }}" href="{{ route('payroll.slip') }}">
                <span class="{{ request()->routeIs('payroll.slip') ? $activeIcon : $inactiveIcon }}">receipt_long</span>
                <span class="font-body-md">Slip Gaji</span>
            </a>
        @endrole
    </nav>
    
    <div class="px-md mt-auto pt-lg space-y-sm">
        <form method="POST" action="{{ route('logout') }}" class="border-t border-outline-variant pt-md">
            @csrf
            <a class="flex items-center gap-md text-on-surface-variant hover:text-error px-md py-sm transition-colors duration-200 cursor-pointer" onclick="event.preventDefault(); this.closest('form').submit();">
                <span class="material-symbols-outlined">logout</span>
                <span class="font-body-md">Logout</span>
            </a>
        </form>
    </div>
</aside>
