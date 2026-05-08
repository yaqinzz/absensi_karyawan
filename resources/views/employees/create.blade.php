<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-h2 text-h2 font-semibold text-on-surface">Tambah Karyawan Baru</h2>
            <p class="text-body-md text-on-surface-variant">Lengkapi data profil karyawan serta pembuatan akun sistem.</p>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <!-- Error display -->
        @if ($errors->any())
            <div class="mb-lg p-md rounded-xl bg-error-container text-on-error-container border border-error">
                <div class="flex items-center gap-sm mb-xs font-bold">
                    <span class="material-symbols-outlined">warning</span>
                    Terdapat Kesalahan Input
                </div>
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('employees.store') }}" class="space-y-lg bg-surface-container-lowest p-xl rounded-2xl border border-outline-variant shadow-sm">
            @csrf

            <!-- SECTION: AKUN LOGIN -->
            <div>
                <h3 class="font-h3 text-h3 text-primary mb-md border-b border-outline-variant pb-xs">1. Akun Login (User)</h3>
                <div class="grid gap-lg md:grid-cols-2">
                    <div>
                        <label for="email" class="block font-bold text-label-caps text-on-surface mb-xs">ALAMAT EMAIL</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-md top-1/2 -translate-y-1/2 text-outline">mail</span>
                            <input id="email" name="email" type="email" value="{{ old('email') }}" required class="block w-full pl-12 pr-md py-sm bg-surface-container-low border border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary rounded-lg text-body-md text-on-surface" placeholder="nama@perusahaan.com" />
                        </div>
                    </div>
                    <div>
                        <label for="password" class="block font-bold text-label-caps text-on-surface mb-xs">PASSWORD SEMENTARA</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-md top-1/2 -translate-y-1/2 text-outline">lock</span>
                            <input id="password" name="password" type="password" required minlength="8" class="block w-full pl-12 pr-md py-sm bg-surface-container-low border border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary rounded-lg text-body-md text-on-surface" placeholder="Minimal 8 karakter" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION: DATA KARYAWAN -->
            <div>
                <h3 class="font-h3 text-h3 text-primary mb-md border-b border-outline-variant pb-xs mt-xl">2. Data Pribadi & Profil</h3>
                
                <div class="grid gap-lg md:grid-cols-3 mb-lg">
                    <div>
                        <label for="nik" class="block font-bold text-label-caps text-on-surface mb-xs">NIK</label>
                        <input id="nik" name="nik" value="{{ old('nik') }}" required class="block w-full px-md py-sm bg-surface-container-low border border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary rounded-lg text-body-md" placeholder="EMP-001" />
                    </div>
                    <div class="md:col-span-2">
                        <label for="name" class="block font-bold text-label-caps text-on-surface mb-xs">NAMA LENGKAP</label>
                        <input id="name" name="name" value="{{ old('name') }}" required class="block w-full px-md py-sm bg-surface-container-low border border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary rounded-lg text-body-md" placeholder="Masukkan nama lengkap sesuai KTP" />
                    </div>
                </div>

                <div class="grid gap-lg md:grid-cols-2 mb-lg">
                    <div>
                        <label for="division_id" class="block font-bold text-label-caps text-on-surface mb-xs">DIVISI</label>
                        <select id="division_id" name="division_id" required class="block w-full px-md py-sm bg-surface-container-low border border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary rounded-lg text-body-md">
                            <option value="">-- Pilih Divisi --</option>
                            @foreach($divisions as $division)
                                <option value="{{ $division->id }}" {{ old('division_id') == $division->id ? 'selected' : '' }}>{{ $division->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="position_id" class="block font-bold text-label-caps text-on-surface mb-xs">JABATAN</label>
                        <select id="position_id" name="position_id" required class="block w-full px-md py-sm bg-surface-container-low border border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary rounded-lg text-body-md">
                            <option value="">-- Pilih Jabatan --</option>
                            @foreach($positions as $position)
                                <option value="{{ $position->id }}" {{ old('position_id') == $position->id ? 'selected' : '' }}>{{ $position->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid gap-lg md:grid-cols-3 mb-lg">
                    <div>
                        <label for="join_date" class="block font-bold text-label-caps text-on-surface mb-xs">TANGGAL MASUK</label>
                        <input id="join_date" name="join_date" type="date" value="{{ old('join_date') }}" required class="block w-full px-md py-sm bg-surface-container-low border border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary rounded-lg text-body-md" />
                    </div>
                    <div>
                        <label for="status" class="block font-bold text-label-caps text-on-surface mb-xs">STATUS KARYAWAN</label>
                        <select id="status" name="status" required class="block w-full px-md py-sm bg-surface-container-low border border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary rounded-lg text-body-md">
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>
                    <div>
                        <label for="base_salary" class="block font-bold text-label-caps text-on-surface mb-xs">GAJI POKOK (RP)</label>
                        <input id="base_salary" name="base_salary" type="number" value="{{ old('base_salary', 0) }}" required min="0" step="1000" class="block w-full px-md py-sm bg-surface-container-low border border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary rounded-lg text-body-md" />
                    </div>
                </div>

                <div class="grid gap-lg md:grid-cols-2">
                    <div>
                        <label for="phone" class="block font-bold text-label-caps text-on-surface mb-xs">NO. HP / WHATSAPP</label>
                        <input id="phone" name="phone" value="{{ old('phone') }}" class="block w-full px-md py-sm bg-surface-container-low border border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary rounded-lg text-body-md" placeholder="08xxxx" />
                    </div>
                    <div>
                        <label for="address" class="block font-bold text-label-caps text-on-surface mb-xs">ALAMAT DOMISILI</label>
                        <textarea id="address" name="address" rows="2" class="block w-full px-md py-sm bg-surface-container-low border border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary rounded-lg text-body-md">{{ old('address') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-md pt-lg border-t border-outline-variant mt-xl">
                <a href="{{ route('employees.index') }}" class="px-lg py-sm rounded-lg font-bold text-on-surface-variant hover:bg-surface-container-low transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-lg py-sm bg-primary text-on-primary rounded-lg font-bold hover:opacity-90 transition-opacity flex items-center gap-sm">
                    <span class="material-symbols-outlined text-sm">save</span>
                    Simpan Data & Buat Akun
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
