<div x-show="mobileNavOpen" class="fixed inset-0 z-40 lg:hidden" style="display: none;">
    <div class="absolute inset-0 bg-slate-900/40" @click="mobileNavOpen = false"></div>
    <div class="absolute inset-y-0 left-0 w-72 overflow-y-auto bg-white p-6 shadow-xl">
        <div class="flex items-center justify-between">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                <div class="h-10 w-10 rounded-2xl bg-emerald-600 text-white flex items-center justify-center text-sm font-semibold">SBG</div>
                <div>
                    <p class="text-sm font-semibold text-slate-800">Absensi & Payroll</p>
                    <p class="text-xs text-slate-500">Karyawan</p>
                </div>
            </a>
            <button @click="mobileNavOpen = false" class="text-slate-500">Tutup</button>
        </div>

        <div class="mt-6 text-[11px] uppercase tracking-[0.2em] text-slate-400">Ringkasan</div>
        <nav class="mt-3 space-y-1">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 rounded-xl px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50">
                <span>Dashboard</span>
            </a>
        </nav>

        @hasanyrole('admin|hrd')
            <div class="mt-6 text-[11px] uppercase tracking-[0.2em] text-slate-400">Master Data</div>
            <nav class="mt-3 space-y-1">
                <a href="{{ route('divisions.index') }}" class="flex items-center gap-3 rounded-xl px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50">Divisi</a>
                <a href="{{ route('positions.index') }}" class="flex items-center gap-3 rounded-xl px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50">Jabatan</a>
                <a href="{{ route('employees.index') }}" class="flex items-center gap-3 rounded-xl px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50">Karyawan</a>
            </nav>
        @endhasanyrole

        @hasanyrole('admin|hrd')
            <div class="mt-6 text-[11px] uppercase tracking-[0.2em] text-slate-400">Operasional</div>
            <nav class="mt-3 space-y-1">
                <a href="{{ route('attendances.index') }}" class="flex items-center gap-3 rounded-xl px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50">Absensi</a>
                <a href="{{ route('payroll.runs') }}" class="flex items-center gap-3 rounded-xl px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50">Penggajian</a>
                <a href="{{ route('salary-components.index') }}" class="flex items-center gap-3 rounded-xl px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50">Komponen Gaji</a>
            </nav>
        @endhasanyrole

        @hasanyrole('admin|hrd')
            <div class="mt-6 text-[11px] uppercase tracking-[0.2em] text-slate-400">Laporan</div>
            <nav class="mt-3 space-y-1">
                <a href="{{ route('reports.attendance') }}" class="flex items-center gap-3 rounded-xl px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50">Laporan Absensi</a>
                <a href="{{ route('reports.payroll') }}" class="flex items-center gap-3 rounded-xl px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50">Laporan Penggajian</a>
            </nav>
        @endhasanyrole

        @role('admin')
            <div class="mt-6 text-[11px] uppercase tracking-[0.2em] text-slate-400">Pengaturan</div>
            <nav class="mt-3 space-y-1">
                <a href="{{ route('settings.work') }}" class="flex items-center gap-3 rounded-xl px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50">Jam Kerja</a>
                <a href="{{ route('salary-components.index') }}" class="flex items-center gap-3 rounded-xl px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50">Aturan Gaji</a>
            </nav>
        @endrole

        @role('karyawan')
            <div class="mt-6 text-[11px] uppercase tracking-[0.2em] text-slate-400">Karyawan</div>
            <nav class="mt-3 space-y-1">
                <a href="{{ route('attendances.checkin') }}" class="flex items-center gap-3 rounded-xl px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50">Absen Masuk/Pulang</a>
                <a href="{{ route('attendances.history') }}" class="flex items-center gap-3 rounded-xl px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50">Riwayat Absensi</a>
                <a href="{{ route('payroll.slip') }}" class="flex items-center gap-3 rounded-xl px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50">Slip Gaji</a>
            </nav>
        @endrole
    </div>
</div>
