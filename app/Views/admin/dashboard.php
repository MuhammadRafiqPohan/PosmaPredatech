<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="space-y-8">
    
    <!-- Welcome Greeting Banner (Maroon Glow) -->
    <div class="relative rounded-3xl bg-gradient-to-r from-[#4c0519] via-[#6e0922] to-[#800000] text-white p-6 sm:p-8 shadow-xl overflow-hidden">
        <div class="absolute -top-24 -right-24 w-80 h-80 bg-rose-500/15 rounded-full blur-2xl pointer-events-none"></div>
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-sm text-xs font-bold text-rose-200 border border-white/20 mb-3">
                    <i class="fa-solid fa-puzzle-piece text-amber-300"></i>
                    <span>Panel Pengelolaan POSMA Predatech</span>
                </span>
                <h1 class="text-2xl sm:text-3xl font-black font-heading tracking-tight leading-tight">
                    Selamat Datang, <?= esc(session()->get('nama_user')) ?>!
                </h1>
                <p class="text-xs sm:text-sm text-rose-100/80 mt-1 max-w-2xl leading-relaxed">
                    Anda masuk dengan level hak akses <strong class="text-amber-300 font-bold"><?= esc($userLevel) ?></strong>. Kelola database alumni, karya publikasi jurnal, prosiding, serta permohonan HKI Predatech dengan mudah dan terstruktur.
                </p>
            </div>

            <div class="flex items-center gap-3 self-start md:self-auto flex-wrap">
                <a href="<?= base_url('admin/anggota/create') ?>" 
                   class="btn-shimmer inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold bg-white text-maroon-900 hover:bg-rose-50 shadow-md transition-all">
                    <i class="fa-solid fa-user-plus text-maroon-800"></i>
                    <span>Tambah Anggota</span>
                </a>
                <a href="<?= base_url('admin/karya/create') ?>" 
                   class="btn-shimmer inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold bg-rose-950/70 hover:bg-rose-950 text-white border border-rose-300/30 transition-all">
                    <i class="fa-solid fa-folder-plus text-rose-400"></i>
                    <span>Tambah Karya</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Cards Row (With Onload Animated Counters) -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-5">
        
        <!-- Total Anggota -->
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 hover-lift group"
             x-data="animatedCounter(<?= $statsAnggota['total'] ?? 0 ?>)">
            <div class="flex items-center justify-between mb-2">
                <span class="w-10 h-10 rounded-xl bg-rose-50 text-maroon-800 flex items-center justify-center text-lg group-hover:bg-maroon-800 group-hover:text-white transition-colors">
                    <i class="fa-solid fa-users"></i>
                </span>
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Database</span>
            </div>
            <div class="text-3xl font-black text-gray-900 font-heading" x-text="current">
                <?= $statsAnggota['total'] ?? 0 ?>
            </div>
            <p class="text-xs font-semibold text-gray-500 mt-1">Total Anggota &amp; Alumni</p>
        </div>

        <!-- Total Karya -->
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 hover-lift group"
             x-data="animatedCounter(<?= $statsKarya['total'] ?? 0 ?>)">
            <div class="flex items-center justify-between mb-2">
                <span class="w-10 h-10 rounded-xl bg-rose-50 text-maroon-800 flex items-center justify-center text-lg group-hover:bg-maroon-800 group-hover:text-white transition-colors">
                    <i class="fa-solid fa-book-journal-whills"></i>
                </span>
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Publikasi</span>
            </div>
            <div class="text-3xl font-black text-gray-900 font-heading" x-text="current">
                <?= $statsKarya['total'] ?? 0 ?>
            </div>
            <p class="text-xs font-semibold text-gray-500 mt-1">Karya &amp; Makalah</p>
        </div>

        <!-- Total Jurnal -->
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 hover-lift group"
             x-data="animatedCounter(<?= $statsKarya['jurnal'] ?? 0 ?>)">
            <div class="flex items-center justify-between mb-2">
                <span class="w-10 h-10 rounded-xl bg-rose-50 text-maroon-800 flex items-center justify-center text-lg group-hover:bg-maroon-800 group-hover:text-white transition-colors">
                    <i class="fa-solid fa-award"></i>
                </span>
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Sinta &amp; Scopus</span>
            </div>
            <div class="text-3xl font-black text-gray-900 font-heading" x-text="current">
                <?= $statsKarya['jurnal'] ?? 0 ?>
            </div>
            <p class="text-xs font-semibold text-gray-500 mt-1">Jurnal Terakreditasi</p>
        </div>

        <!-- Total HKI / Aplikasi -->
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 hover-lift group"
             x-data="animatedCounter(<?= ($statsKarya['hki'] ?? 0) + ($statsKarya['sistem'] ?? 0) ?>)">
            <div class="flex items-center justify-between mb-2">
                <span class="w-10 h-10 rounded-xl bg-rose-50 text-maroon-800 flex items-center justify-center text-lg group-hover:bg-maroon-800 group-hover:text-white transition-colors">
                    <i class="fa-solid fa-shield-halved"></i>
                </span>
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Inovasi</span>
            </div>
            <div class="text-3xl font-black text-gray-900 font-heading" x-text="current">
                <?= ($statsKarya['hki'] ?? 0) + ($statsKarya['sistem'] ?? 0) ?>
            </div>
            <p class="text-xs font-semibold text-gray-500 mt-1">HKI, Paten &amp; Software</p>
        </div>

    </div>

    <!-- Personal Summary Card (If Logged in as Anggota) -->
    <?php if ($userLevel === 'Anggota' && $myProfile): ?>
        <div class="bg-white rounded-2xl p-6 border border-rose-100 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-2xl bg-rose-50 border border-rose-200 overflow-hidden flex-shrink-0">
                    <img src="<?= base_url('uploads/anggota/' . (!empty($myProfile['foto_anggota']) ? $myProfile['foto_anggota'] : 'avatar_female.svg')) ?>" 
                         alt="<?= esc($myProfile['nama_anggota']) ?>" 
                         class="w-full h-full object-cover">
                </div>
                <div>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-maroon-800 bg-rose-50 px-2 py-0.5 rounded-full">
                        Profil Anggota Saya
                    </span>
                    <h3 class="text-lg font-bold text-gray-900 mt-1"><?= esc($myProfile['nama_anggota']) ?></h3>
                    <p class="text-xs text-gray-500">NIM: <?= esc($myProfile['id_anggota']) ?> &bull; <?= esc($myProfile['program_studi']) ?> (<?= esc($myProfile['angkatan']) ?>)</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <a href="<?= base_url('admin/anggota/edit/' . $myProfile['id_anggota']) ?>" class="px-4 py-2 rounded-xl text-xs font-bold text-maroon-900 bg-rose-50 hover:bg-rose-100 border border-rose-200 transition-colors">
                    <i class="fa-solid fa-pen-to-square mr-1"></i> Edit Profil Saya
                </a>
                <a href="<?= base_url('anggota/' . $myProfile['id_anggota']) ?>" target="_blank" class="px-4 py-2 rounded-xl text-xs font-bold text-white bg-maroon-900 hover:bg-maroon-950 transition-colors">
                    <i class="fa-solid fa-globe mr-1"></i> Halaman Publik
                </a>
            </div>
        </div>
    <?php endif; ?>

    <!-- Two-column Section: Data Tables -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- Recent Anggota -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-5 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-sm font-bold text-gray-900 font-heading flex items-center gap-2">
                    <i class="fa-solid fa-user-graduate text-maroon-800"></i>
                    <span>Anggota &amp; Alumni Terbaru</span>
                </h3>
                <a href="<?= base_url('admin/anggota') ?>" class="text-xs font-bold text-maroon-800 hover:text-maroon-950 transition-colors">
                    Lihat Semua &rarr;
                </a>
            </div>
            <div class="divide-y divide-gray-100 text-xs">
                <?php foreach ($recentAnggota as $a): ?>
                    <div class="p-4 flex items-center justify-between gap-3 hover:bg-gray-50 transition-colors">
                        <div class="flex items-center gap-3 overflow-hidden">
                            <div class="w-9 h-9 rounded-full bg-rose-50 border border-rose-200 overflow-hidden flex-shrink-0">
                                <img src="<?= base_url('uploads/anggota/' . (!empty($a['foto_anggota']) ? $a['foto_anggota'] : 'avatar_female.svg')) ?>" 
                                     alt="<?= esc($a['nama_anggota']) ?>" 
                                     class="w-full h-full object-cover">
                            </div>
                            <div class="overflow-hidden">
                                <h4 class="font-bold text-gray-900 truncate"><?= esc($a['nama_anggota']) ?></h4>
                                <p class="text-gray-500 truncate">NIM: <?= esc($a['id_anggota']) ?> &bull; <?= esc($a['program_studi']) ?></p>
                            </div>
                        </div>
                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full <?= ($a['status_keanggotaan'] === 'Alumni') ? 'bg-amber-100 text-amber-900' : 'bg-emerald-100 text-emerald-900' ?>">
                            <?= esc($a['status_keanggotaan']) ?>
                        </span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Recent Karya -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-5 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-sm font-bold text-gray-900 font-heading flex items-center gap-2">
                    <i class="fa-solid fa-book-open text-maroon-800"></i>
                    <span>Karya &amp; Publikasi Terbaru</span>
                </h3>
                <a href="<?= base_url('admin/karya') ?>" class="text-xs font-bold text-maroon-800 hover:text-maroon-950 transition-colors">
                    Lihat Semua &rarr;
                </a>
            </div>
            <div class="divide-y divide-gray-100 text-xs">
                <?php foreach ($recentKarya as $k): ?>
                    <div class="p-4 flex items-center justify-between gap-3 hover:bg-gray-50 transition-colors">
                        <div class="overflow-hidden">
                            <h4 class="font-bold text-gray-900 truncate"><?= esc($k['judul_karya']) ?></h4>
                            <p class="text-gray-500 mt-0.5 truncate">
                                <?= esc($k['penulis_pertama']) ?> &bull; <span class="text-maroon-800 font-semibold"><?= esc($k['nama_kategori'] ?? $k['jenis_karya']) ?></span> (<?= esc($k['tahun_terbit']) ?>)
                            </p>
                        </div>
                        <a href="<?= base_url('admin/karya/detail/' . $k['id_karya']) ?>" class="p-1.5 rounded-lg text-gray-400 hover:text-maroon-800 hover:bg-rose-50 transition-colors flex-shrink-0">
                            <i class="fa-solid fa-chevron-right text-xs"></i>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

    </div>

</div>

<?= $this->endSection() ?>
