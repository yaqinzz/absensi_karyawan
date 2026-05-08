<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-semibold text-slate-900">Detail Payroll</h2>
                <p class="text-sm text-slate-500">Periode {{ $run->period_start->format('F Y') }}</p>
            </div>
            @if($run->status != 'final')
                <div class="flex gap-2">
                    <form action="{{ route('payroll.runs.destroy', $run->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus draft payroll ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="rounded-xl bg-rose-100 px-4 py-2 text-sm font-semibold text-rose-700 hover:bg-rose-200">Hapus Draft</button>
                    </form>
                    <form action="{{ route('payroll.runs.finalize', $run->id) }}" method="POST" onsubmit="return confirm('Setelah difinalisasi, payroll tidak bisa dihapus atau diubah. Lanjutkan?');">
                        @csrf
                        <button type="submit" class="rounded-xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">Finalisasi</button>
                    </form>
                </div>
            @endif
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="grid gap-4 md:grid-cols-3">
            <div class="rounded-2xl border border-white/70 bg-white/90 p-4 shadow-sm">
                <p class="text-xs text-slate-500">Total Karyawan</p>
                <p class="mt-2 text-2xl font-semibold text-slate-800">{{ $payrolls->total() }}</p>
            </div>
            <div class="rounded-2xl border border-white/70 bg-white/90 p-4 shadow-sm">
                <p class="text-xs text-slate-500">Total Gaji Bersih</p>
                <!-- Simple sum for mockup purposes. For real app, calculate sum at controller. -->
                <p class="mt-2 text-2xl font-semibold text-slate-800">Rp {{ number_format($payrolls->sum('net_pay'), 0, ',', '.') }}</p>
            </div>
            <div class="rounded-2xl border border-white/70 bg-white/90 p-4 shadow-sm">
                <p class="text-xs text-slate-500">Status</p>
                @if($run->status == 'final')
                    <p class="mt-2 text-sm font-semibold text-emerald-700">Final</p>
                @else
                    <p class="mt-2 text-sm font-semibold text-amber-700">{{ ucfirst($run->status) }}</p>
                @endif
            </div>
        </div>

        <div class="rounded-2xl border border-white/70 bg-white/90 p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-semibold text-slate-700">Rincian Karyawan</h3>
                <span class="text-xs text-slate-500">{{ $payrolls->total() }} baris</span>
            </div>
            <div class="mt-4 overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="text-left text-xs uppercase tracking-wider text-slate-400">
                        <tr>
                            <th class="pb-3">Nama</th>
                            <th class="pb-3">Gaji Pokok</th>
                            <th class="pb-3">Tunjangan</th>
                            <th class="pb-3">Potongan</th>
                            <th class="pb-3">Gaji Bersih</th>
                            <th class="pb-3 text-right">Slip</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($payrolls as $payroll)
                        <tr>
                            <td class="py-3 font-medium text-slate-800">{{ $payroll->employee->name ?? '-' }}</td>
                            <td class="py-3">Rp {{ number_format($payroll->base_salary, 0, ',', '.') }}</td>
                            <td class="py-3">Rp {{ number_format($payroll->total_earnings, 0, ',', '.') }}</td>
                            <td class="py-3">Rp {{ number_format($payroll->total_deductions, 0, ',', '.') }}</td>
                            <td class="py-3 font-semibold text-emerald-700">Rp {{ number_format($payroll->net_pay, 0, ',', '.') }}</td>
                            <td class="py-3 text-right"><a href="{{ route('payroll.slip.pdf', $payroll->id) }}" class="text-emerald-600">Unduh</a></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-4 text-center text-slate-500">Belum ada rincian gaji.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $payrolls->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
