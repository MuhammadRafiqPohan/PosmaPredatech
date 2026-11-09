<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'POSMA PREDATECH - Sistem Informasi Repository & Alumni') ?></title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    
    <!-- Font Awesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Tailwind CSS (Play CDN with Maroon Customization) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        maroon: {
                            50: '#fff1f2',
                            100: '#ffe4e6',
                            200: '#fecdd3',
                            300: '#fda4af',
                            400: '#fb7185',
                            500: '#f43f5e',
                            600: '#e11d48',
                            700: '#be123c',
                            800: '#9f1239',
                            900: '#800000',
                            950: '#4c0519',
                            base: '#800000',
                            dark: '#4c0519',
                            deep: '#35020f',
                        },
                        gold: {
                            400: '#fbbf24',
                            500: '#f59e0b',
                            600: '#d97706',
                        }
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        heading: ['"Outfit"', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    
    <!-- Alpine.js Plugins & Core -->
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Custom POSMA Stylesheet -->
    <link rel="stylesheet" href="<?= base_url('css/posma.css') ?>">
    <script src="<?= base_url('js/posma.js') ?>" defer></script>
</head>
<body class="bg-[#fafaf9] text-gray-800 antialiased flex flex-col min-h-screen selection:bg-maroon-800 selection:text-white"
      x-data="{ 
          mobileMenuOpen: false, 
          scrolled: false, 
          showBackToTop: false 
      }"
      @scroll.window="
          scrolled = (window.pageYOffset > 40);
          showBackToTop = (window.pageYOffset > 300);
      ">

    <!-- Top Reading Progress Bar (OnScroll Animation) -->
    <div id="scrollProgressBar" class="fixed top-0 left-0 h-1 bg-gradient-to-r from-red-600 via-rose-500 to-amber-400 z-50 transition-all duration-150"></div>

    <!-- Navigation Header -->
    <header class="fixed top-0 left-0 right-0 z-40 transition-all duration-500"
            :class="scrolled ? 'bg-white/95 backdrop-blur-md shadow-lg shadow-maroon-950/5 py-3 border-b border-rose-100' : 'bg-white/80 backdrop-blur-sm py-4 border-b border-rose-50'">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between">
            
            <!-- Logo & Brand -->
            <a href="<?= base_url() ?>" class="flex items-center gap-3.5 group">
                <div class="relative w-12 h-12 rounded-xl bg-gradient-to-br from-maroon-900 to-maroon-700 flex items-center justify-center shadow-md shadow-maroon-950/20 group-hover:scale-105 group-hover:rotate-3 transition-transform duration-300">
                    <i class="fa-solid fa-puzzle-piece text-white text-2xl group-hover:animate-pulse"></i>
                    <span class="absolute -bottom-1 -right-1 w-3.5 h-3.5 bg-emerald-500 border-2 border-white rounded-full"></span>
                </div>
                <div class="flex flex-col">
                    <span class="text-xl font-black tracking-tight text-maroon-900 group-hover:text-maroon-700 transition-colors font-heading flex items-center gap-1.5">
                        POSMA <span class="text-xs px-2 py-0.5 rounded-full bg-rose-100 text-maroon-800 font-bold tracking-normal">PREDATECH</span>
                    </span>
                    <span class="text-[11px] font-medium text-gray-500 -mt-0.5 tracking-wide hidden sm:block">
                        Repository & Manajemen Alumni UIN Suska Riau
                    </span>
                </div>
            </a>

            <!-- Desktop Nav Items -->
            <nav class="hidden md:flex items-center gap-1 lg:gap-2">
                <a href="<?= base_url() ?>" class="px-3.5 py-2 rounded-lg text-sm font-semibold transition-all duration-200 <?= (current_url() == base_url()) ? 'text-maroon-900 bg-rose-50' : 'text-gray-600 hover:text-maroon-900 hover:bg-rose-50/60' ?>">
                    <i class="fa-solid fa-house mr-1.5 text-xs text-maroon-700"></i> Beranda
                </a>
                <a href="<?= base_url('search?type=Anggota') ?>" class="px-3.5 py-2 rounded-lg text-sm font-semibold transition-all duration-200 <?= (isset($type) && $type === 'Anggota') ? 'text-maroon-900 bg-rose-50' : 'text-gray-600 hover:text-maroon-900 hover:bg-rose-50/60' ?>">
                    <i class="fa-solid fa-user-graduate mr-1.5 text-xs text-maroon-700"></i> Data Anggota
                </a>
                <a href="<?= base_url('search?type=Karya') ?>" class="px-3.5 py-2 rounded-lg text-sm font-semibold transition-all duration-200 <?= (isset($type) && $type === 'Karya') ? 'text-maroon-900 bg-rose-50' : 'text-gray-600 hover:text-maroon-900 hover:bg-rose-50/60' ?>">
                    <i class="fa-solid fa-book-open mr-1.5 text-xs text-maroon-700"></i> Repositori Karya
                </a>
                <a href="<?= base_url() ?>#timeline-team" class="px-3.5 py-2 rounded-lg text-sm font-semibold text-gray-600 hover:text-maroon-900 hover:bg-rose-50/60 transition-all duration-200">
                    <i class="fa-solid fa-users mr-1.5 text-xs text-maroon-700"></i> Tim & Timeline
                </a>
            </nav>

            <!-- Action Buttons -->
            <div class="flex items-center gap-3">
                <?php if (session()->get('isLoggedIn')): ?>
                    <a href="<?= base_url('dashboard') ?>" 
                       class="btn-shimmer inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-maroon-900 via-maroon-800 to-rose-900 hover:from-maroon-950 hover:to-rose-800 shadow-md shadow-maroon-950/20 hover:shadow-lg transition-all transform hover:-translate-y-0.5">
                        <i class="fa-solid fa-gauge-high"></i>
                        <span>Dashboard</span>
                    </a>
                <?php else: ?>
                    <a href="<?= base_url('login') ?>" 
                       class="btn-shimmer inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold text-maroon-900 bg-rose-50 hover:bg-maroon-900 hover:text-white border border-rose-200 hover:border-maroon-900 shadow-sm transition-all duration-300 transform hover:-translate-y-0.5">
                        <i class="fa-solid fa-arrow-right-to-bracket"></i>
                        <span>Login Sistem</span>
                    </a>
                <?php endif; ?>

                <!-- Mobile Hamburger Button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" 
                        class="md:hidden p-2.5 rounded-lg text-gray-600 hover:text-maroon-900 hover:bg-rose-50 transition-colors focus:outline-none">
                    <i class="fa-solid" :class="mobileMenuOpen ? 'fa-xmark text-xl' : 'fa-bars text-xl'"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Menu Drawer (Smooth Slide-down) -->
        <div x-show="mobileMenuOpen" 
             x-collapse 
             class="md:hidden bg-white border-b border-rose-100 shadow-xl px-4 pt-2 pb-6 space-y-2">
            <a href="<?= base_url() ?>" class="block px-3 py-2.5 rounded-lg text-sm font-semibold text-gray-700 hover:bg-rose-50 hover:text-maroon-900">
                <i class="fa-solid fa-house mr-2 text-maroon-700"></i> Beranda
            </a>
            <a href="<?= base_url('search?type=Anggota') ?>" class="block px-3 py-2.5 rounded-lg text-sm font-semibold text-gray-700 hover:bg-rose-50 hover:text-maroon-900">
                <i class="fa-solid fa-user-graduate mr-2 text-maroon-700"></i> Data Anggota & Alumni
            </a>
            <a href="<?= base_url('search?type=Karya') ?>" class="block px-3 py-2.5 rounded-lg text-sm font-semibold text-gray-700 hover:bg-rose-50 hover:text-maroon-900">
                <i class="fa-solid fa-book-open mr-2 text-maroon-700"></i> Repositori Karya Ilmiah
            </a>
            <a href="<?= base_url() ?>#timeline-team" class="block px-3 py-2.5 rounded-lg text-sm font-semibold text-gray-700 hover:bg-rose-50 hover:text-maroon-900">
                <i class="fa-solid fa-users mr-2 text-maroon-700"></i> Tim & Timeline
            </a>
            <div class="pt-2 border-t border-rose-100">
                <?php if (session()->get('isLoggedIn')): ?>
                    <a href="<?= base_url('dashboard') ?>" class="block w-full text-center py-2.5 rounded-lg text-sm font-bold text-white bg-maroon-900">
                        Buka Dashboard
                    </a>
                <?php else: ?>
                    <a href="<?= base_url('login') ?>" class="block w-full text-center py-2.5 rounded-lg text-sm font-bold text-white bg-maroon-900">
                        Login Sistem
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <!-- Main Content Slot with top padding for fixed navbar -->
    <main class="flex-grow pt-20">
        <?= $this->renderSection('content') ?>
    </main>

    <!-- Floating Scroll-To-Top Button -->
    <button x-show="showBackToTop" 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-y-4 scale-75"
            x-transition:enter-end="opacity-100 transform translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 transform translate-y-4 scale-75"
            @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
            class="fixed bottom-6 right-6 z-40 p-3.5 rounded-full bg-gradient-to-r from-maroon-900 to-rose-900 text-white shadow-xl shadow-maroon-950/30 hover:shadow-2xl hover:scale-110 active:scale-95 transition-all duration-300 group"
            title="Kembali ke atas">
        <i class="fa-solid fa-arrow-up text-base group-hover:-translate-y-1 transition-transform"></i>
    </button>

    <!-- Footer -->
    <footer class="bg-[#35020f] text-white pt-16 pb-10 border-t-4 border-maroon-600 relative overflow-hidden">
        <!-- Subtle background glow -->
        <div class="absolute -top-32 -right-32 w-96 h-96 bg-maroon-600/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-32 -left-32 w-96 h-96 bg-rose-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 pb-12 border-b border-rose-950">
                
                <!-- Col 1: About Predatech -->
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-maroon-600 to-maroon-800 flex items-center justify-center text-white shadow-md">
                            <i class="fa-solid fa-puzzle-piece text-xl"></i>
                        </div>
                        <span class="text-xl font-black tracking-tight font-heading">POSMA PREDATECH</span>
                    </div>
                    <p class="text-sm text-rose-200/80 leading-relaxed">
                        Sistem Informasi Repository dan Manajemen Alumni (POSMA) PREDATECH — Puzzle Research Data Technology, UIN Sultan Syarif Kasim Riau. Menghimpun karya riset, paten HKI, serta track record alumni pasca kampus.
                    </p>
                    <div class="flex items-center gap-3 pt-2">
                        <a href="https://instagram.com" target="_blank" class="w-8 h-8 rounded-lg bg-white/10 hover:bg-rose-600 flex items-center justify-center text-white transition-colors">
                            <i class="fa-brands fa-instagram text-sm"></i>
                        </a>
                        <a href="https://linkedin.com" target="_blank" class="w-8 h-8 rounded-lg bg-white/10 hover:bg-rose-600 flex items-center justify-center text-white transition-colors">
                            <i class="fa-brands fa-linkedin-in text-sm"></i>
                        </a>
                        <a href="https://github.com" target="_blank" class="w-8 h-8 rounded-lg bg-white/10 hover:bg-rose-600 flex items-center justify-center text-white transition-colors">
                            <i class="fa-brands fa-github text-sm"></i>
                        </a>
                        <a href="mailto:predatech@uin-suska.ac.id" class="w-8 h-8 rounded-lg bg-white/10 hover:bg-rose-600 flex items-center justify-center text-white transition-colors">
                            <i class="fa-solid fa-envelope text-sm"></i>
                        </a>
                    </div>
                </div>

                <!-- Col 2: Navigasi Cepat -->
                <div>
                    <h3 class="text-base font-bold text-white font-heading uppercase tracking-wider mb-4 border-b border-rose-800/40 pb-2">
                        Navigasi Sistem
                    </h3>
                    <ul class="space-y-2 text-sm text-rose-200/80">
                        <li>
                            <a href="<?= base_url() ?>" class="hover:text-white transition-colors flex items-center gap-2">
                                <i class="fa-solid fa-chevron-right text-[10px] text-rose-400"></i> Beranda Utama
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url('search?type=Anggota') ?>" class="hover:text-white transition-colors flex items-center gap-2">
                                <i class="fa-solid fa-chevron-right text-[10px] text-rose-400"></i> Direktori Alumni & Anggota
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url('search?type=Karya') ?>" class="hover:text-white transition-colors flex items-center gap-2">
                                <i class="fa-solid fa-chevron-right text-[10px] text-rose-400"></i> Repositori Jurnal & HKI
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url() ?>#timeline-team" class="hover:text-white transition-colors flex items-center gap-2">
                                <i class="fa-solid fa-chevron-right text-[10px] text-rose-400"></i> Timeline Pengembang & HKI
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url('login') ?>" class="hover:text-white transition-colors flex items-center gap-2">
                                <i class="fa-solid fa-chevron-right text-[10px] text-rose-400"></i> Login Pengelola / Anggota
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Col 3: Research Focus -->
                <div>
                    <h3 class="text-base font-bold text-white font-heading uppercase tracking-wider mb-4 border-b border-rose-800/40 pb-2">
                        Kelompok Riset
                    </h3>
                    <ul class="space-y-2 text-sm text-rose-200/80">
                        <li class="flex items-center gap-2">
                            <i class="fa-solid fa-database text-rose-400 text-xs"></i> Data Mining & Knowledge Discovery
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fa-solid fa-microchip text-rose-400 text-xs"></i> Machine Learning & Artificial Intelligence
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fa-solid fa-wifi text-rose-400 text-xs"></i> Internet of Things (IoT) & Automation
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fa-solid fa-comments text-rose-400 text-xs"></i> Natural Language Processing (NLP)
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fa-solid fa-diagram-project text-rose-400 text-xs"></i> Decision Support Systems (DSS)
                        </li>
                    </ul>
                </div>

                <!-- Col 4: Campus & Contact -->
                <div>
                    <h3 class="text-base font-bold text-white font-heading uppercase tracking-wider mb-4 border-b border-rose-800/40 pb-2">
                        Afiliasi Kampus
                    </h3>
                    <p class="text-sm text-rose-200/80 leading-relaxed mb-3">
                        <strong class="text-white">Fakultas Sains dan Teknologi</strong><br>
                        UIN Sultan Syarif Kasim Riau<br>
                        Jl. HR. Soebrantas KM 15, Tuah Madani, Pekanbaru, Riau 28293
                    </p>
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-rose-950/60 border border-rose-800/50 text-xs text-rose-300">
                        <i class="fa-solid fa-shield-halved text-amber-400"></i>
                        <span>Terdaftar HKI Kemenkumham RI</span>
                    </div>
                </div>

            </div>

            <!-- Bottom Copyright -->
            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between text-xs text-rose-300/70 gap-4">
                <p>&copy; <?= date('Y') ?> POSMA PREDATECH. Hak Cipta Dilindungi Undang-Undang.</p>
                <p class="flex items-center gap-1.5">
                    Dikembangkan dengan <i class="fa-solid fa-heart text-rose-500 animate-pulse"></i> oleh Tim Pengembang POSMA Predatech
                </p>
            </div>
        </div>
    </footer>

</body>
</html>
