<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function index(){
        $data['judul'] = "Index";
        $this->load->view('admin/template/header', $data);
        $this->load->view('admin/index');
        $this->load->view('admin/template/footer');
    }
}
