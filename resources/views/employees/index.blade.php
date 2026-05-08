<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-semibold text-slate-900">Karyawan</h2>
                <p class="text-sm text-slate-500">Kelola data karyawan, status, dan jabatan.</p>
            </div>
            <a href="{{ route('employees.create') }}" class="rounded-xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-emerald-700">Tambah Karyawan</a>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="rounded-2xl border border-white/70 bg-white/80 p-4 shadow-sm">
            <div class="grid gap-3 md:grid-cols-5">
                <input class="rounded-xl border border-slate-200 px-3 py-2 text-sm" placeholder="Cari nama/NIK..." />
                <select class="rounded-xl border border-slate-200 px-3 py-2 text-sm">
                    <option>Semua divisi</option>
                    <option>Engineering</option>
                    <option>Finance</option>
                </select>
                <select class="rounded-xl border border-slate-200 px-3 py-2 text-sm">
                    <option>Semua status</option>
                    <option>Aktif</option>
                    <option>Nonaktif</option>
                </select>
                <button class="rounded-xl bg-slate-900 px-3 py-2 text-sm font-semibold text-white">Terapkan Filter</button>
                <button class="rounded-xl border border-slate-200 px-3 py-2 text-sm font-semibold text-slate-700">Reset</button>
            </div>
        </div>

        <div class="rounded-2xl border border-white/70 bg-white/90 p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-semibold text-slate-700">Daftar Karyawan</h3>
                <span class="text-xs text-slate-500">Total {{ $employees->total() }} karyawan</span>
            </div>
            <div class="mt-4 overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="text-left text-xs uppercase tracking-wider text-slate-400">
                        <tr>
                            <th class="pb-3">NIK</th>
                            <th class="pb-3">Nama</th>
                            <th class="pb-3">Divisi</th>
                            <th class="pb-3">Jabatan</th>
                            <th class="pb-3">Status</th>
                            <th class="pb-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($employees as $employee)
                        <tr>
                            <td class="py-3 font-medium text-slate-800">{{ $employee->nik }}</td>
                            <td class="py-3">{{ $employee->name }}</td>
                            <td class="py-3">{{ $employee->division->name ?? '-' }}</td>
                            <td class="py-3">{{ $employee->position->name ?? '-' }}</td>
                            <td class="py-3">
                                @if($employee->status == 'active')
                                    <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">Aktif</span>
                                @else
                                    <span class="rounded-full bg-rose-100 px-3 py-1 text-xs font-semibold text-rose-700">Nonaktif</span>
                                @endif
                            </td>
                            <td class="py-3 text-right"><a href="{{ route('employees.edit', $employee->id) }}" class="text-emerald-600">Edit</a></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-4 text-center text-slate-500">Belum ada data karyawan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $employees->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
