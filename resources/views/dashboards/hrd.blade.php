<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard HRD</h2>
            <p class="text-sm text-gray-500">Monitoring karyawan, absensi, dan payroll</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Karyawan Aktif</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['employee_count'] }}</p>
                </div>
                <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Hadir Hari Ini</p>
                    <p class="text-3xl font-bold text-emerald-600 mt-2">{{ $stats['today_present'] }}</p>
                </div>
                <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm border-l-4 border-l-blue-500">
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Izin (Bulan Ini)</p>
                    <p class="text-3xl font-bold text-blue-600 mt-2">{{ $stats['month_izin'] }}</p>
                </div>
                <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm border-l-4 border-l-amber-500">
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Sakit (Bulan Ini)</p>
                    <p class="text-3xl font-bold text-amber-600 mt-2">{{ $stats['month_sakit'] }}</p>
                </div>
                <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Payroll Draft</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['draft_payrolls'] }}</p>
                </div>
            </div>

            <div class="mt-8 grid gap-6 lg:grid-cols-3">
                <div class="lg:col-span-2 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <h4 class="text-sm font-semibold text-gray-700">Absensi Hari Ini</h4>
                        <span class="text-xs text-gray-500">Update realtime</span>
                    </div>
                    <div class="mt-4 space-y-3">
                        @forelse($recent_attendances as $att)
                        <div class="flex items-center justify-between rounded-xl bg-gray-50 px-4 py-3">
                            <div>
                                <p class="text-sm font-medium text-gray-700">{{ $att->employee->name }}</p>
                                <p class="text-xs text-gray-500">{{ $att->employee->division->name ?? '-' }} - Check in: {{ $att->check_in_at?->format('H:i') ?? '-' }}</p>
                            </div>
                            @if($att->status == 'present' && $att->late_minutes == 0)
                                <span class="text-xs font-semibold text-emerald-600 px-2 py-1 bg-emerald-100 rounded-lg">Hadir Tepat Waktu</span>
                            @elseif($att->status == 'present' && $att->late_minutes > 0)
                                <span class="text-xs font-semibold text-amber-600 px-2 py-1 bg-amber-100 rounded-lg">Telat {{ $att->late_minutes }}m</span>
                            @else
                                <span class="text-xs font-semibold text-gray-600 px-2 py-1 bg-gray-200 rounded-lg">{{ ucfirst($att->status) }}</span>
                            @endif
                        </div>
                        @empty
                        <div class="text-center text-sm text-gray-500 py-4">Belum ada karyawan yang absen hari ini.</div>
                        @endforelse
                    </div>
                </div>

                <div class="rounded-2xl bg-gradient-to-br from-amber-50 via-white to-orange-50 p-6 shadow-sm">
                    <h4 class="text-sm font-semibold text-gray-700">Aksi Cepat</h4>
                    <div class="mt-4 space-y-3">
                        <a href="{{ route('employees.create') }}" class="block w-full rounded-xl bg-white px-4 py-3 text-left text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">Input Karyawan</a>
                        <a href="{{ route('attendances.index') }}" class="block w-full rounded-xl bg-white px-4 py-3 text-left text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">Rekap Absensi</a>
                        <a href="{{ route('payroll.runs') }}" class="block w-full rounded-xl bg-white px-4 py-3 text-left text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">Proses Payroll</a>
                    </div>
                </div>
            </div>

            <div class="mt-8 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <h4 class="text-sm font-semibold text-gray-700">Karyawan Terbaru</h4>
                    <span class="text-xs text-gray-500">Baru ditambahkan</span>
                </div>
                <div class="mt-4 grid gap-3 md:grid-cols-3">
                    @forelse($recent_employees as $emp)
                    <div class="rounded-xl bg-gray-50 p-4 border border-gray-100 hover:border-emerald-200 transition-colors">
                        <p class="text-sm font-medium text-gray-700">{{ $emp->name }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $emp->division->name ?? '-' }} - {{ $emp->position->name ?? '-' }}</p>
                    </div>
                    @empty
                    <div class="col-span-3 text-center text-sm text-gray-500 py-4">Belum ada karyawan terdaftar.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
