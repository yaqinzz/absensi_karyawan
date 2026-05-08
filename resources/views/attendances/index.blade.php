<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-semibold text-slate-900">Rekap Absensi</h2>
                <p class="text-sm text-slate-500">Pantau kehadiran karyawan per periode.</p>
            </div>
            <div class="flex items-center gap-2">
                <button class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700">Export PDF</button>
                <button class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700">Export Excel</button>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="grid gap-4 md:grid-cols-4">
            <div class="rounded-2xl border border-white/70 bg-white/90 p-4 shadow-sm">
                <p class="text-xs text-slate-500">Hadir</p>
                <p class="mt-2 text-2xl font-semibold text-slate-800">{{ $stats['present'] }}</p>
            </div>
            <div class="rounded-2xl border border-white/70 bg-white/90 p-4 shadow-sm">
                <p class="text-xs text-slate-500">Izin</p>
                <p class="mt-2 text-2xl font-semibold text-slate-800">{{ $stats['permit'] }}</p>
            </div>
            <div class="rounded-2xl border border-white/70 bg-white/90 p-4 shadow-sm">
                <p class="text-xs text-slate-500">Sakit</p>
                <p class="mt-2 text-2xl font-semibold text-slate-800">{{ $stats['sick'] }}</p>
            </div>
            <div class="rounded-2xl border border-white/70 bg-white/90 p-4 shadow-sm">
                <p class="text-xs text-slate-500">Alpha</p>
                <p class="mt-2 text-2xl font-semibold text-slate-800">{{ $stats['absent'] }}</p>
            </div>
        </div>

        <div class="rounded-2xl border border-white/70 bg-white/80 p-4 shadow-sm">
            <div class="grid gap-3 md:grid-cols-5">
                <input type="date" class="rounded-xl border border-slate-200 px-3 py-2 text-sm" />
                <input type="date" class="rounded-xl border border-slate-200 px-3 py-2 text-sm" />
                <select class="rounded-xl border border-slate-200 px-3 py-2 text-sm">
                    <option>Semua divisi</option>
                    <option>Engineering</option>
                    <option>Finance</option>
                </select>
                <select class="rounded-xl border border-slate-200 px-3 py-2 text-sm">
                    <option>Semua status</option>
                    <option>Hadir</option>
                    <option>Izin</option>
                </select>
                <button class="rounded-xl bg-slate-900 px-3 py-2 text-sm font-semibold text-white">Terapkan Filter</button>
            </div>
        </div>

        <div class="rounded-2xl border border-white/70 bg-white/90 p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-semibold text-slate-700">Daftar Kehadiran</h3>
                <span class="text-xs text-slate-500">Total Data: {{ $attendances->total() }}</span>
            </div>
            <div class="mt-4 overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="text-left text-xs uppercase tracking-wider text-slate-400">
                        <tr>
                            <th class="pb-3">Tanggal</th>
                            <th class="pb-3">Nama</th>
                            <th class="pb-3">Divisi</th>
                            <th class="pb-3">Check-in</th>
                            <th class="pb-3">Check-out</th>
                            <th class="pb-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($attendances as $att)
                        <tr>
                            <td class="py-3">{{ $att->work_date->format('Y-m-d') }}</td>
                            <td class="py-3 font-medium text-slate-800">{{ $att->employee->name ?? '-' }}</td>
                            <td class="py-3">{{ $att->employee->division->name ?? '-' }}</td>
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
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-4 text-center text-slate-500">Belum ada data absensi.</td>
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
