<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold text-slate-900">Aturan Komponen Gaji</h2>
            <p class="text-sm text-slate-500">Kelola aturan dan default komponen gaji.</p>
        </div>
    </x-slot>

    <div class="space-y-6">
        @if (session('status'))
            <div class="rounded-xl bg-emerald-100 p-4 text-sm font-medium text-emerald-700">
                {{ session('status') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="rounded-xl bg-rose-100 p-4 text-sm font-medium text-rose-700">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="rounded-2xl border border-white/70 bg-white/90 p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-semibold text-slate-700">{{ isset($edit_component) ? 'Edit Komponen Gaji' : 'Tambah Komponen Baru' }}</h3>
                @if(isset($edit_component))
                    <a href="{{ route('salary-components.index') }}" class="text-xs text-slate-500 hover:text-slate-700">Batal Edit</a>
                @endif
            </div>
            <form action="{{ isset($edit_component) ? route('salary-components.update', $edit_component->id) : route('salary-components.store') }}" method="POST" class="mt-4 grid gap-4 md:grid-cols-4">
                @csrf
                @if(isset($edit_component))
                    @method('PUT')
                @endif
                <div>
                    <label class="text-xs text-slate-500">Kode</label>
                    <input name="code" value="{{ old('code', $edit_component->code ?? '') }}" required class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm" placeholder="Contoh: GP, BPJS" />
                </div>
                <div>
                    <label class="text-xs text-slate-500">Nama Komponen</label>
                    <input name="name" value="{{ old('name', $edit_component->name ?? '') }}" required class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm" placeholder="Contoh: Gaji Pokok" />
                </div>
                <div>
                    <label class="text-xs text-slate-500">Tipe</label>
                    <select name="type" required class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm">
                        <option value="allowance" {{ old('type', $edit_component->type ?? '') == 'allowance' ? 'selected' : '' }}>Pendapatan (Tunjangan)</option>
                        <option value="deduction" {{ old('type', $edit_component->type ?? '') == 'deduction' ? 'selected' : '' }}>Potongan</option>
                    </select>
                </div>
                <div>
                    <label class="text-xs text-slate-500">Jenis Nilai</label>
                    <select name="is_percentage" class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm">
                        <option value="0" {{ old('is_percentage', $edit_component->is_percentage ?? 0) == 0 ? 'selected' : '' }}>Nominal Tetap (Rp)</option>
                        <option value="1" {{ old('is_percentage', $edit_component->is_percentage ?? 0) == 1 ? 'selected' : '' }}>Persentase (%)</option>
                    </select>
                </div>
                <div>
                    <label class="text-xs text-slate-500">Nilai Default (Rp / %)</label>
                    <input type="number" step="0.01" name="default_amount" value="{{ old('default_amount', $edit_component->default_amount ?? '0') }}" required class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm" />
                </div>
                <div>
                    <label class="text-xs text-slate-500">Status</label>
                    <select name="is_active" class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm">
                        <option value="1" {{ old('is_active', $edit_component->is_active ?? 1) == 1 ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ old('is_active', $edit_component->is_active ?? 1) == 0 ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
                <div class="md:col-span-4 flex justify-end gap-2">
                    <button type="submit" class="rounded-xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white">
                        {{ isset($edit_component) ? 'Simpan Perubahan' : 'Simpan Komponen' }}
                    </button>
                </div>
            </form>
        </div>

        <div class="rounded-2xl border border-white/70 bg-white/90 p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-semibold text-slate-700">Daftar Komponen</h3>
                <span class="text-xs text-slate-500">{{ $components->total() }} komponen</span>
            </div>
            <div class="mt-4 overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="text-left text-xs uppercase tracking-wider text-slate-400">
                        <tr>
                            <th class="pb-3">Kode</th>
                            <th class="pb-3">Nama Komponen</th>
                            <th class="pb-3">Tipe</th>
                            <th class="pb-3">Default</th>
                            <th class="pb-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($components as $comp)
                        <tr>
                            <td class="py-3 font-medium text-slate-800">{{ $comp->code }}</td>
                            <td class="py-3 font-medium text-slate-800">{{ $comp->name }}</td>
                            <td class="py-3">
                                @if($comp->type == 'allowance')
                                    <span class="rounded bg-emerald-50 px-2 py-1 text-xs text-emerald-600 border border-emerald-100">Pendapatan</span>
                                @else
                                    <span class="rounded bg-rose-50 px-2 py-1 text-xs text-rose-600 border border-rose-100">Potongan</span>
                                @endif
                            </td>
                            <td class="py-3">
                                @if($comp->is_percentage)
                                    {{ rtrim(rtrim(number_format($comp->default_amount, 2, ',', '.'), '0'), ',') }} %
                                @else
                                    Rp {{ number_format($comp->default_amount, 0, ',', '.') }}
                                @endif
                            </td>
                            <td class="py-3 text-right">
                                <a href="{{ route('salary-components.edit', $comp->id) }}" class="text-emerald-600 mr-3">Edit</a>
                                <form action="{{ route('salary-components.destroy', $comp->id) }}" method="POST" onsubmit="return confirm('Hapus komponen ini?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-600">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-4 text-center text-slate-500">Belum ada pengaturan komponen gaji.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $components->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
