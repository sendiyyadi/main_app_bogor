<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function cek_maintenance()
{
    $maintenance_mode = TRUE; // ganti FALSE kalau mau matiin

    if ($maintenance_mode) {
        $CI =& get_instance();
        $CI->load->helper('url'); // pastiin base_url() kepanggil, jaga2 kalau belum di-autoload
        $CI->load->view('maintenis');
        exit();
    }
}