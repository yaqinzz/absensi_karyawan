<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold text-slate-900">Cuti Saya</h2>
            <p class="text-sm text-slate-500">Ajukan dan pantau status cuti Anda.</p>
        </div>
    </x-slot>

    <div class="space-y-6">
        {{-- Form Pengajuan Cuti --}}
        <div class="rounded-2xl border border-white/70 bg-white/90 p-6 shadow-sm">
            <h3 class="text-sm font-semibold text-slate-700 mb-4">Ajukan Cuti Baru</h3>
            <form action="{{ route('leaves.store') }}" method="POST" class="grid gap-4 md:grid-cols-2">
                @csrf
                @if ($errors->any())
                    <div class="md:col-span-2 rounded-xl bg-rose-50 p-3 text-sm text-rose-700">
                        {{ $errors->first() }}
                    </div>
                @endif

                <div>
                    <label class="text-xs text-slate-500">Jenis Cuti</label>
                    <select name="leave_type" class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm">
                        @foreach(\App\Models\LeaveRequest::$typeLabels as $val => $label)
                            <option value="{{ $val }}" {{ old('leave_type') == $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="text-xs text-slate-500">Mulai</label>
                        <input type="date" name="start_date" value="{{ old('start_date') }}" required
                               class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm" />
                    </div>
                    <div>
                        <label class="text-xs text-slate-500">Selesai</label>
                        <input type="date" name="end_date" value="{{ old('end_date') }}" required
                               class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm" />
                    </div>
                </div>
                <div class="md:col-span-2">
                    <label class="text-xs text-slate-500">Alasan</label>
                    <textarea name="reason" rows="2" required placeholder="Jelaskan alasan pengajuan cuti..."
                              class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm resize-none">{{ old('reason') }}</textarea>
                </div>
                <div class="md:col-span-2 flex justify-end">
                    <button type="submit" class="rounded-xl bg-emerald-600 px-6 py-2 text-sm font-semibold text-white">
                        Kirim Pengajuan
                    </button>
                </div>
            </form>
        </div>

        {{-- Riwayat Cuti --}}
        <div class="rounded-2xl border border-white/70 bg-white/90 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100">
                <h3 class="text-sm font-semibold text-slate-700">Riwayat Pengajuan</h3>
            </div>

            @if(session('status'))
                <div class="px-6 py-3 bg-emerald-50 text-sm text-emerald-700">{{ session('status') }}</div>
            @endif

            @if($leaves->isEmpty())
                <div class="py-10 text-center text-sm text-slate-400">Belum ada pengajuan cuti.</div>
            @else
                <table class="w-full text-sm">
                    <thead class="border-b border-slate-100">
                        <tr class="text-xs font-semibold uppercase text-slate-400">
                            <th class="px-6 py-3 text-left">Jenis</th>
                            <th class="px-6 py-3 text-left">Tanggal</th>
                            <th class="px-6 py-3 text-center">Hari</th>
                            <th class="px-6 py-3 text-left">Alasan</th>
                            <th class="px-6 py-3 text-center">Status</th>
                            <th class="px-6 py-3 text-left">Catatan</th>
                            <th class="px-6 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($leaves as $leave)
                        <tr>
                            <td class="px-6 py-4 font-medium text-slate-800">
                                {{ \App\Models\LeaveRequest::$typeLabels[$leave->leave_type] }}
                                @if($leave->leave_type === 'unpaid')
                                    <span class="ml-1 text-xs text-rose-500">(Tanpa Bayar)</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-slate-600">
                                {{ $leave->start_date->format('d M Y') }}
                                @if(!$leave->start_date->eq($leave->end_date))
                                    – {{ $leave->end_date->format('d M Y') }}
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">{{ $leave->total_days }}</td>
                            <td class="px-6 py-4 text-slate-500 max-w-xs truncate">{{ $leave->reason }}</td>
                            <td class="px-6 py-4 text-center">
                                @if($leave->status === 'pending')
                                    <span class="rounded-full bg-amber-100 px-2 py-0.5 text-xs font-semibold text-amber-600">Menunggu</span>
                                @elseif($leave->status === 'approved')
                                    <span class="rounded-full bg-emerald-100 px-2 py-0.5 text-xs font-semibold text-emerald-600">Disetujui</span>
                                @else
                                    <span class="rounded-full bg-rose-100 px-2 py-0.5 text-xs font-semibold text-rose-600">Ditolak</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-xs text-slate-400">{{ $leave->approver_notes ?? '-' }}</td>
                            <td class="px-6 py-4 text-right">
                                @if($leave->status === 'pending')
                                    <form action="{{ route('leaves.destroy', $leave->id) }}" method="POST" onsubmit="return confirm('Batalkan pengajuan ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-xs font-semibold text-rose-500 hover:underline">Batalkan</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="px-6 py-4">{{ $leaves->links() }}</div>
            @endif
        </div>
    </div>
</x-app-layout>
