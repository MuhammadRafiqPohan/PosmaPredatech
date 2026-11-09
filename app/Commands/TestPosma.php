<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Config\Services;

class TestPosma extends BaseCommand
{
    protected $group       = 'Testing';
    protected $name        = 'posma:test';
    protected $description = 'Tests all POSMA Predatech endpoints and views';

    public function run(array $params)
    {
        CLI::write('==========================================', 'yellow');
        CLI::write('POSMA PREDATECH ENDPOINT & VIEW TEST SUITE', 'yellow');
        CLI::write('==========================================', 'yellow');

        // Test 1: Home index
        try {
            $home = new \App\Controllers\Home();
            $home->initController(Services::request(), Services::response(), Services::logger());
            $output = $home->index();
            CLI::write('✓ Home::index rendered successfully (' . strlen($output) . ' bytes)', 'green');
        } catch (\Throwable $e) {
            CLI::error('✗ Home::index failed: ' . $e->getMessage());
        }

        // Test 2: Search Anggota
        try {
            $_GET['type'] = 'Anggota';
            $_GET['q'] = 'Nurul';
            $output = $home->search();
            CLI::write('✓ Home::search (Anggota) rendered successfully (' . strlen($output) . ' bytes)', 'green');
        } catch (\Throwable $e) {
            CLI::error('✗ Home::search (Anggota) failed: ' . $e->getMessage());
        }

        // Test 3: Search Karya
        try {
            $_GET['type'] = 'Karya';
            $_GET['q'] = 'Naïve';
            $output = $home->search();
            CLI::write('✓ Home::search (Karya) rendered successfully (' . strlen($output) . ' bytes)', 'green');
        } catch (\Throwable $e) {
            CLI::error('✗ Home::search (Karya) failed: ' . $e->getMessage());
        }

        // Test 4: Detail Anggota
        try {
            $output = $home->anggotaDetail('1106722092');
            CLI::write('✓ Home::anggotaDetail (1106722092) rendered successfully (' . strlen($output) . ' bytes)', 'green');
        } catch (\Throwable $e) {
            CLI::error('✗ Home::anggotaDetail failed: ' . $e->getMessage());
        }

        // Test 5: Detail Karya
        try {
            $output = $home->karyaDetail(1);
            CLI::write('✓ Home::karyaDetail (1) rendered successfully (' . strlen($output) . ' bytes)', 'green');
        } catch (\Throwable $e) {
            CLI::error('✗ Home::karyaDetail failed: ' . $e->getMessage());
        }

        // Test 6: API Instant Search
        try {
            $_GET['type'] = 'Anggota';
            $_GET['q'] = 'Nurul';
            $res = $home->apiSearch();
            CLI::write('✓ Home::apiSearch (JSON) returned successfully', 'green');
        } catch (\Throwable $e) {
            CLI::error('✗ Home::apiSearch failed: ' . $e->getMessage());
        }

        // Test 7: Auth Login
        try {
            $auth = new \App\Controllers\Auth();
            $auth->initController(Services::incomingrequest(), Services::response(), Services::logger());
            $output = $auth->login();
            CLI::write('✓ Auth::login rendered successfully (' . strlen($output) . ' bytes)', 'green');
        } catch (\Throwable $e) {
            CLI::error('✗ Auth::login failed: ' . $e->getMessage());
        }

        // Test 8: Dashboard (Admin)
        try {
            session()->set([
                'isLoggedIn'   => true,
                'id_user'      => 1,
                'nama_user'    => 'Administrator POSMA',
                'username'     => 'admin',
                'level'        => 'Admin',
                'id_anggota'   => null,
                'foto_anggota' => null
            ]);
            $dash = new \App\Controllers\Dashboard();
            $dash->initController(Services::request(), Services::response(), Services::logger());
            $output = $dash->index();
            CLI::write('✓ Dashboard::index rendered successfully (' . strlen($output) . ' bytes)', 'green');
        } catch (\Throwable $e) {
            CLI::error('✗ Dashboard::index failed: ' . $e->getMessage());
        }

        // Test 9: Anggota Index View
        try {
            $anggotaCtrl = new \App\Controllers\Anggota();
            $anggotaCtrl->initController(Services::request(), Services::response(), Services::logger());
            $output = $anggotaCtrl->index();
            CLI::write('✓ Anggota::index rendered successfully (' . strlen($output) . ' bytes)', 'green');
        } catch (\Throwable $e) {
            CLI::error('✗ Anggota::index failed: ' . $e->getMessage());
        }

        // Test 10: Karya Index View
        try {
            $karyaCtrl = new \App\Controllers\Karya();
            $karyaCtrl->initController(Services::request(), Services::response(), Services::logger());
            $output = $karyaCtrl->index();
            CLI::write('✓ Karya::index rendered successfully (' . strlen($output) . ' bytes)', 'green');
        } catch (\Throwable $e) {
            CLI::error('✗ Karya::index failed: ' . $e->getMessage());
        }

        CLI::write('==========================================', 'yellow');
        CLI::write('ALL TESTS EXECUTED!', 'yellow');
    }
}
