<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-semibold text-slate-900">Data Jabatan</h2>
                <p class="text-sm text-slate-500">Kelola daftar posisi/jabatan beserta tingkatan levelnya.</p>
            </div>
            <a href="{{ route('positions.create') }}" class="rounded-xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-emerald-700">Tambah Jabatan</a>
        </div>
    </x-slot>

    <div class="space-y-6">
        @if (session('status'))
            <div class="rounded-xl bg-emerald-100 p-4 text-sm font-medium text-emerald-700">
                {{ session('status') }}
            </div>
        @endif

        <div class="rounded-2xl border border-white/70 bg-white/90 p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-semibold text-slate-700">Daftar Jabatan</h3>
                <span class="text-xs text-slate-500">Total {{ $positions->total() }} jabatan</span>
            </div>
            <div class="mt-4 overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="text-left text-xs uppercase tracking-wider text-slate-400">
                        <tr>
                            <th class="pb-3">KODE</th>
                            <th class="pb-3">NAMA JABATAN</th>
                            <th class="pb-3">LEVEL</th>
                            <th class="pb-3">STATUS</th>
                            <th class="pb-3 text-right">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($positions as $position)
                        <tr>
                            <td class="py-3 font-medium text-slate-800">{{ $position->code }}</td>
                            <td class="py-3">{{ $position->name }}</td>
                            <td class="py-3">
                                <span class="rounded bg-slate-100 px-2 py-1 text-xs font-semibold text-slate-600 border border-slate-200">Level {{ $position->level }}</span>
                            </td>
                            <td class="py-3">
                                @if($position->is_active)
                                    <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">Aktif</span>
                                @else
                                    <span class="rounded-full bg-rose-100 px-3 py-1 text-xs font-semibold text-rose-700">Nonaktif</span>
                                @endif
                            </td>
                            <td class="py-3 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('positions.edit', $position->id) }}" class="text-emerald-600">Edit</a>
                                    <form action="{{ route('positions.destroy', $position->id) }}" method="POST" onsubmit="return confirm('Hapus jabatan ini?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-rose-600">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-4 text-center text-slate-500">Belum ada data jabatan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $positions->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
