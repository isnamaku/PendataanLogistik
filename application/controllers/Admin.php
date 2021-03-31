<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        Parent::__construct();
        $this->load->model('Barang_model');
    }

    public function index(){
        if (logged_in()){
            $data['judul'] = "Index";
            $data['admin'] = $this->db->get_where('admin', ['email' => $this->session->userdata('email')])->row_array();
            $data['total_barangmasuk'] = $this->Barang_model->countAllBarangMasuk();
            $data['total_barangkeluar'] = $this->Barang_model->countAllBarangKeluar();
            $data['total_anggota'] = $this->Barang_model->countAnggota();
            $data['post'] = $this->Barang_model->countHarga();
            // $data['post2'] = $this->Barang_model->countTotalHargaDistribusi();
            
            $this->load->view('admin/template/header', $data);
            $this->load->view('admin/index');
            $this->load->view('admin/template/footer');
        }
        else {
            redirect('Beranda');
        }
    }

    // Barang Masuk
    public function barang_masuk(){
        if (logged_in()){
            $data['judul'] = "Barang Masuk";
            $data['admin'] = $this->db->get_where('admin', ['email' => $this->session->userdata('email')])->row_array();
            $data['post'] = $this->Barang_model->ambilBarang();

            $this->load->view('admin/template/header', $data);
            $this->load->view('admin/barang_masuk', $data);
            $this->load->view('admin/template/footer');
        }
        else {
            redirect('Beranda');
        }
    }

    public function tambah_barang_masuk(){
        if (logged_in()){
            $data['judul'] = "Tambah Barang";

            $last_row_barcode = $this->db->select('barcode')->order_by('barcode', "desc")->limit(1)->get('barang')->row();

            $noUrut = (int)substr($last_row_barcode->barcode, 2, 6);
            $noUrut++;

            $str = '51';
            $newKode = $str . sprintf('%04s', $noUrut);

            $this->load->view('admin/template/header_data', $data, $newKode);
            $this->load->view('admin/tambah_barang_masuk');
        }
        else {
            redirect('Beranda');
        }
    }

    public function proses_tambah_barang_masuk()
    {
        $this->Barang_model->tambahBarangMasuk();
        redirect(base_url() . "admin/barang_masuk");
    }


    public function edit_barang_masuk($id){
        if (logged_in()){
            $data['judul'] = "Edit Barang";
            $data['post'] = $this->Barang_model->ambilBarangById($id);

            $this->load->view('admin/template/header_data', $data);
            $this->load->view('admin/edit_barang_masuk', $data);
        }
        else {
            redirect('Beranda');
        }
    }

    public function update_barang_masuk($id){

        if (logged_in()){
            $this->Barang_model->updateBarang($id);
          
            redirect(base_url() . "admin/barang_masuk");
        }
        else {
            redirect('Beranda');
        }

    }

    public function info_barang_masuk($id){
        if (logged_in()){
            $data['judul'] = "Info Barang";
            $data['post'] = $this->Barang_model->ambilBarangById($id);
            $last_row_barcode = $this->db->select('barcode')->order_by('barcode', "desc")->limit(1)->get('barang')->row();

            $noUrut = (int)substr($last_row_barcode->barcode, 2, 6);
            $noUrut++;

            $str = '51';
            $newKode = $str . sprintf('%04s', $noUrut);

            $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();

            $this->load->view('admin/template/header_data', $data. $generator);
            $this->load->view('admin/info_barang_masuk');
        }
        else {
            redirect('Beranda');
        }
    }

    public function hapus_barang_masuk($id)
    {
            if (logged_in()) {
            $data['judul'] = "Hapus Barang";
            $this->Barang_model->hapusBarangMasuk($id);
            redirect(base_url() . "admin/barang_masuk");
        }
        else {
            redirect('admin/barang_masuk');
        }
    }

    public function no_barang(){
        if (logged_in()) {
            $data['post'] = $this->Barang_model->ambilNoBarang();

            redirect(base_url() . "admin/tambah_barang_masuk");
        }
        else {
            redirect('admin/barang_masuk');
        }
    }

     // Barang Keluar

     
    public function barang_keluar()
    {
        if (logged_in()) {
            $data['judul'] = "Barang Keluar";
            $data['admin'] = $this->db->get_where('admin', ['email' => $this->session->userdata('email')])->row_array();
            $data['post'] = $this->Barang_model->ambilBarangKeluar();
 
            $this->load->view('admin/template/header', $data);
            $this->load->view('admin/barang_keluar');
            $this->load->view('admin/template/footer');
        } else {
            redirect('Beranda');
        }
    }

    public function tambah_barang_keluar()
    {
        if (logged_in()) {
            $data['judul'] = "Tambah Barang";
            $this->load->view('admin/template/header_data', $data);
            $this->load->view('admin/tambah_barang_keluar');
        } else {
            redirect('Beranda');
        }
    }

    public function proses_tambah_barang_keluar()
    {
        $this->Barang_model->tambahBarangKeluar();
        redirect(base_url() . "admin/barang_keluar");
    }


    public function update_barang_keluar($id)
    {
 
        if (logged_in()) {
            $this->Barang_model->updateBarangKeluar($id);
 
            redirect(base_url() . "admin/barang_keluar");
        } else {
            redirect('Beranda');
        }
    }

    public function info_barang_keluar($id)
    {
        if (logged_in()) {
            $data['judul'] = "Info Barang";
            $data['post'] = $this->Barang_model->ambilBarangKeluarById($id);
            $this->load->view('admin/template/header_data', $data);
            $this->load->view('admin/info_barang_keluar', $data);
        } else {
            redirect('Beranda');
        }
    }

    public function edit_barang_keluar(){
        if (logged_in()){
            $data['judul'] = "Barang Keluar";
            $this->load->view('admin/template/header_data', $data);
            $this->load->view('admin/edit_barang_keluar');
        }
        else {
            redirect('Beranda');
        }
    }

    // Berita Acara

    public function berita_acara(){
        if (logged_in()){
            $data['judul'] = "Berita Acara";
            $data['admin'] = $this->db->get_where('admin', ['email' => $this->session->userdata('email')])->row_array();
            $this->load->view('admin/template/header', $data);
            $this->load->view('admin/berita_acara',$data);
            $this->load->view('admin/template/footer' );
        }
        else {
            redirect('Beranda');
        }
    }

    //     // Print Beirta Acara
    public function a_print()
    { 
        $data['judul'] = "Berita Acara";
        $data['admin'] = $this->db->get_where('admin', ['email' => $this->session->userdata('email')])->row_array();

        $data = array(
            'tanggal_BA' => $this->input->post('tanggal_BA'),
            'nama' => $this->input->post('nama'),
            'nip' => $this->input->post('nip'),
            'jabatan' => $this->input->post('jabatan'),
            'instansi' => $this->input->post('instansi'),
            'telepon' => $this->input->post('telepon'),
            'barcode' => $this->input->post('barcode'),
            'stock_keluar' => $this->input->post('stock_keluar')
        );
        $this->load->view('admin/print_BA', $data);
       
    }

    //Detail Barang BA

	public function detail_barang($barcode)
	{
    // echo "sampai sini";
    // echo $barcode;
    $data['admin'] = $this->db->get_where('admin', ['email' => $this->session->userdata('email')])->row_array();
            $data['post'] = $this->Barang_model->detailBarangById($barcode);
		$data['judul'] = 'Detail Barang';

        $this->load->view('admin/template/header', $data);
		$this->load->view('admin/berita_acara', $data);
		$this->load->view('admin/template/footer');	
	}

    public function getDataBarcode()
    {
        $barcode = $this->input->post('barcode');

        if ($barcode != null) {
            $data= $this->Barang_model->detailBarangById($barcode);
            echo json_encode($data);
        }else {
            echo json_encode('kosong');
        }
    }
}
