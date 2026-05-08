<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard Admin</h2>
            <p class="text-sm text-gray-500">Ringkasan sistem dan kontrol utama</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid gap-6 lg:grid-cols-3">
                <div class="lg:col-span-2 rounded-2xl p-6 bg-gradient-to-br from-slate-900 via-slate-800 to-emerald-700 text-white shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-emerald-100">Status Sistem</p>
                            <h3 class="text-2xl font-semibold mt-1">Operasional Normal</h3>
                        </div>
                        <div class="text-xs uppercase tracking-wider bg-white/10 px-3 py-1 rounded-full">Mei 2026</div>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mt-6">
                        <div class="rounded-xl bg-white/10 p-4">
                            <p class="text-xs text-emerald-100 uppercase tracking-wider">Hadir Hari Ini</p>
                            <p class="text-2xl font-bold">{{ $stats['today_present'] }}</p>
                        </div>
                        <div class="rounded-xl bg-white/10 p-4">
                            <p class="text-xs text-emerald-100 uppercase tracking-wider">Izin (Bulan Ini)</p>
                            <p class="text-2xl font-bold">{{ $stats['month_izin'] }}</p>
                        </div>
                        <div class="rounded-xl bg-white/10 p-4">
                            <p class="text-xs text-emerald-100 uppercase tracking-wider">Sakit (Bulan Ini)</p>
                            <p class="text-2xl font-bold">{{ $stats['month_sakit'] }}</p>
                        </div>
                        <div class="rounded-xl bg-white/10 p-4">
                            <p class="text-xs text-emerald-100 uppercase tracking-wider">Absensi (%)</p>
                            <p class="text-2xl font-bold">{{ $stats['attendance_percentage'] }}%</p>
                        </div>
                        <div class="rounded-xl bg-white/10 p-4">
                            <p class="text-xs text-emerald-100">Payroll Draft</p>
                            <p class="text-2xl font-semibold">{{ $stats['draft_payrolls'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                    <h4 class="text-sm font-semibold text-gray-700">Aksi Cepat</h4>
                    <div class="mt-4 space-y-3">
                        <a href="{{ route('employees.index') }}" class="block w-full rounded-xl border border-gray-200 px-4 py-3 text-left text-sm font-medium text-gray-700 hover:bg-gray-50">Manajemen Karyawan</a>
                        <a href="{{ route('salary-components.index') }}" class="block w-full rounded-xl border border-gray-200 px-4 py-3 text-left text-sm font-medium text-gray-700 hover:bg-gray-50">Komponen Gaji</a>
                        <a href="{{ route('settings.work') }}" class="block w-full rounded-xl border border-gray-200 px-4 py-3 text-left text-sm font-medium text-gray-700 hover:bg-gray-50">Pengaturan Sistem</a>
                    </div>
                </div>
            </div>

            <div class="mt-8 grid gap-6 lg:grid-cols-3">
                <div class="lg:col-span-2 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <h4 class="text-sm font-semibold text-gray-700">Karyawan Terbaru</h4>
                        <span class="text-xs text-gray-500">Baru ditambahkan</span>
                    </div>
                    <div class="mt-4 space-y-3">
                        @forelse($recent_employees as $emp)
                        <div class="flex items-center justify-between rounded-xl bg-gray-50 px-4 py-3">
                            <div>
                                <p class="text-sm font-medium text-gray-700">{{ $emp->name }}</p>
                                <p class="text-xs text-gray-500">{{ $emp->division->name ?? '-' }} - {{ $emp->position->name ?? '-' }}</p>
                            </div>
                            <span class="text-xs text-emerald-600 bg-emerald-100 px-2 py-1 rounded-full">Aktif</span>
                        </div>
                        @empty
                        <div class="text-center text-sm text-gray-500 py-4">Belum ada data karyawan.</div>
                        @endforelse
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                        <h4 class="text-sm font-semibold text-gray-700">Ringkasan Pengaturan</h4>
                        <div class="mt-4 space-y-4">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-500">Jam kerja</span>
                                <span class="font-medium text-gray-700">08:00 - 17:00</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-500">Toleransi terlambat</span>
                                <span class="font-medium text-gray-700">10 menit</span>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                        <div class="flex items-center justify-between">
                            <h4 class="text-sm font-semibold text-gray-700">Absensi Terakhir</h4>
                            <span class="text-xs text-gray-500">Realtime</span>
                        </div>
                        <div class="mt-4 space-y-3">
                            @forelse($recent_attendances->take(3) as $att)
                            <div class="flex items-center justify-between border-b border-gray-100 pb-2 last:border-0 last:pb-0">
                                <div>
                                    <p class="text-xs font-medium text-gray-700">{{ $att->employee->name }}</p>
                                    <p class="text-[10px] text-gray-500">{{ $att->check_in_at?->format('H:i') ?? '-' }}</p>
                                </div>
                                <span class="text-[10px] uppercase font-semibold text-emerald-600">{{ $att->status }}</span>
                            </div>
                            @empty
                            <div class="text-center text-xs text-gray-500">Belum ada absensi</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
