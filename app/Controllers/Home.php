<?php

namespace App\Controllers;

use App\Models\AnggotaModel;
use App\Models\KaryaModel;
use App\Models\KategoriModel;

class Home extends BaseController
{
    protected $anggotaModel;
    protected $karyaModel;
    protected $kategoriModel;

    public function __construct()
    {
        $this->anggotaModel  = new AnggotaModel();
        $this->karyaModel    = new KaryaModel();
        $this->kategoriModel = new KategoriModel();
    }

    /**
     * Homepage / Beranda POSMA Predatech
     */
    public function index()
    {
        $statsAnggota = $this->anggotaModel->getStatistics();
        $statsKarya   = $this->karyaModel->getStatistics();

        // Recent Anggota (last 6)
        $recentAnggota = $this->anggotaModel->orderBy('created_at', 'DESC')->findAll(6);

        // Recent Karya (last 6 with details)
        $recentKarya = $this->karyaModel->getKaryaWithDetails();
        $recentKarya = array_slice($recentKarya, 0, 6);

        // All Categories
        $categories = $this->kategoriModel->findAll();

        $data = [
            'title'         => 'POSMA Predatech - Sistem Informasi Repository & Manajemen Alumni',
            'statsAnggota'  => $statsAnggota,
            'statsKarya'    => $statsKarya,
            'recentAnggota' => $recentAnggota,
            'recentKarya'   => $recentKarya,
            'categories'    => $categories,
        ];

        return view('frontend/home', $data);
    }

    /**
     * Search Results Page (Matching PDF Page 3 & 5)
     */
    public function search()
    {
        $type    = $this->request->getGet('type') ?? 'Anggota'; // 'Anggota' or 'Karya'
        $keyword = trim((string)($this->request->getGet('q') ?? ''));
        $filter  = $this->request->getGet('filter') ?? '';

        $results = [];

        if (strtolower($type) === 'karya') {
            $results = $this->karyaModel->searchKarya($keyword, $filter);
        } else {
            $type = 'Anggota';
            $results = $this->anggotaModel->searchAnggota($keyword, $filter);
        }

        $data = [
            'title'   => 'Hasil Pencarian ' . $type . ': ' . ($keyword ?: 'Semua Data') . ' - POSMA Predatech',
            'type'    => $type,
            'keyword' => $keyword,
            'filter'  => $filter,
            'results' => $results,
        ];

        return view('frontend/search_results', $data);
    }

    /**
     * Detail Anggota Page (Matching PDF Page 4)
     */
    public function anggotaDetail($id_anggota)
    {
        $anggota = $this->anggotaModel->getAnggotaWithUser($id_anggota);
        if (!$anggota) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Data Anggota dengan NIM ' . $id_anggota . ' tidak ditemukan.');
        }

        // Get all works / publications by this member
        $karyaList = $this->karyaModel->getByAnggota($id_anggota);

        $data = [
            'title'     => 'Profil Anggota: ' . $anggota['nama_anggota'] . ' - POSMA Predatech',
            'anggota'   => $anggota,
            'karyaList' => $karyaList,
        ];

        return view('frontend/detail_anggota', $data);
    }

    /**
     * Detail Karya Page (Matching PDF Page 5)
     */
    public function karyaDetail($id_karya)
    {
        $karya = $this->karyaModel->getKaryaWithDetails($id_karya);
        if (!$karya) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Data Karya dengan ID ' . $id_karya . ' tidak ditemukan.');
        }

        // Get other publications by same author or similar
        $otherKarya = $this->karyaModel->getByAnggota($karya['id_anggota']);

        $data = [
            'title'      => 'Detail Karya: ' . $karya['judul_karya'] . ' - POSMA Predatech',
            'karya'      => $karya,
            'otherKarya' => $otherKarya,
        ];

        return view('frontend/detail_karya', $data);
    }

    /**
     * Instant JSON Search for Alpine.js Autocomplete
     */
    public function apiSearch()
    {
        $type    = $this->request->getGet('type') ?? 'Anggota';
        $keyword = trim((string)($this->request->getGet('q') ?? ''));

        if (empty($keyword)) {
            return $this->response->setJSON(['status' => 'success', 'data' => []]);
        }

        if (strtolower($type) === 'karya') {
            $items = $this->karyaModel->searchKarya($keyword);
            $formatted = array_map(function ($k) {
                return [
                    'id'       => $k['id_karya'],
                    'title'    => $k['judul_karya'],
                    'subtitle' => $k['penulis_pertama'] . ' (' . $k['tahun_terbit'] . ') - ' . $k['jenis_karya'],
                    'badge'    => $k['nama_kategori'] ?? $k['level_karya'],
                    'url'      => base_url('karya/' . $k['id_karya']),
                    'icon'     => 'fa-book-open',
                ];
            }, array_slice($items, 0, 8));
        } else {
            $items = $this->anggotaModel->searchAnggota($keyword);
            $formatted = array_map(function ($a) {
                return [
                    'id'       => $a['id_anggota'],
                    'title'    => $a['nama_anggota'],
                    'subtitle' => 'NIM: ' . $a['id_anggota'] . ' | ' . $a['program_studi'] . ' - ' . $a['status_keanggotaan'],
                    'badge'    => $a['status_keanggotaan'],
                    'url'      => base_url('anggota/' . $a['id_anggota']),
                    'icon'     => 'fa-user-graduate',
                ];
            }, array_slice($items, 0, 8));
        }

        return $this->response->setJSON([
            'status' => 'success',
            'count'  => count($formatted),
            'data'   => $formatted,
        ]);
    }
}
