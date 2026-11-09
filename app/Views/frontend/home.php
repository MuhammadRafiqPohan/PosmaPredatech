<?= $this->extend('layouts/frontend') ?>

<?= $this->section('content') ?>

<!-- ========================================================
     HERO SECTION WITH MODERN DEEP MAROON GRADIENT & PUZZLE GLOW
     ======================================================== -->
<section class="relative bg-gradient-to-br from-[#38020d] via-[#4c0519] to-[#700b25] text-white pt-16 pb-28 overflow-hidden">
    <!-- Animated background glowing blobs -->
    <div class="absolute top-10 left-10 w-96 h-96 bg-rose-600/15 rounded-full blur-3xl animate-float pointer-events-none"></div>
    <div class="absolute bottom-10 right-10 w-[500px] h-[500px] bg-red-800/20 rounded-full blur-3xl animate-float pointer-events-none" style="animation-delay: -2.5s;"></div>
    
    <!-- Floating puzzle icon watermark in background -->
    <div class="absolute right-[-60px] top-[10%] opacity-5 pointer-events-none select-none text-[320px] text-white">
        <i class="fa-solid fa-puzzle-piece"></i>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center max-w-4xl mx-auto space-y-6">
            
            <!-- Campus Badge (OnLoad Entrance) -->
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-rose-300/20 text-xs font-bold text-rose-200 tracking-wider uppercase animate-entrance-down">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                <span>PUZZLE RESEARCH DATA TECHNOLOGY &bull; UIN SUSKA RIAU</span>
            </div>

            <!-- Main Heading -->
            <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black font-heading tracking-tight leading-tight animate-entrance-up">
                Sistem Informasi Repository &amp; <br class="hidden sm:inline">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-rose-200 via-amber-200 to-rose-100">
                    Manajemen Alumni (POSMA)
                </span>
            </h1>

            <!-- Subtitle -->
            <p class="text-base sm:text-lg text-rose-100/85 leading-relaxed max-w-3xl mx-auto font-normal">
                Sistem terintegrasi untuk mendata karya ilmiah, publikasi bereputasi, prosiding, produk HKI, dan tracking karir alumni UIN Sultan Syarif Kasim Riau yang tergabung dalam keluarga besar riset Predatech.
            </p>

            <!-- ========================================================
                 SEARCH BAR SECTION (Directly matching PDF Page 3 & Page 5)
                 ======================================================== -->
            <div class="pt-6 max-w-3xl mx-auto" 
                 x-data="posmaSearch('<?= base_url() ?>/')" 
                 @click.away="closeDropdown()">
                
                <form action="<?= base_url('search') ?>" method="GET" class="relative group">
                    <div class="bg-white p-2 rounded-2xl shadow-2xl shadow-maroon-950/40 border-2 border-rose-200/80 flex flex-col sm:flex-row items-center gap-2 transition-all duration-300 group-hover:border-rose-400 group-hover:shadow-rose-950/50">
                        
                        <!-- Category Selector (Anggota / Karya) -->
                        <div class="w-full sm:w-auto relative" x-data="{ openCat: false }">
                            <input type="hidden" name="type" :value="category">
                            <button type="button" 
                                    @click="openCat = !openCat"
                                    class="w-full sm:w-44 flex items-center justify-between gap-2 px-4 py-3.5 rounded-xl bg-rose-50 hover:bg-rose-100/80 text-maroon-900 font-bold text-sm transition-colors border border-rose-200/70">
                                <span class="flex items-center gap-2">
                                    <i class="fa-solid" :class="category === 'Anggota' ? 'fa-user-graduate text-maroon-800' : 'fa-book-open text-maroon-800'"></i>
                                    <span x-text="category">Anggota</span>
                                </span>
                                <i class="fa-solid fa-chevron-down text-xs text-rose-700 transition-transform" :class="openCat ? 'rotate-180' : ''"></i>
                            </button>

                            <!-- Category Dropdown Menu -->
                            <div x-show="openCat" 
                                 @click.away="openCat = false"
                                 x-transition 
                                 class="absolute left-0 mt-2 w-48 bg-white rounded-xl shadow-2xl border border-gray-100 py-1.5 z-50 text-left text-gray-800">
                                <button type="button" 
                                        @click="setCategory('Anggota'); openCat = false"
                                        class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm font-semibold hover:bg-rose-50 hover:text-maroon-900 transition-colors"
                                        :class="category === 'Anggota' ? 'text-maroon-900 bg-rose-50/70' : 'text-gray-700'">
                                    <i class="fa-solid fa-user-graduate text-xs text-maroon-700"></i>
                                    <span>Data Anggota</span>
                                </button>
                                <button type="button" 
                                        @click="setCategory('Karya'); openCat = false"
                                        class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm font-semibold hover:bg-rose-50 hover:text-maroon-900 transition-colors"
                                        :class="category === 'Karya' ? 'text-maroon-900 bg-rose-50/70' : 'text-gray-700'">
                                    <i class="fa-solid fa-book-open text-xs text-maroon-700"></i>
                                    <span>Data Karya &amp; Publikasi</span>
                                </button>
                            </div>
                        </div>

                        <!-- Keyword Input Field -->
                        <div class="relative flex-1 w-full">
                            <input type="text" 
                                   name="q" 
                                   x-model="keyword"
                                   @input.debounce.350ms="performSearch()"
                                   @focus="if(keyword.length >= 2) showDropdown = true"
                                   :placeholder="category === 'Anggota' ? 'Cari nama, NIM, instansi, atau bidang riset (mis: Nurul)...' : 'Cari judul paper, metode, penulis (mis: Naïve Bayes)...'"
                                   class="w-full px-4 py-3.5 text-gray-900 text-sm font-medium focus:outline-none placeholder-gray-400 bg-transparent"
                                   autocomplete="off">
                            
                            <!-- Search Icon / Loading Spinner -->
                            <div class="absolute right-3 top-3.5 text-gray-400">
                                <i x-show="!isLoading" class="fa-solid fa-magnifying-glass text-gray-400 text-sm"></i>
                                <i x-show="isLoading" class="fa-solid fa-circle-notch fa-spin text-maroon-700 text-sm"></i>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" 
                                class="btn-shimmer w-full sm:w-auto px-7 py-3.5 rounded-xl bg-gradient-to-r from-maroon-900 via-maroon-800 to-rose-900 hover:from-maroon-950 hover:to-rose-950 text-white font-bold text-sm shadow-md hover:shadow-xl transition-all transform hover:-translate-y-0.5 active:translate-y-0 flex items-center justify-center gap-2 whitespace-nowrap">
                            <span>Search</span>
                            <i class="fa-solid fa-arrow-right text-xs"></i>
                        </button>
                    </div>

                    <!-- Instant Live Results Dropdown (Alpine.js) -->
                    <div x-show="showDropdown && results.length > 0" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 transform -translate-y-2"
                         x-transition:enter-end="opacity-100 transform translate-y-0"
                         class="absolute left-0 right-0 mt-2 bg-white rounded-2xl shadow-2xl border border-rose-100 divide-y divide-gray-100 max-h-80 overflow-y-auto z-50 text-left text-gray-800">
                        <div class="p-3 bg-rose-50/60 text-xs font-bold text-maroon-900 uppercase tracking-wider flex items-center justify-between">
                            <span>Hasil Pencarian Cepat (<span x-text="results.length"></span>)</span>
                            <span class="text-[10px] text-gray-500 font-normal">Tekan Enter untuk melihat semua</span>
                        </div>
                        <template x-for="item in results" :key="item.id">
                            <a :href="item.url" class="p-3.5 hover:bg-rose-50/50 flex items-start gap-3 transition-colors group/item block">
                                <div class="w-8 h-8 rounded-lg bg-rose-100 text-maroon-800 flex items-center justify-center flex-shrink-0 group-hover/item:bg-maroon-800 group-hover/item:text-white transition-colors">
                                    <i class="fa-solid" :class="item.icon"></i>
                                </div>
                                <div class="flex-1 overflow-hidden">
                                    <div class="flex items-center justify-between gap-2">
                                        <h4 class="text-sm font-bold text-gray-900 truncate group-hover/item:text-maroon-800" x-text="item.title"></h4>
                                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-rose-100 text-maroon-800 whitespace-nowrap" x-text="item.badge"></span>
                                    </div>
                                    <p class="text-xs text-gray-500 truncate" x-text="item.subtitle"></p>
                                </div>
                            </a>
                        </template>
                    </div>
                </form>

                <!-- Quick tags suggestion matching PDF search examples -->
                <div class="mt-3 flex flex-wrap items-center justify-center gap-2 text-xs text-rose-200/80">
                    <span class="font-semibold text-rose-200">Pencarian Populer:</span>
                    <a href="<?= base_url('search?type=Anggota&q=Nurul') ?>" class="px-2.5 py-1 rounded-full bg-white/10 hover:bg-white/20 text-white transition-colors border border-white/10">
                        "Nurul" (Alumni)
                    </a>
                    <a href="<?= base_url('search?type=Karya&q=Naïve+Bayes') ?>" class="px-2.5 py-1 rounded-full bg-white/10 hover:bg-white/20 text-white transition-colors border border-white/10">
                        "Naïve Bayes" (Karya)
                    </a>
                    <a href="<?= base_url('search?type=Karya&q=IoT') ?>" class="px-2.5 py-1 rounded-full bg-white/10 hover:bg-white/20 text-white transition-colors border border-white/10">
                        "IoT &amp; Automation"
                    </a>
                    <a href="<?= base_url('search?type=Karya&q=Mikrotik') ?>" class="px-2.5 py-1 rounded-full bg-white/10 hover:bg-white/20 text-white transition-colors border border-white/10">
                        "Router Mikrotik"
                    </a>
                </div>

            </div>

        </div>
    </div>

    <!-- Wave divider transition to body -->
    <div class="absolute bottom-0 left-0 right-0 leading-none">
        <svg viewBox="0 0 1440 80" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-8 sm:h-12 md:h-16 text-[#fafaf9] preserve-3d">
            <path d="M0,32L60,42.7C120,53,240,75,360,74.7C480,75,600,53,720,42.7C840,32,960,32,1080,37.3C1200,43,1320,53,1380,58.7L1440,64L1440,80L1380,80C1320,80,1200,80,1080,80C960,80,840,80,720,80C600,80,480,80,360,80C240,80,120,80,60,80L0,80Z" fill="currentColor"></path>
        </svg>
    </div>
</section>

<!-- ========================================================
     KEY METRICS STATS COUNTERS (Animated OnLoad)
     ======================================================== -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-10 sm:-mt-14 relative z-20">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6">
        
        <!-- Total Anggota -->
        <div class="glass-white p-5 sm:p-6 rounded-2xl shadow-xl shadow-gray-200/60 border border-white hover-lift group"
             x-data="animatedCounter(<?= $statsAnggota['total'] ?? 0 ?>)">
            <div class="flex items-center justify-between mb-3">
                <span class="w-12 h-12 rounded-xl bg-rose-100 text-maroon-800 flex items-center justify-center text-xl group-hover:scale-110 group-hover:bg-maroon-800 group-hover:text-white transition-all duration-300">
                    <i class="fa-solid fa-users"></i>
                </span>
                <span class="text-[11px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full bg-rose-50 text-maroon-800">
                    Database
                </span>
            </div>
            <div class="text-2xl sm:text-4xl font-black text-gray-900 font-heading" x-text="current">
                <?= $statsAnggota['total'] ?? 0 ?>
            </div>
            <p class="text-xs sm:text-sm font-semibold text-gray-500 mt-1">Total Anggota &amp; Alumni</p>
        </div>

        <!-- Total Karya Ilmiah -->
        <div class="glass-white p-5 sm:p-6 rounded-2xl shadow-xl shadow-gray-200/60 border border-white hover-lift group"
             x-data="animatedCounter(<?= $statsKarya['total'] ?? 0 ?>)">
            <div class="flex items-center justify-between mb-3">
                <span class="w-12 h-12 rounded-xl bg-rose-100 text-maroon-800 flex items-center justify-center text-xl group-hover:scale-110 group-hover:bg-maroon-800 group-hover:text-white transition-all duration-300">
                    <i class="fa-solid fa-book-journal-whills"></i>
                </span>
                <span class="text-[11px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full bg-rose-50 text-maroon-800">
                    Karya
                </span>
            </div>
            <div class="text-2xl sm:text-4xl font-black text-gray-900 font-heading" x-text="current">
                <?= $statsKarya['total'] ?? 0 ?>
            </div>
            <p class="text-xs sm:text-sm font-semibold text-gray-500 mt-1">Publikasi &amp; Karya Ilmiah</p>
        </div>

        <!-- Jurnal Terakreditasi -->
        <div class="glass-white p-5 sm:p-6 rounded-2xl shadow-xl shadow-gray-200/60 border border-white hover-lift group"
             x-data="animatedCounter(<?= $statsKarya['jurnal'] ?? 0 ?>)">
            <div class="flex items-center justify-between mb-3">
                <span class="w-12 h-12 rounded-xl bg-rose-100 text-maroon-800 flex items-center justify-center text-xl group-hover:scale-110 group-hover:bg-maroon-800 group-hover:text-white transition-all duration-300">
                    <i class="fa-solid fa-award"></i>
                </span>
                <span class="text-[11px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full bg-rose-50 text-maroon-800">
                    Sinta &amp; Scopus
                </span>
            </div>
            <div class="text-2xl sm:text-4xl font-black text-gray-900 font-heading" x-text="current">
                <?= $statsKarya['jurnal'] ?? 0 ?>
            </div>
            <p class="text-xs sm:text-sm font-semibold text-gray-500 mt-1">Jurnal Bereputasi</p>
        </div>

        <!-- Paten HKI & Aplikasi -->
        <div class="glass-white p-5 sm:p-6 rounded-2xl shadow-xl shadow-gray-200/60 border border-white hover-lift group"
             x-data="animatedCounter(<?= ($statsKarya['hki'] ?? 0) + ($statsKarya['sistem'] ?? 0) ?>)">
            <div class="flex items-center justify-between mb-3">
                <span class="w-12 h-12 rounded-xl bg-rose-100 text-maroon-800 flex items-center justify-center text-xl group-hover:scale-110 group-hover:bg-maroon-800 group-hover:text-white transition-all duration-300">
                    <i class="fa-solid fa-shield-halved"></i>
                </span>
                <span class="text-[11px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full bg-rose-50 text-maroon-800">
                    Inovasi
                </span>
            </div>
            <div class="text-2xl sm:text-4xl font-black text-gray-900 font-heading" x-text="current">
                <?= ($statsKarya['hki'] ?? 0) + ($statsKarya['sistem'] ?? 0) ?>
            </div>
            <p class="text-xs sm:text-sm font-semibold text-gray-500 mt-1">HKI &amp; Sistem Aplikasi</p>
        </div>

    </div>
</section>

<!-- ========================================================
     FEATURED PUBLICATIONS / KARYA ILMIAH SHOWCASE
     ======================================================== -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 reveal-on-scroll">
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
        <div>
            <div class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-maroon-800 mb-2">
                <i class="fa-solid fa-layer-group"></i> Repositori Unggulan
            </div>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 font-heading">
                Karya &amp; Publikasi Ilmiah Terbaru
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                Karya penelitian terindeks Scopus, Sinta 1-6, prosiding internasional dan paten HKI anggota Predatech.
            </p>
        </div>
        <a href="<?= base_url('search?type=Karya') ?>" 
           class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold text-maroon-900 bg-rose-50 hover:bg-maroon-900 hover:text-white transition-all duration-300 border border-rose-200 self-start md:self-auto group">
            <span>Jelajahi Semua Karya</span>
            <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
        </a>
    </div>

    <!-- Publications Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($recentKarya as $karya): ?>
            <div class="bg-white rounded-2xl p-6 border border-rose-100 shadow-md shadow-gray-100 hover-lift flex flex-col justify-between group relative overflow-hidden">
                <!-- Top Accent Line -->
                <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-maroon-800 via-rose-600 to-amber-500"></div>

                <div>
                    <!-- Badges -->
                    <div class="flex items-center justify-between gap-2 mb-3">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-rose-50 text-maroon-800 border border-rose-200/60">
                            <i class="fa-solid <?= esc($karya['icon_karya'] ?? 'fa-tag') ?> text-[10px]"></i>
                            <span><?= esc($karya['nama_kategori'] ?? $karya['jenis_karya']) ?></span>
                        </span>
                        <span class="text-xs font-bold text-gray-500 bg-gray-100 px-2.5 py-0.5 rounded-full">
                            <?= esc($karya['tahun_terbit']) ?>
                        </span>
                    </div>

                    <!-- Judul Karya -->
                    <h3 class="text-base font-bold text-gray-900 group-hover:text-maroon-800 transition-colors line-clamp-3 leading-snug mb-3">
                        <a href="<?= base_url('karya/' . $karya['id_karya']) ?>">
                            <?= esc($karya['judul_karya']) ?>
                        </a>
                    </h3>

                    <!-- Penulis -->
                    <div class="flex items-center gap-2 text-xs text-gray-600 mb-2">
                        <i class="fa-solid fa-feather text-maroon-700 text-xs"></i>
                        <span class="font-medium truncate"><?= esc($karya['penulis_pertama']) ?></span>
                    </div>

                    <!-- Terbitan / Venue -->
                    <?php if (!empty($karya['nama_terbitan'])): ?>
                        <div class="flex items-start gap-2 text-xs text-gray-500 mb-4 line-clamp-2">
                            <i class="fa-solid fa-landmark text-gray-400 mt-0.5 text-xs"></i>
                            <span class="italic"><?= esc($karya['nama_terbitan']) ?></span>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Footer Card Action -->
                <div class="pt-4 border-t border-gray-100 flex items-center justify-between">
                    <span class="text-xs font-semibold text-gray-500">
                        Level: <span class="text-maroon-800 font-bold"><?= esc($karya['level_karya']) ?></span>
                    </span>
                    <a href="<?= base_url('karya/' . $karya['id_karya']) ?>" 
                       class="inline-flex items-center gap-1.5 text-xs font-bold text-maroon-900 hover:text-rose-600 transition-colors group-hover:translate-x-0.5">
                        <span>Detail Karya</span>
                        <i class="fa-solid fa-chevron-right text-[10px]"></i>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- ========================================================
     ALUMNI & ANGGOTA DIRECTORY SHOWCASE
     ======================================================== -->
<section class="bg-rose-50/40 py-20 border-y border-rose-100 reveal-on-scroll">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
            <div>
                <div class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-maroon-800 mb-2">
                    <i class="fa-solid fa-user-graduate"></i> Jejaring Alumni &amp; Anggota
                </div>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 font-heading">
                    Profil Anggota &amp; Peneliti Predatech
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    Tracking karir, institusi kerja, serta profil riset alumni pasca lulus dari kampus UIN Suska Riau.
                </p>
            </div>
            <a href="<?= base_url('search?type=Anggota') ?>" 
               class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold text-maroon-900 bg-white hover:bg-maroon-900 hover:text-white transition-all duration-300 border border-rose-200 shadow-sm self-start md:self-auto group">
                <span>Lihat Semua Anggota</span>
                <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>

        <!-- Members Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php foreach ($recentAnggota as $anggota): ?>
                <div class="bg-white rounded-2xl p-6 border border-rose-100/80 shadow-md hover-lift text-center group flex flex-col justify-between">
                    <div>
                        <!-- Avatar with Zoom on Hover -->
                        <div class="relative w-24 h-24 mx-auto mb-4 rounded-2xl overflow-hidden bg-rose-50 p-1 border-2 border-rose-100 group-hover:border-maroon-700 transition-all duration-300 shadow-sm">
                            <?php 
                                $photoPath = !empty($anggota['foto_anggota']) ? $anggota['foto_anggota'] : 'avatar_female.svg';
                                $imgSrc = str_starts_with($photoPath, 'avatar_') ? base_url('uploads/anggota/' . $photoPath) : base_url('uploads/anggota/' . $photoPath);
                            ?>
                            <img src="<?= $imgSrc ?>" alt="<?= esc($anggota['nama_anggota']) ?>" class="w-full h-full object-cover rounded-xl group-hover:scale-110 transition-transform duration-500">
                        </div>

                        <!-- Name & NIM -->
                        <h3 class="text-base font-bold text-gray-900 group-hover:text-maroon-800 transition-colors line-clamp-1">
                            <?= esc($anggota['nama_anggota']) ?>
                        </h3>
                        <p class="text-xs text-gray-500 font-medium mb-2">
                            NIM: <?= esc($anggota['id_anggota']) ?> &bull; <?= esc($anggota['program_studi']) ?>
                        </p>

                        <!-- Status Badge -->
                        <span class="inline-block px-3 py-1 rounded-full text-[11px] font-bold <?= ($anggota['status_keanggotaan'] === 'Alumni') ? 'bg-amber-100 text-amber-900 border border-amber-200' : (($anggota['status_keanggotaan'] === 'Dosen') ? 'bg-purple-100 text-purple-900 border border-purple-200' : 'bg-emerald-100 text-emerald-900 border border-emerald-200') ?> mb-3">
                            <?= esc($anggota['status_keanggotaan']) ?> (<?= esc($anggota['angkatan']) ?>)
                        </span>

                        <!-- Current Work -->
                        <div class="text-xs text-gray-600 bg-gray-50 rounded-xl p-3 mb-4 text-left">
                            <p class="font-bold text-gray-800 truncate">
                                <i class="fa-solid fa-briefcase text-maroon-700 mr-1 text-[11px]"></i>
                                <?= esc($anggota['pekerjaan_saat_ini'] ?: 'Mahasiswa / Peneliti') ?>
                            </p>
                            <p class="text-gray-500 truncate text-[11px] mt-0.5">
                                <?= esc($anggota['instansi_perusahaan'] ?: 'UIN Sultan Syarif Kasim Riau') ?>
                            </p>
                        </div>
                    </div>

                    <!-- Action Button -->
                    <a href="<?= base_url('anggota/' . $anggota['id_anggota']) ?>" 
                       class="w-full py-2.5 rounded-xl text-xs font-bold text-maroon-900 bg-rose-50 hover:bg-maroon-900 hover:text-white transition-all duration-300 border border-rose-200 flex items-center justify-center gap-1.5">
                        <span>Lihat Profil &amp; Karya</span>
                        <i class="fa-solid fa-chevron-right text-[10px]"></i>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ========================================================
     RESEARCH FOCUS CLUSTERS
     ======================================================== -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 reveal-on-scroll">
    <div class="text-center max-w-2xl mx-auto mb-16">
        <span class="text-xs font-bold uppercase tracking-wider text-maroon-800 bg-rose-50 px-3 py-1 rounded-full border border-rose-200">
            Fokus &amp; Keilmuan
        </span>
        <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 font-heading mt-3">
            Bidang Riset Puzzle Research
        </h2>
        <p class="text-sm text-gray-500 mt-1">
            Predatech berfokus pada inovasi komputasi cerdas berbasis data terapan di industri, pemerintahan, dan lingkungan.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- 1: Data Mining -->
        <div class="p-6 rounded-2xl bg-white border border-rose-100 shadow-sm hover-lift group">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-maroon-800 to-rose-700 text-white flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition-transform shadow-md">
                <i class="fa-solid fa-database"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900 font-heading mb-2">Data Mining &amp; Analytics</h3>
            <p class="text-xs text-gray-500 leading-relaxed">
                Eksplorasi pola tersembunyi, klasifikasi Naïve Bayes, Random Forest, Decision Tree, asosiasi pasar, dan klasterisasi data skala besar.
            </p>
        </div>

        <!-- 2: Machine Learning & AI -->
        <div class="p-6 rounded-2xl bg-white border border-rose-100 shadow-sm hover-lift group">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-maroon-800 to-rose-700 text-white flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition-transform shadow-md">
                <i class="fa-solid fa-brain"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900 font-heading mb-2">Machine Learning &amp; AI</h3>
            <p class="text-xs text-gray-500 leading-relaxed">
                Model pembelajaran mesin, deep learning, computer vision, prediksi berbasis deret waktu, dan otomasi cerdas.
            </p>
        </div>

        <!-- 3: IoT & Embedded Systems -->
        <div class="p-6 rounded-2xl bg-white border border-rose-100 shadow-sm hover-lift group">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-maroon-800 to-rose-700 text-white flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition-transform shadow-md">
                <i class="fa-solid fa-microchip"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900 font-heading mb-2">IoT &amp; Smart Devices</h3>
            <p class="text-xs text-gray-500 leading-relaxed">
                Pengembangan perangkat sensorik pintar, smart agriculture monitoring, otomasi jaringan mikrotik, dan telemetri energi cerdas.
            </p>
        </div>

        <!-- 4: Knowledge Management -->
        <div class="p-6 rounded-2xl bg-white border border-rose-100 shadow-sm hover-lift group">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-maroon-800 to-rose-700 text-white flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition-transform shadow-md">
                <i class="fa-solid fa-diagram-project"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900 font-heading mb-2">Knowledge Management &amp; DSS</h3>
            <p class="text-xs text-gray-500 leading-relaxed">
                Sistem pendukung keputusan analitik hirarki (AHP), representasi ontologi pengetahuan, fuzzy logic, dan enterprise digital architecture.
            </p>
        </div>
    </div>
</section>

<!-- ========================================================
     TIMELINE & TIM PENGEMBANG (Directly matching PDF Page 6)
     ======================================================== -->
<section id="timeline-team" class="bg-gradient-to-b from-[#35020f] to-[#4c0519] text-white py-20 border-t border-rose-950 relative overflow-hidden">
    <!-- Glow elements -->
    <div class="absolute -top-20 -left-20 w-80 h-80 bg-rose-600/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-20 -right-20 w-80 h-80 bg-red-600/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-amber-300 bg-amber-400/10 px-3.5 py-1 rounded-full border border-amber-400/30">
                <i class="fa-solid fa-code"></i> Metode Extreme Programming
            </span>
            <h2 class="text-2xl sm:text-4xl font-extrabold font-heading mt-3">
                Timeline Pengembangan &amp; Tim POSMA
            </h2>
            <p class="text-sm text-rose-200/80 mt-2">
                Dokumentasi alur rekayasa perangkat lunak, tim pengembang, serta output HKI Kemenkumham resmi dari sistem POSMA Predatech.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
            
            <!-- Left: Extreme Programming Timeline Table (PDF Page 6) -->
            <div class="lg:col-span-7 bg-white/5 rounded-2xl p-6 border border-white/10 backdrop-blur-md shadow-2xl">
                <h3 class="text-lg font-bold text-white font-heading mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-calendar-check text-rose-400"></i>
                    <span>Jadwal Pengerjaan (Januari – Februari)</span>
                </h3>

                <div class="overflow-x-auto">
                    <table class="w-full text-xs text-left">
                        <thead>
                            <tr class="border-b border-rose-900/60 text-rose-300">
                                <th class="py-2.5 px-3">No</th>
                                <th class="py-2.5 px-3">Pekerjaan</th>
                                <th class="py-2.5 px-2 text-center">M4 (Jan)</th>
                                <th class="py-2.5 px-2 text-center">M1 (Feb)</th>
                                <th class="py-2.5 px-2 text-center">M2</th>
                                <th class="py-2.5 px-2 text-center">M3</th>
                                <th class="py-2.5 px-2 text-center">M4</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-rose-900/40 text-rose-100">
                            <tr>
                                <td class="py-3 px-3 font-bold text-rose-400">1</td>
                                <td class="py-3 px-3 font-medium">Perencanaan, Desain Tabel &amp; Tampilan Sistem</td>
                                <td class="py-3 px-2 text-center"><span class="inline-block w-5 h-5 rounded bg-emerald-500/80"></span></td>
                                <td class="py-3 px-2 text-center">-</td>
                                <td class="py-3 px-2 text-center">-</td>
                                <td class="py-3 px-2 text-center">-</td>
                                <td class="py-3 px-2 text-center">-</td>
                            </tr>
                            <tr>
                                <td class="py-3 px-3 font-bold text-rose-400">2</td>
                                <td class="py-3 px-3 font-medium">Desain Seluruh Halaman</td>
                                <td class="py-3 px-2 text-center"><span class="inline-block w-5 h-5 rounded bg-emerald-500/80"></span></td>
                                <td class="py-3 px-2 text-center"><span class="inline-block w-5 h-5 rounded bg-emerald-500/80"></span></td>
                                <td class="py-3 px-2 text-center">-</td>
                                <td class="py-3 px-2 text-center">-</td>
                                <td class="py-3 px-2 text-center">-</td>
                            </tr>
                            <tr>
                                <td class="py-3 px-3 font-bold text-rose-400">3</td>
                                <td class="py-3 px-3 font-medium">Front-End Proses Utama</td>
                                <td class="py-3 px-2 text-center"><span class="inline-block w-5 h-5 rounded bg-emerald-500/80"></span></td>
                                <td class="py-3 px-2 text-center"><span class="inline-block w-5 h-5 rounded bg-emerald-500/80"></span></td>
                                <td class="py-3 px-2 text-center"><span class="inline-block w-5 h-5 rounded bg-emerald-500/80"></span></td>
                                <td class="py-3 px-2 text-center">-</td>
                                <td class="py-3 px-2 text-center">-</td>
                            </tr>
                            <tr>
                                <td class="py-3 px-3 font-bold text-rose-400">4</td>
                                <td class="py-3 px-3 font-medium">Halaman Input Data</td>
                                <td class="py-3 px-2 text-center"><span class="inline-block w-5 h-5 rounded bg-emerald-500/80"></span></td>
                                <td class="py-3 px-2 text-center"><span class="inline-block w-5 h-5 rounded bg-emerald-500/80"></span></td>
                                <td class="py-3 px-2 text-center"><span class="inline-block w-5 h-5 rounded bg-emerald-500/80"></span></td>
                                <td class="py-3 px-2 text-center">-</td>
                                <td class="py-3 px-2 text-center">-</td>
                            </tr>
                            <tr>
                                <td class="py-3 px-3 font-bold text-rose-400">5</td>
                                <td class="py-3 px-3 font-medium">Demo dan Pengujian</td>
                                <td class="py-3 px-2 text-center">-</td>
                                <td class="py-3 px-2 text-center">-</td>
                                <td class="py-3 px-2 text-center"><span class="inline-block w-5 h-5 rounded bg-emerald-500/80"></span></td>
                                <td class="py-3 px-2 text-center"><span class="inline-block w-5 h-5 rounded bg-emerald-500/80"></span></td>
                                <td class="py-3 px-2 text-center">-</td>
                            </tr>
                            <tr>
                                <td class="py-3 px-3 font-bold text-rose-400">6</td>
                                <td class="py-3 px-3 font-medium">Input Data</td>
                                <td class="py-3 px-2 text-center">-</td>
                                <td class="py-3 px-2 text-center">-</td>
                                <td class="py-3 px-2 text-center">-</td>
                                <td class="py-3 px-2 text-center"><span class="inline-block w-5 h-5 rounded bg-emerald-500/80"></span></td>
                                <td class="py-3 px-2 text-center">-</td>
                            </tr>
                            <tr>
                                <td class="py-3 px-3 font-bold text-rose-400">7</td>
                                <td class="py-3 px-3 font-medium">Pendaftaran HKI Kemenkumham</td>
                                <td class="py-3 px-2 text-center">-</td>
                                <td class="py-3 px-2 text-center">-</td>
                                <td class="py-3 px-2 text-center">-</td>
                                <td class="py-3 px-2 text-center">-</td>
                                <td class="py-3 px-2 text-center"><span class="inline-block w-5 h-5 rounded bg-amber-400 text-maroon-950 font-bold flex items-center justify-center">✓</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Output & Benefit Box -->
                <div class="mt-6 p-4 rounded-xl bg-rose-950/70 border border-rose-800/40">
                    <h4 class="text-sm font-bold text-amber-300 uppercase tracking-wider mb-2 flex items-center gap-2">
                        <i class="fa-solid fa-trophy text-amber-400"></i>
                        <span>Output dan Benefit Sistem:</span>
                    </h4>
                    <ol class="list-decimal list-inside text-xs text-rose-100/90 space-y-1.5 leading-relaxed">
                        <li>Sistem dan Manual Penggunaan Sistem POSMA</li>
                        <li>Hak Kekayaan Intelektual (HKI) Kemenkumham untuk Semua Pengembang</li>
                        <li>SK Dekan Sebagai Portofolio Programmer dan Pengembang Sistem Kampus</li>
                        <li>Sertifikat Penghargaan Dekan FST UIN Suska Riau</li>
                        <li>Penghargaan di Big Event 2025 dari UIN Suska Riau</li>
                    </ol>
                </div>
            </div>

            <!-- Right: Team Pengembang List (PDF Page 6) -->
            <div class="lg:col-span-5 space-y-6">
                <!-- Team Pengembang Card -->
                <div class="bg-white/5 rounded-2xl p-6 border border-white/10 backdrop-blur-md shadow-2xl">
                    <h3 class="text-lg font-bold text-white font-heading mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-laptop-code text-rose-400"></i>
                        <span>Team Pengembang Sistem</span>
                    </h3>
                    <ul class="space-y-2.5 text-xs">
                        <li class="flex items-center justify-between p-2 rounded-lg bg-white/5 border border-white/5">
                            <span class="font-bold text-white">1. Yoga Disastro</span>
                            <span class="px-2 py-0.5 rounded-full bg-rose-500/20 text-rose-300 font-bold border border-rose-500/30">Lead Developer</span>
                        </li>
                        <li class="flex items-center justify-between p-2 rounded-lg bg-white/5 border border-white/5">
                            <span class="font-medium text-rose-100">2. Afif Fatin</span>
                            <span class="text-rose-300/80">Developer</span>
                        </li>
                        <li class="flex items-center justify-between p-2 rounded-lg bg-white/5 border border-white/5">
                            <span class="font-medium text-rose-100">3. Anggi Mulya</span>
                            <span class="text-rose-300/80">Developer</span>
                        </li>
                        <li class="flex items-center justify-between p-2 rounded-lg bg-white/5 border border-white/5">
                            <span class="font-medium text-rose-100">4. Raka Sabri</span>
                            <span class="text-rose-300/80">Developer</span>
                        </li>
                        <li class="flex items-center justify-between p-2 rounded-lg bg-white/5 border border-white/5">
                            <span class="font-medium text-rose-100">5. Kia Kurniawan</span>
                            <span class="text-rose-300/80">Developer</span>
                        </li>
                        <li class="flex items-center justify-between p-2 rounded-lg bg-white/5 border border-white/5">
                            <span class="font-medium text-rose-100">6. Nasya Amirah Mulyani</span>
                            <span class="text-rose-300/80">Developer</span>
                        </li>
                        <li class="flex items-center justify-between p-2 rounded-lg bg-white/5 border border-white/5">
                            <span class="font-medium text-rose-100">7. Fahryan Rizki Pratama</span>
                            <span class="text-rose-300/80">Developer</span>
                        </li>
                        <li class="flex items-center justify-between p-2 rounded-lg bg-white/5 border border-white/5">
                            <span class="font-medium text-rose-100">8. Novrian Pratama Siregar</span>
                            <span class="text-rose-300/80">Developer</span>
                        </li>
                    </ul>
                </div>

                <!-- Team Pengumpul Data -->
                <div class="bg-white/5 rounded-2xl p-6 border border-white/10 backdrop-blur-md shadow-2xl">
                    <h3 class="text-lg font-bold text-white font-heading mb-3 flex items-center gap-2">
                        <i class="fa-solid fa-clipboard-list text-amber-400"></i>
                        <span>Team Pengumpul &amp; Input Data</span>
                    </h3>
                    <div class="space-y-2 text-xs">
                        <div class="flex items-center justify-between p-2.5 rounded-lg bg-white/5 border border-white/5">
                            <span class="font-bold text-white">Vina Wulandari</span>
                            <span class="px-2 py-0.5 rounded-full bg-amber-400/20 text-amber-300 font-bold border border-amber-400/30">Lead Pengumpul Data</span>
                        </div>
                        <p class="text-rose-200/80 text-[11px] px-2 pt-1">
                            Didukung oleh Ketua Divisi dari 4 orang masing-masing divisi riset Predatech UIN Suska Riau.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<?= $this->endSection() ?>
