<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="space-y-6">
    
    <!-- Top Action Bar -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-black text-gray-900 font-heading">Detail Data Anggota</h1>
            <p class="text-xs text-gray-500">Profil lengkap dan repositori publikasi karya ilmiah</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="<?= base_url('admin/anggota/edit/' . $anggota['id_anggota']) ?>" class="px-3.5 py-2 rounded-xl text-xs font-bold text-amber-700 bg-amber-50 hover:bg-amber-100 transition-colors border border-amber-200">
                <i class="fa-solid fa-pen-to-square mr-1"></i> Edit Data
            </a>
            <a href="<?= base_url('anggota/' . $anggota['id_anggota']) ?>" target="_blank" class="px-3.5 py-2 rounded-xl text-xs font-bold text-maroon-900 bg-rose-50 hover:bg-rose-100 transition-colors border border-rose-200">
                <i class="fa-solid fa-arrow-up-right-from-square mr-1"></i> Lihat Publik
            </a>
            <a href="<?= base_url('admin/anggota') ?>" class="px-3.5 py-2 rounded-xl text-xs font-bold text-gray-600 bg-white hover:bg-gray-50 transition-colors border border-gray-200">
                <i class="fa-solid fa-arrow-left mr-1"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Main Profile Card -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 sm:p-8">
        <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6 pb-6 border-b border-gray-100">
            <div class="w-24 h-24 rounded-2xl bg-rose-50 border-2 border-rose-100 overflow-hidden flex-shrink-0">
                <img src="<?= base_url('uploads/anggota/' . (!empty($anggota['foto_anggota']) ? $anggota['foto_anggota'] : 'avatar_female.svg')) ?>" 
                     alt="<?= esc($anggota['nama_anggota']) ?>" class="w-full h-full object-cover">
            </div>
            <div class="flex-1 text-center sm:text-left">
                <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2 mb-1.5">
                    <span class="text-xs font-bold px-2.5 py-0.5 rounded-full <?= ($anggota['status_keanggotaan'] === 'Alumni') ? 'bg-amber-100 text-amber-900' : 'bg-emerald-100 text-emerald-900' ?>">
                        <?= esc($anggota['status_keanggotaan']) ?> (Angkatan <?= esc($anggota['angkatan']) ?>)
                    </span>
                    <span class="text-xs font-bold px-2.5 py-0.5 rounded-full bg-rose-100 text-maroon-800">
                        Prodi <?= esc($anggota['program_studi']) ?>
                    </span>
                    <span class="text-xs font-bold px-2.5 py-0.5 rounded-full bg-gray-100 text-gray-700">
                        Puzzle <?= esc($anggota['grup_puzzle']) ?>
                    </span>
                </div>
                <h2 class="text-2xl font-black text-gray-900 font-heading"><?= esc($anggota['nama_anggota']) ?></h2>
                <p class="text-xs text-gray-500 mt-1">NIM: <strong class="text-gray-800 font-mono"><?= esc($anggota['id_anggota']) ?></strong> &bull; No. Anggota: <strong class="text-gray-800 font-mono"><?= esc($anggota['nomor_anggota']) ?></strong></p>
                <?php if (!empty($anggota['motto'])): ?>
                    <p class="text-xs italic text-gray-600 mt-2">&ldquo;<?= esc($anggota['motto']) ?>&rdquo;</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- 33 Fields Detailed Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4 pt-6 text-xs">
            <div class="space-y-3">
                <h4 class="font-bold text-maroon-900 uppercase tracking-wider border-b border-rose-100 pb-1">Kontak &amp; Domisili</h4>
                <div class="flex justify-between py-1 border-b border-gray-50">
                    <span class="text-gray-500 font-medium">Email:</span>
                    <span class="font-bold text-gray-900"><?= esc($anggota['email_aktif']) ?></span>
                </div>
                <div class="flex justify-between py-1 border-b border-gray-50">
                    <span class="text-gray-500 font-medium">No. HP / WhatsApp:</span>
                    <span class="font-bold text-gray-900"><?= esc($anggota['no_hp']) ?></span>
                </div>
                <div class="flex justify-between py-1 border-b border-gray-50">
                    <span class="text-gray-500 font-medium">Kota Domisili:</span>
                    <span class="font-bold text-gray-900"><?= esc($anggota['kota_domisili']) ?></span>
                </div>
                <div class="flex justify-between py-1 border-b border-gray-50">
                    <span class="text-gray-500 font-medium">Alamat:</span>
                    <span class="font-bold text-gray-900 text-right max-w-xs"><?= esc($anggota['alamat_domisili'] ?: '-') ?></span>
                </div>
            </div>

            <div class="space-y-3">
                <h4 class="font-bold text-maroon-900 uppercase tracking-wider border-b border-rose-100 pb-1">Karir &amp; Institusi</h4>
                <div class="flex justify-between py-1 border-b border-gray-50">
                    <span class="text-gray-500 font-medium">Pekerjaan Saat Ini:</span>
                    <span class="font-bold text-gray-900"><?= esc($anggota['pekerjaan_saat_ini'] ?: '-') ?></span>
                </div>
                <div class="flex justify-between py-1 border-b border-gray-50">
                    <span class="text-gray-500 font-medium">Instansi / Perusahaan:</span>
                    <span class="font-bold text-gray-900"><?= esc($anggota['instansi_perusahaan'] ?: '-') ?></span>
                </div>
                <div class="flex justify-between py-1 border-b border-gray-50">
                    <span class="text-gray-500 font-medium">Jabatan:</span>
                    <span class="font-bold text-gray-900"><?= esc($anggota['jabatan_pekerjaan'] ?: '-') ?></span>
                </div>
                <div class="flex justify-between py-1 border-b border-gray-50">
                    <span class="text-gray-500 font-medium">Tahun Kelulusan:</span>
                    <span class="font-bold text-gray-900"><?= esc($anggota['tahun_lulus'] ?: 'Belum Lulus') ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Works / Publications produced by this member -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-base font-bold text-gray-900 font-heading flex items-center gap-2">
                <i class="fa-solid fa-book-open text-maroon-800"></i>
                <span>Daftar Karya Ilmiah Anggota (<?= count($karyaList) ?>)</span>
            </h3>
            <a href="<?= base_url('admin/karya/create?id_anggota=' . $anggota['id_anggota']) ?>" 
               class="btn-shimmer px-4 py-2 rounded-xl text-xs font-bold text-white bg-maroon-900 hover:bg-maroon-950 transition-all flex items-center gap-1.5">
                <i class="fa-solid fa-plus text-[10px]"></i>
                <span>Tambah Karya</span>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 uppercase tracking-wider font-bold border-b border-gray-100">
                        <th class="py-3 px-4 w-28">Jenis</th>
                        <th class="py-3 px-4 w-28">Level</th>
                        <th class="py-3 px-4 w-20">Tahun</th>
                        <th class="py-3 px-4">Judul Karya</th>
                        <th class="py-3 px-4 text-right w-28">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700">
                    <?php if (!empty($karyaList)): ?>
                        <?php foreach ($karyaList as $k): ?>
                            <tr class="hover:bg-rose-50/30 transition-colors">
                                <td class="py-3.5 px-4 font-bold text-maroon-800">
                                    <?= esc($k['jenis_karya']) ?>
                                </td>
                                <td class="py-3.5 px-4 font-semibold text-gray-700">
                                    <?= esc($k['level_karya']) ?>
                                    <span class="block text-[10px] text-gray-400"><?= esc($k['nama_kategori'] ?? '') ?></span>
                                </td>
                                <td class="py-3.5 px-4 font-mono font-bold text-gray-600">
                                    <?= esc($k['tahun_terbit']) ?>
                                </td>
                                <td class="py-3.5 px-4 font-medium text-gray-900">
                                    <a href="<?= base_url('admin/karya/detail/' . $k['id_karya']) ?>" class="hover:text-maroon-800 font-semibold block">
                                        <?= esc($k['judul_karya']) ?>
                                    </a>
                                </td>
                                <td class="py-3.5 px-4 text-right">
                                    <div class="inline-flex items-center gap-1">
                                        <a href="<?= base_url('admin/karya/edit/' . $k['id_karya']) ?>" class="p-1 rounded bg-rose-50 text-amber-700 hover:bg-amber-600 hover:text-white" title="Edit">
                                            <i class="fa-solid fa-pen text-[10px]"></i>
                                        </a>
                                        <a href="<?= base_url('admin/karya/delete/' . $k['id_karya']) ?>" onclick="return confirm('Hapus karya ini?')" class="p-1 rounded bg-red-50 text-red-600 hover:bg-red-600 hover:text-white" title="Hapus">
                                            <i class="fa-solid fa-trash text-[10px]"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="py-8 text-center text-gray-400">
                                Belum ada karya ilmiah yang didaftarkan untuk anggota ini.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
