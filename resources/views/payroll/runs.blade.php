<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-semibold text-slate-900">Payroll Run</h2>
                <p class="text-sm text-slate-500">Kelola proses penggajian per periode.</p>
            </div>
            <form action="{{ route('payroll.runs.store') }}" method="POST" class="flex items-center gap-2">
                @csrf
                <input type="month" name="period_month" required class="rounded-xl border border-slate-200 px-3 py-2 text-sm" value="{{ date('Y-m') }}" />
                <button type="submit" class="rounded-xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">Buat Payroll Baru</button>
            </form>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="rounded-2xl border border-white/70 bg-white/80 p-4 shadow-sm">
            <div class="grid gap-3 md:grid-cols-4">
                <input type="month" class="rounded-xl border border-slate-200 px-3 py-2 text-sm" />
                <select class="rounded-xl border border-slate-200 px-3 py-2 text-sm">
                    <option>Semua status</option>
                    <option>Draft</option>
                    <option>Final</option>
                </select>
                <button class="rounded-xl bg-slate-900 px-3 py-2 text-sm font-semibold text-white">Terapkan Filter</button>
                <button class="rounded-xl border border-slate-200 px-3 py-2 text-sm font-semibold text-slate-700">Reset</button>
            </div>
        </div>

        <div class="rounded-2xl border border-white/70 bg-white/90 p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-semibold text-slate-700">Riwayat Payroll</h3>
                <span class="text-xs text-slate-500">Total {{ $runs->total() }} periode</span>
            </div>
            <div class="mt-4 overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="text-left text-xs uppercase tracking-wider text-slate-400">
                        <tr>
                            <th class="pb-3">Periode</th>
                            <th class="pb-3">Tanggal Bayar</th>
                            <th class="pb-3">Status</th>
                            <th class="pb-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($runs as $run)
                        <tr>
                            <td class="py-3 font-medium text-slate-800">{{ $run->period_start->format('F Y') }}</td>
                            <td class="py-3">{{ $run->pay_date->format('Y-m-d') }}</td>
                            <td class="py-3">
                                @if($run->status == 'final')
                                    <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">Final</span>
                                @else
                                    <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">{{ ucfirst($run->status) }}</span>
                                @endif
                            </td>
                            <td class="py-3 text-right"><a href="{{ route('payroll.show', $run->id) }}" class="text-emerald-600">Detail</a></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-4 text-center text-slate-500">Belum ada data payroll.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $runs->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
