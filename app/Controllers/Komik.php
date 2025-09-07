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

        if (empty($data['komik'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Judul Komik ' . $slug . ' tidak ditemukan');
        }

        return view('Komik/detail', $data);
    }

    public function save()
    {

        if (!$this->validate([
            'judul' => [
                'rules' => 'required|is_unique[komik.judul] ',
                'errors' => [
                    'required' => "Judul Komik Wajib Di Isi",
                    'is_unique' => "Judul Komik Sudah Terdaftar"
                ]
            ],
            'penulis' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Penulis Wajib Di Isi"
                ]
            ],
            'penerbit' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "Penerbit Wajib Di isi"
                ]
            ],
            'sampul' => [
                'rules' => 'max_size[sampul,1024]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'File terlalu besar',
                    'is_image' => 'File Harus Berupa Gambar',
                    'mime_in' => 'File Harus Berupa JPG, JPEG, atau PNG'
                ]
            ],
        ])) {
            return redirect()->back()->withInput();
        }


        $fileSampul = $this->request->getFile('sampul');
        if ($fileSampul->getError() == 4) {
            $namaSampul = 'default.jpg';
        } else {
            $fileSampul->move('img');
            $namaSampul = $fileSampul->getName();
        }

        $slug = url_title($this->request->getVar('judul'), '-', true);
        $this->komikModel->save([
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'sampul' => $namaSampul
        ]);

        session()->setFlashdata('pesan', 'Data Berhasil Ditambahkan');

        return redirect()->to("/komik");
    }

    public function delete($id)
    {
        $komik = $this->komikModel->find($id);

        if ($komik['sampul'] != 'default.jpg') {
            unlink('img/' . $komik['sampul']);
        }

        $this->komikModel->delete($id);
        return redirect()->to('/komik');
    }

    public function edit($slug)
    {
        $komik = $this->komikModel->getKomik($slug);
        $data = [
            'title' => "Daftar Komik",
            'komik' => $komik
        ];

        if (empty($data['komik'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Judul Komik ' . $slug . ' tidak ditemukan');
        }

        return view('Komik/detail', $data);
    }

    public function update($id)
    {
        $old = $this->komikModel->getKomik($this->request->getVar('slug'));
        if ($old['judul'] == $this->request->getVar('judul')) {
            $rule_judul = 'required';
        } else {
            $rule_judul = 'required|is_unique[komik.judul]';
        }
        if (!$this->validate([
            'judul' => [
                'rules' => $rule_judul,
                'errors' => [
                    'required' => "Judul Komik Wajib Di Isi",
                    'is_unique' => "Judul Komik Sudah Terdaftar"
                ]
            ],
            'penulis' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Penulis Wajib Di Isi"
                ]
            ],
            'penerbit' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "Penerbit Wajib Di isi"
                ]
            ],
            'sampul' => [
                'rules' => 'max_size[sampul,1024]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'File terlalu besar',
                    'is_image' => 'File Harus Berupa Gambar',
                    'mime_in' => 'File Harus Berupa JPG, JPEG, atau PNG'
                ]
            ],
        ])) {
            return redirect()->to("/komik/edit/" . $this->request->getVar('slug'))->withInput();
        }

        $fileSampul = $this->request->getFile('sampul');

        if($fileSampul->getError() == 4){
            $namaSampul = $this->request->getVar('fileLama'); 
        } 
        else {
            $namaSampul = $fileSampul->getName();
            $fileSampul->move('img', $namaSampul);
            unlink('img/' . $this->request->getVar('fileLama'));
        }

        $slug = url_title($this->request->getVar('judul'), '-', true);
        $this->komikModel->save([
            'id' => $id,
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'sampul' => $namaSampul
        ]);

        session()->setFlashdata('pesan', 'Data Berhasil Ditambahkan');
        return redirect()->to('/komik');
    }
}
