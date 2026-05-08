<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold text-slate-900">Edit Jabatan</h2>
            <p class="text-sm text-slate-500">Perbarui data posisi/jabatan yang sudah ada.</p>
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

        <form method="POST" action="{{ route('positions.update', $position->id) }}" class="space-y-6 rounded-2xl border border-white/70 bg-white/90 p-6 shadow-sm">
            @csrf
            @method('PUT')
            
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="text-xs text-slate-500">KODE JABATAN</label>
                    <input name="code" value="{{ old('code', $position->code) }}" required class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm" />
                </div>
                <div>
                    <label class="text-xs text-slate-500">NAMA JABATAN</label>
                    <input name="name" value="{{ old('name', $position->name) }}" required class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm" />
                </div>
            </div>

            <div>
                <label class="text-xs text-slate-500">LEVEL HIRARKI</label>
                <input type="number" name="level" value="{{ old('level', $position->level) }}" min="1" required class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm" />
            </div>

            <div>
                <label class="text-xs text-slate-500">DESKRIPSI</label>
                <textarea name="description" rows="3" class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm">{{ old('description', $position->description) }}</textarea>
            </div>

            <div>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $position->is_active) ? 'checked' : '' }} class="rounded border-slate-300 text-emerald-600 shadow-sm focus:ring-emerald-500" />
                    <span class="text-sm font-medium text-slate-700">Aktifkan Jabatan Ini</span>
                </label>
            </div>

            <div class="flex justify-end gap-2">
                <a href="{{ route('positions.index') }}" class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600">Batal</a>
                <button type="submit" class="rounded-xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white">Perbarui</button>
            </div>
        </form>
    </div>
</x-app-layout>
