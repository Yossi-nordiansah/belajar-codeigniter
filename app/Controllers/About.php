<?php

// use App\Controllers\BaseController;
namespace App\Controllers;

class About extends BaseController {
    
    public function index($nama = "Yossi Nordiansah", $usia = 26){
        echo "Hallo nama saya $nama, saya berusia $usia";
    }

}