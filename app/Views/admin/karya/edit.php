<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="max-w-4xl mx-auto space-y-6"
     x-data="{
         anggotaList: <?= htmlspecialchars(json_encode(array_map(function($a) {
             return ['id' => $a['id_anggota'], 'name' => $a['nama_anggota']];
         }, $anggotaList)), ENT_QUOTES, 'UTF-8') ?>,
         selectedAnggotaId: '<?= old('id_anggota', $karya['id_anggota']) ?>',
         penulisPertama: '<?= old('penulis_pertama', $karya['penulis_pertama']) ?>',

         onAnggotaChange() {
             const found = this.anggotaList.find(a => a.id == this.selectedAnggotaId);
             if (found) {
                 this.penulisPertama = found.name;
             }
         }
     }">
    
    <!-- Top Action Bar -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-black text-gray-900 font-heading">Edit Karya &amp; Publikasi</h1>
            <p class="text-xs text-gray-500">Perbarui informasi metadata publikasi ilmiah</p>
        </div>
        <a href="<?= base_url('admin/karya') ?>" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 transition-colors">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali</span>
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 sm:p-8">
        <form action="<?= base_url('admin/karya/update/' . $karya['id_karya']) ?>" method="POST" class="space-y-6">
            <?= csrf_field() ?>

            <div class="border-b border-gray-100 pb-3">
                <h3 class="text-base font-bold text-gray-900 font-heading">Edit Data Karya #<?= esc($karya['id_karya']) ?></h3>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 text-xs">
                
                <!-- 2. id_anggota (Foreign Key Tabel Anggota) -->
                <div>
                    <label class="block font-bold uppercase text-gray-700 mb-1">
                        2. Anggota Pengusul <span class="text-red-500">*</span>
                    </label>
                    <select name="id_anggota" 
                            x-model="selectedAnggotaId" 
                            @change="onAnggotaChange()"
                            required 
                            class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-maroon-800 focus:outline-none font-semibold text-gray-900">
                        <?php foreach ($anggotaList as $a): ?>
                            <option value="<?= $a['id_anggota'] ?>" <?= ($karya['id_anggota'] == $a['id_anggota']) ? 'selected' : '' ?>>
                                <?= esc($a['nama_anggota']) ?> (NIM: <?= esc($a['id_anggota']) ?> - <?= esc($a['program_studi']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- 5. id_kategori (Foreign Key Tabel Kategori) -->
                <div>
                    <label class="block font-bold uppercase text-gray-700 mb-1">
                        5. Kategori / Pengindeksan <span class="text-red-500">*</span>
                    </label>
                    <select name="id_kategori" required class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-maroon-800 focus:outline-none">
                        <?php foreach ($kategoriList as $kat): ?>
                            <option value="<?= $kat['id_kategori'] ?>" <?= ($karya['id_kategori'] == $kat['id_kategori']) ? 'selected' : '' ?>>
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
                        <option value="Jurnal" <?= ($karya['jenis_karya'] == 'Jurnal') ? 'selected' : '' ?>>Jurnal</option>
                        <option value="Prosiding" <?= ($karya['jenis_karya'] == 'Prosiding') ? 'selected' : '' ?>>Prosiding</option>
                        <option value="HKI" <?= ($karya['jenis_karya'] == 'HKI') ? 'selected' : '' ?>>HKI / Paten</option>
                        <option value="Buku" <?= ($karya['jenis_karya'] == 'Buku') ? 'selected' : '' ?>>Buku</option>
                        <option value="Sistem dan Aplikasi" <?= ($karya['jenis_karya'] == 'Sistem dan Aplikasi') ? 'selected' : '' ?>>Sistem dan Aplikasi</option>
                    </select>
                </div>

                <!-- 4. level_karya -->
                <div>
                    <label class="block font-bold uppercase text-gray-700 mb-1">
                        4. Level Karya <span class="text-red-500">*</span>
                    </label>
                    <select name="level_karya" required class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-maroon-800 focus:outline-none">
                        <option value="Internasional" <?= ($karya['level_karya'] == 'Internasional') ? 'selected' : '' ?>>Internasional</option>
                        <option value="Nasional" <?= ($karya['level_karya'] == 'Nasional') ? 'selected' : '' ?>>Nasional</option>
                        <option value="Lokal" <?= ($karya['level_karya'] == 'Lokal') ? 'selected' : '' ?>>Lokal</option>
                    </select>
                </div>

                <!-- 6. judul_karya -->
                <div class="sm:col-span-2">
                    <label class="block font-bold uppercase text-gray-700 mb-1">
                        6. Judul Karya / Artikel Ilmiah <span class="text-red-500">*</span>
                    </label>
                    <textarea name="judul_karya" rows="3" required
                              class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-maroon-800 focus:outline-none font-medium leading-relaxed"><?= old('judul_karya', $karya['judul_karya']) ?></textarea>
                </div>

                <!-- 7. penulis_pertama -->
                <div>
                    <label class="block font-bold uppercase text-gray-700 mb-1">
                        7. Penulis Pertama <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="penulis_pertama" 
                           x-model="penulisPertama" 
                           required 
                           class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-maroon-800 focus:outline-none font-semibold text-gray-900">
                </div>

                <!-- 8. penulis_semua -->
                <div>
                    <label class="block font-bold uppercase text-gray-700 mb-1">
                        8. Penulis Semua (Penulis 2, 3 dst)
                    </label>
                    <input type="text" name="penulis_semua" value="<?= old('penulis_semua', $karya['penulis_semua']) ?>"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-maroon-800 focus:outline-none">
                </div>

                <!-- 9. nama_terbitan -->
                <div>
                    <label class="block font-bold uppercase text-gray-700 mb-1">
                        9. Nama Terbitan / Nama Jurnal
                    </label>
                    <input type="text" name="nama_terbitan" value="<?= old('nama_terbitan', $karya['nama_terbitan']) ?>"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-maroon-800 focus:outline-none italic">
                </div>

                <!-- 10. penerbit -->
                <div>
                    <label class="block font-bold uppercase text-gray-700 mb-1">
                        10. Penerbit
                    </label>
                    <input type="text" name="penerbit" value="<?= old('penerbit', $karya['penerbit']) ?>"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-maroon-800 focus:outline-none">
                </div>

                <!-- 11. volume -->
                <div>
                    <label class="block font-bold uppercase text-gray-700 mb-1">
                        11. Volume
                    </label>
                    <input type="text" name="volume" value="<?= old('volume', $karya['volume']) ?>"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-maroon-800 focus:outline-none font-mono">
                </div>

                <!-- 12. nomor -->
                <div>
                    <label class="block font-bold uppercase text-gray-700 mb-1">
                        12. Nomor
                    </label>
                    <input type="text" name="nomor" value="<?= old('nomor', $karya['nomor']) ?>"
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
                            <option value="<?= $y ?>" <?= ($karya['tahun_terbit'] == $y) ? 'selected' : '' ?>>
                                <?= $y ?>
                            </option>
                        <?php endfor; ?>
                    </select>
                </div>

                <!-- 14. link_karya -->
                <div>
                    <label class="block font-bold uppercase text-gray-700 mb-1">
                        14. Link Karya / URL Online
                    </label>
                    <input type="url" name="link_karya" value="<?= old('link_karya', $karya['link_karya']) ?>"
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
                    <span>Perbarui Karya</span>
                </button>
            </div>

        </form>
    </div>

</div>

<?= $this->endSection() ?>
