<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Login Sistem POSMA Predatech') ?></title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
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
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= base_url('css/posma.css') ?>">
</head>
<body class="bg-gradient-to-br from-[#2a010b] via-[#4c0519] to-[#700b25] min-h-screen flex items-center justify-center p-4 relative overflow-hidden font-sans selection:bg-rose-500 selection:text-white"
      x-data="{ showPassword: false }">

    <!-- Ambient Floating Orbs -->
    <div class="absolute -top-20 -left-20 w-96 h-96 bg-rose-600/20 rounded-full blur-3xl animate-float pointer-events-none"></div>
    <div class="absolute -bottom-20 -right-20 w-96 h-96 bg-amber-500/15 rounded-full blur-3xl animate-float pointer-events-none" style="animation-delay: -3s;"></div>

    <!-- Back to Home floating pill -->
    <div class="absolute top-6 left-6 z-20">
        <a href="<?= base_url() ?>" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white/10 hover:bg-white/20 text-white text-xs font-bold backdrop-blur-md border border-white/20 transition-all">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Beranda</span>
        </a>
    </div>

    <!-- Main Login Card (Glassmorphism & Maroon Glow) -->
    <div class="w-full max-w-md bg-white/95 backdrop-blur-xl rounded-3xl shadow-2xl shadow-black/40 border border-white/80 p-8 sm:p-10 relative z-10 animate-entrance-up">
        
        <!-- Header / Logo -->
        <div class="text-center mb-8">
            <div class="inline-flex w-16 h-16 rounded-2xl bg-gradient-to-br from-maroon-900 to-rose-700 text-white items-center justify-center text-3xl shadow-lg shadow-maroon-950/30 mb-3 rotate-3 hover:rotate-6 transition-transform">
                <i class="fa-solid fa-puzzle-piece"></i>
            </div>
            <h1 class="text-2xl font-black text-gray-900 font-heading tracking-tight">
                POSMA PREDATECH
            </h1>
            <p class="text-xs font-semibold text-gray-500 mt-1 uppercase tracking-wider">
                Sistem Informasi Repository &amp; Alumni
            </p>
        </div>

        <!-- Flash Messages -->
        <?php if (session()->getFlashdata('error')): ?>
            <div class="mb-5 p-3.5 rounded-xl bg-red-50 border border-red-200 text-red-800 text-xs font-semibold flex items-center gap-2.5">
                <i class="fa-solid fa-circle-exclamation text-red-600 text-sm flex-shrink-0"></i>
                <span><?= session()->getFlashdata('error') ?></span>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="mb-5 p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center gap-2.5">
                <i class="fa-solid fa-circle-check text-emerald-600 text-sm flex-shrink-0"></i>
                <span><?= session()->getFlashdata('success') ?></span>
            </div>
        <?php endif; ?>

        <!-- Login Form -->
        <form action="<?= base_url('login/process') ?>" method="POST" class="space-y-5">
            <?= csrf_field() ?>

            <!-- Username Field -->
            <div>
                <label for="username" class="block text-xs font-bold uppercase text-gray-600 tracking-wider mb-1.5">
                    Username
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                        <i class="fa-solid fa-user text-xs"></i>
                    </span>
                    <input type="text" 
                           id="username" 
                           name="username" 
                           value="<?= old('username') ?>"
                           required 
                           placeholder="Masukkan username Anda"
                           class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 focus:border-maroon-800 focus:ring-2 focus:ring-maroon-800/20 text-sm font-medium text-gray-800 focus:outline-none transition-all">
                </div>
            </div>

            <!-- Password Field -->
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label for="password" class="block text-xs font-bold uppercase text-gray-600 tracking-wider">
                        Password
                    </label>
                </div>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                        <i class="fa-solid fa-lock text-xs"></i>
                    </span>
                    <input :type="showPassword ? 'text' : 'password'" 
                           id="password" 
                           name="password" 
                           required 
                           placeholder="••••••••"
                           class="w-full pl-10 pr-10 py-3 rounded-xl border border-gray-200 focus:border-maroon-800 focus:ring-2 focus:ring-maroon-800/20 text-sm font-medium text-gray-800 focus:outline-none transition-all">
                    <button type="button" 
                            @click="showPassword = !showPassword"
                            class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-gray-600">
                        <i class="fa-solid" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                    </button>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" 
                    class="btn-shimmer w-full py-3.5 rounded-xl bg-gradient-to-r from-maroon-900 via-maroon-800 to-rose-900 hover:from-maroon-950 hover:to-rose-950 text-white font-extrabold text-sm shadow-lg shadow-maroon-950/30 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5 active:translate-y-0 flex items-center justify-center gap-2">
                <span>Masuk ke Sistem</span>
                <i class="fa-solid fa-arrow-right text-xs"></i>
            </button>
        </form>

        <!-- Demo Accounts Helper Card -->
        <div class="mt-8 pt-6 border-t border-gray-100">
            <p class="text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2.5 text-center">
                Akun Demo Sistem POSMA:
            </p>
            <div class="grid grid-cols-3 gap-2 text-center text-[10px]">
                <button type="button" 
                        onclick="document.getElementById('username').value='admin'; document.getElementById('password').value='admin123';"
                        class="p-2 rounded-lg bg-rose-50 hover:bg-rose-100 text-maroon-900 font-bold border border-rose-200 transition-colors">
                    Admin
                </button>
                <button type="button" 
                        onclick="document.getElementById('username').value='operator'; document.getElementById('password').value='operator123';"
                        class="p-2 rounded-lg bg-rose-50 hover:bg-rose-100 text-maroon-900 font-bold border border-rose-200 transition-colors">
                    Operator
                </button>
                <button type="button" 
                        onclick="document.getElementById('username').value='nurulgayatri'; document.getElementById('password').value='nurul123';"
                        class="p-2 rounded-lg bg-rose-50 hover:bg-rose-100 text-maroon-900 font-bold border border-rose-200 transition-colors">
                    Anggota
                </button>
            </div>
            <p class="text-[10px] text-gray-400 text-center mt-2">
                Password default: <code>admin123</code> / <code>operator123</code> / <code>nurul123</code>
            </p>
        </div>

    </div>

</body>
</html>
