<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold text-slate-900">Riwayat Absensi</h2>
            <p class="text-sm text-slate-500">Daftar absensi pribadi Anda.</p>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="rounded-2xl border border-white/70 bg-white/80 p-4 shadow-sm">
            <div class="grid gap-3 md:grid-cols-4">
                <input type="month" class="rounded-xl border border-slate-200 px-3 py-2 text-sm" />
                <select class="rounded-xl border border-slate-200 px-3 py-2 text-sm">
                    <option>Semua status</option>
                    <option>Hadir</option>
                    <option>Izin</option>
                    <option>Sakit</option>
                </select>
                <button class="rounded-xl bg-slate-900 px-3 py-2 text-sm font-semibold text-white">Terapkan Filter</button>
                <button class="rounded-xl border border-slate-200 px-3 py-2 text-sm font-semibold text-slate-700">Reset</button>
            </div>
        </div>

        <div class="rounded-2xl border border-white/70 bg-white/90 p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-semibold text-slate-700">Absensi Bulan Ini</h3>
                <span class="text-xs text-slate-500">Mei 2026</span>
            </div>
            <div class="mt-4 overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="text-left text-xs uppercase tracking-wider text-slate-400">
                        <tr>
                            <th class="pb-3">Tanggal</th>
                            <th class="pb-3">Check-in</th>
                            <th class="pb-3">Check-out</th>
                            <th class="pb-3">Status</th>
                            <th class="pb-3">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($attendances as $att)
                        <tr>
                            <td class="py-3">{{ $att->work_date->format('Y-m-d') }}</td>
                            <td class="py-3">{{ $att->check_in_at ? $att->check_in_at->format('H:i') : '-' }}</td>
                            <td class="py-3">{{ $att->check_out_at ? $att->check_out_at->format('H:i') : '-' }}</td>
                            <td class="py-3">
                                @if($att->status == 'present')
                                    <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">Hadir</span>
                                @elseif($att->status == 'late')
                                    <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">Terlambat</span>
                                @else
                                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">{{ ucfirst($att->status) }}</span>
                                @endif
                            </td>
                            <td class="py-3 text-slate-500">{{ $att->notes ?: '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-4 text-center text-slate-500">Belum ada data absensi.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $attendances->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
