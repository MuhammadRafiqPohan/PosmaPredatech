<?php

namespace App\Controllers;

use App\Models\AnggotaModel;
use App\Models\KaryaModel;
use App\Models\KategoriModel;
use App\Models\UserModel;

class Dashboard extends BaseController
{
    protected $anggotaModel;
    protected $karyaModel;
    protected $kategoriModel;
    protected $userModel;

    public function __construct()
    {
        $this->anggotaModel  = new AnggotaModel();
        $this->karyaModel    = new KaryaModel();
        $this->kategoriModel = new KategoriModel();
        $this->userModel     = new UserModel();
    }

    public function index()
    {
        $userLevel = session()->get('level');
        $idUser    = session()->get('id_user');
        $idAnggota = session()->get('id_anggota');

        $statsAnggota = $this->anggotaModel->getStatistics();
        $statsKarya   = $this->karyaModel->getStatistics();
        $totalUsers   = $this->userModel->countAllResults();

        // If logged in as 'Anggota', fetch their personal works
        $myKarya = [];
        $myProfile = null;
        if ($userLevel === 'Anggota' && $idAnggota) {
            $myKarya = $this->karyaModel->getByAnggota($idAnggota);
            $myProfile = $this->anggotaModel->find($idAnggota);
        }

        // Recent items
        $recentAnggota = $this->anggotaModel->orderBy('created_at', 'DESC')->findAll(5);
        $recentKarya   = array_slice($this->karyaModel->getKaryaWithDetails(), 0, 5);

        $data = [
            'title'        => 'Dashboard ' . $userLevel . ' - POSMA Predatech',
            'userLevel'    => $userLevel,
            'statsAnggota' => $statsAnggota,
            'statsKarya'   => $statsKarya,
            'totalUsers'   => $totalUsers,
            'myKarya'      => $myKarya,
            'myProfile'    => $myProfile,
            'recentAnggota'=> $recentAnggota,
            'recentKarya'  => $recentKarya,
        ];

        return view('admin/dashboard', $data);
    }
}
