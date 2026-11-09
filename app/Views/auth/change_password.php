<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="max-w-2xl mx-auto">
    
    <div class="bg-white rounded-3xl shadow-xl border border-rose-100 overflow-hidden">
        
        <!-- Header -->
        <div class="bg-gradient-to-r from-maroon-900 to-rose-900 px-6 py-5 text-white flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-lg">
                <i class="fa-solid fa-key"></i>
            </div>
            <div>
                <h3 class="text-lg font-bold font-heading">Ubah Password Akun</h3>
                <p class="text-xs text-rose-200">Perbarui kata sandi keamanan Anda secara berkala</p>
            </div>
        </div>

        <form action="<?= base_url('ubah-password/update') ?>" method="POST" class="p-6 sm:p-8 space-y-6">
            <?= csrf_field() ?>

            <!-- Current Password -->
            <div>
                <label for="current_password" class="block text-xs font-bold uppercase text-gray-600 tracking-wider mb-2">
                    Password Saat Ini <span class="text-red-500">*</span>
                </label>
                <input type="password" 
                       id="current_password" 
                       name="current_password" 
                       required 
                       placeholder="Masukkan password yang sedang digunakan"
                       class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-maroon-800 focus:ring-2 focus:ring-maroon-800/20 text-sm font-medium focus:outline-none">
            </div>

            <!-- New Password -->
            <div>
                <label for="new_password" class="block text-xs font-bold uppercase text-gray-600 tracking-wider mb-2">
                    Password Baru <span class="text-red-500">*</span>
                </label>
                <input type="password" 
                       id="new_password" 
                       name="new_password" 
                       required 
                       placeholder="Minimal 6 karakter"
                       class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-maroon-800 focus:ring-2 focus:ring-maroon-800/20 text-sm font-medium focus:outline-none">
                <p class="text-[11px] text-gray-400 mt-1">Gunakan kombinasi huruf, angka, dan simbol untuk keamanan optimal.</p>
            </div>

            <!-- Confirm New Password -->
            <div>
                <label for="confirm_password" class="block text-xs font-bold uppercase text-gray-600 tracking-wider mb-2">
                    Konfirmasi Password Baru <span class="text-red-500">*</span>
                </label>
                <input type="password" 
                       id="confirm_password" 
                       name="confirm_password" 
                       required 
                       placeholder="Ulangi password baru Anda"
                       class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-maroon-800 focus:ring-2 focus:ring-maroon-800/20 text-sm font-medium focus:outline-none">
            </div>

            <!-- Buttons -->
            <div class="pt-4 border-t border-gray-100 flex items-center justify-end gap-3">
                <a href="<?= base_url('dashboard') ?>" class="px-5 py-2.5 rounded-xl text-xs font-bold text-gray-600 hover:bg-gray-100 transition-colors">
                    Batal
                </a>
                <button type="submit" class="btn-shimmer px-6 py-2.5 rounded-xl bg-maroon-900 hover:bg-maroon-950 text-white font-bold text-xs shadow-md transition-all flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Simpan Password Baru</span>
                </button>
            </div>

        </form>

    </div>

</div>

<?= $this->endSection() ?>
