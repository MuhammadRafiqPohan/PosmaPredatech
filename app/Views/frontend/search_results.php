<?= $this->extend('layouts/frontend') ?>

<?= $this->section('content') ?>

<!-- Header Banner -->
<section class="bg-gradient-to-r from-[#4c0519] via-[#660920] to-[#800000] text-white py-12 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <div class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-rose-300 mb-2">
                    <i class="fa-solid fa-magnifying-glass"></i> Pencarian Sistem POSMA
                </div>
                <h1 class="text-2xl sm:text-4xl font-extrabold font-heading">
                    Hasil Pencarian <?= esc($type) ?>
                </h1>
                <p class="text-sm text-rose-200/90 mt-1">
                    <?php if (!empty($keyword)): ?>
                        Menampilkan hasil untuk kata kunci: <strong class="text-amber-300 font-bold">"<?= esc($keyword) ?>"</strong>
                    <?php else: ?>
                        Menampilkan seluruh data direktori repositori
                    <?php endif; ?>
                </p>
            </div>

            <!-- Tab Switcher (Anggota / Karya) -->
            <div class="inline-flex p-1.5 rounded-2xl bg-black/20 backdrop-blur-md border border-white/10 self-start md:self-auto">
                <a href="<?= base_url('search?type=Anggota&q=' . urlencode($keyword)) ?>" 
                   class="px-5 py-2 rounded-xl text-xs sm:text-sm font-bold transition-all duration-200 flex items-center gap-2 <?= ($type === 'Anggota') ? 'bg-white text-maroon-900 shadow-md' : 'text-rose-200 hover:text-white' ?>">
                    <i class="fa-solid fa-user-graduate"></i>
                    <span>Anggota &amp; Alumni</span>
                </a>
                <a href="<?= base_url('search?type=Karya&q=' . urlencode($keyword)) ?>" 
                   class="px-5 py-2 rounded-xl text-xs sm:text-sm font-bold transition-all duration-200 flex items-center gap-2 <?= ($type === 'Karya') ? 'bg-white text-maroon-900 shadow-md' : 'text-rose-200 hover:text-white' ?>">
                    <i class="fa-solid fa-book-open"></i>
                    <span>Karya &amp; Publikasi</span>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Main Search Filter & Results Container -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <!-- Search Form Bar (Page 3 & 5 style) -->
    <div class="bg-white p-4 rounded-2xl shadow-lg border border-rose-100 mb-8 -mt-16 relative z-20">
        <form action="<?= base_url('search') ?>" method="GET" class="flex flex-col sm:flex-row items-center gap-3">
            <input type="hidden" name="type" value="<?= esc($type) ?>">

            <!-- Type Indicator Badge -->
            <div class="w-full sm:w-auto px-4 py-3 rounded-xl bg-rose-50 border border-rose-200/70 text-maroon-900 font-bold text-xs sm:text-sm flex items-center gap-2 whitespace-nowrap">
                <i class="fa-solid <?= ($type === 'Anggota') ? 'fa-user-graduate text-maroon-800' : 'fa-book-open text-maroon-800' ?>"></i>
                <span>Direktori: <strong><?= esc($type) ?></strong></span>
            </div>

            <!-- Keyword Input -->
            <div class="relative flex-1 w-full">
                <input type="text" 
                       name="q" 
                       value="<?= esc($keyword) ?>" 
                       placeholder="<?= ($type === 'Anggota') ? 'Cari nama alumni, NIM, instansi (misal: Nurul)...' : 'Cari judul karya, topik, metode (misal: Naïve Bayes)...' ?>"
                       class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-maroon-800 focus:ring-2 focus:ring-maroon-800/20 text-sm font-medium text-gray-800 focus:outline-none">
            </div>

            <!-- Search Button -->
            <button type="submit" 
                    class="btn-shimmer w-full sm:w-auto px-7 py-3 rounded-xl bg-maroon-900 hover:bg-maroon-950 text-white font-bold text-sm shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2">
                <i class="fa-solid fa-magnifying-glass text-xs"></i>
                <span>Search</span>
            </button>
        </form>
    </div>

    <!-- Results Header -->
    <div class="flex items-center justify-between mb-4">
        <p class="text-sm font-semibold text-gray-600">
            Ditemukan <span class="text-maroon-900 font-extrabold"><?= count($results) ?></span> data hasil pencarian
        </p>
        <span class="text-xs text-gray-400">
            Sistem Informasi Repository &amp; Manajemen Alumni Predatech
        </span>
    </div>

    <!-- Results Table (Exactly matching PDF Page 3 and Page 5) -->
    <div class="bg-white rounded-2xl shadow-xl border border-rose-100 overflow-hidden">
        <?php if (!empty($results)): ?>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gradient-to-r from-maroon-900 via-maroon-800 to-rose-900 text-white text-xs uppercase tracking-wider">
                            <th class="py-4 px-6 font-bold w-16 text-center">No</th>
                            <?php if ($type === 'Anggota'): ?>
                                <th class="py-4 px-6 font-bold">Nama Anggota / Peneliti</th>
                                <th class="py-4 px-6 font-bold hidden md:table-cell">NIM / Prodi</th>
                                <th class="py-4 px-6 font-bold hidden lg:table-cell">Status &amp; Instansi</th>
                            <?php else: ?>
                                <th class="py-4 px-6 font-bold">Judul Karya / Publikasi Ilmiah</th>
                                <th class="py-4 px-6 font-bold hidden md:table-cell">Penulis &amp; Kategori</th>
                                <th class="py-4 px-6 font-bold hidden lg:table-cell">Tahun &amp; Level</th>
                            <?php endif; ?>
                            <th class="py-4 px-6 font-bold text-right w-28">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        <?php $no = 1; foreach ($results as $item): ?>
                            <tr class="hover:bg-rose-50/50 transition-colors duration-150 group">
                                <td class="py-4 px-6 text-center font-bold text-gray-400 group-hover:text-maroon-900">
                                    <?= $no++ ?>
                                </td>

                                <?php if ($type === 'Anggota'): ?>
                                    <!-- Anggota Row (PDF Page 3) -->
                                    <td class="py-4 px-6 font-medium text-gray-900">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-full bg-rose-50 p-0.5 border border-rose-200 flex-shrink-0">
                                                <img src="<?= base_url('uploads/anggota/' . (!empty($item['foto_anggota']) ? $item['foto_anggota'] : 'avatar_female.svg')) ?>" 
                                                     alt="<?= esc($item['nama_anggota']) ?>" 
                                                     class="w-full h-full object-cover rounded-full">
                                            </div>
                                            <div>
                                                <a href="<?= base_url('anggota/' . $item['id_anggota']) ?>" class="font-bold text-gray-900 group-hover:text-maroon-900 transition-colors">
                                                    <?= esc($item['nama_anggota']) ?>
                                                </a>
                                                <p class="text-xs text-gray-500 md:hidden mt-0.5">
                                                    NIM: <?= esc($item['id_anggota']) ?> &bull; <?= esc($item['program_studi']) ?>
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 hidden md:table-cell text-gray-600">
                                        <span class="font-mono text-xs font-semibold bg-gray-100 px-2 py-1 rounded">NIM: <?= esc($item['id_anggota']) ?></span>
                                        <span class="ml-2 font-bold text-xs text-maroon-800"><?= esc($item['program_studi']) ?></span>
                                    </td>
                                    <td class="py-4 px-6 hidden lg:table-cell text-gray-600">
                                        <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-bold <?= ($item['status_keanggotaan'] === 'Alumni') ? 'bg-amber-100 text-amber-900' : 'bg-emerald-100 text-emerald-900' ?>">
                                            <?= esc($item['status_keanggotaan']) ?>
                                        </span>
                                        <p class="text-xs text-gray-500 mt-1 truncate max-w-xs">
                                            <?= esc($item['instansi_perusahaan'] ?: $item['pekerjaan_saat_ini']) ?>
                                        </p>
                                    </td>
                                    <td class="py-4 px-6 text-right">
                                        <a href="<?= base_url('anggota/' . $item['id_anggota']) ?>" 
                                           class="btn-shimmer inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold text-maroon-900 bg-rose-100/70 hover:bg-maroon-900 hover:text-white transition-all shadow-sm">
                                            <span>Detail</span>
                                            <i class="fa-solid fa-chevron-right text-[10px]"></i>
                                        </a>
                                    </td>

                                <?php else: ?>
                                    <!-- Karya Row (PDF Page 5) -->
                                    <td class="py-4 px-6 font-medium text-gray-900 max-w-lg">
                                        <a href="<?= base_url('karya/' . $item['id_karya']) ?>" class="font-bold text-gray-900 group-hover:text-maroon-900 transition-colors leading-relaxed block">
                                            <?= esc($item['judul_karya']) ?>
                                        </a>
                                        <div class="md:hidden mt-1 text-xs text-gray-500 flex items-center gap-2 flex-wrap">
                                            <span class="text-maroon-800 font-semibold"><?= esc($item['penulis_pertama']) ?></span>
                                            &bull;
                                            <span class="font-bold"><?= esc($item['nama_kategori'] ?? $item['jenis_karya']) ?></span>
                                            &bull;
                                            <span><?= esc($item['tahun_terbit']) ?></span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 hidden md:table-cell text-gray-600">
                                        <p class="text-xs font-bold text-gray-800 truncate max-w-xs"><?= esc($item['penulis_pertama']) ?></p>
                                        <span class="inline-block mt-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-50 text-maroon-800 border border-rose-200">
                                            <?= esc($item['nama_kategori'] ?? $item['jenis_karya']) ?>
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 hidden lg:table-cell text-gray-600">
                                        <span class="font-mono text-xs font-bold text-gray-700 bg-gray-100 px-2 py-0.5 rounded"><?= esc($item['tahun_terbit']) ?></span>
                                        <p class="text-xs text-maroon-800 font-semibold mt-1"><?= esc($item['level_karya']) ?></p>
                                    </td>
                                    <td class="py-4 px-6 text-right">
                                        <a href="<?= base_url('karya/' . $item['id_karya']) ?>" 
                                           class="btn-shimmer inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold text-maroon-900 bg-rose-100/70 hover:bg-maroon-900 hover:text-white transition-all shadow-sm">
                                            <span>Detail</span>
                                            <i class="fa-solid fa-chevron-right text-[10px]"></i>
                                        </a>
                                    </td>
                                <?php endif; ?>

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <!-- Empty Search State -->
            <div class="py-16 text-center px-4">
                <div class="w-20 h-20 rounded-full bg-rose-50 text-maroon-800 flex items-center justify-center text-3xl mx-auto mb-4 border border-rose-200">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900 font-heading">Data Tidak Ditemukan</h3>
                <p class="text-sm text-gray-500 max-w-md mx-auto mt-1 mb-6">
                    Tidak ditemukan data <?= esc($type) ?> yang cocok dengan kata kunci "<strong><?= esc($keyword) ?></strong>". Silakan periksa kembali ejaan atau gunakan kata kunci lain.
                </p>
                <a href="<?= base_url('search?type=' . $type) ?>" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-maroon-900 hover:bg-maroon-950 transition-colors">
                    <i class="fa-solid fa-rotate-left"></i>
                    <span>Tampilkan Semua Data <?= esc($type) ?></span>
                </a>
            </div>
        <?php endif; ?>
    </div>

</section>

<?= $this->endSection() ?>
