<?= $this->extend('layouts/frontend') ?>

<?= $this->section('content') ?>

<!-- Header Banner -->
<section class="bg-gradient-to-r from-[#4c0519] via-[#660920] to-[#800000] text-white py-10 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <nav class="flex items-center gap-2 text-xs text-rose-200/80 mb-2 font-medium">
                    <a href="<?= base_url() ?>" class="hover:text-white transition-colors">Beranda</a>
                    <i class="fa-solid fa-chevron-right text-[9px] text-rose-400"></i>
                    <a href="<?= base_url('search?type=Karya') ?>" class="hover:text-white transition-colors">Data Karya</a>
                    <i class="fa-solid fa-chevron-right text-[9px] text-rose-400"></i>
                    <span class="text-white font-bold truncate max-w-xs"><?= esc($karya['jenis_karya']) ?></span>
                </nav>
                <h1 class="text-2xl sm:text-3xl font-extrabold font-heading text-white">
                    Detail Data Karya &amp; Publikasi Ilmiah
                </h1>
            </div>
            
            <a href="<?= base_url('search?type=Karya') ?>" 
               class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold text-white bg-white/10 hover:bg-white/20 transition-all border border-white/20 self-start md:self-auto">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Kembali ke Repositori</span>
            </a>
        </div>
    </div>
</section>

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    
    <!-- ========================================================
         MAIN KARYA CARD (Directly matching PDF Page 5 Bottom Card)
         ======================================================== -->
    <div class="bg-white rounded-3xl shadow-xl border border-rose-100 overflow-hidden mb-12 -mt-16 relative z-20">
        
        <!-- Header Strip -->
        <div class="bg-gradient-to-r from-maroon-900 via-maroon-800 to-rose-900 px-6 py-4 text-white flex items-center justify-between">
            <h2 class="text-base sm:text-lg font-bold font-heading truncate">
                <?= esc($karya['jenis_karya']) ?>: <?= esc($karya['level_karya']) ?>
            </h2>
            <span class="text-xs px-3 py-1 rounded-full bg-white/15 backdrop-blur-sm text-rose-100 border border-white/20 font-bold whitespace-nowrap">
                <?= esc($karya['nama_kategori'] ?? $karya['level_karya']) ?> &bull; Tahun <?= esc($karya['tahun_terbit']) ?>
            </span>
        </div>

        <div class="p-6 sm:p-8 grid grid-cols-1 md:grid-cols-12 gap-8 items-start">
            
            <!-- Left Column: Icon/Emblem & 'Link Terbitan' Button (PDF Page 5) -->
            <div class="md:col-span-4 lg:col-span-3 flex flex-col items-center text-center">
                
                <div class="w-36 h-36 rounded-2xl bg-gradient-to-br from-rose-50 to-rose-100/60 p-4 border-2 border-rose-200/80 shadow-md flex items-center justify-center mb-6 group hover:border-maroon-700 transition-colors">
                    <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-maroon-900 to-rose-800 text-white flex items-center justify-center text-3xl shadow-lg group-hover:scale-110 transition-transform">
                        <i class="fa-solid <?= esc($karya['icon_karya'] ?? 'fa-book-journal-whills') ?>"></i>
                    </div>
                </div>

                <!-- 'Link Terbitan' Button (Matching PDF Page 5 Action) -->
                <?php if (!empty($karya['link_karya'])): ?>
                    <a href="<?= esc($karya['link_karya']) ?>" 
                       target="_blank" 
                       rel="noopener noreferrer"
                       class="btn-shimmer w-full max-w-[200px] py-3 rounded-xl bg-gradient-to-r from-emerald-700 to-emerald-800 hover:from-emerald-800 hover:to-emerald-900 text-white font-extrabold text-xs sm:text-sm shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                        <i class="fa-solid fa-arrow-up-right-from-square"></i>
                        <span>Link Terbitan</span>
                    </a>
                <?php else: ?>
                    <button disabled class="w-full max-w-[200px] py-3 rounded-xl bg-gray-200 text-gray-500 font-bold text-xs cursor-not-allowed">
                        Link Belum Tersedia
                    </button>
                <?php endif; ?>

                <!-- Author Profile Link -->
                <?php if (!empty($karya['id_anggota'])): ?>
                    <a href="<?= base_url('anggota/' . $karya['id_anggota']) ?>" 
                       class="mt-4 text-xs font-bold text-maroon-800 hover:text-maroon-950 transition-colors flex items-center gap-1.5">
                        <i class="fa-solid fa-user-circle"></i>
                        <span>Profil Penulis Pertama</span>
                    </a>
                <?php endif; ?>

            </div>

            <!-- Right Column: Exact Attributes (Matching PDF Page 5) -->
            <div class="md:col-span-8 lg:col-span-9 space-y-4">
                
                <div class="border-b border-gray-100 pb-3">
                    <span class="text-xs font-bold text-maroon-800 uppercase tracking-wider">Informasi Publikasi</span>
                    <h3 class="text-xl sm:text-2xl font-extrabold text-gray-900 font-heading leading-snug mt-1">
                        <?= esc($karya['judul_karya']) ?>
                    </h3>
                </div>

                <!-- Attributes List (Direct match to PDF Page 5) -->
                <div class="space-y-3.5 text-sm">
                    
                    <div class="flex items-start">
                        <span class="w-40 text-xs font-bold text-gray-500 uppercase tracking-wide flex-shrink-0">Nama Lengkap</span>
                        <span class="text-gray-900 font-bold leading-relaxed">: <?= esc($karya['judul_karya']) ?></span>
                    </div>

                    <div class="flex items-start">
                        <span class="w-40 text-xs font-bold text-gray-500 uppercase tracking-wide flex-shrink-0">Penulis</span>
                        <div class="text-gray-900 font-semibold leading-relaxed">
                            : <?= esc($karya['penulis_pertama']) ?><?php if (!empty($karya['penulis_semua'])): ?>, <?= esc($karya['penulis_semua']) ?><?php endif; ?>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <span class="w-40 text-xs font-bold text-gray-500 uppercase tracking-wide flex-shrink-0">Jenis Karya</span>
                        <span class="text-gray-900 font-semibold">: <?= esc($karya['jenis_karya']) ?></span>
                    </div>

                    <div class="flex items-start">
                        <span class="w-40 text-xs font-bold text-gray-500 uppercase tracking-wide flex-shrink-0">Level Karya</span>
                        <span class="text-gray-900 font-semibold">: <?= esc($karya['level_karya']) ?></span>
                    </div>

                    <div class="flex items-start">
                        <span class="w-40 text-xs font-bold text-gray-500 uppercase tracking-wide flex-shrink-0">Kategori/ Sub Level</span>
                        <span class="text-maroon-800 font-bold">: <?= esc($karya['nama_kategori'] ?? '-') ?></span>
                    </div>

                    <div class="flex items-start">
                        <span class="w-40 text-xs font-bold text-gray-500 uppercase tracking-wide flex-shrink-0">Nama Terbitan</span>
                        <span class="text-gray-900 font-semibold italic">: <?= esc($karya['nama_terbitan'] ?: '-') ?></span>
                    </div>

                    <div class="flex items-start">
                        <span class="w-40 text-xs font-bold text-gray-500 uppercase tracking-wide flex-shrink-0">Penerbit</span>
                        <span class="text-gray-900 font-semibold">: <?= esc($karya['penerbit'] ?: '-') ?></span>
                    </div>

                    <?php if (!empty($karya['volume']) || !empty($karya['nomor'])): ?>
                        <div class="flex items-start">
                            <span class="w-40 text-xs font-bold text-gray-500 uppercase tracking-wide flex-shrink-0">Volume / Nomor</span>
                            <span class="text-gray-900 font-semibold">: Vol. <?= esc($karya['volume'] ?: '-') ?>, No. <?= esc($karya['nomor'] ?: '-') ?></span>
                        </div>
                    <?php endif; ?>

                    <div class="flex items-start">
                        <span class="w-40 text-xs font-bold text-gray-500 uppercase tracking-wide flex-shrink-0">Tahun</span>
                        <span class="text-gray-900 font-bold">: <?= esc($karya['tahun_terbit']) ?></span>
                    </div>

                </div>

                <!-- Citation Box -->
                <div class="mt-6 p-4 rounded-2xl bg-rose-50/70 border border-rose-200/80">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-bold text-maroon-900 uppercase tracking-wider flex items-center gap-1.5">
                            <i class="fa-solid fa-quote-left text-maroon-700"></i> Format Sitasi (APA Style)
                        </span>
                        <button type="button" 
                                onclick="navigator.clipboard.writeText(document.getElementById('citationText').innerText); alert('Sitasi berhasil disalin ke clipboard!');"
                                class="text-xs text-maroon-800 hover:text-maroon-950 font-bold flex items-center gap-1">
                            <i class="fa-regular fa-copy"></i>
                            <span>Salin</span>
                        </button>
                    </div>
                    <p id="citationText" class="text-xs text-gray-700 leading-relaxed font-mono bg-white p-3 rounded-xl border border-rose-100">
                        <?= esc($karya['penulis_pertama']) ?>. (<?= esc($karya['tahun_terbit']) ?>). <?= esc($karya['judul_karya']) ?>. <em><?= esc($karya['nama_terbitan']) ?></em><?= !empty($karya['volume']) ? ', ' . esc($karya['volume']) : '' ?><?= !empty($karya['nomor']) ? '(' . esc($karya['nomor']) . ')' : '' ?>. <?= esc($karya['penerbit']) ?>.
                    </p>
                </div>

            </div>

        </div>

    </div>

    <!-- Related Publications from same author -->
    <?php if (!empty($otherKarya) && count($otherKarya) > 1): ?>
        <div class="bg-white rounded-3xl shadow-xl border border-rose-100 overflow-hidden p-6 sm:p-8">
            <h3 class="text-lg font-bold font-heading text-gray-900 mb-6 flex items-center gap-2">
                <i class="fa-solid fa-layer-group text-maroon-800"></i>
                <span>Publikasi Lainnya oleh Penulis Ini</span>
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <?php foreach ($otherKarya as $ok): if ($ok['id_karya'] == $karya['id_karya']) continue; ?>
                    <a href="<?= base_url('karya/' . $ok['id_karya']) ?>" class="p-4 rounded-xl border border-rose-100 hover:border-maroon-700 hover:bg-rose-50/40 transition-all flex items-start justify-between gap-3 group">
                        <div>
                            <span class="text-[11px] font-bold px-2 py-0.5 rounded-full bg-rose-100 text-maroon-800">
                                <?= esc($ok['jenis_karya']) ?> &bull; <?= esc($ok['tahun_terbit']) ?>
                            </span>
                            <h4 class="text-sm font-bold text-gray-900 group-hover:text-maroon-800 transition-colors mt-2 line-clamp-2">
                                <?= esc($ok['judul_karya']) ?>
                            </h4>
                        </div>
                        <i class="fa-solid fa-chevron-right text-xs text-gray-400 group-hover:text-maroon-800 group-hover:translate-x-1 transition-all mt-1"></i>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

</section>

<?= $this->endSection() ?>
