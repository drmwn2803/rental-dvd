<?php
defined('BASEPATH') or exit('No Direct script access allowed');


class Film extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cek_login();
    }
    
    // Region Kategori
    public function kategori()
    {
        $data['judul'] = 'Kategori Film';
        $data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();
        $data['kategori'] = $this->ModelFilm->getKategori()->result_array();
        $this->form_validation->set_rules(
            'kategori', 
            'Kategori',
            'required', [
                'required' => 'Judul Film harus diisi'
        ]);
        if ($this->form_validation->run() == false) 
        {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('film/kategori', $data);
            $this->load->view('templates/footer');
        } else {
            $data = ['kategori' => $this->input->post('kategori')];
            $this->ModelFilm->simpanKategori($data);
            redirect('film/kategori');
        }
    }

    public function ubahkategori()
    {
        $data['judul'] = 'Ubah Kategori Film';
        $data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();

        $where = ['id' =>  $this->uri->segment(3)];
        $data['kategori'] = $this->ModelFilm->kategoriWhere($where)->row_array();
        
        
        $this->form_validation->set_rules(
            'kategori', 
            'Kategori',
            'required', [
                'required' => 'Judul Film harus diisi'
        ]);

        if ($this->form_validation->run() == false) 
        {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('film/ubah_kategori', $data);
            $this->load->view('templates/footer');
        } else {
            $data = ['kategori' => $this->input->post('kategori',true)];
            $this->ModelFilm->updateKategori(['id' => $this->input->post('id')], $data);
            redirect('film/kategori');
        }
    }

    public function hapusKategori()
    {
        $where = ['id' => $this->uri->segment(3)];
        $this->ModelFilm->hapusKategori($where);
        redirect('film/kategori');
    }


    // Region Film
    public function index()
    {
        $data['judul'] = 'Data Film';
        $data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();
        $data['film'] = $this->ModelFilm->getFilm()->result_array();
        $data['kategori'] = $this->ModelFilm->getKategori()->result_array();

        $this->form_validation->set_rules(
            'judul_film', 
            'Judul Film', 
            'required|min_length[3]', [
                'required' => 'Judul Film harus diisi',
                'min_length' => 'Judul Film terlalu pendek'
        ]);
        $this->form_validation->set_rules(
            'id_kategori', 
            'Kategori',
            'required', [
                'required' => 'Nama kategori harus diisi',
        ]);
        $this->form_validation->set_rules(
            'sutradara', 
            'Nama Sutradara', 
            'required|min_length[3]', [
                'required' => 'Nama sutradara harus diisi', 
                'min_length' => 'Nama Sutradara terlalu pendek'
        ]);
        $this->form_validation->set_rules(
            'studio', 
            'Nama Studio', 
            'required|min_length[3]', [
                'required' => 'Nama studio harus diisi',
                'min_length' => 'Nama studio terlalu pendek'
        ]);
        $this->form_validation->set_rules(
            'tahun', 
            'Tahun Terbit',
            'required|min_length[3]|max_length[4]|numeric', [
                'required' => 'Tahun terbit harus diisi',
                'min_length' => 'Tahun terbit terlalu pendek',
                'max_length' => 'Tahun terbit terlalu panjang',
                'numeric' => 'Hanya boleh diisi angka'
        ]);
        $this->form_validation->set_rules(
            'isbn',
            'Nomor ISBN',
            'required|min_length[3]|numeric', [
                'required' => 'Nama ISBN harus diisi',
                'min_length' => 'Nama ISBN terlalu pendek',
                'numeric' => 'Yang anda masukan bukan angka'
        ]);
        $this->form_validation->set_rules(
            'stok', 
            'Stok',
            'required|numeric', [
                'required' => 'Stok harus diisi',
                'numeric' => 'Yang anda masukan bukan angka'
        ]);

        //konfigurasi sebelum gambar diupload
        $config['upload_path'] = './assets/img/upload/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size'] = '3000';
        $config['max_width'] = '3000';
        $config['max_height'] = '3000';
        $config['file_name'] = 'img' . time();
        $this->load->library('upload', $config);
        if ($this->form_validation->run() == false) 
        {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('film/index', $data);
            $this->load->view('templates/footer');
        } else {
            if ($this->upload->do_upload('image')) 
            {
                $image = $this->upload->data();
                $gambar = $image['file_name'];
            } else { $gambar = ''; }


            $data = [
                'judul_film' => $this->input->post('judul_film',true),
                'id_kategori' => $this->input->post('id_kategori',true),
                'sutradara' => $this->input->post('sutradara',true),
                'studio' => $this->input->post('studio', true),
                'tahun_terbit' => $this->input->post('tahun', true),
                'isbn' => $this->input->post('isbn', true),
                'stok' => $this->input->post('stok', true),
                'dipinjam' => 0,
                'dibooking' => 0,
                'image' => $gambar
            ];
            $this->ModelFilm->simpanFilm($data);
            redirect('film');
        }
    }

    public function ubahFilm()
    {
        $data['judul'] = 'Ubah Data Film';
        $data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();
        $data['film'] = $this->ModelFilm->filmWhere(['id' => $this->uri->segment(3)])->row_array();
        $kategori = $this->ModelFilm->joinKategoriFilm(['film.id' => $this->uri->segment(3)])->result_array();
        
        foreach ($kategori as $k) 
        {
            $data['id'] = $k['id_kategori'];
            $data['k'] = $k['kategori'];
        }
        
        $data['kategori'] = $this->ModelFilm->getKategori()->result_array();


        $this->form_validation->set_rules(
            'judul_film', 
            'Judul film', 
            'required|min_length[3]', [
                'required' => 'Judul film harus diisi',
                'min_length' => 'Judul film terlalu pendek'
        ]);
        $this->form_validation->set_rules(
            'id_kategori', 
            'Kategori',
            'required', [
                'required' => 'Nama kategori harus diisi',
        ]);
        $this->form_validation->set_rules(
            'sutradara', 
            'Nama sutradara', 
            'required|min_length[3]', [
                'required' => 'Nama sutradara harus diisi', 
                'min_length' => 'Nama sutradara terlalu pendek'
        ]);
        $this->form_validation->set_rules(
            'studio', 
            'Nama studio', 
            'required|min_length[3]', [
                'required' => 'Nama studio harus diisi',
                'min_length' => 'Nama studio terlalu pendek'
        ]);
        $this->form_validation->set_rules(
            'tahun', 
            'Tahun Terbit',
            'required|min_length[3]|max_length[4]|numeric', [
                'required' => 'Tahun terbit harus diisi',
                'min_length' => 'Tahun terbit terlalu pendek',
                'max_length' => 'Tahun terbit terlalu panjang',
                'numeric' => 'Hanya boleh diisi angka'
        ]);
        $this->form_validation->set_rules(
            'isbn',
            'Nomor ISBN',
            'required|min_length[3]|numeric', [
                'required' => 'Nama ISBN harus diisi',
                'min_length' => 'Nama ISBN terlalu pendek',
                'numeric' => 'Yang anda masukan bukan angka'
        ]);
        $this->form_validation->set_rules(
            'stok', 
            'Stok',
            'required|numeric', [
                'required' => 'Stok harus diisi',
                'numeric' => 'Yang anda masukan bukan angka'
        ]);

        //konfigurasi sebelum gambar diupload
        $config['upload_path'] = './assets/img/upload/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size'] = '3000';
        $config['max_width'] = '1024';
        $config['max_height'] = '1000';
        $config['file_name'] = 'img' . time();

        //memuat atau memanggil library upload
        $this->load->library('upload', $config);
        if ($this->form_validation->run() == false) 
        {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('film/ubah_film', $data);
            $this->load->view('templates/footer');
        } else {
            if ($this->upload->do_upload('image')) 
            {
                $image = $this->upload->data();
                unlink('assets/img/upload/' . $this->input->post('old_pict', TRUE));
                $gambar = $image['file_name'];
            } else { $gambar = $this->input->post('old_pict', TRUE); }
            
            // data postingan
            $data = [
                'judul_film' => $this->input->post('judul_film',true),
                'id_kategori' => $this->input->post('id_kategori',true),
                'sutradara' => $this->input->post('sutradara',true),
                'studio' => $this->input->post('studio', true),
                'tahun_terbit' => $this->input->post('tahun', true),
                'isbn' => $this->input->post('isbn', true),
                'stok' => $this->input->post('stok', true),
                'image' => $gambar
            ];
            $this->ModelFilm->updateFilm($data, ['id' => $this->input->post('id')]);
            redirect('film');
        }
    }
    public function hapusFilm()
    {
        $where = ['id' => $this->uri->segment(3)];
        $this->ModelFilm->hapusFilm($where);
        redirect('film');
    }

}