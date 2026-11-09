<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="space-y-6 max-w-4xl mx-auto">
    
    <!-- Top Action Bar -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-black text-gray-900 font-heading">Detail Karya &amp; Publikasi</h1>
            <p class="text-xs text-gray-500">Metadata repositori karya ilmiah anggota Predatech</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="<?= base_url('admin/karya/edit/' . $karya['id_karya']) ?>" class="px-3.5 py-2 rounded-xl text-xs font-bold text-amber-700 bg-amber-50 hover:bg-amber-100 transition-colors border border-amber-200">
                <i class="fa-solid fa-pen-to-square mr-1"></i> Edit Karya
            </a>
            <a href="<?= base_url('karya/' . $karya['id_karya']) ?>" target="_blank" class="px-3.5 py-2 rounded-xl text-xs font-bold text-maroon-900 bg-rose-50 hover:bg-rose-100 transition-colors border border-rose-200">
                <i class="fa-solid fa-arrow-up-right-from-square mr-1"></i> Lihat Publik
            </a>
            <a href="<?= base_url('admin/karya') ?>" class="px-3.5 py-2 rounded-xl text-xs font-bold text-gray-600 bg-white hover:bg-gray-50 transition-colors border border-gray-200">
                <i class="fa-solid fa-arrow-left mr-1"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Main Detail Card -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 sm:p-8 space-y-6">
        
        <!-- Header Strip -->
        <div class="flex flex-wrap items-center gap-2">
            <span class="px-3 py-1 rounded-full text-xs font-bold bg-rose-100 text-maroon-900 border border-rose-200">
                <?= esc($karya['jenis_karya']) ?>
            </span>
            <span class="px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-900 border border-amber-200">
                <?= esc($karya['level_karya']) ?>
            </span>
            <span class="px-3 py-1 rounded-full text-xs font-bold bg-purple-100 text-purple-900 border border-purple-200">
                <?= esc($karya['nama_kategori'] ?? 'Kategori') ?>
            </span>
            <span class="px-3 py-1 rounded-full text-xs font-mono font-bold bg-gray-100 text-gray-700">
                Tahun <?= esc($karya['tahun_terbit']) ?>
            </span>
        </div>

        <h2 class="text-xl sm:text-2xl font-black text-gray-900 font-heading leading-relaxed">
            <?= esc($karya['judul_karya']) ?>
        </h2>

        <!-- Metadata Table -->
        <div class="divide-y divide-gray-100 text-xs pt-4 border-t border-gray-100">
            <div class="py-3 flex items-start">
                <span class="w-40 font-bold text-gray-500 uppercase tracking-wide flex-shrink-0">Penulis Utama</span>
                <span class="font-bold text-gray-900">: <?= esc($karya['penulis_pertama']) ?></span>
            </div>

            <?php if (!empty($karya['penulis_semua'])): ?>
                <div class="py-3 flex items-start">
                    <span class="w-40 font-bold text-gray-500 uppercase tracking-wide flex-shrink-0">Penulis Pendamping</span>
                    <span class="font-medium text-gray-800">: <?= esc($karya['penulis_semua']) ?></span>
                </div>
            <?php endif; ?>

            <div class="py-3 flex items-start">
                <span class="w-40 font-bold text-gray-500 uppercase tracking-wide flex-shrink-0">Nama Terbitan</span>
                <span class="font-semibold text-gray-800 italic">: <?= esc($karya['nama_terbitan'] ?: '-') ?></span>
            </div>

            <div class="py-3 flex items-start">
                <span class="w-40 font-bold text-gray-500 uppercase tracking-wide flex-shrink-0">Penerbit</span>
                <span class="font-semibold text-gray-800">: <?= esc($karya['penerbit'] ?: '-') ?></span>
            </div>

            <div class="py-3 flex items-start">
                <span class="w-40 font-bold text-gray-500 uppercase tracking-wide flex-shrink-0">Volume &amp; Nomor</span>
                <span class="font-mono text-gray-800">: Vol. <?= esc($karya['volume'] ?: '-') ?>, No. <?= esc($karya['nomor'] ?: '-') ?></span>
            </div>

            <div class="py-3 flex items-start">
                <span class="w-40 font-bold text-gray-500 uppercase tracking-wide flex-shrink-0">Tautan Online</span>
                <div class="text-gray-800">
                    : <?php if (!empty($karya['link_karya'])): ?>
                        <a href="<?= esc($karya['link_karya']) ?>" target="_blank" class="text-maroon-800 hover:underline font-bold inline-flex items-center gap-1">
                            <span><?= esc($karya['link_karya']) ?></span>
                            <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                        </a>
                    <?php else: ?>
                        <span class="text-gray-400">Belum ada link yang dilampirkan</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>

</div>

<?= $this->endSection() ?>
