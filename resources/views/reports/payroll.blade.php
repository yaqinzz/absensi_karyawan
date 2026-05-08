<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-semibold text-slate-900">Laporan Penggajian</h2>
                <p class="text-sm text-slate-500">Laporan payroll berdasarkan periode.</p>
            </div>
            <div class="flex items-center gap-2">
                <button class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700">Export PDF</button>
                <button class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700">Export Excel</button>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="rounded-2xl border border-white/70 bg-white/80 p-4 shadow-sm">
            <form method="GET" action="{{ route('reports.payroll') }}" class="grid gap-3 md:grid-cols-4">
                <input type="month" name="period_month" value="{{ $periodMonth }}" class="rounded-xl border border-slate-200 px-3 py-2 text-sm" />
                <select name="division_id" class="rounded-xl border border-slate-200 px-3 py-2 text-sm">
                    <option value="all" {{ $divisionId === 'all' ? 'selected' : '' }}>Semua divisi</option>
                    @foreach($divisions as $div)
                        <option value="{{ $div->id }}" {{ $divisionId == $div->id ? 'selected' : '' }}>{{ $div->name }}</option>
                    @endforeach
                </select>
                <button type="submit" class="rounded-xl bg-slate-900 px-3 py-2 text-sm font-semibold text-white">Generate</button>
                <a href="{{ route('reports.payroll') }}" class="rounded-xl border border-slate-200 px-3 py-2 text-sm font-semibold text-slate-700 text-center">Reset</a>
            </form>
        </div>

        <div class="rounded-2xl border border-white/70 bg-white/90 p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-semibold text-slate-700">Ringkasan Payroll</h3>
                <span class="text-xs text-slate-500">{{ \Carbon\Carbon::createFromFormat('Y-m', $periodMonth)->format('F Y') }}</span>
            </div>
            
            @if(!$run)
                <div class="mt-8 text-center text-slate-500 py-8">
                    Belum ada proses payroll untuk bulan ini.
                </div>
            @else
                <div class="mt-4 overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="text-left text-xs uppercase tracking-wider text-slate-400">
                            <tr>
                                <th class="pb-3">Divisi</th>
                                <th class="pb-3">Total Gaji</th>
                                <th class="pb-3">Total Potongan</th>
                                <th class="pb-3">Gaji Bersih</th>
                                <th class="pb-3">Karyawan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($reportData as $row)
                            <tr>
                                <td class="py-3 font-medium text-slate-800">{{ $row['division_name'] }}</td>
                                <td class="py-3">Rp {{ number_format($row['total_earnings'], 0, ',', '.') }}</td>
                                <td class="py-3">Rp {{ number_format($row['total_deductions'], 0, ',', '.') }}</td>
                                <td class="py-3 font-semibold text-emerald-700">Rp {{ number_format($row['net_pay'], 0, ',', '.') }}</td>
                                <td class="py-3">{{ $row['employee_count'] }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="py-4 text-center text-slate-500">Tidak ada data untuk periode ini.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
