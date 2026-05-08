<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-semibold text-slate-900">Komponen Gaji</h2>
                <p class="text-sm text-slate-500">Atur komponen pendapatan dan potongan.</p>
            </div>
            <button class="rounded-xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white">Tambah Komponen</button>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="rounded-2xl border border-white/70 bg-white/80 p-4 shadow-sm">
            <div class="grid gap-3 md:grid-cols-4">
                <input class="rounded-xl border border-slate-200 px-3 py-2 text-sm" placeholder="Cari komponen..." />
                <select class="rounded-xl border border-slate-200 px-3 py-2 text-sm">
                    <option>Semua tipe</option>
                    <option>Pendapatan</option>
                    <option>Potongan</option>
                </select>
                <button class="rounded-xl bg-slate-900 px-3 py-2 text-sm font-semibold text-white">Terapkan Filter</button>
                <button class="rounded-xl border border-slate-200 px-3 py-2 text-sm font-semibold text-slate-700">Reset</button>
            </div>
        </div>

        <div class="rounded-2xl border border-white/70 bg-white/90 p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-semibold text-slate-700">Daftar Komponen</h3>
                <span class="text-xs text-slate-500">Total 7 komponen</span>
            </div>
            <div class="mt-4 overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="text-left text-xs uppercase tracking-wider text-slate-400">
                        <tr>
                            <th class="pb-3">Kode</th>
                            <th class="pb-3">Nama</th>
                            <th class="pb-3">Tipe</th>
                            <th class="pb-3">Default</th>
                            <th class="pb-3">Status</th>
                            <th class="pb-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <tr>
                            <td class="py-3 font-medium text-slate-800">BASIC</td>
                            <td class="py-3">Gaji Pokok</td>
                            <td class="py-3"><span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">Pendapatan</span></td>
                            <td class="py-3">Dinamis</td>
                            <td class="py-3"><span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">Aktif</span></td>
                            <td class="py-3 text-right"><a href="#" class="text-emerald-600">Edit</a></td>
                        </tr>
                        <tr>
                            <td class="py-3 font-medium text-slate-800">LATE</td>
                            <td class="py-3">Keterlambatan</td>
                            <td class="py-3"><span class="rounded-full bg-rose-100 px-3 py-1 text-xs font-semibold text-rose-700">Potongan</span></td>
                            <td class="py-3">Rp 2.000/menit</td>
                            <td class="py-3"><span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">Aktif</span></td>
                            <td class="py-3 text-right"><a href="#" class="text-emerald-600">Edit</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
