<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold text-slate-900">Manajemen Cuti</h2>
            <p class="text-sm text-slate-500">Review dan setujui pengajuan cuti karyawan.</p>
        </div>
    </x-slot>

    <div class="space-y-6">
        {{-- Filter Status --}}
        <div class="flex gap-2">
            @foreach(['pending' => 'Menunggu', 'approved' => 'Disetujui', 'rejected' => 'Ditolak', 'all' => 'Semua'] as $val => $label)
                <a href="{{ route('leaves.index', ['status' => $val]) }}"
                   class="rounded-full px-4 py-1.5 text-sm font-semibold {{ $status === $val ? 'bg-emerald-600 text-white' : 'bg-white border border-slate-200 text-slate-600' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        @if(session('status'))
            <div class="rounded-xl bg-emerald-50 p-3 text-sm text-emerald-700">{{ session('status') }}</div>
        @endif

        <div class="rounded-2xl border border-white/70 bg-white/90 shadow-sm overflow-hidden">
            @if($leaves->isEmpty())
                <div class="py-12 text-center text-sm text-slate-400">Tidak ada pengajuan cuti.</div>
            @else
                <table class="w-full text-sm">
                    <thead class="border-b border-slate-100">
                        <tr class="text-xs font-semibold uppercase text-slate-400">
                            <th class="px-6 py-3 text-left">Karyawan</th>
                            <th class="px-6 py-3 text-left">Jenis</th>
                            <th class="px-6 py-3 text-left">Tanggal</th>
                            <th class="px-6 py-3 text-center">Hari</th>
                            <th class="px-6 py-3 text-left">Alasan</th>
                            <th class="px-6 py-3 text-center">Status</th>
                            <th class="px-6 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($leaves as $leave)
                        <tr>
                            <td class="px-6 py-4 font-medium text-slate-800">{{ $leave->employee->name }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ \App\Models\LeaveRequest::$typeLabels[$leave->leave_type] }}</td>
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
                            <td class="px-6 py-4 text-right">
                                @if($leave->status === 'pending')
                                    <form action="{{ route('leaves.approve', $leave->id) }}" method="POST" class="inline-flex gap-2 items-center">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="action" value="approved">
                                        <button type="submit" class="text-xs font-semibold text-emerald-600 hover:underline">Setujui</button>
                                    </form>
                                    <form action="{{ route('leaves.approve', $leave->id) }}" method="POST" class="inline-flex gap-2 items-center ml-3">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="action" value="rejected">
                                        <button type="submit" class="text-xs font-semibold text-rose-500 hover:underline">Tolak</button>
                                    </form>
                                @else
                                    <span class="text-xs text-slate-400">{{ $leave->approver?->name ?? '-' }}</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="px-6 py-4">{{ $leaves->withQueryString()->links() }}</div>
            @endif
        </div>
    </div>
</x-app-layout>
