<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Dashboard - POSMA Predatech') ?></title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Tailwind CSS (Play CDN) -->
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
                            dark: '#4c0519',
                            deep: '#35020f',
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
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= base_url('css/posma.css') ?>">
    <script src="<?= base_url('js/posma.js') ?>" defer></script>
</head>
<body class="bg-gray-100 text-gray-800 antialiased selection:bg-maroon-800 selection:text-white"
      x-data="{ 
          sidebarOpen: false, 
          userMenuOpen: false 
      }">

    <div class="flex h-screen overflow-hidden">
        
        <!-- SIDEBAR -->
        <aside class="fixed inset-y-0 left-0 z-50 w-64 bg-gradient-to-b from-[#4c0519] via-[#3d0313] to-[#25010a] text-white flex flex-col transition-transform duration-300 transform md:translate-x-0 md:static md:inset-0 shadow-2xl"
               :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
            
            <!-- Sidebar Header / Logo -->
            <div class="h-20 flex items-center justify-between px-6 border-b border-rose-950/60 bg-black/10">
                <a href="<?= base_url() ?>" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-maroon-600 to-rose-700 flex items-center justify-center shadow-lg group-hover:rotate-6 transition-transform">
                        <i class="fa-solid fa-puzzle-piece text-white text-xl"></i>
                    </div>
                    <div>
                        <span class="text-lg font-black tracking-wider text-white font-heading">POSMA</span>
                        <p class="text-[10px] text-rose-300 font-bold uppercase tracking-widest -mt-1">PREDATECH</p>
                    </div>
                </a>
                <button @click="sidebarOpen = false" class="md:hidden text-rose-300 hover:text-white">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            <!-- Current User Quick Card -->
            <div class="px-6 py-4 mx-3 my-4 rounded-xl bg-white/5 border border-white/10 flex items-center gap-3 backdrop-blur-sm">
                <div class="w-11 h-11 rounded-full bg-gradient-to-tr from-maroon-600 to-amber-500 p-0.5 shadow-md flex-shrink-0">
                    <div class="w-full h-full rounded-full bg-[#4c0519] flex items-center justify-center text-white font-bold text-sm">
                        <?= strtoupper(substr(session()->get('nama_user') ?? 'U', 0, 1)) ?>
                    </div>
                </div>
                <div class="overflow-hidden">
                    <h4 class="text-sm font-bold text-white truncate"><?= esc(session()->get('nama_user')) ?></h4>
                    <span class="inline-flex items-center gap-1 text-[11px] font-semibold px-2 py-0.5 rounded-full <?= (session()->get('level') === 'Admin') ? 'bg-amber-500/20 text-amber-300 border border-amber-500/30' : ((session()->get('level') === 'Operator') ? 'bg-sky-500/20 text-sky-300 border border-sky-500/30' : 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30') ?>">
                        <i class="fa-solid fa-circle text-[6px]"></i> <?= esc(session()->get('level')) ?>
                    </span>
                </div>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 px-3 space-y-1 overflow-y-auto">
                <div class="px-3 pb-1 text-[11px] font-bold uppercase text-rose-300/60 tracking-wider">Menu Utama</div>

                <a href="<?= base_url('dashboard') ?>" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 <?= (current_url() == base_url('dashboard')) ? 'bg-maroon-600/40 text-white border-l-4 border-rose-500 shadow-md' : 'text-rose-200/80 hover:bg-white/10 hover:text-white' ?>">
                    <i class="fa-solid fa-gauge-high text-base w-5 text-center text-rose-400"></i>
                    <span>Dashboard</span>
                </a>

                <a href="<?= base_url('admin/anggota') ?>" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 <?= (strpos(current_url(), 'admin/anggota') !== false) ? 'bg-maroon-600/40 text-white border-l-4 border-rose-500 shadow-md' : 'text-rose-200/80 hover:bg-white/10 hover:text-white' ?>">
                    <i class="fa-solid fa-user-graduate text-base w-5 text-center text-rose-400"></i>
                    <span>Data Anggota</span>
                </a>

                <a href="<?= base_url('admin/karya') ?>" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 <?= (strpos(current_url(), 'admin/karya') !== false) ? 'bg-maroon-600/40 text-white border-l-4 border-rose-500 shadow-md' : 'text-rose-200/80 hover:bg-white/10 hover:text-white' ?>">
                    <i class="fa-solid fa-book-open text-base w-5 text-center text-rose-400"></i>
                    <span>Data Karya & Publikasi</span>
                </a>

                <?php if (in_array(session()->get('level'), ['Admin', 'Operator'])): ?>
                    <a href="<?= base_url('admin/kategori') ?>" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 <?= (strpos(current_url(), 'admin/kategori') !== false) ? 'bg-maroon-600/40 text-white border-l-4 border-rose-500 shadow-md' : 'text-rose-200/80 hover:bg-white/10 hover:text-white' ?>">
                        <i class="fa-solid fa-tags text-base w-5 text-center text-rose-400"></i>
                        <span>Kategori & Indexing</span>
                    </a>
                <?php endif; ?>

                <?php if (session()->get('level') === 'Admin'): ?>
                    <div class="px-3 pt-4 pb-1 text-[11px] font-bold uppercase text-rose-300/60 tracking-wider">Konfigurasi</div>
                    <a href="<?= base_url('admin/users') ?>" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 <?= (strpos(current_url(), 'admin/users') !== false) ? 'bg-maroon-600/40 text-white border-l-4 border-rose-500 shadow-md' : 'text-rose-200/80 hover:bg-white/10 hover:text-white' ?>">
                        <i class="fa-solid fa-users-gear text-base w-5 text-center text-rose-400"></i>
                        <span>Manajemen Pengguna</span>
                    </a>
                <?php endif; ?>

                <div class="px-3 pt-4 pb-1 text-[11px] font-bold uppercase text-rose-300/60 tracking-wider">Akun & Portal</div>

                <a href="<?= base_url('ubah-password') ?>" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 <?= (current_url() == base_url('ubah-password')) ? 'bg-maroon-600/40 text-white border-l-4 border-rose-500 shadow-md' : 'text-rose-200/80 hover:bg-white/10 hover:text-white' ?>">
                    <i class="fa-solid fa-key text-base w-5 text-center text-rose-400"></i>
                    <span>Ubah Password</span>
                </a>

                <a href="<?= base_url() ?>" target="_blank"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold text-rose-200/80 hover:bg-white/10 hover:text-white transition-all duration-200">
                    <i class="fa-solid fa-globe text-base w-5 text-center text-rose-400"></i>
                    <span>Lihat Portal Publik <i class="fa-solid fa-arrow-up-right-from-square text-[10px] ml-1"></i></span>
                </a>
            </nav>

            <!-- Logout Link Bottom -->
            <div class="p-4 border-t border-rose-950/60">
                <a href="<?= base_url('logout') ?>" 
                   onclick="return confirm('Apakah Anda yakin ingin keluar dari sistem?')"
                   class="w-full flex items-center justify-center gap-2 py-2.5 rounded-xl text-sm font-bold text-rose-200 bg-rose-950/80 hover:bg-rose-900 hover:text-white transition-colors border border-rose-900/50">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span>Logout</span>
                </a>
            </div>
        </aside>

        <!-- Overlay backdrop for mobile -->
        <div x-show="sidebarOpen" 
             @click="sidebarOpen = false" 
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-black/60 z-40 md:hidden"></div>

        <!-- MAIN CONTENT AREA -->
        <div class="flex-1 flex flex-col overflow-y-auto">
            
            <!-- Top App Bar -->
            <header class="h-20 bg-white border-b border-gray-200 px-6 flex items-center justify-between sticky top-0 z-30 shadow-sm">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = true" class="md:hidden p-2 text-gray-600 hover:text-maroon-900">
                        <i class="fa-solid fa-bars text-xl"></i>
                    </button>
                    <div>
                        <h2 class="text-xl font-extrabold text-gray-900 font-heading">
                            <?= esc($title ?? 'Dashboard') ?>
                        </h2>
                        <p class="text-xs text-gray-500 hidden sm:block">
                            Sistem Informasi Repository & Manajemen Alumni Predatech
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <!-- Quick Portal Link -->
                    <a href="<?= base_url() ?>" target="_blank" class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold text-maroon-800 bg-rose-50 hover:bg-rose-100 transition-colors">
                        <i class="fa-solid fa-arrow-up-right-from-square text-[11px]"></i>
                        <span>Lihat Portal</span>
                    </a>

                    <!-- User Dropdown Menu -->
                    <div class="relative" @click.away="userMenuOpen = false">
                        <button @click="userMenuOpen = !userMenuOpen" 
                                class="flex items-center gap-3 p-1.5 rounded-xl hover:bg-gray-100 transition-colors">
                            <div class="w-9 h-9 rounded-full bg-maroon-900 text-white flex items-center justify-center font-bold text-sm shadow-sm">
                                <?= strtoupper(substr(session()->get('nama_user') ?? 'U', 0, 1)) ?>
                            </div>
                            <div class="text-left hidden md:block">
                                <p class="text-xs font-bold text-gray-800 leading-tight"><?= esc(session()->get('nama_user')) ?></p>
                                <p class="text-[10px] text-gray-500 font-medium"><?= esc(session()->get('level')) ?></p>
                            </div>
                            <i class="fa-solid fa-chevron-down text-xs text-gray-400"></i>
                        </button>

                        <div x-show="userMenuOpen" 
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-100"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-2xl border border-gray-100 py-2 z-50">
                            <div class="px-4 py-2 border-b border-gray-100">
                                <p class="text-xs text-gray-500">Signed in as</p>
                                <p class="text-sm font-bold text-gray-900 truncate"><?= esc(session()->get('username')) ?></p>
                            </div>
                            <a href="<?= base_url('ubah-password') ?>" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-rose-50 hover:text-maroon-900">
                                <i class="fa-solid fa-key text-xs text-maroon-700 w-4"></i> Ubah Password
                            </a>
                            <?php if (session()->get('id_anggota')): ?>
                                <a href="<?= base_url('anggota/' . session()->get('id_anggota')) ?>" target="_blank" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-rose-50 hover:text-maroon-900">
                                    <i class="fa-solid fa-id-badge text-xs text-maroon-700 w-4"></i> Lihat Profil Publik
                                </a>
                            <?php endif; ?>
                            <div class="border-t border-gray-100 mt-1"></div>
                            <a href="<?= base_url('logout') ?>" onclick="return confirm('Yakin ingin logout?')" class="flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                <i class="fa-solid fa-right-from-bracket text-xs w-4"></i> Keluar
                            </a>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Alerts Container -->
            <div class="px-6 pt-6">
                <?php if (session()->getFlashdata('success')): ?>
                    <div x-data="{ show: true }" x-show="show" class="mb-4 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between shadow-sm animate-entrance-down">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
                            <span class="text-sm font-semibold"><?= session()->getFlashdata('success') ?></span>
                        </div>
                        <button @click="show = false" class="text-emerald-500 hover:text-emerald-800"><i class="fa-solid fa-xmark"></i></button>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')): ?>
                    <div x-data="{ show: true }" x-show="show" class="mb-4 p-4 rounded-xl bg-red-50 border border-red-200 text-red-800 flex items-center justify-between shadow-sm animate-entrance-down">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-circle-exclamation text-red-600 text-lg"></i>
                            <span class="text-sm font-semibold"><?= session()->getFlashdata('error') ?></span>
                        </div>
                        <button @click="show = false" class="text-red-500 hover:text-red-800"><i class="fa-solid fa-xmark"></i></button>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('errors')): ?>
                    <div x-data="{ show: true }" x-show="show" class="mb-4 p-4 rounded-xl bg-red-50 border border-red-200 text-red-800 shadow-sm animate-entrance-down">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-2 font-bold text-sm">
                                <i class="fa-solid fa-circle-xmark text-red-600"></i>
                                <span>Terdapat beberapa kesalahan pengisian form:</span>
                            </div>
                            <button @click="show = false" class="text-red-500 hover:text-red-800"><i class="fa-solid fa-xmark"></i></button>
                        </div>
                        <ul class="list-disc list-inside text-xs space-y-1 text-red-700">
                            <?php foreach (session()->getFlashdata('errors') as $err): ?>
                                <li><?= esc($err) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Page Specific Content -->
            <main class="p-6 flex-grow">
                <?= $this->renderSection('content') ?>
            </main>

            <!-- Admin Footer -->
            <footer class="bg-white border-t border-gray-200 px-6 py-4 text-xs text-gray-500 flex flex-col sm:flex-row items-center justify-between gap-2">
                <span>&copy; <?= date('Y') ?> POSMA PREDATECH &bull; UIN Suska Riau. All rights reserved.</span>
                <span class="text-[11px] text-gray-400">Extreme Programming Architecture &bull; CodeIgniter 4 + TailwindCSS</span>
            </footer>
        </div>
    </div>

</body>
</html>
