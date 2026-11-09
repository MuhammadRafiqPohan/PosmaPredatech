<?php

namespace App\Controllers;

use App\Models\AnggotaModel;
use App\Models\KaryaModel;
use App\Models\UserModel;

class Anggota extends BaseController
{
    protected $anggotaModel;
    protected $karyaModel;
    protected $userModel;

    public function __construct()
    {
        $this->anggotaModel = new AnggotaModel();
        $this->karyaModel   = new KaryaModel();
        $this->userModel    = new UserModel();
    }

    /**
     * Display list of Anggota
     */
    public function index()
    {
        $keyword = trim((string)($this->request->getGet('q') ?? ''));
        $prodi   = $this->request->getGet('prodi') ?? '';
        $status  = $this->request->getGet('status') ?? '';

        $anggotaList = $this->anggotaModel->searchAnggota($keyword, $prodi, $status);

        $data = [
            'title'       => 'Manajemen Data Anggota - POSMA Predatech',
            'anggotaList' => $anggotaList,
            'keyword'     => $keyword,
            'prodi'       => $prodi,
            'status'      => $status,
        ];

        return view('admin/anggota/index', $data);
    }

    /**
     * Show form to create new Anggota
     */
    public function create()
    {
        $usersWithoutAnggota = $this->userModel->where('level', 'Anggota')->findAll();

        $data = [
            'title' => 'Tambah Data Anggota Baru - POSMA Predatech',
            'users' => $usersWithoutAnggota,
        ];

        return view('admin/anggota/create', $data);
    }

    /**
     * Store new Anggota in database
     */
    public function store()
    {
        $rules = [
            'id_anggota'            => 'required|numeric|is_unique[anggota.id_anggota]',
            'nama_anggota'          => 'required|min_length[3]|max_length[100]',
            'nomor_anggota'         => 'required|max_length[25]',
            'email_aktif'           => 'required|valid_email|max_length[100]',
            'no_hp'                 => 'required|max_length[20]',
            'program_studi'         => 'required|in_list[TIF,TIN,SIF,MAT,TEL]',
            'angkatan'              => 'required|max_length[4]',
            'tahun_masuk_predatech' => 'required|max_length[4]',
            'status_keanggotaan'    => 'required|in_list[Dosen,Alumni,Mahasiswa]',
            'jenis_kelamin'         => 'required|in_list[Laki-laki,Perempuan]',
            'foto_anggota'          => 'permit_empty|is_image[foto_anggota]|max_size[foto_anggota,2048]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $idAnggota = $this->request->getPost('id_anggota');

        // Handle photo upload
        $fotoName = 'avatar_male.svg';
        if ($this->request->getPost('jenis_kelamin') === 'Perempuan') {
            $fotoName = 'avatar_female.svg';
        }

        $foto = $this->request->getFile('foto_anggota');
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $fotoName = $foto->getRandomName();
            $foto->move(FCPATH . 'uploads/anggota/', $fotoName);
        }

        // Auto create user account if requested or specified
        $idUser = $this->request->getPost('id_user') ?: null;
        if (empty($idUser) && $this->request->getPost('create_user_account')) {
            $username = $this->request->getPost('username') ?: 'user' . $idAnggota;
            $password = $this->request->getPost('password') ?: 'predatech123';
            
            $newUserId = $this->userModel->insert([
                'nama_user' => $this->request->getPost('nama_anggota'),
                'username'  => $username,
                'password'  => $password,
                'level'     => 'Anggota',
            ]);
            $idUser = $newUserId;
        }

        $saveData = [
            'id_anggota'            => $idAnggota,
            'id_user'               => $idUser,
            'nama_anggota'          => $this->request->getPost('nama_anggota'),
            'nomor_anggota'         => $this->request->getPost('nomor_anggota'),
            'grup_puzzle'           => $this->request->getPost('grup_puzzle') ?: 1,
            'jenis_kelamin'         => $this->request->getPost('jenis_kelamin'),
            'program_studi'         => $this->request->getPost('program_studi'),
            'angkatan'              => $this->request->getPost('angkatan'),
            'tahun_masuk_predatech' => $this->request->getPost('tahun_masuk_predatech'),
            'email_aktif'           => $this->request->getPost('email_aktif'),
            'no_hp'                 => $this->request->getPost('no_hp'),
            'kota_domisili'         => $this->request->getPost('kota_domisili'),
            'alamat_domisili'       => $this->request->getPost('alamat_domisili'),
            'link_linkedin'         => $this->request->getPost('link_linkedin'),
            'link_scopus'           => $this->request->getPost('link_scopus'),
            'link_scholar'          => $this->request->getPost('link_scholar'),
            'link_instagram'        => $this->request->getPost('link_instagram'),
            'status_keanggotaan'    => $this->request->getPost('status_keanggotaan'),
            'status_perkawinan'     => $this->request->getPost('status_perkawinan') ?: 'Belum Kawin',
            'bidang_riset'          => $this->request->getPost('bidang_riset') ?: 'Data Mining',
            'foto_anggota'          => $fotoName,
            'motto'                 => $this->request->getPost('motto'),
            'tahun_lulus'           => $this->request->getPost('tahun_lulus') ?: null,
            'pendidikan_sekarang'   => $this->request->getPost('pendidikan_sekarang') ?: 'S1',
            'pekerjaan_pertama'     => $this->request->getPost('pekerjaan_pertama'),
            'tahun_kerja_pertama'   => $this->request->getPost('tahun_kerja_pertama'),
            'pekerjaan_saat_ini'    => $this->request->getPost('pekerjaan_saat_ini'),
            'mulai_bekerja'         => $this->request->getPost('mulai_bekerja'),
            'instansi_perusahaan'   => $this->request->getPost('instansi_perusahaan'),
            'jabatan_pekerjaan'     => $this->request->getPost('jabatan_pekerjaan'),
            'website_instansi'      => $this->request->getPost('website_instansi'),
            'profil_instansi'       => $this->request->getPost('profil_instansi'),
            'tanggal_update'        => date('d-m-Y'),
        ];

        $this->anggotaModel->insert($saveData);

        return redirect()->to('/admin/anggota')->with('success', 'Data Anggota berhasil ditambahkan!');
    }

    /**
     * Show form to edit Anggota
     */
    public function edit($id)
    {
        $anggota = $this->anggotaModel->find($id);
        if (!$anggota) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Anggota tidak ditemukan.');
        }

        // Restrict if regular member tries to edit someone else
        $userLevel = session()->get('level');
        $myNIM     = session()->get('id_anggota');
        if ($userLevel === 'Anggota' && $myNIM != $id) {
            return redirect()->to('/dashboard')->with('error', 'Anda hanya diizinkan mengubah profil Anda sendiri.');
        }

        $users = $this->userModel->findAll();

        $data = [
            'title'   => 'Edit Data Anggota: ' . $anggota['nama_anggota'],
            'anggota' => $anggota,
            'users'   => $users,
        ];

        return view('admin/anggota/edit', $data);
    }

    /**
     * Update Anggota in database
     */
    public function update($id)
    {
        $anggota = $this->anggotaModel->find($id);
        if (!$anggota) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Anggota tidak ditemukan.');
        }

        $userLevel = session()->get('level');
        $myNIM     = session()->get('id_anggota');
        if ($userLevel === 'Anggota' && $myNIM != $id) {
            return redirect()->to('/dashboard')->with('error', 'Anda hanya diizinkan mengubah profil Anda sendiri.');
        }

        $rules = [
            'nama_anggota'          => 'required|min_length[3]|max_length[100]',
            'nomor_anggota'         => 'required|max_length[25]',
            'email_aktif'           => 'required|valid_email|max_length[100]',
            'no_hp'                 => 'required|max_length[20]',
            'program_studi'         => 'required|in_list[TIF,TIN,SIF,MAT,TEL]',
            'angkatan'              => 'required|max_length[4]',
            'tahun_masuk_predatech' => 'required|max_length[4]',
            'status_keanggotaan'    => 'required|in_list[Dosen,Alumni,Mahasiswa]',
            'jenis_kelamin'         => 'required|in_list[Laki-laki,Perempuan]',
            'foto_anggota'          => 'permit_empty|is_image[foto_anggota]|max_size[foto_anggota,2048]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $fotoName = $anggota['foto_anggota'];
        $foto = $this->request->getFile('foto_anggota');
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $fotoName = $foto->getRandomName();
            $foto->move(FCPATH . 'uploads/anggota/', $fotoName);

            // Remove old uploaded file if not default SVG
            if (!empty($anggota['foto_anggota']) && !str_starts_with($anggota['foto_anggota'], 'avatar_')) {
                @unlink(FCPATH . 'uploads/anggota/' . $anggota['foto_anggota']);
            }
        }

        $updateData = [
            'nama_anggota'          => $this->request->getPost('nama_anggota'),
            'nomor_anggota'         => $this->request->getPost('nomor_anggota'),
            'grup_puzzle'           => $this->request->getPost('grup_puzzle') ?: 1,
            'jenis_kelamin'         => $this->request->getPost('jenis_kelamin'),
            'program_studi'         => $this->request->getPost('program_studi'),
            'angkatan'              => $this->request->getPost('angkatan'),
            'tahun_masuk_predatech' => $this->request->getPost('tahun_masuk_predatech'),
            'email_aktif'           => $this->request->getPost('email_aktif'),
            'no_hp'                 => $this->request->getPost('no_hp'),
            'kota_domisili'         => $this->request->getPost('kota_domisili'),
            'alamat_domisili'       => $this->request->getPost('alamat_domisili'),
            'link_linkedin'         => $this->request->getPost('link_linkedin'),
            'link_scopus'           => $this->request->getPost('link_scopus'),
            'link_scholar'          => $this->request->getPost('link_scholar'),
            'link_instagram'        => $this->request->getPost('link_instagram'),
            'status_keanggotaan'    => $this->request->getPost('status_keanggotaan'),
            'status_perkawinan'     => $this->request->getPost('status_perkawinan') ?: 'Belum Kawin',
            'bidang_riset'          => $this->request->getPost('bidang_riset') ?: 'Data Mining',
            'foto_anggota'          => $fotoName,
            'motto'                 => $this->request->getPost('motto'),
            'tahun_lulus'           => $this->request->getPost('tahun_lulus') ?: null,
            'pendidikan_sekarang'   => $this->request->getPost('pendidikan_sekarang') ?: 'S1',
            'pekerjaan_pertama'     => $this->request->getPost('pekerjaan_pertama'),
            'tahun_kerja_pertama'   => $this->request->getPost('tahun_kerja_pertama'),
            'pekerjaan_saat_ini'    => $this->request->getPost('pekerjaan_saat_ini'),
            'mulai_bekerja'         => $this->request->getPost('mulai_bekerja'),
            'instansi_perusahaan'   => $this->request->getPost('instansi_perusahaan'),
            'jabatan_pekerjaan'     => $this->request->getPost('jabatan_pekerjaan'),
            'website_instansi'      => $this->request->getPost('website_instansi'),
            'profil_instansi'       => $this->request->getPost('profil_instansi'),
            'tanggal_update'        => date('d-m-Y'),
        ];

        if ($this->request->getPost('id_user')) {
            $updateData['id_user'] = $this->request->getPost('id_user');
        }

        $this->anggotaModel->update($id, $updateData);

        return redirect()->to('/admin/anggota')->with('success', 'Data Anggota ' . $updateData['nama_anggota'] . ' berhasil diperbarui!');
    }

    /**
     * Delete Anggota
     */
    public function delete($id)
    {
        $anggota = $this->anggotaModel->find($id);
        if (!$anggota) {
            return redirect()->back()->with('error', 'Data Anggota tidak ditemukan.');
        }

        if (!empty($anggota['foto_anggota']) && !str_starts_with($anggota['foto_anggota'], 'avatar_')) {
            @unlink(FCPATH . 'uploads/anggota/' . $anggota['foto_anggota']);
        }

        $this->anggotaModel->delete($id);

        return redirect()->to('/admin/anggota')->with('success', 'Data Anggota berhasil dihapus.');
    }

    /**
     * Show detail page inside Admin view
     */
    public function detail($id)
    {
        $anggota = $this->anggotaModel->getAnggotaWithUser($id);
        if (!$anggota) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Anggota tidak ditemukan.');
        }

        $karyaList = $this->karyaModel->getByAnggota($id);

        $data = [
            'title'     => 'Detail Profil: ' . $anggota['nama_anggota'] . ' - POSMA Predatech',
            'anggota'   => $anggota,
            'karyaList' => $karyaList,
        ];

        return view('admin/anggota/detail', $data);
    }
}
