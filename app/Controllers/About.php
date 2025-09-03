<?php

// use App\Controllers\BaseController;
namespace App\Controllers;

class About extends BaseController {
    
    public function index($nama = "Yossi Nordiansah"){
        echo "Hallo nama saya $nama";
    }

}