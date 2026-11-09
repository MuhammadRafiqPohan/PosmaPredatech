<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="space-y-6 max-w-5xl mx-auto" x-data="{ addModalOpen: false, editModalOpen: false, editId: null, editNama: '', editUsername: '', editLevel: 'Anggota' }">
    
    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-black text-gray-900 font-heading">Manajemen Akun Pengguna</h1>
            <p class="text-xs text-gray-500">Kelola akses autentikasi sistem (Admin, Operator, Anggota)</p>
        </div>

        <button type="button" 
                @click="addModalOpen = true"
                class="btn-shimmer inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-maroon-900 hover:bg-maroon-950 shadow-md transition-all self-start sm:self-auto">
            <i class="fa-solid fa-user-plus"></i>
            <span>Tambah Pengguna Baru</span>
        </button>
    </div>

    <!-- Users Table Card -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-5 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-sm font-bold text-gray-900 font-heading">
                Daftar Akun Pengguna Terdaftar (<?= count($users) ?>)
            </h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100 text-gray-500 uppercase tracking-wider font-bold">
                        <th class="py-3 px-4 w-12 text-center">ID</th>
                        <th class="py-3 px-4">Nama Lengkap</th>
                        <th class="py-3 px-4">Username</th>
                        <th class="py-3 px-4">Level Akses</th>
                        <th class="py-3 px-4 text-right w-28">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700">
                    <?php foreach ($users as $u): ?>
                        <tr class="hover:bg-rose-50/30 transition-colors">
                            <td class="py-3.5 px-4 text-center font-bold text-gray-400">
                                <?= $u['id_user'] ?>
                            </td>
                            <td class="py-3.5 px-4 font-bold text-gray-900">
                                <?= esc($u['nama_user']) ?>
                            </td>
                            <td class="py-3.5 px-4 font-mono font-semibold text-maroon-800">
                                <?= esc($u['username']) ?>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold <?= ($u['level'] === 'Admin') ? 'bg-amber-100 text-amber-900' : (($u['level'] === 'Operator') ? 'bg-sky-100 text-sky-900' : 'bg-emerald-100 text-emerald-900') ?>">
                                    <?= esc($u['level']) ?>
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="inline-flex items-center gap-1">
                                    <button type="button" 
                                            @click="editId = <?= $u['id_user'] ?>; editNama = '<?= esc($u['nama_user']) ?>'; editUsername = '<?= esc($u['username']) ?>'; editLevel = '<?= esc($u['level']) ?>'; editModalOpen = true"
                                            class="p-1 rounded bg-amber-50 text-amber-700 hover:bg-amber-600 hover:text-white" title="Edit">
                                        <i class="fa-solid fa-pen text-[10px]"></i>
                                    </button>
                                    <?php if ($u['id_user'] != session()->get('id_user')): ?>
                                        <a href="<?= base_url('admin/users/delete/' . $u['id_user']) ?>" 
                                           onclick="return confirm('Hapus akun <?= esc($u['nama_user']) ?>?')"
                                           class="p-1 rounded bg-red-50 text-red-600 hover:bg-red-600 hover:text-white" title="Hapus">
                                            <i class="fa-solid fa-trash text-[10px]"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add User Modal -->
    <div x-show="addModalOpen" 
         x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm">
        <div @click.away="addModalOpen = false" class="bg-white rounded-3xl shadow-2xl border border-gray-100 max-w-md w-full p-6 text-xs">
            <h3 class="text-base font-bold text-gray-900 font-heading mb-4">Tambah Akun Pengguna</h3>
            
            <form action="<?= base_url('admin/users/store') ?>" method="POST" class="space-y-4">
                <?= csrf_field() ?>

                <div>
                    <label class="block font-bold text-gray-700 mb-1">Nama Pengguna</label>
                    <input type="text" name="nama_user" required placeholder="Nama lengkap" class="w-full px-3 py-2 rounded-xl border border-gray-200">
                </div>

                <div>
                    <label class="block font-bold text-gray-700 mb-1">Username</label>
                    <input type="text" name="username" required placeholder="username_unik" class="w-full px-3 py-2 rounded-xl border border-gray-200 font-mono">
                </div>

                <div>
                    <label class="block font-bold text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" required placeholder="Minimal 6 karakter" class="w-full px-3 py-2 rounded-xl border border-gray-200">
                </div>

                <div>
                    <label class="block font-bold text-gray-700 mb-1">Level Akses</label>
                    <select name="level" class="w-full px-3 py-2 rounded-xl border border-gray-200">
                        <option value="Anggota">Anggota</option>
                        <option value="Operator">Operator</option>
                        <option value="Admin">Admin</option>
                    </select>
                </div>

                <div class="flex justify-end gap-2 pt-3 border-t border-gray-100">
                    <button type="button" @click="addModalOpen = false" class="px-4 py-2 rounded-xl bg-gray-100 text-gray-700 font-bold">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-maroon-900 text-white font-bold">
                        Simpan Akun
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div x-show="editModalOpen" 
         x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm">
        <div @click.away="editModalOpen = false" class="bg-white rounded-3xl shadow-2xl border border-gray-100 max-w-md w-full p-6 text-xs">
            <h3 class="text-base font-bold text-gray-900 font-heading mb-4">Edit Akun Pengguna</h3>
            
            <form :action="'<?= base_url('admin/users/update') ?>/' + editId" method="POST" class="space-y-4">
                <?= csrf_field() ?>

                <div>
                    <label class="block font-bold text-gray-700 mb-1">Nama Pengguna</label>
                    <input type="text" name="nama_user" x-model="editNama" required class="w-full px-3 py-2 rounded-xl border border-gray-200">
                </div>

                <div>
                    <label class="block font-bold text-gray-700 mb-1">Username</label>
                    <input type="text" name="username" x-model="editUsername" required class="w-full px-3 py-2 rounded-xl border border-gray-200 font-mono">
                </div>

                <div>
                    <label class="block font-bold text-gray-700 mb-1">Password Baru (Kosongkan bila tidak diubah)</label>
                    <input type="password" name="password" placeholder="••••••••" class="w-full px-3 py-2 rounded-xl border border-gray-200">
                </div>

                <div>
                    <label class="block font-bold text-gray-700 mb-1">Level Akses</label>
                    <select name="level" x-model="editLevel" class="w-full px-3 py-2 rounded-xl border border-gray-200">
                        <option value="Anggota">Anggota</option>
                        <option value="Operator">Operator</option>
                        <option value="Admin">Admin</option>
                    </select>
                </div>

                <div class="flex justify-end gap-2 pt-3 border-t border-gray-100">
                    <button type="button" @click="editModalOpen = false" class="px-4 py-2 rounded-xl bg-gray-100 text-gray-700 font-bold">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-maroon-900 text-white font-bold">
                        Perbarui Akun
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
