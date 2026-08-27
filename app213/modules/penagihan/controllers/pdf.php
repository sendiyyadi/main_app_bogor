<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class pdf extends CI_Controller{

    private $controller = 'pdf';
    public function __construct()
    {
        parent::__construct();
        if (!is_login()) {
            echo "<script>window.location.replace('" . base_url() . "');</script>";
            exit;
        }

        $module = 'pdf';
        $this->load->library('module_auth', array(
            'module' => $module
        ));

        $this->load->model(array(
            'apps_model'
        ));

        $this->load->helper(active_module());
        $this->load->library('pdf_fpdf');
        $this->load->model('perubahan_sppt_model', 'MPerubahan_sppt');
    }

    function index(){
        $c_nop   = $this->input->get('C_NOP');
        $c_thn   = $this->input->get('C_THN');
        $kel   = $this->input->get('KD_KEL');
        $kec   = $this->input->get('KD_KEC');
        $sts   = $this->input->get('STS');

        $pdf = new FPDF('l','mm','A4');
        // membuat halaman baru
        $pdf->AddPage();
        // setting jenis font yang akan digunakan
        $pdf->SetFont('Arial','B',16);
        // mencetak string
        $pdf->Cell(290,7,'LAPORAN PERUBAHAN ALAMAT SPPT',0,1,'C');
        // Memberikan space kebawah agar tidak terlalu rapat
        $pdf->Cell(10,7,'',0,1);
        $pdf->SetFont('Arial','B',8);

        $pdf->Cell(80,6,'DETAIL WP/OP',1,0);
        $pdf->Cell(80,6,'DETAIL PERUBAHAN WP/OP',1,0);
        $pdf->Cell(30,6,'TGL PENGAJUAN',1,0);
        $pdf->Cell(30,6,'TGL APPROVE',1,0);
        $pdf->Cell(30,6,'USER ASIGN',1,0);
        $pdf->Cell(30,6,'USER APPROVE',1,1);

        $pdf->SetFont('Arial','',8);
        // $mahasiswa = $this->db->get('DS_PERUBAHAN_OPWP')->where('STATUS=1')->result();
        $mahasiswa = $this->MPerubahan_sppt->get_laporan($c_nop, $c_thn, $kel, $kec, $sts);
        foreach ($mahasiswa as $row){
            // $pdf->Cell(80,6,$pdf->WriteHTML($row->NOP.".".$row->THN_PAJAK_SPPT."<br>".$row->KECAMATAN_WP_OLD),1,0);
            // $pdf->WriteHtmlCell(250,$row->NOP.".".$row->THN_PAJAK_SPPT."<br>".$row->KECAMATAN_WP_OLD);
            // $pdf->WriteHtmlCell(80,$row->KECAMATAN_WP_NM_NEW);
            // $pdf->WriteHtmlCell(30,$row->TGL_PERMOHONAN);
            // $pdf->WriteHtmlCell(30,$row->TGL_APPROVED);
            // $pdf->WriteHtmlCell(30,$row->LOGINNAME);
            // $pdf->WriteHtmlCell(30,$row->APPROVED_BY);

            $pdf->Cell(280,6,$row->NOP_2.".".$row->THN_PAJAK_SPPT,'RL',1);
            $pdf->Cell(160,6,$row->NM_WP_SPPT,'L',0);

            $pdf->Cell(30,6,$row->TGL_PERMOHONAN,0,0);
            $pdf->Cell(30,6,$row->TGL_APPROVED,0,0);
            $pdf->Cell(30,6,$row->LOGINNAME,0,0);
            $pdf->Cell(30,6,$row->APPROVED_BY,'R',1);

            $pdf->Cell(80,6,$row->KECAMATAN_WP_OLD,'L',0);
            $pdf->Cell(80,6,$row->KECAMATAN_WP_NM_NEW,0,0);
            $pdf->Cell(120,6,'','R',1);

            $pdf->Cell(80,6,$row->KELURAHAN_WP_NM_OLD,'L',0);
            $pdf->Cell(80,6,$row->KELURAHAN_WP_NM_NEW,0,0);
            $pdf->Cell(120,6,'','R',1);

            $pdf->Cell(80,6,$row->RT_WP_OLD." / ".$row->RW_WP_OLD,'L',0);
            $pdf->Cell(80,6,$row->RT_WP_NEW." / ".$row->RW_WP_NEW,0,0);
            $pdf->Cell(120,6,'','R',1);

            $pdf->Cell(80,6,$row->JALAN_WP_OLD,'L',0);
            $pdf->Cell(80,6,$row->JALAN_WP_NEW,0,0);
            $pdf->Cell(120,6,'','R',1);

            ////
            $pdf->Cell(80,6,$row->KECAMATAN_OP_NM_OLD,'L',0);
            $pdf->Cell(80,6,$row->KECAMATAN_OP_NM_NEW,0,0);
            $pdf->Cell(120,6,'','R',1);

            $pdf->Cell(80,6,$row->KELURAHAN_OP_NM_OLD,'L',0);
            $pdf->Cell(80,6,$row->KELURAHAN_OP_NM_NEW,0,0);
            $pdf->Cell(120,6,'','R',1);

            $pdf->Cell(80,6,$row->RT_OP_OLD." / ".$row->RW_OP_OLD,'L',0);
            $pdf->Cell(80,6,$row->RT_OP_NEW." / ".$row->RW_OP_NEW,0,0);
            $pdf->Cell(120,6,'','R',1);

            $pdf->Cell(80,6,$row->JALAN_OP_OLD,'LB',0);
            $pdf->Cell(80,6,$row->JALAN_OP_NEW,'B',0);
            $pdf->Cell(30,6,'','B',0);
            $pdf->Cell(30,6,'','B',0);
            $pdf->Cell(30,6,'','B',0);
            $pdf->Cell(30,6,'','RB',1);


        }
        $pdf->Output();
    }

}
