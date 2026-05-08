<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold text-slate-900">Slip Gaji</h2>
            <p class="text-sm text-slate-500">Periode April 2026</p>
        </div>
    </x-slot>

    <div class="max-w-3xl space-y-6">
        @if($payroll)
        <div class="rounded-2xl border border-white/70 bg-white/90 p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-slate-500">Nama</p>
                    <p class="text-lg font-semibold text-slate-800">{{ $payroll->employee->name }}</p>
                </div>
                <div class="text-right">
                    <p class="text-xs text-slate-500">Total Gaji Bersih</p>
                    <p class="text-lg font-semibold text-emerald-700">Rp {{ number_format($payroll->net_pay, 0, ',', '.') }}</p>
                </div>
            </div>
            <div class="mt-6 grid gap-4 md:grid-cols-2">
                <div class="rounded-xl bg-slate-50 p-4">
                    <p class="text-xs font-semibold text-slate-500">Pendapatan</p>
                    <ul class="mt-3 space-y-2 text-sm">
                        <li class="flex justify-between"><span>Gaji Pokok</span><span>Rp {{ number_format($payroll->base_salary, 0, ',', '.') }}</span></li>
                        @foreach($payroll->items->where('type', 'allowance') as $item)
                            <li class="flex justify-between text-slate-600"><span>{{ $item->name }}</span><span>Rp {{ number_format($item->amount, 0, ',', '.') }}</span></li>
                        @endforeach
                        <li class="flex justify-between font-bold pt-2 mt-2 border-t border-slate-200"><span>Total Pendapatan Kotor</span><span>Rp {{ number_format($payroll->base_salary + $payroll->total_earnings, 0, ',', '.') }}</span></li>
                    </ul>
                </div>
                <div class="rounded-xl bg-slate-50 p-4">
                    <p class="text-xs font-semibold text-slate-500">Potongan</p>
                    <ul class="mt-3 space-y-2 text-sm">
                        @forelse($payroll->items->where('type', 'deduction') as $item)
                            <li class="flex justify-between text-slate-600"><span>{{ $item->name }}</span><span>Rp {{ number_format($item->amount, 0, ',', '.') }}</span></li>
                        @empty
                            <li class="text-slate-500 italic text-center">Tidak ada potongan</li>
                        @endforelse
                        <li class="flex justify-between font-bold pt-2 mt-2 border-t border-slate-200"><span>Total Potongan</span><span>Rp {{ number_format($payroll->total_deductions, 0, ',', '.') }}</span></li>
                    </ul>
                </div>
            </div>
        </div>
        @else
        <div class="rounded-2xl border border-white/70 bg-white/90 p-6 shadow-sm text-center">
            <p class="text-slate-500">Belum ada slip gaji yang diterbitkan untuk Anda.</p>
        </div>
        @endif

        <div class="flex justify-end gap-2">
            <a href="{{ route('payroll.slip.pdf', $payroll->id) }}" class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700">Unduh PDF</a>
            <button class="rounded-xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white">Kirim Email</button>
        </div>
    </div>
</x-app-layout>
