<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="space-y-6">

    <!-- Top Action & Filter Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-black text-gray-900 font-heading">Manajemen Data Karya &amp; Publikasi</h1>
            <p class="text-xs text-gray-500">Repositori karya ilmiah, jurnal bereputasi, prosiding, buku, dan produk HKI</p>
        </div>

        <a href="<?= base_url('admin/karya/create') ?>" 
           class="btn-shimmer inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-maroon-900 hover:bg-maroon-950 shadow-md transition-all self-start sm:self-auto">
            <i class="fa-solid fa-plus"></i>
            <span>Tambah Karya Baru</span>
        </a>
    </div>

    <!-- Filter Card -->
    <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100">
        <form action="<?= base_url('admin/karya') ?>" method="GET" class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-center">
            
            <!-- Search Keyword -->
            <div class="sm:col-span-4 relative">
                <input type="text" 
                       name="q" 
                       value="<?= esc($keyword) ?>" 
                       placeholder="Cari judul paper, penulis, jurnal..."
                       class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-gray-200 text-xs focus:border-maroon-800 focus:outline-none">
                <span class="absolute left-3 top-3 text-gray-400 text-xs">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </span>
            </div>

            <!-- Filter Jenis Karya -->
            <div class="sm:col-span-3">
                <select name="jenis" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-xs focus:border-maroon-800 focus:outline-none">
                    <option value="">Semua Jenis Karya</option>
                    <option value="Jurnal" <?= ($jenis === 'Jurnal') ? 'selected' : '' ?>>Jurnal Ilmiah</option>
                    <option value="Prosiding" <?= ($jenis === 'Prosiding') ? 'selected' : '' ?>>Prosiding Konferensi</option>
                    <option value="HKI" <?= ($jenis === 'HKI') ? 'selected' : '' ?>>Hak Cipta / Paten HKI</option>
                    <option value="Buku" <?= ($jenis === 'Buku') ? 'selected' : '' ?>>Buku &amp; Monograf</option>
                    <option value="Sistem dan Aplikasi" <?= ($jenis === 'Sistem dan Aplikasi') ? 'selected' : '' ?>>Sistem &amp; Aplikasi</option>
                </select>
            </div>

            <!-- Filter Level Karya -->
            <div class="sm:col-span-2">
                <select name="level" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-xs focus:border-maroon-800 focus:outline-none">
                    <option value="">Semua Level</option>
                    <option value="Internasional" <?= ($level === 'Internasional') ? 'selected' : '' ?>>Internasional</option>
                    <option value="Nasional" <?= ($level === 'Nasional') ? 'selected' : '' ?>>Nasional</option>
                    <option value="Lokal" <?= ($level === 'Lokal') ? 'selected' : '' ?>>Lokal</option>
                </select>
            </div>

            <!-- Filter Tahun -->
            <div class="sm:col-span-1">
                <input type="text" name="tahun" value="<?= esc($tahun) ?>" placeholder="Tahun" class="w-full px-2 py-2.5 rounded-xl border border-gray-200 text-xs text-center">
            </div>

            <!-- Submit & Reset -->
            <div class="sm:col-span-2 flex items-center gap-2">
                <button type="submit" class="flex-1 py-2.5 rounded-xl bg-gray-900 hover:bg-gray-800 text-white font-bold text-xs transition-colors">
                    Filter
                </button>
                <a href="<?= base_url('admin/karya') ?>" class="p-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs" title="Reset Filter">
                    <i class="fa-solid fa-rotate-left"></i>
                </a>
            </div>

        </form>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100 text-gray-500 uppercase tracking-wider font-bold">
                        <th class="py-3.5 px-4 w-12 text-center">No</th>
                        <th class="py-3.5 px-4">Judul Karya / Publikasi</th>
                        <th class="py-3.5 px-4">Jenis &amp; Kategori</th>
                        <th class="py-3.5 px-4">Level</th>
                        <th class="py-3.5 px-4">Penulis</th>
                        <th class="py-3.5 px-4">Tahun</th>
                        <th class="py-3.5 px-4 text-center">Link</th>
                        <th class="py-3.5 px-4 text-right w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700">
                    <?php if (!empty($karyaList)): ?>
                        <?php $no = 1; foreach ($karyaList as $item): ?>
                            <tr class="hover:bg-rose-50/30 transition-colors">
                                <td class="py-3.5 px-4 text-center font-bold text-gray-400">
                                    <?= $no++ ?>
                                </td>
                                <td class="py-3.5 px-4 font-semibold text-gray-900 max-w-sm">
                                    <a href="<?= base_url('admin/karya/detail/' . $item['id_karya']) ?>" class="hover:text-maroon-800 font-bold block leading-relaxed line-clamp-2">
                                        <?= esc($item['judul_karya']) ?>
                                    </a>
                                    <?php if (!empty($item['nama_terbitan'])): ?>
                                        <p class="text-[11px] text-gray-500 italic mt-0.5 truncate"><?= esc($item['nama_terbitan']) ?></p>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3.5 px-4">
                                    <span class="font-bold text-maroon-800 block"><?= esc($item['jenis_karya']) ?></span>
                                    <span class="text-[10px] text-gray-500"><?= esc($item['nama_kategori'] ?? '-') ?></span>
                                </td>
                                <td class="py-3.5 px-4">
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold <?= ($item['level_karya'] === 'Internasional') ? 'bg-indigo-100 text-indigo-900' : 'bg-emerald-100 text-emerald-900' ?>">
                                        <?= esc($item['level_karya']) ?>
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 max-w-xs truncate">
                                    <span class="font-bold text-gray-800 block truncate"><?= esc($item['penulis_pertama']) ?></span>
                                    <?php if (!empty($item['penulis_semua'])): ?>
                                        <span class="text-[10px] text-gray-400 truncate block"><?= esc($item['penulis_semua']) ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3.5 px-4 font-mono font-bold text-gray-600">
                                    <?= esc($item['tahun_terbit']) ?>
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <?php if (!empty($item['link_karya'])): ?>
                                        <a href="<?= esc($item['link_karya']) ?>" target="_blank" class="p-1 rounded text-emerald-600 hover:text-emerald-800" title="Kunjungi Link">
                                            <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                        </a>
                                    <?php else: ?>
                                        <span class="text-gray-300">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3.5 px-4 text-right">
                                    <div class="inline-flex items-center gap-1.5">
                                        <a href="<?= base_url('admin/karya/detail/' . $item['id_karya']) ?>" 
                                           class="p-1.5 rounded-lg bg-gray-100 hover:bg-maroon-900 hover:text-white text-gray-600 transition-colors" title="Detail">
                                            <i class="fa-solid fa-eye text-xs"></i>
                                        </a>
                                        <a href="<?= base_url('admin/karya/edit/' . $item['id_karya']) ?>" 
                                           class="p-1.5 rounded-lg bg-rose-50 hover:bg-amber-500 hover:text-white text-amber-700 transition-colors" title="Edit">
                                            <i class="fa-solid fa-pen-to-square text-xs"></i>
                                        </a>
                                        <a href="<?= base_url('admin/karya/delete/' . $item['id_karya']) ?>" 
                                           onclick="return confirm('Apakah Anda yakin ingin menghapus karya ilmiah ini?')"
                                           class="p-1.5 rounded-lg bg-red-50 hover:bg-red-600 hover:text-white text-red-600 transition-colors" title="Hapus">
                                            <i class="fa-solid fa-trash-can text-xs"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="py-12 text-center text-gray-400">
                                <i class="fa-solid fa-book-open text-2xl mb-2"></i>
                                <p>Tidak ada data karya ilmiah yang ditemukan.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
