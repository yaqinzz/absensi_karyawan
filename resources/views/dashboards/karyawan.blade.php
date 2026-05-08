<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard Karyawan</h2>
            <p class="text-sm text-gray-500">Pantau absensi dan slip gaji Anda</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid gap-6 lg:grid-cols-3">
                <div class="lg:col-span-2 rounded-2xl bg-gradient-to-br from-emerald-50 via-white to-sky-50 p-6 shadow-sm">
                    @if (session('status'))
                        <div class="mb-4 rounded-xl bg-emerald-100 p-4 text-sm font-medium text-emerald-700">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="mb-4 rounded-xl bg-rose-100 p-4 text-sm font-medium text-rose-700">
                            {{ $errors->first() }}
                        </div>
                    @endif
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-500">Status Hari Ini</p>
                            <p class="text-2xl font-semibold text-gray-800 mt-1">
                                @if(!$attendance)
                                    Belum Absen
                                @elseif(!$attendance->check_out_at)
                                    Sudah Check-in ({{ $attendance->check_in_at->format('H:i') }})
                                @else
                                    Selesai Absen
                                @endif
                            </p>
                        </div>
                        <div class="text-xs uppercase tracking-wider bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full">Shift Pagi</div>
                    </div>
                    <form action="{{ route('attendances.store') }}" method="POST" class="mt-6 grid gap-4 sm:grid-cols-2">
                        @csrf
                        @if(!$attendance)
                            <button type="submit" class="w-full rounded-xl bg-emerald-600 px-4 py-3 text-sm font-semibold text-white shadow-sm hover:bg-emerald-700">Absen Masuk</button>
                            <button type="button" disabled class="w-full rounded-xl bg-slate-300 px-4 py-3 text-sm font-semibold text-white shadow-sm cursor-not-allowed">Absen Pulang</button>
                        @elseif(!$attendance->check_out_at)
                            <button type="button" disabled class="w-full rounded-xl bg-slate-300 px-4 py-3 text-sm font-semibold text-white shadow-sm cursor-not-allowed">Absen Masuk</button>
                            <button type="submit" class="w-full rounded-xl bg-gray-900 px-4 py-3 text-sm font-semibold text-white shadow-sm hover:bg-gray-800">Absen Pulang</button>
                        @else
                            <button type="button" disabled class="w-full rounded-xl bg-slate-300 px-4 py-3 text-sm font-semibold text-white shadow-sm cursor-not-allowed">Selesai</button>
                        @endif
                    </form>
                    <div class="mt-4 text-xs text-gray-500">Jam kerja: 08:00 - 17:00 (toleransi 10 menit)</div>
                </div>

                <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                    <h4 class="text-sm font-semibold text-gray-700">Ringkasan Bulan Ini</h4>
                    <div class="mt-4 space-y-3 text-sm">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500">Hadir</span>
                            <span class="font-medium text-gray-700">{{ $stats['present'] }} hari</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500">Izin</span>
                            <span class="font-medium text-gray-700">{{ $stats['permit'] }} hari</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500">Sakit</span>
                            <span class="font-medium text-gray-700">{{ $stats['sick'] }} hari</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500">Terlambat</span>
                            <span class="font-medium text-gray-700">{{ $stats['late'] }} kali</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 grid gap-6 lg:grid-cols-2">
                <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <h4 class="text-sm font-semibold text-gray-700">Absensi Terakhir</h4>
                        <span class="text-xs text-gray-500">5 hari terakhir</span>
                    </div>
                    <div class="mt-4 space-y-3">
                        @forelse($recent_attendances as $att)
                        <div class="flex items-center justify-between rounded-xl bg-gray-50 px-4 py-3 text-sm">
                            <span class="text-gray-600">{{ \Carbon\Carbon::parse($att->work_date)->translatedFormat('l, d F Y') }}</span>
                            @if($att->status == 'present' && $att->late_minutes == 0)
                                <span class="font-medium text-emerald-600">Hadir</span>
                            @elseif($att->status == 'present' && $att->late_minutes > 0)
                                <span class="font-medium text-amber-600">Terlambat</span>
                            @else
                                <span class="font-medium text-amber-600">{{ ucfirst($att->status) }}</span>
                            @endif
                        </div>
                        @empty
                        <div class="text-center text-sm text-gray-500 py-2">Belum ada data absensi.</div>
                        @endforelse
                    </div>
                </div>

                <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <h4 class="text-sm font-semibold text-gray-700">Slip Gaji Terakhir</h4>
                        <span class="text-xs text-gray-500">{{ $latest_payroll ? $latest_payroll->run->period_start->format('F Y') : '-' }}</span>
                    </div>
                    <div class="mt-4 space-y-4">
                        @if($latest_payroll)
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-500">Total pendapatan</span>
                                <span class="font-semibold text-gray-800">Rp {{ number_format($latest_payroll->base_salary + $latest_payroll->total_earnings, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-500">Total potongan</span>
                                <span class="font-semibold text-gray-800">Rp {{ number_format($latest_payroll->total_deductions, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex items-center justify-between rounded-xl bg-emerald-50 px-4 py-3 text-sm">
                                <span class="text-emerald-700">Gaji bersih</span>
                                <span class="font-semibold text-emerald-700">Rp {{ number_format($latest_payroll->net_pay, 0, ',', '.') }}</span>
                            </div>
                            <a href="{{ route('payroll.slip') }}" class="block w-full text-center rounded-xl border border-gray-200 px-4 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-50">Lihat Slip Gaji</a>
                        @else
                            <div class="text-center text-sm text-gray-500 py-6">Belum ada slip gaji.</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
