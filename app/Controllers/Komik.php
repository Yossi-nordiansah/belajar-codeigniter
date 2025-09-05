<?php

namespace App\Controllers;

use \App\Models\KomikModel;

class Komik extends BaseController
{
    protected $komikModel;
    public function __construct()
    {
        $this->komikModel = new KomikModel();
    }

    public function index(): string
    {
        $komik = $this->komikModel->getKomik();
        $data = [
            'title' => "Daftar Komik",
            'komik' => $komik
        ];
        return view('Komik/index', $data);
    }

    public function detail($slug): string
    {
        $komik = $this->komikModel->getKomik($slug);
        $data = [
            'title' => "Daftar Komik",
            'komik' => $komik
        ];
        return view('Komik/detail', $data);
    }
}
