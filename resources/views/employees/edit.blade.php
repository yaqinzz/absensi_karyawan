<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold text-slate-900">Edit Karyawan</h2>
            <p class="text-sm text-slate-500">Perbarui data karyawan: <strong>{{ $employee->name }}</strong></p>
        </div>
    </x-slot>

    <div class="max-w-4xl">
        <form action="{{ route('employees.update', $employee->id) }}" method="POST" class="space-y-6 rounded-2xl border border-white/70 bg-white/90 p-6 shadow-sm">
            @csrf
            @method('PUT')

            @if ($errors->any())
                <div class="rounded-xl bg-rose-50 p-4 text-sm text-rose-700">
                    <ul class="list-inside list-disc space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid gap-4 md:grid-cols-3">
                <div>
                    <label class="text-xs text-slate-500">NIK</label>
                    <input name="nik" required class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm" value="{{ old('nik', $employee->nik) }}" />
                </div>
                <div>
                    <label class="text-xs text-slate-500">Nama Lengkap</label>
                    <input name="name" required class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm" value="{{ old('name', $employee->name) }}" />
                </div>
                <div>
                    <label class="text-xs text-slate-500">No HP</label>
                    <input name="phone" class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm" value="{{ old('phone', $employee->phone) }}" />
                </div>
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="text-xs text-slate-500">Divisi</label>
                    <select name="division_id" required class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm">
                        <option value="">-- Pilih Divisi --</option>
                        @foreach($divisions as $division)
                            <option value="{{ $division->id }}" {{ old('division_id', $employee->division_id) == $division->id ? 'selected' : '' }}>{{ $division->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-xs text-slate-500">Jabatan</label>
                    <select name="position_id" required class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm">
                        <option value="">-- Pilih Jabatan --</option>
                        @foreach($positions as $position)
                            <option value="{{ $position->id }}" {{ old('position_id', $employee->position_id) == $position->id ? 'selected' : '' }}>{{ $position->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid gap-4 md:grid-cols-3">
                <div>
                    <label class="text-xs text-slate-500">Tanggal Masuk</label>
                    <input type="date" name="join_date" required class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm" value="{{ old('join_date', $employee->join_date?->format('Y-m-d')) }}" />
                </div>
                <div>
                    <label class="text-xs text-slate-500">Status</label>
                    <select name="status" required class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm">
                        <option value="active" {{ old('status', $employee->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ old('status', $employee->status) == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
                <div>
                    <label class="text-xs text-slate-500">Gaji Pokok (Rp)</label>
                    <input type="number" name="base_salary" required min="0" class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm" value="{{ old('base_salary', $employee->base_salary) }}" />
                </div>
            </div>

            <div>
                <label class="text-xs text-slate-500">Alamat</label>
                <textarea name="address" class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm" rows="3">{{ old('address', $employee->address) }}</textarea>
            </div>

            <div class="border-t border-slate-100 pt-4">
                <p class="text-xs font-semibold text-slate-500 mb-3">Akun Login</p>
                <div class="grid gap-4 md:grid-cols-3">
                    <div class="md:col-span-1">
                        <label class="text-xs text-slate-500">Email</label>
                        <input type="email" name="email" required class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm" value="{{ old('email', $employee->user->email) }}" />
                    </div>
                    <div>
                        <label class="text-xs text-slate-500">Password Baru</label>
                        <input type="password" name="password" class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm" placeholder="Kosongkan jika tidak diubah" />
                    </div>
                    <div>
                        <label class="text-xs text-slate-500">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm" placeholder="Ulangi password baru" />
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-2">
                <a href="{{ route('employees.index') }}" class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600">Batal</a>
                <button type="submit" class="rounded-xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</x-app-layout>
