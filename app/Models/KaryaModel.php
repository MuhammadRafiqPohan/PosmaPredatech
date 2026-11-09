<?php

namespace App\Models;

use CodeIgniter\Model;

class KaryaModel extends Model
{
    protected $table            = 'karya';
    protected $primaryKey       = 'id_karya';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_anggota',
        'jenis_karya',
        'level_karya',
        'id_kategori',
        'judul_karya',
        'penulis_pertama',
        'penulis_semua',
        'nama_terbitan',
        'penerbit',
        'volume',
        'nomor',
        'tahun_terbit',
        'link_karya',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Get Karya with Anggota and Kategori details
     */
    public function getKaryaWithDetails($id_karya = null)
    {
        $builder = $this->builder();
        $builder->select('karya.*, anggota.nama_anggota, anggota.nomor_anggota, anggota.foto_anggota, anggota.program_studi, kategori.kategori as nama_kategori, kategori.icon_karya');
        $builder->join('anggota', 'anggota.id_anggota = karya.id_anggota', 'left');
        $builder->join('kategori', 'kategori.id_kategori = karya.id_kategori', 'left');

        if ($id_karya !== null) {
            return $builder->where('karya.id_karya', $id_karya)->get()->getRowArray();
        }

        return $builder->orderBy('karya.tahun_terbit', 'DESC')
            ->orderBy('karya.id_karya', 'DESC')
            ->get()->getResultArray();
    }

    /**
     * Get all Karya produced by a specific Anggota
     */
    public function getByAnggota($id_anggota)
    {
        return $this->builder()
            ->select('karya.*, kategori.kategori as nama_kategori, kategori.icon_karya')
            ->join('kategori', 'kategori.id_kategori = karya.id_kategori', 'left')
            ->where('karya.id_anggota', $id_anggota)
            ->orderBy('karya.tahun_terbit', 'DESC')
            ->get()->getResultArray();
    }

    /**
     * Search Karya by query keyword and optional filters
     */
    public function searchKarya($keyword = null, $jenis = null, $level = null, $tahun = null)
    {
        $builder = $this->builder();
        $builder->select('karya.*, anggota.nama_anggota, anggota.nomor_anggota, anggota.foto_anggota, kategori.kategori as nama_kategori, kategori.icon_karya');
        $builder->join('anggota', 'anggota.id_anggota = karya.id_anggota', 'left');
        $builder->join('kategori', 'kategori.id_kategori = karya.id_kategori', 'left');

        if (!empty($keyword)) {
            $builder->groupStart()
                ->like('karya.judul_karya', $keyword)
                ->orLike('karya.penulis_pertama', $keyword)
                ->orLike('karya.penulis_semua', $keyword)
                ->orLike('karya.nama_terbitan', $keyword)
                ->orLike('karya.penerbit', $keyword)
                ->orLike('kategori.kategori', $keyword)
                ->groupEnd();
        }

        if (!empty($jenis)) {
            $builder->where('karya.jenis_karya', $jenis);
        }

        if (!empty($level)) {
            $builder->where('karya.level_karya', $level);
        }

        if (!empty($tahun)) {
            $builder->where('karya.tahun_terbit', $tahun);
        }

        return $builder->orderBy('karya.tahun_terbit', 'DESC')
            ->orderBy('karya.id_karya', 'DESC')
            ->get()->getResultArray();
    }

    /**
     * Statistics for Dashboard
     */
    public function getStatistics()
    {
        $total = $this->countAllResults();
        $jurnal = $this->where('jenis_karya', 'Jurnal')->countAllResults();
        $prosiding = $this->where('jenis_karya', 'Prosiding')->countAllResults();
        $hki = $this->where('jenis_karya', 'HKI')->countAllResults();
        $buku = $this->where('jenis_karya', 'Buku')->countAllResults();
        $sistem = $this->where('jenis_karya', 'Sistem dan Aplikasi')->countAllResults();

        // By Year
        $yearlyCounts = $this->builder()
            ->select('tahun_terbit, count(*) as count')
            ->groupBy('tahun_terbit')
            ->orderBy('tahun_terbit', 'ASC')
            ->get()->getResultArray();

        return [
            'total' => $total,
            'jurnal' => $jurnal,
            'prosiding' => $prosiding,
            'hki' => $hki,
            'buku' => $buku,
            'sistem' => $sistem,
            'yearly' => $yearlyCounts,
        ];
    }
}
