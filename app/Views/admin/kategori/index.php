<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="space-y-6 max-w-5xl mx-auto" x-data="{ editModalOpen: false, editId: null, editKategori: '', editIcon: '' }">
    
    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-black text-gray-900 font-heading">Kategori &amp; Pengindeksan Karya</h1>
            <p class="text-xs text-gray-500">Kelola master data pengindeksan jurnal dan level publikasi</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-start">
        
        <!-- Add New Category Form (Left / 4 Cols) -->
        <div class="md:col-span-5 bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-sm font-bold text-gray-900 font-heading mb-4 flex items-center gap-2">
                <i class="fa-solid fa-plus-circle text-maroon-800"></i>
                <span>Tambah Kategori Baru</span>
            </h3>

            <form action="<?= base_url('admin/kategori/store') ?>" method="POST" class="space-y-4 text-xs">
                <?= csrf_field() ?>

                <div>
                    <label class="block font-bold uppercase text-gray-700 mb-1">
                        Nama Kategori <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="kategori" required placeholder="Contoh: Sinta 1, Scopus Q1, dll."
                           class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-maroon-800 focus:outline-none">
                </div>

                <div>
                    <label class="block font-bold uppercase text-gray-700 mb-1">
                        FontAwesome Icon Class
                    </label>
                    <input type="text" name="icon_karya" value="fa-award" placeholder="fa-award, fa-book, fa-globe..."
                           class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-maroon-800 focus:outline-none font-mono">
                    <span class="text-[10px] text-gray-400">Nama class ikon FontAwesome 6</span>
                </div>

                <button type="submit" 
                        class="btn-shimmer w-full py-2.5 rounded-xl bg-maroon-900 hover:bg-maroon-950 text-white font-bold text-xs shadow-md transition-all flex items-center justify-center gap-1.5">
                    <i class="fa-solid fa-plus text-[10px]"></i>
                    <span>Simpan Kategori</span>
                </button>
            </form>
        </div>

        <!-- Category List Table (Right / 7 Cols) -->
        <div class="md:col-span-7 bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-5 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-sm font-bold text-gray-900 font-heading">
                    Daftar Kategori Tersedia (<?= count($categories) ?>)
                </h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100 text-gray-500 uppercase tracking-wider font-bold">
                            <th class="py-3 px-4 w-12 text-center">ID</th>
                            <th class="py-3 px-4">Ikon</th>
                            <th class="py-3 px-4">Kategori / Indexing</th>
                            <th class="py-3 px-4 text-right w-24">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        <?php foreach ($categories as $cat): ?>
                            <tr class="hover:bg-rose-50/30 transition-colors">
                                <td class="py-3 px-4 text-center font-bold text-gray-400">
                                    <?= $cat['id_kategori'] ?>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="w-8 h-8 rounded-lg bg-rose-50 text-maroon-800 flex items-center justify-center border border-rose-200">
                                        <i class="fa-solid <?= esc($cat['icon_karya'] ?: 'fa-tag') ?>"></i>
                                    </span>
                                </td>
                                <td class="py-3 px-4 font-bold text-gray-900">
                                    <?= esc($cat['kategori']) ?>
                                </td>
                                <td class="py-3 px-4 text-right">
                                    <div class="inline-flex items-center gap-1">
                                        <button type="button" 
                                                @click="editId = <?= $cat['id_kategori'] ?>; editKategori = '<?= esc($cat['kategori']) ?>'; editIcon = '<?= esc($cat['icon_karya']) ?>'; editModalOpen = true"
                                                class="p-1 rounded bg-amber-50 text-amber-700 hover:bg-amber-600 hover:text-white" title="Edit">
                                            <i class="fa-solid fa-pen text-[10px]"></i>
                                        </button>
                                        <a href="<?= base_url('admin/kategori/delete/' . $cat['id_kategori']) ?>" 
                                           onclick="return confirm('Hapus kategori ini?')"
                                           class="p-1 rounded bg-red-50 text-red-600 hover:bg-red-600 hover:text-white" title="Hapus">
                                            <i class="fa-solid fa-trash text-[10px]"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Edit Category Modal (Alpine.js) -->
    <div x-show="editModalOpen" 
         x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm">
        <div @click.away="editModalOpen = false" class="bg-white rounded-3xl shadow-2xl border border-gray-100 max-w-md w-full p-6 text-xs">
            <h3 class="text-base font-bold text-gray-900 font-heading mb-4">Edit Kategori</h3>
            
            <form :action="'<?= base_url('admin/kategori/update') ?>/' + editId" method="POST" class="space-y-4">
                <?= csrf_field() ?>

                <div>
                    <label class="block font-bold text-gray-700 mb-1">Nama Kategori</label>
                    <input type="text" name="kategori" x-model="editKategori" required class="w-full px-3 py-2 rounded-xl border border-gray-200">
                </div>

                <div>
                    <label class="block font-bold text-gray-700 mb-1">Ikon FontAwesome</label>
                    <input type="text" name="icon_karya" x-model="editIcon" class="w-full px-3 py-2 rounded-xl border border-gray-200">
                </div>

                <div class="flex justify-end gap-2 pt-3 border-t border-gray-100">
                    <button type="button" @click="editModalOpen = false" class="px-4 py-2 rounded-xl bg-gray-100 text-gray-700 font-bold">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-maroon-900 text-white font-bold">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
