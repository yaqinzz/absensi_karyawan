<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold text-slate-900">Pengaturan Jam Kerja</h2>
            <p class="text-sm text-slate-500">Atur jam kerja, toleransi, dan aturan potongan.</p>
        </div>
    </x-slot>

    <div class="max-w-3xl">
        <form class="space-y-6 rounded-2xl border border-white/70 bg-white/90 p-6 shadow-sm">
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="text-xs text-slate-500">Jam Mulai</label>
                    <input type="time" class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm" value="08:00" />
                </div>
                <div>
                    <label class="text-xs text-slate-500">Jam Selesai</label>
                    <input type="time" class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm" value="17:00" />
                </div>
            </div>
            <div class="grid gap-4 md:grid-cols-3">
                <div>
                    <label class="text-xs text-slate-500">Toleransi Terlambat (menit)</label>
                    <input class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm" value="10" />
                </div>
                <div>
                    <label class="text-xs text-slate-500">Potongan per Menit</label>
                    <input class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm" value="2000" />
                </div>
                <div>
                    <label class="text-xs text-slate-500">Potongan Alpha per Hari</label>
                    <input class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm" value="150000" />
                </div>
            </div>
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="text-xs text-slate-500">Persentase BPJS</label>
                    <input class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm" value="1" />
                </div>
                <div>
                    <label class="text-xs text-slate-500">Persentase Pajak</label>
                    <input class="mt-1 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm" value="5" />
                </div>
            </div>
            <div class="flex justify-end gap-2">
                <button class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600">Batal</button>
                <button class="rounded-xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white">Simpan Pengaturan</button>
            </div>
        </form>
    </div>
</x-app-layout>
