<?= $this->extend('layouts/frontend') ?>

<?= $this->section('content') ?>

<!-- Header Breadcrumb Banner -->
<section class="bg-gradient-to-r from-[#4c0519] via-[#660920] to-[#800000] text-white py-10 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <nav class="flex items-center gap-2 text-xs text-rose-200/80 mb-2 font-medium">
                    <a href="<?= base_url() ?>" class="hover:text-white transition-colors">Beranda</a>
                    <i class="fa-solid fa-chevron-right text-[9px] text-rose-400"></i>
                    <a href="<?= base_url('search?type=Anggota') ?>" class="hover:text-white transition-colors">Data Anggota</a>
                    <i class="fa-solid fa-chevron-right text-[9px] text-rose-400"></i>
                    <span class="text-white font-bold truncate max-w-xs"><?= esc($anggota['nama_anggota']) ?></span>
                </nav>
                <h1 class="text-2xl sm:text-3xl font-extrabold font-heading text-white">
                    Detail Data Anggota &amp; Peneliti
                </h1>
            </div>
            
            <a href="<?= base_url('search?type=Anggota') ?>" 
               class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold text-white bg-white/10 hover:bg-white/20 transition-all border border-white/20 self-start md:self-auto">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Kembali ke Pencarian</span>
            </a>
        </div>
    </div>
</section>

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    
    <!-- ========================================================
         MAIN PROFILE CARD (Matching PDF Page 4 Top Section)
         ======================================================== -->
    <div class="bg-white rounded-3xl shadow-xl border border-rose-100 overflow-hidden mb-12 -mt-16 relative z-20">
        
        <!-- Header Strip -->
        <div class="bg-gradient-to-r from-maroon-900 via-maroon-800 to-rose-900 px-6 py-4 text-white flex items-center justify-between">
            <h2 class="text-base sm:text-lg font-bold font-heading truncate">
                <?= esc($anggota['nama_anggota']) ?>
            </h2>
            <span class="text-xs px-3 py-1 rounded-full bg-white/15 backdrop-blur-sm text-rose-100 border border-white/20 font-bold whitespace-nowrap">
                <?= esc($anggota['status_keanggotaan']) ?> &bull; Angkatan <?= esc($anggota['angkatan']) ?>
            </span>
        </div>

        <div class="p-6 sm:p-8 grid grid-cols-1 md:grid-cols-12 gap-8 items-start">
            
            <!-- Left: Avatar Column & 'Lihat Karya' Button (PDF Page 4) -->
            <div class="md:col-span-4 lg:col-span-3 flex flex-col items-center text-center">
                <div class="relative w-44 h-44 rounded-2xl overflow-hidden bg-rose-50 p-1.5 border-4 border-rose-100 shadow-xl mb-4 group">
                    <?php 
                        $photoPath = !empty($anggota['foto_anggota']) ? $anggota['foto_anggota'] : 'avatar_female.svg';
                    ?>
                    <img src="<?= base_url('uploads/anggota/' . $photoPath) ?>" 
                         alt="<?= esc($anggota['nama_anggota']) ?>" 
                         class="w-full h-full object-cover rounded-xl group-hover:scale-105 transition-transform duration-300">
                </div>

                <!-- 'Lihat Karya' Action Button (Matching PDF Page 4 Button) -->
                <a href="#section-karya" 
                   class="btn-shimmer w-full max-w-[200px] py-3 rounded-xl bg-gradient-to-r from-maroon-900 to-rose-800 hover:from-maroon-950 hover:to-rose-900 text-white font-extrabold text-xs sm:text-sm shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-book-open"></i>
                    <span>Lihat Karya (<?= count($karyaList) ?>)</span>
                </a>

                <!-- Social / Scholarly Links -->
                <div class="flex items-center justify-center gap-2.5 mt-5">
                    <?php if (!empty($anggota['link_scholar'])): ?>
                        <a href="<?= esc($anggota['link_scholar']) ?>" target="_blank" class="w-9 h-9 rounded-xl bg-rose-50 text-maroon-800 hover:bg-maroon-800 hover:text-white flex items-center justify-center transition-colors border border-rose-200" title="Google Scholar">
                            <i class="fa-brands fa-google-scholar text-sm"></i>
                        </a>
                    <?php endif; ?>
                    <?php if (!empty($anggota['link_scopus'])): ?>
                        <a href="<?= esc($anggota['link_scopus']) ?>" target="_blank" class="w-9 h-9 rounded-xl bg-rose-50 text-maroon-800 hover:bg-maroon-800 hover:text-white flex items-center justify-center transition-colors border border-rose-200" title="Scopus Profile">
                            <i class="fa-solid fa-globe text-sm"></i>
                        </a>
                    <?php endif; ?>
                    <?php if (!empty($anggota['link_linkedin'])): ?>
                        <a href="<?= esc($anggota['link_linkedin']) ?>" target="_blank" class="w-9 h-9 rounded-xl bg-rose-50 text-maroon-800 hover:bg-maroon-800 hover:text-white flex items-center justify-center transition-colors border border-rose-200" title="LinkedIn Profile">
                            <i class="fa-brands fa-linkedin-in text-sm"></i>
                        </a>
                    <?php endif; ?>
                    <?php if (!empty($anggota['link_instagram'])): ?>
                        <a href="<?= esc($anggota['link_instagram']) ?>" target="_blank" class="w-9 h-9 rounded-xl bg-rose-50 text-maroon-800 hover:bg-maroon-800 hover:text-white flex items-center justify-center transition-colors border border-rose-200" title="Instagram">
                            <i class="fa-brands fa-instagram text-sm"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Right: Exact Details Key-Value List (Matching PDF Page 4) -->
            <div class="md:col-span-8 lg:col-span-9 space-y-4">
                
                <div class="border-b border-gray-100 pb-3">
                    <span class="text-xs font-bold text-maroon-800 uppercase tracking-wider">Biodata Anggota</span>
                    <h3 class="text-xl font-bold text-gray-900 font-heading"><?= esc($anggota['nama_anggota']) ?></h3>
                </div>

                <!-- Details Grid according to PDF Page 4 layout -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-3.5 text-sm">
                    
                    <div class="flex items-start">
                        <span class="w-36 text-xs font-bold text-gray-500 uppercase tracking-wide flex-shrink-0">Nama Lengkap</span>
                        <span class="text-gray-900 font-semibold">: <?= esc($anggota['nama_anggota']) ?></span>
                    </div>

                    <div class="flex items-start">
                        <span class="w-36 text-xs font-bold text-gray-500 uppercase tracking-wide flex-shrink-0">Nomor Anggota</span>
                        <span class="text-gray-900 font-semibold font-mono">: <?= esc($anggota['nomor_anggota']) ?></span>
                    </div>

                    <div class="flex items-start">
                        <span class="w-36 text-xs font-bold text-gray-500 uppercase tracking-wide flex-shrink-0">Pekerjaan</span>
                        <span class="text-gray-900 font-semibold">: <?= esc($anggota['pekerjaan_saat_ini'] ?: '-') ?></span>
                    </div>

                    <div class="flex items-start">
                        <span class="w-36 text-xs font-bold text-gray-500 uppercase tracking-wide flex-shrink-0">Instansi</span>
                        <span class="text-gray-900 font-semibold">: <?= esc($anggota['instansi_perusahaan'] ?: '-') ?></span>
                    </div>

                    <div class="flex items-start">
                        <span class="w-36 text-xs font-bold text-gray-500 uppercase tracking-wide flex-shrink-0">Tahun Lulus</span>
                        <span class="text-gray-900 font-semibold">: <?= esc($anggota['tahun_lulus'] ?: 'Belum Lulus') ?></span>
                    </div>

                    <div class="flex items-start">
                        <span class="w-36 text-xs font-bold text-gray-500 uppercase tracking-wide flex-shrink-0">Bidang Riset</span>
                        <span class="text-maroon-800 font-bold">: <?= esc($anggota['bidang_riset'] ?: '-') ?></span>
                    </div>

                    <div class="flex items-start">
                        <span class="w-36 text-xs font-bold text-gray-500 uppercase tracking-wide flex-shrink-0">Program Studi</span>
                        <span class="text-gray-900 font-semibold">: <?= esc($anggota['program_studi']) ?></span>
                    </div>

                    <div class="flex items-start">
                        <span class="w-36 text-xs font-bold text-gray-500 uppercase tracking-wide flex-shrink-0">Pendidikan</span>
                        <span class="text-gray-900 font-semibold">: <?= esc($anggota['pendidikan_sekarang'] ?: 'S1') ?></span>
                    </div>

                    <div class="flex items-start">
                        <span class="w-36 text-xs font-bold text-gray-500 uppercase tracking-wide flex-shrink-0">Domisili</span>
                        <span class="text-gray-900 font-semibold">: <?= esc($anggota['kota_domisili']) ?></span>
                    </div>

                    <div class="flex items-start">
                        <span class="w-36 text-xs font-bold text-gray-500 uppercase tracking-wide flex-shrink-0">Grup Puzzle</span>
                        <span class="text-gray-900 font-semibold">: Divisi Puzzle <?= esc($anggota['grup_puzzle']) ?></span>
                    </div>

                    <div class="flex items-start sm:col-span-2">
                        <span class="w-36 text-xs font-bold text-gray-500 uppercase tracking-wide flex-shrink-0">Motto</span>
                        <span class="text-gray-700 italic">: &ldquo;<?= esc($anggota['motto'] ?: 'Terus berkontribusi dalam riset dan teknologi') ?>&rdquo;</span>
                    </div>

                    <?php if (!empty($anggota['profil_instansi'])): ?>
                        <div class="flex items-start sm:col-span-2">
                            <span class="w-36 text-xs font-bold text-gray-500 uppercase tracking-wide flex-shrink-0">Profil Instansi</span>
                            <span class="text-gray-700 leading-relaxed">: <?= esc($anggota['profil_instansi']) ?></span>
                        </div>
                    <?php endif; ?>

                    <div class="flex items-start sm:col-span-2 pt-2 border-t border-gray-100 text-xs text-gray-400">
                        <span class="w-36 uppercase tracking-wide flex-shrink-0">Update Terakhir</span>
                        <span>: <?= esc($anggota['tanggal_update'] ?: date('d-m-Y')) ?></span>
                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- ========================================================
         KARYA PUBLIKASI TABLE (Matching PDF Page 4 Bottom Section)
         ======================================================== -->
    <div id="section-karya" class="bg-white rounded-3xl shadow-xl border border-rose-100 overflow-hidden">
        
        <!-- Table Title Bar (PDF Page 4) -->
        <div class="bg-gradient-to-r from-maroon-900 via-maroon-800 to-rose-900 px-6 py-4 text-white flex items-center justify-between">
            <h3 class="text-base sm:text-lg font-bold font-heading">
                Karya: <?= esc($anggota['nama_anggota']) ?>
            </h3>
            <span class="text-xs px-3 py-1 rounded-full bg-white/20 text-white font-bold">
                <?= count($karyaList) ?> Karya Dihasilkan
            </span>
        </div>

        <?php if (!empty($karyaList)): ?>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-rose-50/70 text-maroon-900 text-xs uppercase tracking-wider border-b border-rose-100">
                            <th class="py-3.5 px-6 font-bold w-28">Jenis</th>
                            <th class="py-3.5 px-6 font-bold w-36">Level</th>
                            <th class="py-3.5 px-6 font-bold w-24">Tahun</th>
                            <th class="py-3.5 px-6 font-bold">Judul Karya</th>
                            <th class="py-3.5 px-6 font-bold text-right w-24">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        <?php foreach ($karyaList as $karya): ?>
                            <tr class="hover:bg-rose-50/40 transition-colors group">
                                <td class="py-4 px-6 font-bold text-gray-800">
                                    <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-rose-100 text-maroon-800 border border-rose-200">
                                        <?= esc($karya['jenis_karya']) ?>
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-gray-700">
                                    <span class="font-bold text-xs"><?= esc($karya['level_karya']) ?></span>
                                    <?php if (!empty($karya['nama_kategori'])): ?>
                                        <p class="text-[11px] text-maroon-800 font-semibold mt-0.5"><?= esc($karya['nama_kategori']) ?></p>
                                    <?php endif; ?>
                                </td>
                                <td class="py-4 px-6 font-mono text-xs font-bold text-gray-600">
                                    <?= esc($karya['tahun_terbit']) ?>
                                </td>
                                <td class="py-4 px-6 font-medium text-gray-900">
                                    <a href="<?= base_url('karya/' . $karya['id_karya']) ?>" class="group-hover:text-maroon-800 transition-colors leading-relaxed block font-semibold">
                                        <?= esc($karya['judul_karya']) ?>
                                    </a>
                                    <?php if (!empty($karya['nama_terbitan'])): ?>
                                        <p class="text-xs text-gray-500 italic mt-1"><?= esc($karya['nama_terbitan']) ?></p>
                                    <?php endif; ?>
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <a href="<?= base_url('karya/' . $karya['id_karya']) ?>" 
                                       class="btn-shimmer inline-flex items-center gap-1 px-3.5 py-1.5 rounded-xl text-xs font-bold text-maroon-900 bg-rose-100 hover:bg-maroon-900 hover:text-white transition-all shadow-sm">
                                        <span>Detail</span>
                                        <i class="fa-solid fa-chevron-right text-[9px]"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="py-12 text-center text-gray-500 text-sm">
                <i class="fa-solid fa-folder-open text-3xl text-gray-300 mb-2"></i>
                <p>Belum ada data karya ilmiah yang tercatat untuk anggota ini.</p>
            </div>
        <?php endif; ?>

    </div>

</section>

<?= $this->endSection() ?>
