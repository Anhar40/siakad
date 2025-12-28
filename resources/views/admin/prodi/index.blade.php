<x-app-layout>
    <x-slot name="header">
        Data Program Studi
    </x-slot>

    <div class="mb-6 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
        <div>
            <p class="text-sm text-siakad-secondary dark:text-gray-400 hidden md:block">
                Kelola data program studi berdasarkan fakultas
            </p>
        </div>

        <button
            onclick="document.getElementById('createModal').classList.remove('hidden')"
            class="btn-primary-saas w-full md:w-auto px-4 py-2.5 rounded-lg text-sm font-medium flex items-center justify-center gap-2"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Tambah Prodi
        </button>
    </div>

    @foreach($fakultas as $index => $f)
    <div class="card-saas overflow-hidden mb-4 dark:bg-gray-800" x-data="{ open: false }">
        <button @click="open = !open" type="button" class="w-full px-6 py-4 bg-siakad-primary/5 border-b border-siakad-light dark:bg-gray-700/50 dark:border-gray-700 flex items-center justify-between hover:bg-siakad-primary/10 dark:hover:bg-gray-700 transition cursor-pointer text-left">
            <div class="flex items-center gap-3">
                <div>
                    <h3 class="font-semibold text-siakad-dark dark:text-white">{{ $f->nama }}</h3>
                    <p class="text-xs text-siakad-secondary dark:text-gray-400">{{ $f->prodi->count() }} Program Studi</p>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <span class="inline-flex items-center px-3 py-1 text-xs font-medium bg-siakad-primary/10 text-siakad-primary dark:bg-indigo-900/50 dark:text-indigo-400 rounded-full">
                    {{ $f->prodi->sum(fn($p) => $p->mahasiswa_count ?? 0) }} Mahasiswa
                </span>
                <svg class="w-5 h-5 text-siakad-secondary dark:text-gray-400 transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </div>
        </button>

        <div x-show="open" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="overflow-x-auto">
            
            <table class="hidden md:table w-full table-saas">
                <thead>
                    <tr class="bg-siakad-light/30 dark:bg-gray-900">
                        <th class="text-left py-3 px-5 text-xs font-semibold text-siakad-secondary dark:text-gray-400 uppercase tracking-wider w-16">#</th>
                        <th class="text-left py-3 px-5 text-xs font-semibold text-siakad-secondary dark:text-gray-400 uppercase tracking-wider">Nama Program Studi</th>
                        <th class="text-left py-3 px-5 text-xs font-semibold text-siakad-secondary dark:text-gray-400 uppercase tracking-wider">Ketua Prodi</th>
                        <th class="text-left py-3 px-5 text-xs font-semibold text-siakad-secondary dark:text-gray-400 uppercase tracking-wider w-32">Mahasiswa</th>
                        <th class="text-left py-3 px-5 text-xs font-semibold text-siakad-secondary dark:text-gray-400 uppercase tracking-wider w-24">Dosen</th>
                        <th class="text-right py-3 px-5 text-xs font-semibold text-siakad-secondary dark:text-gray-400 uppercase tracking-wider w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($f->prodi as $idx => $p)
                    <tr class="border-b border-siakad-light/50 dark:border-gray-700/50 hover:bg-siakad-light/10 dark:hover:bg-gray-700/30 transition">
                        <td class="py-4 px-5 text-sm text-siakad-secondary dark:text-gray-400">{{ $idx + 1 }}</td>
                        <td class="py-4 px-5">
                            <span class="text-sm font-medium text-siakad-dark dark:text-white">{{ $p->nama }}</span>
                        </td>
                        <td class="py-4 px-5">
                            <span class="text-sm text-siakad-secondary dark:text-gray-400">{{ $p->ketua_prodi ?? '-' }}</span>
                        </td>
                        <td class="py-4 px-5">
                            <span class="inline-flex px-2.5 py-1 text-xs font-medium bg-siakad-primary/10 text-siakad-primary dark:bg-blue-900/50 dark:text-blue-400 rounded-full">{{ $p->mahasiswa_count ?? 0 }}</span>
                        </td>
                        <td class="py-4 px-5">
                            <span class="inline-flex px-2.5 py-1 text-xs font-medium bg-siakad-secondary/10 text-siakad-secondary dark:bg-gray-700 dark:text-gray-300 rounded-full">{{ $p->dosen_count ?? 0 }}</span>
                        </td>
                        <td class="py-4 px-5 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button onclick="editProdi({{ $p->id }}, '{{ $p->nama }}', {{ $f->id }}, '{{ $p->ketua_prodi }}')" class="p-2 text-siakad-secondary dark:text-gray-400 hover:text-siakad-primary dark:hover:text-blue-400 hover:bg-siakad-primary/10 dark:hover:bg-gray-700 rounded-lg transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                                <form action="{{ route('admin.prodi.destroy', $p) }}" method="POST" onsubmit="return confirm('Hapus prodi ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-siakad-secondary dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-siakad-secondary dark:text-gray-400 text-sm">Belum ada program studi</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="md:hidden space-y-4 px-4 pb-4">
                @foreach($f->prodi as $p)
                <div class="card-saas p-4 dark:bg-gray-800 border border-siakad-light dark:border-gray-700">
                    <div class="flex items-start justify-between mb-1">
                        <h4 class="font-bold text-siakad-dark dark:text-white">{{ $p->nama }}</h4>
                    </div>
                    <p class="text-xs text-siakad-secondary dark:text-gray-400 mb-3 italic">Kaprodi: {{ $p->ketua_prodi ?? '-' }}</p>

                    <div class="grid grid-cols-2 gap-3 mb-4">
                        <div class="bg-gray-50 dark:bg-gray-700/50 p-2 rounded-lg text-center">
                            <span class="block text-[10px] text-siakad-secondary dark:text-gray-400 uppercase tracking-wider">Mahasiswa</span>
                            <span class="font-bold text-siakad-dark dark:text-white">{{ $p->mahasiswa_count ?? 0 }}</span>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700/50 p-2 rounded-lg text-center">
                            <span class="block text-[10px] text-siakad-secondary dark:text-gray-400 uppercase tracking-wider">Dosen</span>
                            <span class="font-bold text-siakad-dark dark:text-white">{{ $p->dosen_count ?? 0 }}</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 pt-3 border-t border-siakad-light dark:border-gray-700">
                        <button onclick="editProdi({{ $p->id }}, '{{ $p->nama }}', {{ $f->id }}, '{{ $p->ketua_prodi }}')" class="flex-1 py-2 text-sm font-medium text-siakad-secondary bg-siakad-light/50 dark:bg-gray-700 dark:text-gray-300 rounded-lg transition text-center">
                            Edit
                        </button>
                        <form action="{{ route('admin.prodi.destroy', $p) }}" method="POST" class="flex-1">
                            @csrf @method('DELETE')
                            <button type="submit" class="w-full py-2 text-sm font-medium text-red-600 bg-red-50 dark:bg-red-900/20 rounded-lg">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endforeach

    <div id="createModal" class="hidden fixed inset-0 bg-black/40 z-50 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl w-full max-w-md">
            <div class="px-6 py-4 border-b border-siakad-light dark:border-gray-700">
                <h3 class="text-lg font-semibold text-siakad-dark dark:text-white">Tambah Program Studi</h3>
            </div>
            <form action="{{ route('admin.prodi.store') }}" method="POST">
                @csrf
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-siakad-dark dark:text-gray-300 mb-2">Fakultas</label>
                        <select name="fakultas_id" class="input-saas w-full px-4 py-2.5 text-sm dark:bg-gray-900 dark:text-white" required>
                            <option value="">Pilih Fakultas</option>
                            @foreach($fakultas as $f)
                                <option value="{{ $f->id }}">{{ $f->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-siakad-dark dark:text-gray-300 mb-2">Nama Prodi</label>
                        <input type="text" name="nama" class="input-saas w-full px-4 py-2.5 text-sm dark:bg-gray-900 dark:text-white" placeholder="Nama prodi" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-siakad-dark dark:text-gray-300 mb-2">Ketua Prodi</label>
                        <select name="ketua_prodi" class="input-saas w-full px-4 py-2.5 text-sm dark:bg-gray-900 dark:text-white">
                            <option value="">-- Pilih Dosen --</option>
                            @foreach($dosens as $d)
                                <option value="{{ $d->user->name }}">{{ $d->user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="px-6 py-4 border-t border-siakad-light dark:border-gray-700 flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('createModal').classList.add('hidden')" class="btn-ghost-saas px-4 py-2 text-sm">Batal</button>
                    <button type="submit" class="btn-primary-saas px-4 py-2 text-sm">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <div id="editModal" class="hidden fixed inset-0 bg-black/40 z-50 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl w-full max-w-md">
            <div class="px-6 py-4 border-b border-siakad-light dark:border-gray-700">
                <h3 class="text-lg font-semibold text-siakad-dark dark:text-white">Edit Program Studi</h3>
            </div>
            <form id="editForm" method="POST">
                @csrf @method('PUT')
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-siakad-dark dark:text-gray-300 mb-2">Fakultas</label>
                        <select name="fakultas_id" id="editFakultas" class="input-saas w-full px-4 py-2.5 text-sm dark:bg-gray-900 dark:text-white" required>
                            @foreach($fakultas as $f)
                                <option value="{{ $f->id }}">{{ $f->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-siakad-dark dark:text-gray-300 mb-2">Nama Prodi</label>
                        <input type="text" name="nama" id="editNama" class="input-saas w-full px-4 py-2.5 text-sm dark:bg-gray-900 dark:text-white" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-siakad-dark dark:text-gray-300 mb-2">Ketua Prodi</label>
                        <select name="ketua_prodi" id="editKetua" class="input-saas w-full px-4 py-2.5 text-sm dark:bg-gray-900 dark:text-white">
                            <option value="">-- Pilih Dosen --</option>
                            @foreach($dosens as $d)
                                <option value="{{ $d->user->name }}">{{ $d->user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="px-6 py-4 border-t border-siakad-light dark:border-gray-700 flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('editModal').classList.add('hidden')" class="btn-ghost-saas px-4 py-2 text-sm">Batal</button>
                    <button type="submit" class="btn-primary-saas px-4 py-2 text-sm">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function editProdi(id, nama, fakultasId, ketua) {
            document.getElementById('editForm').action = `/admin/prodi/${id}`;
            document.getElementById('editNama').value = nama;
            document.getElementById('editFakultas').value = fakultasId;
            // Value dropdown akan otomatis terpilih jika string nama cocok
            document.getElementById('editKetua').value = ketua || ''; 
            document.getElementById('editModal').classList.remove('hidden');
        }
    </script>
</x-app-layout>