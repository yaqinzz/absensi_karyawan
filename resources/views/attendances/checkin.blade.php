<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold text-slate-900">Absensi Harian</h2>
            <p class="text-sm text-slate-500">Absen masuk dan pulang sesuai jadwal.</p>
        </div>
    </x-slot>

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

            {{-- Live Clock --}}
            <div class="mb-6 flex flex-col items-center justify-center py-4">
                <p id="live-date" class="text-sm font-medium text-slate-500"></p>
                <p id="live-clock" class="mt-1 text-5xl font-bold tracking-tight text-slate-800 tabular-nums"></p>
            </div>

            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-slate-500">Status Hari Ini</p>
                    <p class="mt-2 text-2xl font-semibold text-slate-800">
                        @if(!$attendance)
                            Belum Absen
                        @elseif(!$attendance->check_out_at)
                            Sudah Check-in ({{ $attendance->check_in_at->format('H:i') }})
                        @else
                            Selesai Absen
                        @endif
                    </p>
                </div>
                <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">Shift Pagi</span>
            </div>
            
            <form action="{{ route('attendances.store') }}" method="POST" class="mt-6 grid gap-3 sm:grid-cols-2">
                @csrf
                @if(!$attendance)
                    <button type="submit" class="rounded-xl bg-emerald-600 px-4 py-3 text-sm font-semibold text-white">Absen Masuk</button>
                    <button type="button" disabled class="rounded-xl bg-slate-300 px-4 py-3 text-sm font-semibold text-white cursor-not-allowed">Absen Pulang</button>
                @elseif(!$attendance->check_out_at)
                    <button type="button" disabled class="rounded-xl bg-slate-300 px-4 py-3 text-sm font-semibold text-white cursor-not-allowed">Absen Masuk</button>
                    <button type="submit" class="rounded-xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white">Absen Pulang</button>
                @else
                    <button type="button" disabled class="rounded-xl bg-slate-300 px-4 py-3 text-sm font-semibold text-white cursor-not-allowed">Selesai</button>
                @endif
            </form>
            <p class="mt-4 text-xs text-slate-500">Jam kerja 08:00 - 17:00. Toleransi keterlambatan 10 menit.</p>
        </div>

        <div class="rounded-2xl border border-white/70 bg-white/90 p-6 shadow-sm">
            <h3 class="text-sm font-semibold text-slate-700">Ringkasan Bulan Ini</h3>
            <div class="mt-4 space-y-3 text-sm">
                <div class="flex items-center justify-between">
                    <span class="text-slate-500">Hadir</span>
                    <span class="font-medium text-slate-700">{{ $stats['present'] }} hari</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-slate-500">Izin</span>
                    <span class="font-medium text-slate-700">{{ $stats['permit'] }} hari</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-slate-500">Sakit</span>
                    <span class="font-medium text-slate-700">{{ $stats['sick'] }} hari</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-slate-500">Alpha</span>
                    <span class="font-medium text-slate-700">{{ $stats['absent'] }} hari</span>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        const DAYS = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        const MONTHS = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        function updateClock() {
            const now = new Date();
            const hh = String(now.getHours()).padStart(2, '0');
            const mm = String(now.getMinutes()).padStart(2, '0');
            const ss = String(now.getSeconds()).padStart(2, '0');
            const dayName = DAYS[now.getDay()];
            const date = now.getDate();
            const month = MONTHS[now.getMonth()];
            const year = now.getFullYear();

            document.getElementById('live-clock').textContent = `${hh}:${mm}:${ss}`;
            document.getElementById('live-date').textContent = `${dayName}, ${date} ${month} ${year}`;
        }

        updateClock();
        setInterval(updateClock, 1000);
    </script>
    @endpush
</x-app-layout>
