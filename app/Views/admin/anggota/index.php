<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="space-y-6">

    <!-- Top Action & Filter Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-black text-gray-900 font-heading">Manajemen Data Anggota</h1>
            <p class="text-xs text-gray-500">Daftar lengkap anggota riset, mahasiswa, dan alumni Predatech</p>
        </div>

        <a href="<?= base_url('admin/anggota/create') ?>" 
           class="btn-shimmer inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-maroon-900 hover:bg-maroon-950 shadow-md transition-all self-start sm:self-auto">
            <i class="fa-solid fa-user-plus"></i>
            <span>Tambah Anggota Baru</span>
        </a>
    </div>

    <!-- Filter Card -->
    <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100">
        <form action="<?= base_url('admin/anggota') ?>" method="GET" class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-center">
            
            <!-- Search Keyword -->
            <div class="sm:col-span-5 relative">
                <input type="text" 
                       name="q" 
                       value="<?= esc($keyword) ?>" 
                       placeholder="Cari nama, NIM, instansi, pekerjaan..."
                       class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-gray-200 text-xs focus:border-maroon-800 focus:outline-none">
                <span class="absolute left-3 top-3 text-gray-400 text-xs">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </span>
            </div>

            <!-- Filter Program Studi -->
            <div class="sm:col-span-3">
                <select name="prodi" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-xs focus:border-maroon-800 focus:outline-none">
                    <option value="">Semua Program Studi</option>
                    <option value="TIF" <?= ($prodi === 'TIF') ? 'selected' : '' ?>>Teknik Informatika (TIF)</option>
                    <option value="TIN" <?= ($prodi === 'TIN') ? 'selected' : '' ?>>Teknik Industri (TIN)</option>
                    <option value="SIF" <?= ($prodi === 'SIF') ? 'selected' : '' ?>>Sistem Informasi (SIF)</option>
                    <option value="MAT" <?= ($prodi === 'MAT') ? 'selected' : '' ?>>Matematika (MAT)</option>
                    <option value="TEL" <?= ($prodi === 'TEL') ? 'selected' : '' ?>>Teknik Elektro (TEL)</option>
                </select>
            </div>

            <!-- Filter Status -->
            <div class="sm:col-span-2">
                <select name="status" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-xs focus:border-maroon-800 focus:outline-none">
                    <option value="">Semua Status</option>
                    <option value="Alumni" <?= ($status === 'Alumni') ? 'selected' : '' ?>>Alumni</option>
                    <option value="Mahasiswa" <?= ($status === 'Mahasiswa') ? 'selected' : '' ?>>Mahasiswa</option>
                    <option value="Dosen" <?= ($status === 'Dosen') ? 'selected' : '' ?>>Dosen</option>
                </select>
            </div>

            <!-- Filter Submit & Reset -->
            <div class="sm:col-span-2 flex items-center gap-2">
                <button type="submit" class="flex-1 py-2.5 rounded-xl bg-gray-900 hover:bg-gray-800 text-white font-bold text-xs transition-colors">
                    Filter
                </button>
                <a href="<?= base_url('admin/anggota') ?>" class="p-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs" title="Reset Filter">
                    <i class="fa-solid fa-rotate-left"></i>
                </a>
            </div>

        </form>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100 text-gray-500 uppercase tracking-wider font-bold">
                        <th class="py-3.5 px-4 w-12 text-center">No</th>
                        <th class="py-3.5 px-4">Anggota</th>
                        <th class="py-3.5 px-4">NIM / No. Anggota</th>
                        <th class="py-3.5 px-4">Prodi &amp; Angkatan</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-4">Karir / Instansi</th>
                        <th class="py-3.5 px-4">Update</th>
                        <th class="py-3.5 px-4 text-right w-36">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700">
                    <?php if (!empty($anggotaList)): ?>
                        <?php $no = 1; foreach ($anggotaList as $item): ?>
                            <tr class="hover:bg-rose-50/30 transition-colors">
                                <td class="py-3.5 px-4 text-center font-bold text-gray-400">
                                    <?= $no++ ?>
                                </td>
                                <td class="py-3.5 px-4 font-semibold text-gray-900">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full bg-rose-50 border border-rose-200 overflow-hidden flex-shrink-0">
                                            <img src="<?= base_url('uploads/anggota/' . (!empty($item['foto_anggota']) ? $item['foto_anggota'] : 'avatar_female.svg')) ?>" 
                                                 alt="<?= esc($item['nama_anggota']) ?>" 
                                                 class="w-full h-full object-cover">
                                        </div>
                                        <div>
                                            <span class="font-bold text-gray-900 block"><?= esc($item['nama_anggota']) ?></span>
                                            <span class="text-[10px] text-gray-400"><?= esc($item['email_aktif']) ?></span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4 font-mono font-medium">
                                    <span class="bg-gray-100 px-2 py-0.5 rounded text-gray-800 font-bold"><?= esc($item['id_anggota']) ?></span>
                                    <p class="text-[10px] text-gray-400 mt-0.5"><?= esc($item['nomor_anggota']) ?></p>
                                </td>
                                <td class="py-3.5 px-4">
                                    <span class="font-bold text-maroon-800"><?= esc($item['program_studi']) ?></span>
                                    <span class="text-gray-400">/ <?= esc($item['angkatan']) ?></span>
                                </td>
                                <td class="py-3.5 px-4">
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold <?= ($item['status_keanggotaan'] === 'Alumni') ? 'bg-amber-100 text-amber-900' : (($item['status_keanggotaan'] === 'Dosen') ? 'bg-purple-100 text-purple-900' : 'bg-emerald-100 text-emerald-900') ?>">
                                        <?= esc($item['status_keanggotaan']) ?>
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 max-w-xs truncate">
                                    <p class="font-semibold text-gray-800 truncate"><?= esc($item['pekerjaan_saat_ini'] ?: '-') ?></p>
                                    <p class="text-[10px] text-gray-400 truncate"><?= esc($item['instansi_perusahaan'] ?: '-') ?></p>
                                </td>
                                <td class="py-3.5 px-4 text-gray-400 text-[11px] whitespace-nowrap">
                                    <?= esc($item['tanggal_update'] ?: '-') ?>
                                </td>
                                <td class="py-3.5 px-4 text-right">
                                    <div class="inline-flex items-center gap-1.5">
                                        <a href="<?= base_url('admin/anggota/detail/' . $item['id_anggota']) ?>" 
                                           class="p-1.5 rounded-lg bg-gray-100 hover:bg-maroon-900 hover:text-white text-gray-600 transition-colors" title="Detail">
                                            <i class="fa-solid fa-eye text-xs"></i>
                                        </a>
                                        <a href="<?= base_url('admin/anggota/edit/' . $item['id_anggota']) ?>" 
                                           class="p-1.5 rounded-lg bg-rose-50 hover:bg-amber-500 hover:text-white text-amber-700 transition-colors" title="Edit">
                                            <i class="fa-solid fa-pen-to-square text-xs"></i>
                                        </a>
                                        <?php if (in_array(session()->get('level'), ['Admin', 'Operator'])): ?>
                                            <a href="<?= base_url('admin/anggota/delete/' . $item['id_anggota']) ?>" 
                                               onclick="return confirm('Apakah Anda yakin ingin menghapus data anggota <?= esc($item['nama_anggota']) ?>? Data karya terkait juga akan terpengaruh.')"
                                               class="p-1.5 rounded-lg bg-red-50 hover:bg-red-600 hover:text-white text-red-600 transition-colors" title="Hapus">
                                                <i class="fa-solid fa-trash-can text-xs"></i>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="py-12 text-center text-gray-400">
                                <i class="fa-solid fa-user-slash text-2xl mb-2"></i>
                                <p>Tidak ada data anggota yang ditemukan.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
