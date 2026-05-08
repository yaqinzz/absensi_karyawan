<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold text-slate-900">Tambah Jabatan</h2>
            <p class="text-sm text-slate-500">Buat posisi/jabatan baru untuk karyawan.</p>
        </div>
    </x-slot>

    <div class="max-w-4xl">
        @if ($errors->any())
            <div class="mb-6 rounded-xl bg-rose-100 p-4 text-sm font-medium text-rose-700">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('positions.store') }}" class="space-y-6 rounded-2xl border border-white/70 bg-white/90 p-6 shadow-sm">
            @csrf
            
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="text-xs text-slate-500">KODE JABATAN</label>
                    <input name="code" value="{{ old('code') }}" required class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm" placeholder="MGR, STF" />
                </div>
                <div>
                    <label class="text-xs text-slate-500">NAMA JABATAN</label>
                    <input name="name" value="{{ old('name') }}" required class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm" placeholder="Manager IT" />
                </div>
            </div>

            <div>
                <label class="text-xs text-slate-500">LEVEL HIRARKI</label>
                <input type="number" name="level" value="{{ old('level', 1) }}" min="1" required class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm" />
                <p class="mt-1 text-xs text-slate-400">1 = Paling Rendah (Staff), semakin tinggi angka, semakin tinggi jabatan.</p>
            </div>

            <div>
                <label class="text-xs text-slate-500">DESKRIPSI</label>
                <textarea name="description" rows="3" class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm">{{ old('description') }}</textarea>
            </div>

            <div>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="rounded border-slate-300 text-emerald-600 shadow-sm focus:ring-emerald-500" />
                    <span class="text-sm font-medium text-slate-700">Aktifkan Jabatan Ini</span>
                </label>
            </div>

            <div class="flex justify-end gap-2">
                <a href="{{ route('positions.index') }}" class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600">Batal</a>
                <button type="submit" class="rounded-xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white">Simpan</button>
            </div>
        </form>
    </div>
</x-app-layout>
