<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\AnggotaModel;

class User extends BaseController
{
    protected $userModel;
    protected $anggotaModel;

    public function __construct()
    {
        $this->userModel    = new UserModel();
        $this->anggotaModel = new AnggotaModel();
    }

    public function index()
    {
        $users = $this->userModel->orderBy('id_user', 'ASC')->findAll();

        $data = [
            'title' => 'Manajemen Pengguna Sistem - POSMA Predatech',
            'users' => $users,
        ];

        return view('admin/user/index', $data);
    }

    public function store()
    {
        $rules = [
            'nama_user' => 'required|min_length[3]|max_length[50]',
            'username'  => 'required|min_length[3]|max_length[50]|is_unique[user.username]',
            'password'  => 'required|min_length[6]',
            'level'     => 'required|in_list[Admin,Operator,Anggota]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->userModel->insert([
            'nama_user' => $this->request->getPost('nama_user'),
            'username'  => $this->request->getPost('username'),
            'password'  => $this->request->getPost('password'),
            'level'     => $this->request->getPost('level'),
        ]);

        return redirect()->to('/admin/users')->with('success', 'Akun pengguna berhasil dibuat!');
    }

    public function update($id)
    {
        $rules = [
            'nama_user' => 'required|min_length[3]|max_length[50]',
            'username'  => "required|min_length[3]|max_length[50]|is_unique[user.username,id_user,{$id}]",
            'level'     => 'required|in_list[Admin,Operator,Anggota]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $updateData = [
            'nama_user' => $this->request->getPost('nama_user'),
            'username'  => $this->request->getPost('username'),
            'level'     => $this->request->getPost('level'),
        ];

        if ($this->request->getPost('password')) {
            $updateData['password'] = $this->request->getPost('password');
        }

        $this->userModel->update($id, $updateData);

        return redirect()->to('/admin/users')->with('success', 'Data akun berhasil diperbarui!');
    }

    public function delete($id)
    {
        if ($id == session()->get('id_user')) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $this->userModel->delete($id);

        return redirect()->to('/admin/users')->with('success', 'Akun pengguna berhasil dihapus.');
    }
}
