<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold text-slate-900">Hari Libur</h2>
            <p class="text-sm text-slate-500">Kelola hari libur nasional dan libur kantor.</p>
        </div>
    </x-slot>

    <div class="space-y-6">

        {{-- Form Tambah / Edit --}}
        <div class="rounded-2xl border border-white/70 bg-white/90 p-6 shadow-sm">
            <h3 class="text-sm font-semibold text-slate-700 mb-4">
                {{ $editHoliday ? 'Edit Hari Libur' : 'Tambah Hari Libur' }}
            </h3>
            <form action="{{ $editHoliday ? route('holidays.update', $editHoliday->id) : route('holidays.store') }}" method="POST" class="grid gap-4 md:grid-cols-4">
                @csrf
                @if($editHoliday) @method('PUT') @endif

                @if ($errors->any())
                    <div class="md:col-span-4 rounded-xl bg-rose-50 p-3 text-sm text-rose-700">
                        {{ $errors->first() }}
                    </div>
                @endif

                <div>
                    <label class="text-xs text-slate-500">Tanggal</label>
                    <input type="date" name="date" required
                        value="{{ old('date', $editHoliday?->date?->format('Y-m-d')) }}"
                        class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm" />
                </div>
                <div>
                    <label class="text-xs text-slate-500">Nama Hari Libur</label>
                    <input type="text" name="name" required placeholder="Contoh: Hari Raya Idul Fitri"
                        value="{{ old('name', $editHoliday?->name) }}"
                        class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm" />
                </div>
                <div>
                    <label class="text-xs text-slate-500">Jenis</label>
                    <select name="type" class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm">
                        <option value="national" {{ old('type', $editHoliday?->type) == 'national' ? 'selected' : '' }}>Hari Libur Nasional</option>
                        <option value="office" {{ old('type', $editHoliday?->type) == 'office' ? 'selected' : '' }}>Libur Kantor</option>
                    </select>
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="flex-1 rounded-xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white">
                        {{ $editHoliday ? 'Simpan Perubahan' : 'Tambah' }}
                    </button>
                    @if($editHoliday)
                        <a href="{{ route('holidays.index') }}" class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600">Batal</a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Filter Tahun + Daftar --}}
        <div class="rounded-2xl border border-white/70 bg-white/90 p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-semibold text-slate-700">Daftar Hari Libur Tahun {{ $year }}</h3>
                <form method="GET" action="{{ route('holidays.index') }}" class="flex gap-2 items-center">
                    <select name="year" onchange="this.form.submit()" class="rounded-xl border border-slate-200 px-3 py-2 text-sm">
                        @foreach(range(now()->year - 1, now()->year + 2) as $y)
                            <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
                        @endforeach
                    </select>
                </form>
            </div>

            @if(session('status'))
                <div class="mb-4 rounded-xl bg-emerald-50 p-3 text-sm text-emerald-700">{{ session('status') }}</div>
            @endif

            @if($holidays->isEmpty())
                <p class="text-sm text-slate-400 text-center py-6">Belum ada hari libur untuk tahun {{ $year }}.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-slate-100 text-xs font-semibold uppercase text-slate-400">
                                <th class="pb-3 text-left">Tanggal</th>
                                <th class="pb-3 text-left">Nama</th>
                                <th class="pb-3 text-left">Jenis</th>
                                <th class="pb-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($holidays as $holiday)
                            <tr>
                                <td class="py-3 text-slate-700 font-medium">{{ $holiday->date->translatedFormat('d F Y') }}</td>
                                <td class="py-3 text-slate-600">{{ $holiday->name }}</td>
                                <td class="py-3">
                                    @if($holiday->type === 'national')
                                        <span class="rounded-full bg-red-100 px-2 py-0.5 text-xs font-semibold text-red-600">Nasional</span>
                                    @else
                                        <span class="rounded-full bg-blue-100 px-2 py-0.5 text-xs font-semibold text-blue-600">Libur Kantor</span>
                                    @endif
                                </td>
                                <td class="py-3 text-right space-x-3">
                                    <a href="{{ route('holidays.index', ['edit' => $holiday->id, 'year' => $year]) }}" class="text-xs font-semibold text-emerald-600 hover:underline">Edit</a>
                                    <form action="{{ route('holidays.destroy', $holiday->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus hari libur ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-xs font-semibold text-rose-500 hover:underline">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
