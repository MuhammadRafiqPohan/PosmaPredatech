<?php

namespace App\Models;

use CodeIgniter\Model;

class AnggotaModel extends Model
{
    protected $table            = 'anggota';
    protected $primaryKey       = 'id_anggota';
    protected $useAutoIncrement = false; // Primary Key is NIM UIN
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_anggota',
        'id_user',
        'nama_anggota',
        'nomor_anggota',
        'grup_puzzle',
        'jenis_kelamin',
        'program_studi',
        'angkatan',
        'tahun_masuk_predatech',
        'email_aktif',
        'no_hp',
        'kota_domisili',
        'alamat_domisili',
        'link_linkedin',
        'link_scopus',
        'link_scholar',
        'link_instagram',
        'status_keanggotaan',
        'status_perkawinan',
        'bidang_riset',
        'foto_anggota',
        'motto',
        'tahun_lulus',
        'pendidikan_sekarang',
        'pekerjaan_pertama',
        'tahun_kerja_pertama',
        'pekerjaan_saat_ini',
        'mulai_bekerja',
        'instansi_perusahaan',
        'jabatan_pekerjaan',
        'website_instansi',
        'profil_instansi',
        'tanggal_update',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Get Anggota with User details
     */
    public function getAnggotaWithUser($id_anggota = null)
    {
        $builder = $this->builder();
        $builder->select('anggota.*, user.username, user.level');
        $builder->join('user', 'user.id_user = anggota.id_user', 'left');

        if ($id_anggota !== null) {
            return $builder->where('anggota.id_anggota', $id_anggota)->get()->getRowArray();
        }

        return $builder->orderBy('anggota.nama_anggota', 'ASC')->get()->getResultArray();
    }

    /**
     * Search Anggota by query keyword
     */
    public function searchAnggota($keyword = null, $prodi = null, $status = null)
    {
        $builder = $this->builder();
        $builder->select('anggota.*, user.username, user.level, COUNT(karya.id_karya) as total_karya');
        $builder->join('user', 'user.id_user = anggota.id_user', 'left');
        $builder->join('karya', 'karya.id_anggota = anggota.id_anggota', 'left');

        if (!empty($keyword)) {
            $builder->groupStart()
                ->like('anggota.nama_anggota', $keyword)
                ->orLike('anggota.nomor_anggota', $keyword)
                ->orLike('CAST(anggota.id_anggota AS CHAR)', $keyword)
                ->orLike('anggota.bidang_riset', $keyword)
                ->orLike('anggota.pekerjaan_saat_ini', $keyword)
                ->orLike('anggota.instansi_perusahaan', $keyword)
                ->orLike('anggota.kota_domisili', $keyword)
                ->groupEnd();
        }

        if (!empty($prodi)) {
            $builder->where('anggota.program_studi', $prodi);
        }

        if (!empty($status)) {
            $builder->where('anggota.status_keanggotaan', $status);
        }

        $builder->groupBy('anggota.id_anggota');
        $builder->orderBy('anggota.nama_anggota', 'ASC');

        return $builder->get()->getResultArray();
    }

    /**
     * Statistics for Dashboard
     */
    public function getStatistics()
    {
        $total = $this->countAllResults();
        $alumni = $this->where('status_keanggotaan', 'Alumni')->countAllResults();
        $mahasiswa = $this->where('status_keanggotaan', 'Mahasiswa')->countAllResults();
        $dosen = $this->where('status_keanggotaan', 'Dosen')->countAllResults();

        // By Prodi
        $prodiCounts = $this->builder()
            ->select('program_studi, count(*) as count')
            ->groupBy('program_studi')
            ->get()->getResultArray();

        return [
            'total' => $total,
            'alumni' => $alumni,
            'mahasiswa' => $mahasiswa,
            'dosen' => $dosen,
            'prodi' => $prodiCounts,
        ];
    }
}
