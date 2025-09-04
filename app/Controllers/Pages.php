<?php

namespace App\Controllers;

class Pages extends BaseController
{
    public function index()
    {
        $data = [
            "title" => "Home | Yossi Nordiansah"
        ];
        return view('pages/home', $data);
    }

    public function about()
    {
        $data = [
            "title" => "About | Yossi Nordiansah"
        ];
        return view('pages/about', $data);
    }

    public function contact()
    {
        $data = [
            "title" => "Contact | Yossi Nordiansah",
            "alamat" => [
                [
                    'tipe' => "rumah",
                    "alamat" => "Jl Salak, RT 06, Rw 01, Segunung, Dlanggu",
                    "kota" => "Mojokerto"
                ],
                [
                    'tipe' => "Kantor",
                    "alamat" => "Jl Jabon, RT 06, Rw 01, Jabon, Mojoanyar",
                    "kota" => "Mojokerto"
                ]
                ]
        ];
        return view('pages/contact', $data);
    }
}
