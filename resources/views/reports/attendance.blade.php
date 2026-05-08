<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-semibold text-slate-900">Laporan Absensi</h2>
                <p class="text-sm text-slate-500">Filter laporan berdasarkan periode dan divisi.</p>
            </div>
            <div class="flex items-center gap-2">
                <button class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700">Export PDF</button>
                <button class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700">Export Excel</button>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="rounded-2xl border border-white/70 bg-white/80 p-4 shadow-sm">
            <form method="GET" action="{{ route('reports.attendance') }}" class="grid gap-3 md:grid-cols-4">
                <input type="month" name="period_month" value="{{ $periodMonth }}" class="rounded-xl border border-slate-200 px-3 py-2 text-sm" />
                <select name="division_id" class="rounded-xl border border-slate-200 px-3 py-2 text-sm">
                    <option value="all" {{ $divisionId === 'all' ? 'selected' : '' }}>Semua divisi</option>
                    @foreach($divisions as $div)
                        <option value="{{ $div->id }}" {{ $divisionId == $div->id ? 'selected' : '' }}>{{ $div->name }}</option>
                    @endforeach
                </select>
                <button type="submit" class="rounded-xl bg-slate-900 px-3 py-2 text-sm font-semibold text-white">Generate</button>
                <a href="{{ route('reports.attendance') }}" class="rounded-xl border border-slate-200 px-3 py-2 text-sm font-semibold text-slate-700 text-center">Reset</a>
            </form>
        </div>

        <div class="rounded-2xl border border-white/70 bg-white/90 p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-semibold text-slate-700">Ringkasan Laporan</h3>
                <span class="text-xs text-slate-500">{{ \Carbon\Carbon::createFromFormat('Y-m', $periodMonth)->format('F Y') }}</span>
            </div>
            <div class="mt-4 overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="text-left text-xs uppercase tracking-wider text-slate-400">
                        <tr>
                            <th class="pb-3">Divisi</th>
                            <th class="pb-3">Hadir</th>
                            <th class="pb-3">Izin</th>
                            <th class="pb-3">Sakit</th>
                            <th class="pb-3">Alpha</th>
                            <th class="pb-3">Terlambat</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($reportData as $row)
                        <tr>
                            <td class="py-3 font-medium text-slate-800">{{ $row['division_name'] }}</td>
                            <td class="py-3">{{ $row['present'] }}</td>
                            <td class="py-3">{{ $row['permit'] }}</td>
                            <td class="py-3">{{ $row['sick'] }}</td>
                            <td class="py-3">{{ $row['absent'] }}</td>
                            <td class="py-3">{{ $row['late'] }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-4 text-center text-slate-500">Tidak ada data divisi.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
