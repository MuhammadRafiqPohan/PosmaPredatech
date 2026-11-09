<?php

namespace App\Controllers;

use App\Models\KategoriModel;

class Kategori extends BaseController
{
    protected $kategoriModel;

    public function __construct()
    {
        $this->kategoriModel = new KategoriModel();
    }

    public function index()
    {
        $categories = $this->kategoriModel->findAll();

        $data = [
            'title'      => 'Kelola Kategori Karya - POSMA Predatech',
            'categories' => $categories,
        ];

        return view('admin/kategori/index', $data);
    }

    public function store()
    {
        $rules = [
            'kategori'   => 'required|min_length[2]|max_length[50]',
            'icon_karya' => 'permit_empty|max_length[100]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->kategoriModel->insert([
            'kategori'   => $this->request->getPost('kategori'),
            'icon_karya' => $this->request->getPost('icon_karya') ?: 'fa-tag',
        ]);

        return redirect()->to('/admin/kategori')->with('success', 'Kategori baru berhasil ditambahkan!');
    }

    public function update($id)
    {
        $rules = [
            'kategori'   => 'required|min_length[2]|max_length[50]',
            'icon_karya' => 'permit_empty|max_length[100]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->kategoriModel->update($id, [
            'kategori'   => $this->request->getPost('kategori'),
            'icon_karya' => $this->request->getPost('icon_karya') ?: 'fa-tag',
        ]);

        return redirect()->to('/admin/kategori')->with('success', 'Kategori berhasil diperbarui!');
    }

    public function delete($id)
    {
        try {
            $this->kategoriModel->delete($id);
            return redirect()->to('/admin/kategori')->with('success', 'Kategori berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Kategori tidak dapat dihapus karena masih digunakan pada data karya.');
        }
    }
}
