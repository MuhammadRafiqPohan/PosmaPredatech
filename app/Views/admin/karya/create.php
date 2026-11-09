<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="max-w-4xl mx-auto space-y-6"
     x-data="{
         anggotaList: <?= htmlspecialchars(json_encode(array_map(function($a) {
             return ['id' => $a['id_anggota'], 'name' => $a['nama_anggota']];
         }, $anggotaList)), ENT_QUOTES, 'UTF-8') ?>,
         selectedAnggotaId: '<?= $preselectedAnggota ?? old('id_anggota', '') ?>',
         penulisPertama: '<?= old('penulis_pertama', '') ?>',

         onAnggotaChange() {
             const found = this.anggotaList.find(a => a.id == this.selectedAnggotaId);
             if (found) {
                 this.penulisPertama = found.name;
             }
         },

         init() {
             if (this.selectedAnggotaId) {
                 this.onAnggotaChange();
             }
         }
     }">
    
    <!-- Top Action Bar -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-black text-gray-900 font-heading">Tambah Karya &amp; Publikasi Ilmiah</h1>
            <p class="text-xs text-gray-500">Mendaftarkan jurnal, prosiding, buku, atau hak cipta ke repositori POSMA</p>
        </div>
        <a href="<?= base_url('admin/karya') ?>" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 transition-colors">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali</span>
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 sm:p-8">
        <form action="<?= base_url('admin/karya/store') ?>" method="POST" class="space-y-6">
            <?= csrf_field() ?>

            <div class="border-b border-gray-100 pb-3">
                <h3 class="text-base font-bold text-gray-900 font-heading">Form Data Karya (PDF Schema)</h3>
                <p class="text-xs text-gray-500">Isi metadata publikasi dengan lengkap dan akurat</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 text-xs">
                
                <!-- 2. id_anggota (Foreign Key Tabel Anggota) -->
                <div>
                    <label class="block font-bold uppercase text-gray-700 mb-1">
                        2. Anggota Pengusul (Foreign Key) <span class="text-red-500">*</span>
                    </label>
                    <select name="id_anggota" 
                            x-model="selectedAnggotaId" 
                            @change="onAnggotaChange()"
                            required 
                            class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-maroon-800 focus:outline-none font-semibold text-gray-900">
                        <option value="">-- Pilih Anggota / Peneliti --</option>
                        <?php foreach ($anggotaList as $a): ?>
                            <option value="<?= $a['id_anggota'] ?>" <?= ($preselectedAnggota == $a['id_anggota']) ? 'selected' : '' ?>>
                                <?= esc($a['nama_anggota']) ?> (NIM: <?= esc($a['id_anggota']) ?> - <?= esc($a['program_studi']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <span class="text-[10px] text-gray-400">Pilih dari database Anggota Predatech</span>
                </div>

                <!-- 5. id_kategori (Foreign Key Tabel Kategori) -->
                <div>
                    <label class="block font-bold uppercase text-gray-700 mb-1">
                        5. Kategori / Pengindeksan (Foreign Key) <span class="text-red-500">*</span>
                    </label>
                    <select name="id_kategori" required class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-maroon-800 focus:outline-none">
                        <option value="">-- Pilih Kategori --</option>
                        <?php foreach ($kategoriList as $kat): ?>
                            <option value="<?= $kat['id_kategori'] ?>" <?= (old('id_kategori') == $kat['id_kategori']) ? 'selected' : '' ?>>
                                <?= esc($kat['kategori']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- 3. jenis_karya -->
                <div>
                    <label class="block font-bold uppercase text-gray-700 mb-1">
                        3. Jenis Karya <span class="text-red-500">*</span>
                    </label>
                    <select name="jenis_karya" required class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-maroon-800 focus:outline-none font-bold text-maroon-900">
                        <option value="Jurnal" <?= (old('jenis_karya') == 'Jurnal') ? 'selected' : '' ?>>Jurnal</option>
                        <option value="Prosiding" <?= (old('jenis_karya') == 'Prosiding') ? 'selected' : '' ?>>Prosiding</option>
                        <option value="HKI" <?= (old('jenis_karya') == 'HKI') ? 'selected' : '' ?>>HKI / Paten</option>
                        <option value="Buku" <?= (old('jenis_karya') == 'Buku') ? 'selected' : '' ?>>Buku</option>
                        <option value="Sistem dan Aplikasi" <?= (old('jenis_karya') == 'Sistem dan Aplikasi') ? 'selected' : '' ?>>Sistem dan Aplikasi</option>
                    </select>
                </div>

                <!-- 4. level_karya -->
                <div>
                    <label class="block font-bold uppercase text-gray-700 mb-1">
                        4. Level Karya <span class="text-red-500">*</span>
                    </label>
                    <select name="level_karya" required class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-maroon-800 focus:outline-none">
                        <option value="Internasional" <?= (old('level_karya') == 'Internasional') ? 'selected' : '' ?>>Internasional</option>
                        <option value="Nasional" <?= (old('level_karya') == 'Nasional' || !old('level_karya')) ? 'selected' : '' ?>>Nasional</option>
                        <option value="Lokal" <?= (old('level_karya') == 'Lokal') ? 'selected' : '' ?>>Lokal</option>
                    </select>
                </div>

                <!-- 6. judul_karya -->
                <div class="sm:col-span-2">
                    <label class="block font-bold uppercase text-gray-700 mb-1">
                        6. Judul Karya / Artikel Ilmiah <span class="text-red-500">*</span>
                    </label>
                    <textarea name="judul_karya" rows="3" required placeholder="Contoh: Perancangan Sistem Monitoring Cerdas Berbasis IoT..."
                              class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-maroon-800 focus:outline-none font-medium leading-relaxed"><?= old('judul_karya') ?></textarea>
                </div>

                <!-- 7. penulis_pertama (Auto-filled from Anggota selection) -->
                <div>
                    <label class="block font-bold uppercase text-gray-700 mb-1">
                        7. Penulis Pertama (Auto-Complete Anggota) <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="penulis_pertama" 
                           x-model="penulisPertama" 
                           required 
                           placeholder="Nama penulis utama"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-maroon-800 focus:outline-none bg-rose-50/50 font-semibold text-gray-900">
                    <span class="text-[10px] text-gray-400">Terisi otomatis saat memilih anggota di atas</span>
                </div>

                <!-- 8. penulis_semua -->
                <div>
                    <label class="block font-bold uppercase text-gray-700 mb-1">
                        8. Penulis Semua (Penulis 2, 3 dst)
                    </label>
                    <input type="text" name="penulis_semua" value="<?= old('penulis_semua') ?>" placeholder="Contoh: Okfalisa, Inggih Permana, Surya Ramadhan"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-maroon-800 focus:outline-none">
                    <span class="text-[10px] text-gray-400">Pisahkan dengan koma</span>
                </div>

                <!-- 9. nama_terbitan -->
                <div>
                    <label class="block font-bold uppercase text-gray-700 mb-1">
                        9. Nama Terbitan / Nama Jurnal / Konferensi
                    </label>
                    <input type="text" name="nama_terbitan" value="<?= old('nama_terbitan') ?>" placeholder="Contoh: Indonesian Journal of Computing"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-maroon-800 focus:outline-none italic">
                </div>

                <!-- 10. penerbit -->
                <div>
                    <label class="block font-bold uppercase text-gray-700 mb-1">
                        10. Penerbit
                    </label>
                    <input type="text" name="penerbit" value="<?= old('penerbit') ?>" placeholder="Contoh: Universitas Indonesia / IEEE"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-maroon-800 focus:outline-none">
                </div>

                <!-- 11. volume -->
                <div>
                    <label class="block font-bold uppercase text-gray-700 mb-1">
                        11. Volume
                    </label>
                    <input type="text" name="volume" value="<?= old('volume') ?>" placeholder="Contoh: 3"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-maroon-800 focus:outline-none font-mono">
                </div>

                <!-- 12. nomor -->
                <div>
                    <label class="block font-bold uppercase text-gray-700 mb-1">
                        12. Nomor
                    </label>
                    <input type="text" name="nomor" value="<?= old('nomor') ?>" placeholder="Contoh: 2"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-maroon-800 focus:outline-none font-mono">
                </div>

                <!-- 13. tahun_terbit -->
                <div>
                    <label class="block font-bold uppercase text-gray-700 mb-1">
                        13. Tahun Terbit <span class="text-red-500">*</span>
                    </label>
                    <select name="tahun_terbit" required class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-maroon-800 focus:outline-none font-bold">
                        <?php 
                            $currYear = (int)date('Y');
                            for ($y = $currYear + 1; $y >= 2015; $y--): 
                        ?>
                            <option value="<?= $y ?>" <?= ($y == $currYear || old('tahun_terbit') == $y) ? 'selected' : '' ?>>
                                <?= $y ?>
                            </option>
                        <?php endfor; ?>
                    </select>
                </div>

                <!-- 14. link_karya -->
                <div>
                    <label class="block font-bold uppercase text-gray-700 mb-1">
                        14. Link Karya / URL Artikel Online
                    </label>
                    <input type="url" name="link_karya" value="<?= old('link_karya') ?>" placeholder="https://doi.org/10.xxxx atau https://jurnal.ac.id/..."
                           class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-maroon-800 focus:outline-none">
                </div>

            </div>

            <div class="flex justify-end gap-3 pt-6 border-t border-gray-100">
                <a href="<?= base_url('admin/karya') ?>" class="px-5 py-2.5 rounded-xl bg-gray-100 text-gray-700 font-bold text-xs">
                    Batal
                </a>
                <button type="submit" 
                        class="btn-shimmer px-8 py-3 rounded-xl bg-gradient-to-r from-maroon-900 to-rose-900 hover:from-maroon-950 hover:to-rose-950 text-white font-bold text-xs shadow-lg transition-all flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Simpan Karya Ilmiah</span>
                </button>
            </div>

        </form>
    </div>

</div>

<?= $this->endSection() ?>
