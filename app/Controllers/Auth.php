<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\AnggotaModel;

class Auth extends BaseController
{
    protected $userModel;
    protected $anggotaModel;

    public function __construct()
    {
        $this->userModel    = new UserModel();
        $this->anggotaModel = new AnggotaModel();
    }

    /**
     * Show Login Page
     */
    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to(base_url('dashboard'));
        }

        $data = [
            'title' => 'Login Sistem POSMA Predatech',
        ];

        return view('auth/login', $data);
    }

    /**
     * Handle Login Authentication
     */
    public function processLogin()
    {
        $rules = [
            'username' => 'required|min_length[3]',
            'password' => 'required|min_length[4]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Silakan masukkan username dan password yang valid.');
        }

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $this->userModel->authenticate($username, $password);

        if (!$user) {
            return redirect()->back()->withInput()->with('error', 'Username atau password salah. Silakan coba lagi.');
        }

        // Check if there is an associated Anggota profile
        $anggota = $this->anggotaModel->where('id_user', $user['id_user'])->first();

        // Set session
        $sessionData = [
            'isLoggedIn'   => true,
            'id_user'      => $user['id_user'],
            'nama_user'    => $user['nama_user'],
            'username'     => $user['username'],
            'level'        => $user['level'], // 'Admin', 'Operator', 'Anggota'
            'id_anggota'   => $anggota ? $anggota['id_anggota'] : null,
            'foto_anggota' => $anggota ? $anggota['foto_anggota'] : null,
        ];

        session()->set($sessionData);

        return redirect()->to(base_url('dashboard'))->with('success', 'Selamat datang kembali, ' . $user['nama_user'] . '!');
    }

    /**
     * Logout
     */
    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'))->with('success', 'Anda telah berhasil keluar dari sistem.');
    }

    /**
     * Show Change Password View
     */
    public function changePassword()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'Ubah Password - POSMA Predatech',
        ];

        return view('auth/change_password', $data);
    }

    /**
     * Process Password Change
     */
    public function updatePassword()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $rules = [
            'current_password' => 'required',
            'new_password'     => 'required|min_length[6]',
            'confirm_password' => 'required|matches[new_password]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        $userId = session()->get('id_user');
        $user   = $this->userModel->find($userId);

        $currentPassword = $this->request->getPost('current_password');
        $newPassword     = $this->request->getPost('new_password');

        if (!password_verify($currentPassword, $user['password']) && $currentPassword !== $user['password']) {
            return redirect()->back()->with('error', 'Password saat ini tidak sesuai.');
        }

        $this->userModel->update($userId, [
            'password' => $newPassword
        ]);

        return redirect()->back()->with('success', 'Password Anda berhasil diperbarui!');
    }
}
