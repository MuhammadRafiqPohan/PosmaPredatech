<?php

namespace App\Controllers;

use App\Models\KaryaModel;
use App\Models\AnggotaModel;
use App\Models\KategoriModel;

class Karya extends BaseController
{
    protected $karyaModel;
    protected $anggotaModel;
    protected $kategoriModel;

    public function __construct()
    {
        $this->karyaModel    = new KaryaModel();
        $this->anggotaModel  = new AnggotaModel();
        $this->kategoriModel = new KategoriModel();
    }

    /**
     * Display list of Karya
     */
    public function index()
    {
        $keyword = trim((string)($this->request->getGet('q') ?? ''));
        $jenis   = $this->request->getGet('jenis') ?? '';
        $level   = $this->request->getGet('level') ?? '';
        $tahun   = $this->request->getGet('tahun') ?? '';

        $karyaList = $this->karyaModel->searchKarya($keyword, $jenis, $level, $tahun);
        $categories = $this->kategoriModel->findAll();

        $data = [
            'title'      => 'Manajemen Data Karya & Publikasi - POSMA Predatech',
            'karyaList'  => $karyaList,
            'categories' => $categories,
            'keyword'    => $keyword,
            'jenis'      => $jenis,
            'level'      => $level,
            'tahun'      => $tahun,
        ];

        return view('admin/karya/index', $data);
    }

    /**
     * Show form to create new Karya
     */
    public function create()
    {
        $anggotaList = $this->anggotaModel->orderBy('nama_anggota', 'ASC')->findAll();
        $kategoriList = $this->kategoriModel->orderBy('kategori', 'ASC')->findAll();

        $preselectedAnggota = $this->request->getGet('id_anggota');

        $data = [
            'title'              => 'Tambah Karya / Publikasi Baru - POSMA Predatech',
            'anggotaList'        => $anggotaList,
            'kategoriList'       => $kategoriList,
            'preselectedAnggota' => $preselectedAnggota,
        ];

        return view('admin/karya/create', $data);
    }

    /**
     * Store new Karya
     */
    public function store()
    {
        $rules = [
            'id_anggota'      => 'required|numeric',
            'jenis_karya'     => 'required|in_list[Prosiding,Jurnal,HKI,Buku,Sistem dan Aplikasi]',
            'level_karya'     => 'required|in_list[Lokal,Nasional,Internasional]',
            'id_kategori'     => 'required|numeric',
            'judul_karya'     => 'required|min_length[5]',
            'penulis_pertama' => 'required',
            'tahun_terbit'    => 'required|numeric|exact_length[4]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $saveData = [
            'id_anggota'      => $this->request->getPost('id_anggota'),
            'jenis_karya'     => $this->request->getPost('jenis_karya'),
            'level_karya'     => $this->request->getPost('level_karya'),
            'id_kategori'     => $this->request->getPost('id_kategori'),
            'judul_karya'     => $this->request->getPost('judul_karya'),
            'penulis_pertama' => $this->request->getPost('penulis_pertama'),
            'penulis_semua'   => $this->request->getPost('penulis_semua'),
            'nama_terbitan'   => $this->request->getPost('nama_terbitan'),
            'penerbit'        => $this->request->getPost('penerbit'),
            'volume'          => $this->request->getPost('volume'),
            'nomor'           => $this->request->getPost('nomor'),
            'tahun_terbit'    => $this->request->getPost('tahun_terbit'),
            'link_karya'      => $this->request->getPost('link_karya'),
        ];

        $this->karyaModel->insert($saveData);

        return redirect()->to('/admin/karya')->with('success', 'Karya berhasil didaftarkan ke repositori POSMA!');
    }

    /**
     * Show form to edit Karya
     */
    public function edit($id)
    {
        $karya = $this->karyaModel->find($id);
        if (!$karya) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Karya tidak ditemukan.');
        }

        // Access check for regular members
        $userLevel = session()->get('level');
        $myNIM     = session()->get('id_anggota');
        if ($userLevel === 'Anggota' && $myNIM != $karya['id_anggota']) {
            return redirect()->to('/dashboard')->with('error', 'Anda hanya diizinkan mengedit karya Anda sendiri.');
        }

        $anggotaList = $this->anggotaModel->orderBy('nama_anggota', 'ASC')->findAll();
        $kategoriList = $this->kategoriModel->orderBy('kategori', 'ASC')->findAll();

        $data = [
            'title'        => 'Edit Karya: ' . $karya['judul_karya'],
            'karya'        => $karya,
            'anggotaList'  => $anggotaList,
            'kategoriList' => $kategoriList,
        ];

        return view('admin/karya/edit', $data);
    }

    /**
     * Update Karya
     */
    public function update($id)
    {
        $karya = $this->karyaModel->find($id);
        if (!$karya) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Karya tidak ditemukan.');
        }

        $userLevel = session()->get('level');
        $myNIM     = session()->get('id_anggota');
        if ($userLevel === 'Anggota' && $myNIM != $karya['id_anggota']) {
            return redirect()->to('/dashboard')->with('error', 'Anda hanya diizinkan mengedit karya Anda sendiri.');
        }

        $rules = [
            'id_anggota'      => 'required|numeric',
            'jenis_karya'     => 'required|in_list[Prosiding,Jurnal,HKI,Buku,Sistem dan Aplikasi]',
            'level_karya'     => 'required|in_list[Lokal,Nasional,Internasional]',
            'id_kategori'     => 'required|numeric',
            'judul_karya'     => 'required|min_length[5]',
            'penulis_pertama' => 'required',
            'tahun_terbit'    => 'required|numeric|exact_length[4]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $updateData = [
            'id_anggota'      => $this->request->getPost('id_anggota'),
            'jenis_karya'     => $this->request->getPost('jenis_karya'),
            'level_karya'     => $this->request->getPost('level_karya'),
            'id_kategori'     => $this->request->getPost('id_kategori'),
            'judul_karya'     => $this->request->getPost('judul_karya'),
            'penulis_pertama' => $this->request->getPost('penulis_pertama'),
            'penulis_semua'   => $this->request->getPost('penulis_semua'),
            'nama_terbitan'   => $this->request->getPost('nama_terbitan'),
            'penerbit'        => $this->request->getPost('penerbit'),
            'volume'          => $this->request->getPost('volume'),
            'nomor'           => $this->request->getPost('nomor'),
            'tahun_terbit'    => $this->request->getPost('tahun_terbit'),
            'link_karya'      => $this->request->getPost('link_karya'),
        ];

        $this->karyaModel->update($id, $updateData);

        return redirect()->to('/admin/karya')->with('success', 'Data karya berhasil diperbarui!');
    }

    /**
     * Delete Karya
     */
    public function delete($id)
    {
        $karya = $this->karyaModel->find($id);
        if (!$karya) {
            return redirect()->back()->with('error', 'Data Karya tidak ditemukan.');
        }

        $userLevel = session()->get('level');
        $myNIM     = session()->get('id_anggota');
        if ($userLevel === 'Anggota' && $myNIM != $karya['id_anggota']) {
            return redirect()->to('/dashboard')->with('error', 'Anda tidak diizinkan menghapus karya ini.');
        }

        $this->karyaModel->delete($id);

        return redirect()->to('/admin/karya')->with('success', 'Karya berhasil dihapus.');
    }

    /**
     * Detail Karya inside Admin
     */
    public function detail($id)
    {
        $karya = $this->karyaModel->getKaryaWithDetails($id);
        if (!$karya) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Karya tidak ditemukan.');
        }

        $data = [
            'title' => 'Detail Karya: ' . $karya['judul_karya'],
            'karya' => $karya,
        ];

        return view('admin/karya/detail', $data);
    }
}
