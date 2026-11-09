<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="max-w-5xl mx-auto space-y-6" x-data="{ activeTab: 1 }">
    
    <!-- Top Bar -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-black text-gray-900 font-heading">Edit Data Anggota</h1>
            <p class="text-xs text-gray-500">Memperbarui profil anggota: <strong class="text-maroon-800"><?= esc($anggota['nama_anggota']) ?></strong></p>
        </div>
        <a href="<?= base_url('admin/anggota') ?>" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 transition-colors">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali</span>
        </a>
    </div>

    <!-- Stepper / Tabs Header -->
    <div class="bg-white p-2 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between gap-1 overflow-x-auto text-xs font-bold">
        <button type="button" @click="activeTab = 1" 
                class="flex-1 min-w-[140px] py-2.5 px-3 rounded-xl flex items-center justify-center gap-2 transition-all"
                :class="activeTab === 1 ? 'bg-maroon-900 text-white shadow-md' : 'text-gray-600 hover:bg-rose-50 hover:text-maroon-900'">
            <span class="w-5 h-5 rounded-full flex items-center justify-center text-[10px]" :class="activeTab === 1 ? 'bg-white/20 text-white' : 'bg-gray-200 text-gray-700'">1</span>
            <span>Identitas Pribadi</span>
        </button>

        <button type="button" @click="activeTab = 2" 
                class="flex-1 min-w-[140px] py-2.5 px-3 rounded-xl flex items-center justify-center gap-2 transition-all"
                :class="activeTab === 2 ? 'bg-maroon-900 text-white shadow-md' : 'text-gray-600 hover:bg-rose-50 hover:text-maroon-900'">
            <span class="w-5 h-5 rounded-full flex items-center justify-center text-[10px]" :class="activeTab === 2 ? 'bg-white/20 text-white' : 'bg-gray-200 text-gray-700'">2</span>
            <span>Akademik &amp; Riset</span>
        </button>

        <button type="button" @click="activeTab = 3" 
                class="flex-1 min-w-[140px] py-2.5 px-3 rounded-xl flex items-center justify-center gap-2 transition-all"
                :class="activeTab === 3 ? 'bg-maroon-900 text-white shadow-md' : 'text-gray-600 hover:bg-rose-50 hover:text-maroon-900'">
            <span class="w-5 h-5 rounded-full flex items-center justify-center text-[10px]" :class="activeTab === 3 ? 'bg-white/20 text-white' : 'bg-gray-200 text-gray-700'">3</span>
            <span>Kontak &amp; Sosmed</span>
        </button>

        <button type="button" @click="activeTab = 4" 
                class="flex-1 min-w-[140px] py-2.5 px-3 rounded-xl flex items-center justify-center gap-2 transition-all"
                :class="activeTab === 4 ? 'bg-maroon-900 text-white shadow-md' : 'text-gray-600 hover:bg-rose-50 hover:text-maroon-900'">
            <span class="w-5 h-5 rounded-full flex items-center justify-center text-[10px]" :class="activeTab === 4 ? 'bg-white/20 text-white' : 'bg-gray-200 text-gray-700'">4</span>
            <span>Karir &amp; Instansi</span>
        </button>
    </div>

    <!-- Main Form Card -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 sm:p-8">
        <form action="<?= base_url('admin/anggota/update/' . $anggota['id_anggota']) ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
            <?= csrf_field() ?>

            <!-- ================= TAB 1: IDENTITAS PRIBADI ================= -->
            <div x-show="activeTab === 1" class="space-y-6">
                <div class="border-b border-gray-100 pb-3">
                    <h3 class="text-base font-bold text-gray-900 font-heading">Bagian 1: Identitas &amp; Profil Pribadi</h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 text-xs">
                    
                    <!-- 1. id_anggota (NIM UIN) - Readonly on edit -->
                    <div>
                        <label class="block font-bold uppercase text-gray-700 mb-1">
                            1. ID Anggota (NIM UIN)
                        </label>
                        <input type="text" value="<?= esc($anggota['id_anggota']) ?>" disabled
                               class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-gray-500 font-mono font-bold cursor-not-allowed">
                        <span class="text-[10px] text-gray-400">Primary Key tidak dapat diubah</span>
                    </div>

                    <!-- 4. nomor_anggota -->
                    <div>
                        <label class="block font-bold uppercase text-gray-700 mb-1">
                            4. Nomor Anggota Predatech <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nomor_anggota" value="<?= old('nomor_anggota', $anggota['nomor_anggota']) ?>" required
                               class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-maroon-800 focus:outline-none font-mono">
                    </div>

                    <!-- 3. nama_anggota -->
                    <div class="sm:col-span-2">
                        <label class="block font-bold uppercase text-gray-700 mb-1">
                            3. Nama Lengkap &amp; Gelar <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama_anggota" value="<?= old('nama_anggota', $anggota['nama_anggota']) ?>" required
                               class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-maroon-800 focus:outline-none font-semibold text-gray-900">
                    </div>

                    <!-- 5. grup_puzzle -->
                    <div>
                        <label class="block font-bold uppercase text-gray-700 mb-1">
                            5. Grup Puzzle <span class="text-red-500">*</span>
                        </label>
                        <select name="grup_puzzle" class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-maroon-800 focus:outline-none">
                            <option value="1" <?= ($anggota['grup_puzzle'] == 1) ? 'selected' : '' ?>>Divisi Puzzle 1</option>
                            <option value="2" <?= ($anggota['grup_puzzle'] == 2) ? 'selected' : '' ?>>Divisi Puzzle 2</option>
                            <option value="3" <?= ($anggota['grup_puzzle'] == 3) ? 'selected' : '' ?>>Divisi Puzzle 3</option>
                            <option value="4" <?= ($anggota['grup_puzzle'] == 4) ? 'selected' : '' ?>>Divisi Puzzle 4</option>
                        </select>
                    </div>

                    <!-- 6. jenis_kelamin -->
                    <div>
                        <label class="block font-bold uppercase text-gray-700 mb-1">
                            6. Jenis Kelamin <span class="text-red-500">*</span>
                        </label>
                        <div class="flex items-center gap-6 mt-2">
                            <label class="inline-flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="jenis_kelamin" value="Laki-laki" <?= (old('jenis_kelamin', $anggota['jenis_kelamin']) == 'Laki-laki') ? 'checked' : '' ?> class="text-maroon-800 focus:ring-maroon-800">
                                <span>Laki-laki</span>
                            </label>
                            <label class="inline-flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="jenis_kelamin" value="Perempuan" <?= (old('jenis_kelamin', $anggota['jenis_kelamin']) == 'Perempuan') ? 'checked' : '' ?> class="text-maroon-800 focus:ring-maroon-800">
                                <span>Perempuan</span>
                            </label>
                        </div>
                    </div>

                    <!-- 19. status_perkawinan -->
                    <div>
                        <label class="block font-bold uppercase text-gray-700 mb-1">
                            19. Status Perkawinan
                        </label>
                        <select name="status_perkawinan" class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-maroon-800 focus:outline-none">
                            <option value="Belum Kawin" <?= (old('status_perkawinan', $anggota['status_perkawinan']) == 'Belum Kawin') ? 'selected' : '' ?>>Belum Kawin</option>
                            <option value="Kawin" <?= (old('status_perkawinan', $anggota['status_perkawinan']) == 'Kawin') ? 'selected' : '' ?>>Kawin</option>
                        </select>
                    </div>

                    <!-- 21. foto_anggota -->
                    <div>
                        <label class="block font-bold uppercase text-gray-700 mb-1">
                            21. Ganti Foto Profil Anggota (Opsional)
                        </label>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-rose-50 border border-rose-200 overflow-hidden flex-shrink-0">
                                <img src="<?= base_url('uploads/anggota/' . (!empty($anggota['foto_anggota']) ? $anggota['foto_anggota'] : 'avatar_female.svg')) ?>" 
                                     alt="Preview" class="w-full h-full object-cover">
                            </div>
                            <input type="file" name="foto_anggota" accept="image/*"
                                   class="w-full px-3 py-1.5 rounded-xl border border-gray-200 text-xs">
                        </div>
                    </div>

                    <!-- 22. motto -->
                    <div class="sm:col-span-2">
                        <label class="block font-bold uppercase text-gray-700 mb-1">
                            22. Motto Hidup / Kalimat Inspiratif
                        </label>
                        <textarea name="motto" rows="2"
                                  class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-maroon-800 focus:outline-none"><?= old('motto', $anggota['motto']) ?></textarea>
                    </div>

                </div>

                <div class="flex justify-end pt-4">
                    <button type="button" @click="activeTab = 2" class="px-6 py-2.5 rounded-xl bg-maroon-900 text-white font-bold text-xs flex items-center gap-2">
                        <span>Lanjut: Akademik &amp; Riset</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </div>
            </div>

            <!-- ================= TAB 2: AKADEMIK & RISET ================= -->
            <div x-show="activeTab === 2" class="space-y-6">
                <div class="border-b border-gray-100 pb-3">
                    <h3 class="text-base font-bold text-gray-900 font-heading">Bagian 2: Data Akademik &amp; Riset</h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 text-xs">
                    
                    <!-- 7. program_studi -->
                    <div>
                        <label class="block font-bold uppercase text-gray-700 mb-1">
                            7. Program Studi <span class="text-red-500">*</span>
                        </label>
                        <select name="program_studi" required class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-maroon-800 focus:outline-none">
                            <option value="TIF" <?= (old('program_studi', $anggota['program_studi']) == 'TIF') ? 'selected' : '' ?>>Teknik Informatika (TIF)</option>
                            <option value="TIN" <?= (old('program_studi', $anggota['program_studi']) == 'TIN') ? 'selected' : '' ?>>Teknik Industri (TIN)</option>
                            <option value="SIF" <?= (old('program_studi', $anggota['program_studi']) == 'SIF') ? 'selected' : '' ?>>Sistem Informasi (SIF)</option>
                            <option value="MAT" <?= (old('program_studi', $anggota['program_studi']) == 'MAT') ? 'selected' : '' ?>>Matematika (MAT)</option>
                            <option value="TEL" <?= (old('program_studi', $anggota['program_studi']) == 'TEL') ? 'selected' : '' ?>>Teknik Elektro (TEL)</option>
                        </select>
                    </div>

                    <!-- 18. status_keanggotaan -->
                    <div>
                        <label class="block font-bold uppercase text-gray-700 mb-1">
                            18. Status Keanggotaan <span class="text-red-500">*</span>
                        </label>
                        <select name="status_keanggotaan" required class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-maroon-800 focus:outline-none font-bold text-maroon-800">
                            <option value="Mahasiswa" <?= (old('status_keanggotaan', $anggota['status_keanggotaan']) == 'Mahasiswa') ? 'selected' : '' ?>>Mahasiswa Aktif</option>
                            <option value="Alumni" <?= (old('status_keanggotaan', $anggota['status_keanggotaan']) == 'Alumni') ? 'selected' : '' ?>>Alumni</option>
                            <option value="Dosen" <?= (old('status_keanggotaan', $anggota['status_keanggotaan']) == 'Dosen') ? 'selected' : '' ?>>Dosen / Peneliti Senior</option>
                        </select>
                    </div>

                    <!-- 8. angkatan -->
                    <div>
                        <label class="block font-bold uppercase text-gray-700 mb-1">
                            8. Angkatan Kampus <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="angkatan" value="<?= old('angkatan', $anggota['angkatan']) ?>" required
                               class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-maroon-800 focus:outline-none">
                    </div>

                    <!-- 9. tahun_masuk_predatech -->
                    <div>
                        <label class="block font-bold uppercase text-gray-700 mb-1">
                            9. Tahun Masuk Predatech <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="tahun_masuk_predatech" value="<?= old('tahun_masuk_predatech', $anggota['tahun_masuk_predatech']) ?>" required
                               class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-maroon-800 focus:outline-none">
                    </div>

                    <!-- 20. bidang_riset -->
                    <div>
                        <label class="block font-bold uppercase text-gray-700 mb-1">
                            20. Bidang Riset / Minat Utama
                        </label>
                        <input type="text" name="bidang_riset" value="<?= old('bidang_riset', $anggota['bidang_riset']) ?>"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-maroon-800 focus:outline-none">
                    </div>

                    <!-- 23. tahun_lulus -->
                    <div>
                        <label class="block font-bold uppercase text-gray-700 mb-1">
                            23. Tahun Kelulusan
                        </label>
                        <input type="text" name="tahun_lulus" value="<?= old('tahun_lulus', $anggota['tahun_lulus']) ?>"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-maroon-800 focus:outline-none">
                    </div>

                    <!-- 24. pendidikan_sekarang -->
                    <div class="sm:col-span-2">
                        <label class="block font-bold uppercase text-gray-700 mb-1">
                            24. Jenjang Pendidikan Sekarang
                        </label>
                        <select name="pendidikan_sekarang" class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-maroon-800 focus:outline-none">
                            <option value="S1" <?= (old('pendidikan_sekarang', $anggota['pendidikan_sekarang']) == 'S1') ? 'selected' : '' ?>>S1 (Sarjana)</option>
                            <option value="S2" <?= (old('pendidikan_sekarang', $anggota['pendidikan_sekarang']) == 'S2') ? 'selected' : '' ?>>S2 (Magister)</option>
                            <option value="S3" <?= (old('pendidikan_sekarang', $anggota['pendidikan_sekarang']) == 'S3') ? 'selected' : '' ?>>S3 (Doktoral)</option>
                        </select>
                    </div>

                </div>

                <div class="flex justify-between pt-4">
                    <button type="button" @click="activeTab = 1" class="px-5 py-2.5 rounded-xl bg-gray-100 text-gray-700 font-bold text-xs">
                        &larr; Kembali
                    </button>
                    <button type="button" @click="activeTab = 3" class="px-6 py-2.5 rounded-xl bg-maroon-900 text-white font-bold text-xs flex items-center gap-2">
                        <span>Lanjut: Kontak &amp; Sosmed</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </div>
            </div>

            <!-- ================= TAB 3: KONTAK & MEDIA SOSIAL ================= -->
            <div x-show="activeTab === 3" class="space-y-6">
                <div class="border-b border-gray-100 pb-3">
                    <h3 class="text-base font-bold text-gray-900 font-heading">Bagian 3: Kontak &amp; Media Sosial</h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 text-xs">
                    
                    <!-- 10. email_aktif -->
                    <div>
                        <label class="block font-bold uppercase text-gray-700 mb-1">
                            10. Email Aktif <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="email_aktif" value="<?= old('email_aktif', $anggota['email_aktif']) ?>" required
                               class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-maroon-800 focus:outline-none">
                    </div>

                    <!-- 11. no_hp -->
                    <div>
                        <label class="block font-bold uppercase text-gray-700 mb-1">
                            11. No. HP / WhatsApp <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="no_hp" value="<?= old('no_hp', $anggota['no_hp']) ?>" required
                               class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-maroon-800 focus:outline-none">
                    </div>

                    <!-- 12. kota_domisili -->
                    <div>
                        <label class="block font-bold uppercase text-gray-700 mb-1">
                            12. Kota / Kabupaten Domisili <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="kota_domisili" value="<?= old('kota_domisili', $anggota['kota_domisili']) ?>" required
                               class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-maroon-800 focus:outline-none">
                    </div>

                    <!-- 17. link_instagram -->
                    <div>
                        <label class="block font-bold uppercase text-gray-700 mb-1">
                            17. Link / Username Instagram
                        </label>
                        <input type="text" name="link_instagram" value="<?= old('link_instagram', $anggota['link_instagram']) ?>"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-maroon-800 focus:outline-none">
                    </div>

                    <!-- 13. alamat_domisili -->
                    <div class="sm:col-span-2">
                        <label class="block font-bold uppercase text-gray-700 mb-1">
                            13. Alamat Lengkap Domisili
                        </label>
                        <textarea name="alamat_domisili" rows="2"
                                  class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-maroon-800 focus:outline-none"><?= old('alamat_domisili', $anggota['alamat_domisili']) ?></textarea>
                    </div>

                    <!-- 14. link_linkedin -->
                    <div>
                        <label class="block font-bold uppercase text-gray-700 mb-1">
                            14. Link LinkedIn
                        </label>
                        <input type="url" name="link_linkedin" value="<?= old('link_linkedin', $anggota['link_linkedin']) ?>"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-maroon-800 focus:outline-none">
                    </div>

                    <!-- 15. link_scopus -->
                    <div>
                        <label class="block font-bold uppercase text-gray-700 mb-1">
                            15. Link Profil Scopus
                        </label>
                        <input type="url" name="link_scopus" value="<?= old('link_scopus', $anggota['link_scopus']) ?>"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-maroon-800 focus:outline-none">
                    </div>

                    <!-- 16. link_scholar -->
                    <div class="sm:col-span-2">
                        <label class="block font-bold uppercase text-gray-700 mb-1">
                            16. Link Google Scholar
                        </label>
                        <input type="url" name="link_scholar" value="<?= old('link_scholar', $anggota['link_scholar']) ?>"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-maroon-800 focus:outline-none">
                    </div>

                </div>

                <div class="flex justify-between pt-4">
                    <button type="button" @click="activeTab = 2" class="px-5 py-2.5 rounded-xl bg-gray-100 text-gray-700 font-bold text-xs">
                        &larr; Kembali
                    </button>
                    <button type="button" @click="activeTab = 4" class="px-6 py-2.5 rounded-xl bg-maroon-900 text-white font-bold text-xs flex items-center gap-2">
                        <span>Lanjut: Karir &amp; Instansi</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </div>
            </div>

            <!-- ================= TAB 4: KARIR & INSTANSI KERJA ================= -->
            <div x-show="activeTab === 4" class="space-y-6">
                <div class="border-b border-gray-100 pb-3">
                    <h3 class="text-base font-bold text-gray-900 font-heading">Bagian 4: Riwayat Karir &amp; Instansi Kerja</h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 text-xs">
                    
                    <!-- 25. pekerjaan_pertama -->
                    <div>
                        <label class="block font-bold uppercase text-gray-700 mb-1">
                            25. Pekerjaan / Tempat Kerja Pertama
                        </label>
                        <input type="text" name="pekerjaan_pertama" value="<?= old('pekerjaan_pertama', $anggota['pekerjaan_pertama']) ?>"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-maroon-800 focus:outline-none">
                    </div>

                    <!-- 26. tahun_kerja_pertama -->
                    <div>
                        <label class="block font-bold uppercase text-gray-700 mb-1">
                            26. Tahun Mulai Kerja Pertama
                        </label>
                        <input type="text" name="tahun_kerja_pertama" value="<?= old('tahun_kerja_pertama', $anggota['tahun_kerja_pertama']) ?>"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-maroon-800 focus:outline-none">
                    </div>

                    <!-- 27. pekerjaan_saat_ini -->
                    <div>
                        <label class="block font-bold uppercase text-gray-700 mb-1">
                            27. Pekerjaan Saat Ini
                        </label>
                        <input type="text" name="pekerjaan_saat_ini" value="<?= old('pekerjaan_saat_ini', $anggota['pekerjaan_saat_ini']) ?>"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-maroon-800 focus:outline-none">
                    </div>

                    <!-- 28. mulai_bekerja -->
                    <div>
                        <label class="block font-bold uppercase text-gray-700 mb-1">
                            28. Tahun Mulai di Pekerjaan Saat Ini
                        </label>
                        <input type="text" name="mulai_bekerja" value="<?= old('mulai_bekerja', $anggota['mulai_bekerja']) ?>"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-maroon-800 focus:outline-none">
                    </div>

                    <!-- 29. instansi_perusahaan -->
                    <div>
                        <label class="block font-bold uppercase text-gray-700 mb-1">
                            29. Nama Perusahaan / Instansi Kerja
                        </label>
                        <input type="text" name="instansi_perusahaan" value="<?= old('instansi_perusahaan', $anggota['instansi_perusahaan']) ?>"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-maroon-800 focus:outline-none">
                    </div>

                    <!-- 30. jabatan_pekerjaan -->
                    <div>
                        <label class="block font-bold uppercase text-gray-700 mb-1">
                            30. Jabatan / Posisi Pekerjaan
                        </label>
                        <input type="text" name="jabatan_pekerjaan" value="<?= old('jabatan_pekerjaan', $anggota['jabatan_pekerjaan']) ?>"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-maroon-800 focus:outline-none">
                    </div>

                    <!-- 31. website_instansi -->
                    <div class="sm:col-span-2">
                        <label class="block font-bold uppercase text-gray-700 mb-1">
                            31. Website Perusahaan / Instansi
                        </label>
                        <input type="url" name="website_instansi" value="<?= old('website_instansi', $anggota['website_instansi']) ?>"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-maroon-800 focus:outline-none">
                    </div>

                    <!-- 32. profil_instansi -->
                    <div class="sm:col-span-2">
                        <label class="block font-bold uppercase text-gray-700 mb-1">
                            32. Profil Singkat Perusahaan / Instansi
                        </label>
                        <textarea name="profil_instansi" rows="3"
                                  class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-maroon-800 focus:outline-none"><?= old('profil_instansi', $anggota['profil_instansi']) ?></textarea>
                    </div>

                </div>

                <div class="flex justify-between pt-6 border-t border-gray-100">
                    <button type="button" @click="activeTab = 3" class="px-5 py-2.5 rounded-xl bg-gray-100 text-gray-700 font-bold text-xs">
                        &larr; Kembali
                    </button>
                    
                    <button type="submit" 
                            class="btn-shimmer px-8 py-3 rounded-xl bg-gradient-to-r from-maroon-900 to-rose-900 hover:from-maroon-950 hover:to-rose-950 text-white font-bold text-xs shadow-lg transition-all flex items-center gap-2">
                        <i class="fa-solid fa-floppy-disk"></i>
                        <span>Perbarui Data Anggota</span>
                    </button>
                </div>
            </div>

        </form>
    </div>

</div>

<?= $this->endSection() ?>
