<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriModel extends Model
{
    protected $table            = 'kategori';
    protected $primaryKey       = 'id_kategori';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = [
        'kategori',
        'icon_karya'
    ];

    protected $useTimestamps = false;

    protected $validationRules = [
        'kategori' => 'required|min_length[2]|max_length[50]',
    ];
}
