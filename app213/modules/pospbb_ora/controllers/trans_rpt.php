<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class trans_rpt extends CI_Controller {
	function __construct() {
		parent::__construct();

        if (!$this->session->userdata('login')) {
            $this->session->set_flashdata('msg_warning', 'Session telah kadaluarsa, silahkan login ulang.');
            redirect('login');
            exit;
        }
        
		if(active_module()!='pospbb_ora') { 
			show_404();
			exit;
		}
        
		$this->load->model(array('apps_model', 'login_model', 'pospbb_ora_model'));
		//$this->pospbb_ora_model->set_userarea();

	}
    
    // PINDAHAN/COPY DARI PBBM JUGA
    
	function show_rpt() {
		$cls_mtd_html = $this->router->fetch_class()."/cetak/html/";
		$cls_mtd_pdf  = $this->router->fetch_class()."/cetak/pdf/";
		$data['rpt_html'] = active_module_url($cls_mtd_html. $_SERVER['QUERY_STRING']);;
		$data['rpt_pdf']  = active_module_url($cls_mtd_pdf . $_SERVER['QUERY_STRING']);;
    $this->load->view('vjasper_viewer', $data);
	}
	
	function cetak() {

        $kec_kd=NULL;
        $kel_kd=NULL;
        $tahun=NULL;
        $tahun2=NULL;
        $bukumin=NULL;
        $bukumax=NULL;
        $buku=NULL;
        $tglawal=NULL;
        $tglakhir=NULL;
        $kd_tp='';
        
        $type = $this->uri->segment(4);
        $jenis = $this->uri->segment(5);

        $kec_kd = $this->uri->segment(6);
        $kel_kd = $this->uri->segment(7);
        $tahun_sppt1 = $this->uri->segment(8);
        $tahun_sppt2 = $this->uri->segment(9);
        $buku = $this->uri->segment(10);  

        if ($jenis == 3) {
		   $tahun = $this->uri->segment(11);
		   $kd_tp = $this->uri->segment(12);
		} elseif($jenis == 4 || $jenis == 5){
            $buku = $this->uri->segment(8);
            $tglawal = $this->uri->segment(9);
            $tglakhir = $this->uri->segment(10);
            $kd_tp = $this->uri->segment(11);
        } else {
		   $tglawal = $this->uri->segment(11);
		   $tglakhir = $this->uri->segment(12);
		   $kd_tp = $this->uri->segment(13);
		}

        $bukumin = $this->pospbb_ora_model->rangebuku[substr($buku, 0, 1)][0];
        $bukumax = $this->pospbb_ora_model->rangebuku[substr($buku, 1, 1)][1];      

		if ($kec_kd == '000' && $kel_kd == '000') {
		   if ( $jenis==3 ) {$rptx = 'trans_bulan';}
		   elseif ( $jenis==2 ) {$rptx = 'trans_2';}
		   elseif ( $jenis==1 ) {$rptx = 'trans_1';}
           elseif ( $jenis==4 ) {$rptx = 'trans_3';}
           elseif ( $jenis==5 ) {$rptx = 'trans_4';}
           }
		if ($kec_kd != '000' && $kel_kd == '000') {
		   if ( $jenis==3 ) {$rptx = 'trans_bulan_kec';}
		   elseif ( $jenis==2 ) {$rptx = 'trans_2_kec';}
		   elseif ( $jenis==1 ) {$rptx = 'trans_1_kec';}
           elseif ( $jenis==4 ) {$rptx = 'trans_3_kec';}
           elseif ( $jenis==5 ) {$rptx = 'trans_4_kec';}
           }

	    if ($kec_kd != '000' && $kel_kd != '000')  {
		   if ( $jenis==3 ) {$rptx = 'trans_bulan_kel';}
		   elseif ( $jenis==2 ) {$rptx = 'trans_2_kel';}
		   elseif ( $jenis==1 ) {$rptx = 'trans_1_kel';}
           elseif ( $jenis==4 ) {$rptx = 'trans_3_kel';}
           elseif ( $jenis==5 ) {$rptx = 'trans_4_kel';}
           }
        //
        if (DEF_POS_TYPE==1){
            $pos_fld    = "p.KD_KANWIL,p.KD_KANTOR,p.KD_TP ";
            $pos_join   = "p.KD_KANWIL=tp.KD_KANWIL and p.KD_KANTOR=tp.KD_KANTOR and p.KD_TP=tp.KD_TP "; 
            $pos_uraian = "tp.KD_KANWIL||tp.KD_KANTOR||tp.KD_TP ";                 
        }
        else{
            $pos_fld    = "p.KD_BANK_TUNGGAL,p.KD_BANK_PERSEPSI,p.KD_KANWIL, p.KD_KANTOR,p.KD_TP ";
            $pos_join   = "p.KD_BANK_TUNGGAL=tp.KD_BANK_TUNGGAL and p.KD_BANK_PERSEPSI=tp.KD_BANK_PERSEPSI ";
            $pos_join  .= " and p.KD_KANWIL=tp.KD_KANWIL and p.KD_KANTOR=tp.KD_KANTOR and p.KD_TP=tp.KD_TP "; 
            $pos_uraian = "tp.KD_BANK_TUNGGAL||tp.KD_BANK_PERSEPSI||tp.KD_KANWIL||tp.KD_KANTOR||tp.KD_TP "; 
        }
        //

        //var_dump($kd_tp);die;
        
        if($kd_tp!='0' && $kd_tp != -99999 && $kd_tp != "")
            $where_tp = " and {$pos_uraian}='{$kd_tp}' ";
        else
            $where_tp = '';

		$jasper = $this->load->library('Jasper_Ora');
		$params = array(
			"daerah" => LICENSE_TO,
			"kd_propinsi" => KD_PROPINSI, 
			"kd_dati2" => KD_DATI2, 
			"kd_kecamatan" => $kec_kd, 
			"kd_kelurahan" => $kel_kd, 
			"tahun" => $tahun, 
			"tahun_sppt1" => $tahun_sppt1, 
			"tahun_sppt2" => $tahun_sppt2, 
			"bukumin" => $bukumin, 
			"bukumax" => $bukumax, 
			"buku" => $buku, 
			"tglawal" => date('Y-m-d', strtotime($tglawal)),
			"tglakhir" => date('Y-m-d', strtotime($tglakhir)),
			"logo" => base_url("assets/img/logorpt__.jpg"),
			"dinas" => LICENSE_TO_SUB,
            
            "pos_fld" => $pos_fld,
            "pos_join" => $pos_join,
            "pos_uraian" => $pos_uraian,
            "where_tp" => $where_tp,
		);

        //var_dump($params);die;
        //var_dump($rptx);die;
 
       //File kkktrans_bulan_kec.jrxml tidak ditemukan!
       //  $rptx = 'kkk'.$rptx;   //File kkk trans_2.jrxml tidak ditemukan!
      //   $rptx = $where_tp;
 //       log_message('info', "KKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKKK".
 //           $bukumin.'--'.$bukumax);
		echo $jasper->cetak_ora($rptx, $params, $type, false);
	}
    
	public function csv_rekap_bulanan() {

        $schema_pbb = SCHEMA_PBB.".";
        $buku        = (isset($_POST['buku'])) ? $_POST['buku'] : '11';
        $bukumin     = $this->pospbb_ora_model->rangebuku[substr($buku, 0, 1)][0];
        $bukumax     = $this->pospbb_ora_model->rangebuku[substr($buku, 1, 1)][1];
        $tahun       = (isset($_POST['tahun'])) ? $_POST['tahun'] : date('Y');
        $tahun_sppt1 = (isset($_POST['tahun_sppt1'])) ? $_POST['tahun_sppt1'] : date('Y');
        $tahun_sppt2 = (isset($_POST['tahun_sppt2'])) ? $_POST['tahun_sppt2'] : date('Y');
        $kec_kd      = (isset($_POST['kec_kd']) && is_numeric($_POST['kec_kd'])) ? $_POST['kec_kd'] : '000';
        $kel_kd      = (isset($_POST['kel_kd']) && is_numeric($_POST['kel_kd'])) ? $_POST['kel_kd'] : '000';
        
        if (get_user_kec_kd() != '000' && get_user_kec_kd() != $kec_kd)
            $kec_kd = get_user_kec_kd();
        
        if (get_user_kel_kd() != '000' && get_user_kel_kd() != $kel_kd)
            $kec_kd = get_user_kel_kd();
        
        $where = "WHERE extract(year FROM p.tgl_pembayaran_sppt)= $tahun 
            AND p.kd_propinsi='" . KD_PROPINSI . "' 
            AND p.kd_dati2='" . KD_DATI2 . "'
            AND k.pbb_yg_harus_dibayar_sppt between $bukumin AND $bukumax 
            AND p.thn_pajak_sppt between '$tahun_sppt1' AND '$tahun_sppt2' ";
        if ($kec_kd != "000")
            $where .= " AND p.kd_kecamatan='$kec_kd'";
        if ($kel_kd != "000")
            $where .= " AND p.kd_kelurahan='$kel_kd'";
        //
        if (DEF_POS_TYPE==1){
            $pos_fld    = "p.KD_KANWIL,p.KD_KANTOR,p.KD_TP ";
            $pos_join   = "p.KD_KANWIL=tp.KD_KANWIL and p.KD_KANTOR=tp.KD_KANTOR and p.KD_TP=tp.KD_TP "; 
            $pos_uraian = "tp.KD_KANWIL||tp.KD_KANTOR||tp.KD_TP ";                 
        }
        else{
            $pos_fld    = "p.KD_BANK_TUNGGAL,p.KD_BANK_PERSEPSI,p.KD_KANWIL, p.KD_KANTOR,p.KD_TP ";
            $pos_join   = "p.KD_BANK_TUNGGAL=tp.KD_BANK_TUNGGAL and p.KD_BANK_PERSEPSI=tp.KD_BANK_PERSEPSI ";
            $pos_join  .= " and p.KD_KANWIL=tp.KD_KANWIL and p.KD_KANTOR=tp.KD_KANTOR and p.KD_TP=tp.KD_TP "; 
            $pos_uraian = "tp.KD_BANK_TUNGGAL||tp.KD_BANK_PERSEPSI||tp.KD_KANWIL||tp.KD_KANTOR||tp.KD_TP "; 
        }
        //        
        $tp_kd = (isset($_POST['tp_kd'])) ? $_POST['tp_kd'] : '';
        if ($tp_kd!='0')
            $where .= " AND {$pos_uraian} = '{$tp_kd}'";
            
        $sql_query_r = "SELECT  Extract(month FROM tgl_pembayaran_sppt) kode,
            {$pos_uraian}||':'||tp.nm_tp uraian, p.thn_pajak_sppt,
            sum(coalesce(p.jml_sppt_yg_dibayar,0) - coalesce(p.denda_sppt,0))  pokok, 
            sum(p.denda_sppt) denda, sum(p.jml_sppt_yg_dibayar) bayar
            FROM S_SPPT k 
            INNER JOIN S_PEMBAYARAN_SPPT p 
            ON k.kd_propinsi = p.kd_propinsi
            AND k.kd_dati2 = p.kd_dati2 
            AND k.kd_kecamatan = p.kd_kecamatan 
            AND k.kd_kelurahan = p.kd_kelurahan 
            AND k.kd_blok = p.kd_blok 
            AND k.no_urut = p.no_urut 
            AND k.kd_jns_op = p.kd_jns_op 
            AND k.thn_pajak_sppt = p.thn_pajak_sppt 
            LEFT JOIN S_TEMPAT_PEMBAYARAN tp ON {$pos_join}
            {$where}
            GROUP BY Extract(month FROM tgl_pembayaran_sppt),{$pos_uraian}||':'||tp.nm_tp,p.thn_pajak_sppt
            ORDER BY Extract(month FROM tgl_pembayaran_sppt),{$pos_uraian}||':'||tp.nm_tp,p.thn_pajak_sppt ";
        
            

        $rptnm = "REKAP BULANAN";
		header("Content-type: text/plain"); 
		header("Cache-Control: no-store, no-cache"); 
		header('Content-Disposition: attachment; filename="'.$rptnm.'.csv"'); 

        if($rows = $this->db->query($sql_query_r)->result_array()){
            $title = array('BULAN','URAIAN','THN.SPPT','POKOK','DENDA','BAYAR');
            $this->csv_encode( $rows, $title ); 
        } else {
            echo "Tidak ada data";
        }
        exit;
	}

    public function xls_rekap_bulanan(){
        include "PHPExcel/Classes/PHPExcel.php";
        $this->load->helper('sipkd');
        // include "PHPExcel/Classes/PHPExcel/Writer/Excel5.php";
        $tahun= (isset($_GET['tahun'])) ? $_GET['tahun'] : date('Y');
        $tahun_sppt1 = (isset($_GET['tahun_sppt1'])) ? $_GET['tahun_sppt1'] : date('Y');
        $tahun_sppt2 = (isset($_GET['tahun_sppt2'])) ? $_GET['tahun_sppt2'] : date('Y');
        $buku    = (!empty($this->input->get('buku'))) ? $this->input->get('buku') : '11';
        $bukumin = $this->load->model('pospbb_ora_model')->rangebuku[substr($buku, 0, 1)][0];
        $bukumax = $this->load->model('pospbb_ora_model')->rangebuku[substr($buku, 1, 1)][1];
        // $tp_kd = $this->input->get('tp_kd');
        $kec_kd = (isset($_GET['kec_kd']) && is_numeric($_GET['kec_kd'])) ? $_GET['kec_kd'] : '000';
        $kel_kd = $kel_kd = (isset($_GET['kel_kd']) && is_numeric($_GET['kel_kd'])) ? $_GET['kel_kd'] : '000';
        if (get_user_kec_kd() != '000' && get_user_kec_kd() != $kec_kd)
            $kec_kd = get_user_kec_kd();
        
        if (get_user_kel_kd() != '000' && get_user_kel_kd() != $kel_kd)
            $kec_kd = get_user_kel_kd();

        $datetime=date('Y-m-d').' '.time();

        $where = "WHERE extract(year FROM p.tgl_pembayaran_sppt)= $tahun 
            AND p.kd_propinsi='" . KD_PROPINSI . "' 
            AND p.kd_dati2='" . KD_DATI2 . "'
            AND k.pbb_yg_harus_dibayar_sppt between $bukumin AND $bukumax 
            AND p.thn_pajak_sppt between '$tahun_sppt1' AND '$tahun_sppt2' ";
        if ($kec_kd != "000")
            $where .= " AND p.kd_kecamatan='$kec_kd'";
        if ($kel_kd != "000")
            $where .= " AND p.kd_kelurahan='$kel_kd'";
        
        // POS_FIELD
        $fields     = explode(',', POS_FIELD);
        $pos_fld    = '';
        $pos_join   = '';
        $pos_uraian = '';
        $fs = '';
        foreach ($fields as $f) {
            $fs = $f;
            if ($f == 'kd_kanwil')
                $fs = 'kd_kanwil';
            else if ($f == 'kd_kppbb')
                $fs = 'kd_kantor';

            $pos_fld .= "p.{$f}, ";
            $pos_join .= "p.{$f}=tp.{$fs} and ";
            $pos_uraian .= "tp.{$fs}||";
        }
        $pos_fld = substr($pos_fld, 0, -2);
        $pos_join = substr($pos_join, 0, -4);
        $pos_uraian = substr($pos_uraian, 0, -2);
        
        $tp_kd = (isset($_GET['tp_kd'])) ? $_GET['tp_kd'] : '';
        if ($tp_kd!='0')
            $where .= " AND {$pos_uraian} = '{$tp_kd}'";
        
         $sql_query_r = "SELECT  Extract(month FROM p.tgl_pembayaran_sppt) tanggal,
            {$pos_uraian}||':'||tp.nm_tp uraian, p.thn_pajak_sppt,
            sum(coalesce(p.jml_sppt_yg_dibayar,0) - coalesce(p.denda_sppt,0))  pokok, 
            sum(p.denda_sppt) denda, sum(p.jml_sppt_yg_dibayar) bayar
            FROM sppt k 
            INNER JOIN pembayaran_sppt p 
            ON k.kd_propinsi = p.kd_propinsi
            AND k.kd_dati2 = p.kd_dati2 
            AND k.kd_kecamatan = p.kd_kecamatan 
            AND k.kd_kelurahan = p.kd_kelurahan 
            AND k.kd_blok = p.kd_blok 
            AND k.no_urut = p.no_urut 
            AND k.kd_jns_op = p.kd_jns_op 
            AND k.thn_pajak_sppt = p.thn_pajak_sppt 
            LEFT JOIN tempat_pembayaran tp ON {$pos_join}
            $where
            GROUP BY Extract(month FROM p.tgl_pembayaran_sppt),{$pos_uraian}||':'||tp.nm_tp,p.thn_pajak_sppt
            ORDER BY Extract(month FROM p.tgl_pembayaran_sppt),{$pos_uraian}||':'||tp.nm_tp,p.thn_pajak_sppt ";
            $exec = $this->db->query($sql_query_r);
            $fetch = $exec->result();
            $obj_excel = new PHPExcel;
            $obj_excel->getActiveSheet()->getProtection()->setSheet(true);
 
            $obj_excel->getProperties()->setCreator("Eon");
            $obj_excel->getProperties()->setLastModifiedBy("Eon");
            $obj_excel->getProperties()->setTitle("Data Rincian Harian");
            $obj_excel->removeSheetByIndex(0);
             

            $sheet = $obj_excel->createSheet();
            $active_sheet = $obj_excel->getActiveSheet();
            $sheet->setTitle('REKAP_BULANAN');
            foreach(range('A','F') as $columnID) {
                $active_sheet->getColumnDimension($columnID)
                    ->setAutoSize(true);
            }
            $hcol =1;
            $active_sheet->getStyle('A'.$hcol.':F'.$hcol)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
             $active_sheet->setCellValue("A".$hcol, "Tanggal");
             $active_sheet->setCellValue("B".$hcol, "Uraian");
             $active_sheet->setCellValue("C".$hcol, "Tahun Sppt");
             $active_sheet->setCellValue("D".$hcol, "Pokok");
             $active_sheet->setCellValue("E".$hcol, "Denda");
             $active_sheet->setCellValue("F".$hcol, "Bayar");
 

    // STYLE HEADER
    $styleArray = array(
        'font'  => array(
            'bold'  => true,
            'size'  => 11,
            'name'  => 'Calibri'
        ));

    $active_sheet->getStyle('A'.$hcol.':H'.$hcol)->applyFromArray($styleArray);
     
    $i = 2;
    $ii = $i;
    $pokok_sum = array();
    $denda_sum = array();
    $bayar_sum = array();
    foreach ($exec->result() as $aa) {
        $sheet->setCellValue("A".$i, $aa->TANGGAL.':'.namabulan($aa->TANGGAL));
        $sheet->setCellValue("B".$i, $aa->URAIAN);
        $sheet->setCellValue("C".$i, $aa->THN_PAJAK_SPPT);
        $sheet->setCellValue("D".$i, $aa->POKOK);
        $sheet->setCellValue("E".$i, $aa->DENDA);
        $sheet->setCellValue("F".$i, $aa->BAYAR);
        array_push($pokok_sum, $aa->POKOK);
        array_push($denda_sum, $aa->DENDA);
        array_push($bayar_sum, $aa->BAYAR);
         $i++;
     }
    $row_tot = count($fetch)+$ii;
    // $sum_row = $row_tot-1;
    $sheet->setCellValue("A".$row_tot, 'Total');
    $active_sheet->getStyle('A'.$row_tot.':F'.$row_tot)->applyFromArray($styleArray);
    $active_sheet->getStyle('A'.$row_tot)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $sheet->setCellValue("D".$row_tot, array_sum($pokok_sum));
    $sheet->setCellValue("E".$row_tot, array_sum($denda_sum));
    $sheet->setCellValue("F".$row_tot, array_sum($bayar_sum));
    // $namafile = "excel_export/REKAP_BULANAN".sipkd_user_id().$datetime.".xlsx";
    $namafile = "assets/dok_excel/reb".$datetime.sipkd_user_id().".xlsx";
    // Redirect output to a client’s web browser (Excel5)


    $objWriter = PHPExcel_IOFactory::createWriter($obj_excel, 'Excel2007');
    if(!$objWriter){
        $this->session->set_flashdata('msg_warning', 'Gagal Export File');
        redirect(active_module_url().'rekap_bulan');
    }else{
        $objWriter->save($namafile);
         $reader = PHPExcel_IOFactory::createReader('Excel2007');
        if ($reader->canRead($namafile)) {
            //redirect($namafile);

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="'.basename($namafile).'"');
            header('Content-Length: ' . filesize($namafile));
            readfile($namafile);
            unlink($namafile); // Hapus setelah dikirim
            exit;
        }else{
            $this->session->set_flashdata('msg_warning', 'Gagal Export File');
            redirect(active_module_url().'rekap_bulan');   
        }
    }
        $obj_excel->disconnectWorksheets();
        unset($obj_excel);   
    }

    public function xls_rekap_harian(){
        include "PHPExcel/Classes/PHPExcel.php";
        $this->load->helper('sipkd');
        // include "PHPExcel/Classes/PHPExcel/Writer/Excel5.php";
        $tglm = date('Y-m-d',strtotime($this->input->get('tglawal')));
        $tgls = date('Y-m-d',strtotime($this->input->get('tglakhir')));
        $tahun_sppt1 = (isset($_GET['tahun_sppt1'])) ? $_GET['tahun_sppt1'] : date('Y');
        $tahun_sppt2 = (isset($_GET['tahun_sppt2'])) ? $_GET['tahun_sppt2'] : date('Y');
        $buku    = (!empty($this->input->get('buku'))) ? $this->input->get('buku') : '11';
        $bukumin = $this->load->model('pospbb_ora_model')->rangebuku[substr($buku, 0, 1)][0];
        $bukumax = $this->load->model('pospbb_ora_model')->rangebuku[substr($buku, 1, 1)][1];
        // $tp_kd = $this->input->get('tp_kd');
        $kec_kd = (isset($_GET['kec_kd']) && is_numeric($_GET['kec_kd'])) ? $_GET['kec_kd'] : '000';
        $kel_kd = $kel_kd = (isset($_GET['kel_kd']) && is_numeric($_GET['kel_kd'])) ? $_GET['kel_kd'] : '000';
        if (get_user_kel_kd() != '000' && get_user_kel_kd() != $kel_kd)
            $kec_kd = get_user_kel_kd();

        // $micro = microtime();
        $datetime = date('Ymd').time();
        $where = "WHERE p.tgl_pembayaran_sppt BETWEEN TO_DATE('$tglm', 'YYYY-MM-DD') AND TO_DATE('$tgls', 'YYYY-MM-DD')
            AND p.kd_propinsi='" . KD_PROPINSI . "' 
            AND p.kd_dati2='" . KD_DATI2 . "' 
            AND p.thn_pajak_sppt BETWEEN '$tahun_sppt1' AND '$tahun_sppt2'
            AND k.pbb_yg_harus_dibayar_sppt between $bukumin AND $bukumax ";
        
        if ($kec_kd != "000")
            $where .= " AND p.kd_kecamatan='$kec_kd'";
        if ($kel_kd != "000")
            $where .= " AND p.kd_kelurahan='$kel_kd'";
        
        /// -- DARI SINI ..
        $fields     = explode(',', POS_FIELD);
        $pos_fld    = '';
        $pos_join   = '';
        $pos_uraian = '';
        $fs = '';
        foreach ($fields as $f) {
            $fs = $f;
            if ($f == 'kd_kanwil')
                $fs = 'kd_kanwil';
            else if ($f == 'kd_kppbb')
                $fs = 'kd_kantor';
                
            $pos_fld .= "p.{$f}, ";
            $pos_join .= "p.{$f}=tp.{$fs} and ";
            $pos_uraian .= "tp.{$fs}||";
        }
        $pos_fld = substr($pos_fld, 0, -2);
        $pos_join = substr($pos_join, 0, -4);
        $pos_uraian = substr($pos_uraian, 0, -2);
        
        $tp_kd = (isset($_GET['tp_kd'])) ? $_GET['tp_kd'] : '';
        
        if ($tp_kd != 0)
            $where .= " AND {$pos_uraian} = '{$tp_kd}'";
        
         $sql_query_r = "SELECT tgl_pembayaran_sppt tanggal,{$pos_uraian}||':'||tp.nm_tp uraian, p.thn_pajak_sppt,
            sum(coalesce(p.jml_sppt_yg_dibayar,0) - coalesce(p.denda_sppt,0))  pokok, 
            sum(p.denda_sppt) denda, 
            sum(p.jml_sppt_yg_dibayar) bayar
            FROM sppt k 
            INNER JOIN pembayaran_sppt p 
            ON k.kd_propinsi = p.kd_propinsi
            AND k.kd_dati2 = p.kd_dati2 
            AND k.kd_kecamatan = p.kd_kecamatan 
            AND k.kd_kelurahan = p.kd_kelurahan 
            AND k.kd_blok = p.kd_blok 
            AND k.no_urut = p.no_urut 
            AND k.kd_jns_op = p.kd_jns_op 
            AND k.thn_pajak_sppt = p.thn_pajak_sppt 
            LEFT JOIN tempat_pembayaran tp ON {$pos_join}
            $where
            GROUP BY tgl_pembayaran_sppt,{$pos_uraian}||':'||tp.nm_tp,p.thn_pajak_sppt
            ORDER BY tgl_pembayaran_sppt,{$pos_uraian}||':'||tp.nm_tp,p.thn_pajak_sppt ";

            
            $exec = $this->db->query($sql_query_r);
            $fetch = $exec->result_array();
            $obj_excel = new PHPExcel;
            $obj_excel->getActiveSheet()->getProtection()->setSheet(true);
 
            $obj_excel->getProperties()->setCreator("Eon");
            $obj_excel->getProperties()->setLastModifiedBy("Eon");
            $obj_excel->getProperties()->setTitle("Data Rincian Harian");
            $obj_excel->removeSheetByIndex(0);
             

            $sheet = $obj_excel->createSheet();
            $active_sheet = $obj_excel->getActiveSheet();
            $sheet->setTitle('REKAP_HARIAN');
            foreach(range('A','F') as $columnID) {
                $active_sheet->getColumnDimension($columnID)
                    ->setAutoSize(true);
            }
            $hcol =1;
            $active_sheet->getStyle('A'.$hcol.':F'.$hcol)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
             $active_sheet->setCellValue("A".$hcol, "Tanggal");
             $active_sheet->setCellValue("B".$hcol, "Uraian");
             $active_sheet->setCellValue("C".$hcol, "Tahun Sppt");
             $active_sheet->setCellValue("D".$hcol, "Pokok");
             $active_sheet->setCellValue("E".$hcol, "Denda");
             $active_sheet->setCellValue("F".$hcol, "Bayar");
             

            // STYLE HEADER
            $styleArray = array(
                'font'  => array(
                    'bold'  => true,
                    'size'  => 11,
                    'name'  => 'Calibri'
                ));

                $active_sheet->getStyle('A'.$hcol.':H'.$hcol)->applyFromArray($styleArray);
            $i = 2;
            $ii = $i;
            $pokok_sum = array();
            $denda_sum = array();
            $bayar_sum = array();
             foreach ($exec->result() as $aa) {
             $sheet->setCellValue("A".$i, date('d-m-Y',strtotime($aa->TANGGAL)));
            $sheet->setCellValue("B".$i, $aa->URAIAN);
            $sheet->setCellValue("C".$i, $aa->THN_PAJAK_SPPT);
            $sheet->setCellValue("D".$i, $aa->POKOK);
            $sheet->setCellValue("E".$i, $aa->DENDA);
            $sheet->setCellValue("F".$i, $aa->BAYAR);
            array_push($pokok_sum, $aa->POKOK);
            array_push($denda_sum, $aa->DENDA);
            array_push($bayar_sum, $aa->BAYAR);
             $i++;
             }
              $row_tot = count($fetch)+$ii;
             $sum_row = $row_tot-1;
              $sheet->setCellValue("A".$row_tot, 'Total');
              $active_sheet->getStyle('A'.$row_tot.':H'.$row_tot)->applyFromArray($styleArray);
              $active_sheet->getStyle('A'.$row_tot)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
             $sheet->setCellValue("D".$row_tot, array_sum($pokok_sum));
              $sheet->setCellValue("E".$row_tot, array_sum($denda_sum));
            $sheet->setCellValue("F".$row_tot, array_sum($bayar_sum));
             // $namafile = "excel_export/REKAP_HARIAN".sipkd_user_id().$datetime.".xlsx";
            $namafile = "assets/dok_excel/reh".$datetime.sipkd_user_id().".xlsx";
            // Redirect output to a client’s web browser (Excel5)


            $objWriter = PHPExcel_IOFactory::createWriter($obj_excel, 'Excel2007');
            if(!$objWriter){
            $this->session->set_flashdata('msg_warning', 'Gagal Export File');
            redirect(active_module_url().'rekap_harian');
            }else{
            $objWriter->save($namafile);
             $reader = PHPExcel_IOFactory::createReader('Excel2007');
            if ($reader->canRead($namafile)) {
                    //redirect($namafile);
                    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                    header('Content-Disposition: attachment; filename="'.basename($namafile).'"');
                    header('Content-Length: ' . filesize($namafile));
                    readfile($namafile);
                    unlink($namafile); // Hapus setelah dikirim
                }else{
                    $this->session->set_flashdata('msg_warning', 'Gagal Export File');
                    redirect(active_module_url().'rekap_harian');   
                }
            }
            $obj_excel->disconnectWorksheets();
            unset($obj_excel);
    }

    public function xls_rincian_harian(){
        include "PHPExcel/Classes/PHPExcel.php";
        $this->load->helper('sipkd');
        // include "PHPExcel/Classes/PHPExcel/Writer/Excel5.php";
        $tglm = date('Y-m-d',strtotime($this->input->get('tglawal')));
        $tgls = date('Y-m-d',strtotime($this->input->get('tglakhir')));
        $tahun_sppt1 = (isset($_GET['tahun_sppt1'])) ? $_GET['tahun_sppt1'] : date('Y');
        $tahun_sppt2 = (isset($_GET['tahun_sppt2'])) ? $_GET['tahun_sppt2'] : date('Y');
        $buku    = (!empty($this->input->get('buku'))) ? $this->input->get('buku') : '11';
        $bukumin = $this->load->model('pospbb_ora_model')->rangebuku[substr($buku, 0, 1)][0];
        $bukumax = $this->load->model('pospbb_ora_model')->rangebuku[substr($buku, 1, 1)][1];
        $tp_kd = $this->input->get('tp_kd');
        $kec_kd = (isset($_GET['kec_kd']) && is_numeric($_GET['kec_kd'])) ? $_GET['kec_kd'] : '000';
        $kel_kd = $kel_kd = (isset($_GET['kel_kd']) && is_numeric($_GET['kel_kd'])) ? $_GET['kel_kd'] : '000';

        // $micro = microtime();
        $datetime = date('Ymd').time();
        $where = "WHERE p.tgl_pembayaran_sppt BETWEEN TO_DATE('$tglm', 'YYYY-MM-DD') AND TO_DATE('$tgls', 'YYYY-MM-DD')
            AND k.kd_propinsi='" . KD_PROPINSI . "' 
            AND k.kd_dati2='" . KD_DATI2 . "' 
            AND p.thn_pajak_sppt BETWEEN '$tahun_sppt1' AND '$tahun_sppt2'
            AND k.pbb_yg_harus_dibayar_sppt between $bukumin AND $bukumax ";
         if ($kec_kd != "000") {
            $where .= " AND k.kd_kecamatan='$kec_kd'";
            if ($kel_kd != "000")
                $where .= " AND k.kd_kelurahan='$kel_kd'";
        }

       $fields     = explode(',', POS_FIELD);
        $pos_fld    = '';
        $pos_join   = '';
        $pos_uraian = '';
        $fs = '';
        foreach ($fields as $f) {
            $fs = $f;
            if ($f == 'kd_kanwil')
                $fs = 'kd_kanwil';
            else if ($f == 'kd_kantor')
                $fs = 'kd_kantor';
                
            $pos_fld .= "p.{$f}, ";
            $pos_join .= "p.{$f}=tp.{$fs} and ";
            $pos_uraian .= "tp.{$fs}||";
        }
        $pos_fld = substr($pos_fld, 0, -2);
        $pos_join = substr($pos_join, 0, -4);
        $pos_uraian = substr($pos_uraian, 0, -2);
        $tp_kd = (isset($_GET['tp_kd'])) ? $_GET['tp_kd'] : '';

        if ($tp_kd != 0)
            $where .= " AND {$pos_uraian} = '{$tp_kd}'";


         $sql_query_r = "SELECT  
            k.kd_propinsi||'.'||k.kd_dati2||'-'||k.kd_kecamatan||'.'||k.kd_kelurahan ||'-'|| k.kd_blok ||'.'||k.no_urut||'.'|| k.kd_jns_op kode, 
            k.nm_wp_sppt uraian, {$pos_uraian}||':'||tp.nm_tp nm_tp,p.thn_pajak_sppt,
            (coalesce(p.jml_sppt_yg_dibayar,0) - coalesce(p.denda_sppt,0)) pokok, 
            p.denda_sppt denda, p.jml_sppt_yg_dibayar bayar, to_char(p.tgl_pembayaran_sppt,'dd-mm-yyyy') tanggal
            FROM sppt k 
            INNER JOIN pembayaran_sppt p 
            ON k.kd_propinsi = p.kd_propinsi
            AND k.kd_dati2 = p.kd_dati2 
            AND k.kd_kecamatan = p.kd_kecamatan 
            AND k.kd_kelurahan = p.kd_kelurahan 
            AND k.kd_blok = p.kd_blok 
            AND k.no_urut = p.no_urut 
            AND k.kd_jns_op = p.kd_jns_op 
            AND k.thn_pajak_sppt = p.thn_pajak_sppt
            LEFT JOIN tempat_pembayaran tp ON {$pos_join}
            $where
            ORDER BY k.kd_propinsi||'.'||k.kd_dati2||'-'||k.kd_kecamatan||'.'||k.kd_kelurahan ||'-'|| k.kd_blok ||'.'||k.no_urut||'.'|| k.kd_jns_op,k.nm_wp_sppt,{$pos_uraian}||':'||tp.nm_tp";
            $exec = $this->db->query($sql_query_r);
            $fetch = $exec->result();
            $obj_excel = new PHPExcel;
            $obj_excel->getActiveSheet()->getProtection()->setSheet(true);
 
            $obj_excel->getProperties()->setCreator("Eon");
            $obj_excel->getProperties()->setLastModifiedBy("Eon");
            $obj_excel->getProperties()->setTitle("Data Rincian Harian");
            $obj_excel->removeSheetByIndex(0);
             

            $sheet = $obj_excel->createSheet();
            $active_sheet = $obj_excel->getActiveSheet();
            $sheet->setTitle('RINCIAN_HARIAN');
            foreach(range('A','H') as $columnID) {
                $active_sheet->getColumnDimension($columnID)
                    ->setAutoSize(true);
            }
            $hcol =1;
            $active_sheet->getStyle('A'.$hcol.':I'.$hcol)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
             $active_sheet->setCellValue("A".$hcol, "NOP");
             $active_sheet->setCellValue("B".$hcol, "Uraian");
             $active_sheet->setCellValue("C".$hcol, "Tahun Sppt");
             $active_sheet->setCellValue("D".$hcol, "Pokok");
             $active_sheet->setCellValue("E".$hcol, "Denda");
             $active_sheet->setCellValue("F".$hcol, "Bayar");
             $active_sheet->setCellValue("G".$hcol, "Tanggal");
             $active_sheet->setCellValue("H".$hcol, "Tempat Pembayaran");

            // STYLE HEADER
            $styleArray = array(
                'font'  => array(
                    'bold'  => true,
                    'size'  => 11,
                    'name'  => 'Calibri'
                ));

                $active_sheet->getStyle('A'.$hcol.':H'.$hcol)->applyFromArray($styleArray);
            $i = 2;
            $ii = $i;
            $pokok_sum = array();
            $denda_sum = array();
            $bayar_sum = array();
             foreach ($fetch as $aa) {
             $sheet->setCellValue("A".$i, $aa->KODE);
            $sheet->setCellValue("B".$i, $aa->URAIAN);
            $sheet->setCellValue("C".$i, $aa->THN_PAJAK_SPPT);
            $sheet->setCellValue("D".$i, $aa->POKOK);
            $sheet->setCellValue("E".$i, $aa->DENDA);
            $sheet->setCellValue("F".$i, $aa->BAYAR);
            $sheet->setCellValue("G".$i, date('d-m-Y',strtotime($aa->TANGGAL)));
            $sheet->setCellValue("H".$i, $aa->NM_TP);
            array_push($pokok_sum, $aa->POKOK);
            array_push($denda_sum, $aa->DENDA);
            array_push($bayar_sum, $aa->BAYAR);
             $i++;
             }
             $row_tot = count($fetch)+$ii;
             // $sum_row = $row_tot-1;
              $sheet->setCellValue("A".$row_tot, 'Total');
              $active_sheet->getStyle('A'.$row_tot.':I'.$row_tot)->applyFromArray($styleArray);
              $active_sheet->getStyle('A'.$row_tot)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
             $sheet->setCellValue("D".$row_tot, array_sum($pokok_sum));
              $sheet->setCellValue("E".$row_tot, array_sum($denda_sum));
              $sheet->setCellValue("F".$row_tot, array_sum($bayar_sum));
             $namafile = "assets/dok_excel/rih".$datetime.sipkd_user_id().".xlsx";

            // Redirect output to a client’s web browser (Excel5)


            $objWriter = PHPExcel_IOFactory::createWriter($obj_excel, 'Excel2007');
            if(!$objWriter){
            $this->session->set_flashdata('msg_warning', 'Gagal Export File');
            redirect(active_module_url().'rincian_harian');

            }else{
            $objWriter->save($namafile);
             $reader = PHPExcel_IOFactory::createReader('Excel2007');
            if ($reader->canRead($namafile)) {
                    //redirect($namafile);
                    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                    header('Content-Disposition: attachment; filename="'.basename($namafile).'"');
                    header('Content-Length: ' . filesize($namafile));
                    readfile($namafile);
                    unlink($namafile); // Hapus setelah dikirim
                }else{
                    $this->session->set_flashdata('msg_warning', 'Gagal Export File');
                    redirect(active_module_url().'rincian_harian');   
                }
            }
            $obj_excel->disconnectWorksheets();
            unset($obj_excel);
    }

    public function xls_rekap_user(){

        include "PHPExcel/Classes/PHPExcel.php";
        $this->load->helper('sipkd');
        // include "PHPExcel/Classes/PHPExcel/Writer/Excel5.php";
        $tglm = date('Y-m-d',strtotime($this->input->get('tglawal')));
        $tgls = date('Y-m-d',strtotime($this->input->get('tglakhir')));
        $buku        = (isset($_GET['buku'])) ? $_GET['buku'] : '11';
        $bukumin     = $this->load->model('pospbb_ora_model')->rangebuku[substr($buku, 0, 1)][0];
        $bukumax     = $this->load->model('pospbb_ora_model')->rangebuku[substr($buku, 1, 1)][1];
        
        $kec_kd      = (isset($_GET['kec_kd']) && is_numeric($_GET['kec_kd'])) ? $_GET['kec_kd'] : '000';
        if (get_user_kec_kd() != '000' && get_user_kec_kd() != $kec_kd)
            $kec_kd = get_user_kec_kd();
        
        $kel_kd = (isset($_GET['kel_kd']) && is_numeric($_GET['kel_kd'])) ? $_GET['kel_kd'] : '000';
        
        if (get_user_kel_kd() != '000' && get_user_kel_kd() != $kel_kd)
            $kec_kd = get_user_kel_kd();

        $datetime=date('Y-m-d').' '.time();

        $where = "WHERE p.tgl_pembayaran_sppt BETWEEN TO_DATE('$tglm', 'YYYY-MM-DD') AND TO_DATE('$tgls', 'YYYY-MM-DD')
            AND p.kd_propinsi='" . KD_PROPINSI . "' 
            AND p.kd_dati2='" . KD_DATI2 . "' 
            AND k.pbb_yg_harus_dibayar_sppt between $bukumin AND $bukumax ";
        
        if ($kec_kd != "000")
            $where .= " AND p.kd_kecamatan='$kec_kd'";
        if ($kel_kd != "000")
            $where .= " AND p.kd_kelurahan='$kel_kd'";
        /// -- DARI SINI ..
        $fields     = explode(',', POS_FIELD);
        $pos_fld    = '';
        $pos_join   = '';
        $pos_uraian = '';
        $fs = '';
        foreach ($fields as $f) {
            $fs = $f;
            if ($f == 'kd_kanwil')
                $fs = 'kd_kanwil';
            else if ($f == 'kd_kppbb')
                $fs = 'kd_kantor';
                
            $pos_fld .= "p.{$f}, ";
            $pos_join .= "p.{$f}=tp.{$fs} and ";
            $pos_uraian .= "tp.{$fs}||";
        }
        $pos_fld = substr($pos_fld, 0, -2);
        $pos_join = substr($pos_join, 0, -4);
        $pos_uraian = substr($pos_uraian, 0, -2);
        
        $user_kd = (isset($_GET['user_kd'])) ? $_GET['user_kd'] : "";
        //var_dump($user_kd);die;
        if ($user_kd != ""){
            if ($user_kd=="0") $where .= " AND p.user_id is null";
            elseif ($user_kd=="-1") $where .= " AND p.user_id is not null";
            else $where .= " AND p.user_id = {$user_kd}";
        }
        
          $sql_query_r = "SELECT  tgl_pembayaran_sppt tanggal,{$pos_uraian}||':'||tp.nm_tp uraian,
            sum(coalesce(p.jml_sppt_yg_dibayar,0) - coalesce(p.denda_sppt,0))  pokok, 
            sum(p.denda_sppt) denda, 
            sum(p.jml_sppt_yg_dibayar) bayar, u.nama
            FROM sppt k 
            INNER JOIN pembayaran_sppt p 
            ON k.kd_propinsi = p.kd_propinsi
            AND k.kd_dati2 = p.kd_dati2 
            AND k.kd_kecamatan = p.kd_kecamatan 
            AND k.kd_kelurahan = p.kd_kelurahan 
            AND k.kd_blok = p.kd_blok 
            AND k.no_urut = p.no_urut 
            AND k.kd_jns_op = p.kd_jns_op 
            AND k.thn_pajak_sppt = p.thn_pajak_sppt 
            LEFT JOIN tempat_pembayaran tp ON {$pos_join}
            LEFT JOIN SEC_USERS u ON u.NIP=p.NIP_REKAM_BYR_SPPT
            $where
            GROUP BY tgl_pembayaran_sppt,{$pos_uraian}||':'||tp.nm_tp,u.nama
            ORDER BY tgl_pembayaran_sppt,{$pos_uraian}||':'||tp.nm_tp,u.nama ";
            $exec = $this->db->query($sql_query_r);
            $fetch = $exec->result_array();
            $obj_excel = new PHPExcel;
            $obj_excel->getActiveSheet()->getProtection()->setSheet(true);
 
            $obj_excel->getProperties()->setCreator("Eon");
            $obj_excel->getProperties()->setLastModifiedBy("Eon");
            $obj_excel->getProperties()->setTitle("Data Rincian Harian");
            $obj_excel->removeSheetByIndex(0);
             

            $sheet = $obj_excel->createSheet();
            $active_sheet = $obj_excel->getActiveSheet();
            $sheet->setTitle('REKAP_USER');
            foreach(range('A','F') as $columnID) {
                $active_sheet->getColumnDimension($columnID)
                    ->setAutoSize(true);
            }
            $hcol =1;
            $active_sheet->getStyle('A'.$hcol.':F'.$hcol)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
             $active_sheet->setCellValue("A".$hcol, "Tanggal");
             $active_sheet->setCellValue("B".$hcol, "Uraian");
             $active_sheet->setCellValue("C".$hcol, "Pokok");
             $active_sheet->setCellValue("D".$hcol, "Denda");
             $active_sheet->setCellValue("E".$hcol, "Bayar");
              $active_sheet->setCellValue("F".$hcol, "User");
             

            // STYLE HEADER
            $styleArray = array(
                'font'  => array(
                    'bold'  => true,
                    'size'  => 11,
                    'name'  => 'Calibri'
                ));

                $active_sheet->getStyle('A'.$hcol.':H'.$hcol)->applyFromArray($styleArray);
             
            $i = 2;
            $ii = $i;
            $pokok_sum = array();
            $denda_sum = array();
            $bayar_sum = array();
             foreach ($exec->result() as $aa) {
             $sheet->setCellValue("A".$i, date('d-m-Y',strtotime($aa->TANGGAL)));
            $sheet->setCellValue("B".$i, $aa->URAIAN);
            $sheet->setCellValue("C".$i, $aa->POKOK);
            $sheet->setCellValue("D".$i, $aa->DENDA);
            $sheet->setCellValue("E".$i, $aa->BAYAR);
            $sheet->setCellValue("F".$i, $aa->NAMA);
            array_push($pokok_sum, $aa->POKOK);
            array_push($denda_sum, $aa->DENDA);
            array_push($bayar_sum, $aa->BAYAR);
             $i++;
             }
              $row_tot = count($fetch)+$ii;
             $sum_row = $row_tot-1;
              $sheet->setCellValue("A".$row_tot, 'Total');
              $active_sheet->getStyle('A'.$row_tot.':F'.$row_tot)->applyFromArray($styleArray);
              $active_sheet->getStyle('A'.$row_tot)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
             $sheet->setCellValue("C".$row_tot, array_sum($pokok_sum));
              $sheet->setCellValue("D".$row_tot, array_sum($denda_sum));
                $sheet->setCellValue("E".$row_tot, array_sum($bayar_sum));
             // $namafile = "excel_export/REKAP_USER".sipkd_user_id().$datetime.".xlsx";
            $namafile = "assets/dok_excel/reu".$datetime.sipkd_user_id().".xlsx";
            // Redirect output to a client’s web browser (Excel5)


            $objWriter = PHPExcel_IOFactory::createWriter($obj_excel, 'Excel2007');
            if(!$objWriter){
            $this->session->set_flashdata('msg_warning', 'Gagal Export File');
            redirect(active_module_url().'rekap_user');
            }else{
            $objWriter->save($namafile);
             $reader = PHPExcel_IOFactory::createReader('Excel2007');
            if ($reader->canRead($namafile)) {
                    //redirect($namafile);
                    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                    header('Content-Disposition: attachment; filename="'.basename($namafile).'"');
                    header('Content-Length: ' . filesize($namafile));
                    readfile($namafile);
                    unlink($namafile); // Hapus setelah dikirim
                }else{
                    $this->session->set_flashdata('msg_warning', 'Gagal Export File');
                    redirect(active_module_url().'rekap_user');   
                }
            }
            $obj_excel->disconnectWorksheets();
            unset($obj_excel);   
    }

    public function xls_rincian_user(){
        include "PHPExcel/Classes/PHPExcel.php";
        $this->load->helper('sipkd');
        // include "PHPExcel/Classes/PHPExcel/Writer/Excel5.php";
        $tglm1 = date('Y-m-d',strtotime($this->input->get('tglawal')));
        $tgls1 = date('Y-m-d',strtotime($this->input->get('tglakhir')));
       $kec_kd = (isset($_GET['kec_kd']) && is_numeric($_GET['kec_kd'])) ? $_GET['kec_kd'] : '000';
        if (get_user_kec_kd() != '000' && get_user_kec_kd() != $kec_kd)
            $kec_kd = get_user_kec_kd();
        
        $kel_kd = (isset($_GET['kel_kd']) && is_numeric($_GET['kel_kd'])) ? $_GET['kel_kd'] : '000';
        if (get_user_kel_kd() != '000' && get_user_kel_kd() != $kel_kd)
            $kec_kd = get_user_kel_kd();
        
        $buku    = (isset($_GET['buku'])) ? $_GET['buku'] : '15';
        $bukumin = $this->load->model('pospbb_ora_model')->rangebuku[substr($buku, 0, 1)][0];
        $bukumax = $this->load->model('pospbb_ora_model')->rangebuku[substr($buku, 1, 1)][1];
        
        $tglm = (isset($_GET['tglawal'])) ? $tglm1 : date('Y-m-d');
        $tgls = (isset($_GET['tglakhir'])) ? $tgls1 : date('Y-m-d');

        // $micro = microtime();
        $datetime = date('Y-m-d').' '.time();
        $where = "WHERE p.tgl_pembayaran_sppt BETWEEN TO_DATE('$tglm', 'YYYY-MM-DD') AND TO_DATE('$tgls', 'YYYY-MM-DD')
            AND k.kd_propinsi='" . KD_PROPINSI . "' 
            AND k.kd_dati2='" . KD_DATI2 . "' 
            AND k.pbb_yg_harus_dibayar_sppt between $bukumin AND $bukumax ";
        
        //die($where);    
        if ($kec_kd != "000") {
            $where .= " AND k.kd_kecamatan='$kec_kd'";
            if ($kel_kd != "000")
                $where .= " AND k.kd_kelurahan='$kel_kd'";
        }
        /*
         * Output
         */
        $fields     = explode(',', POS_FIELD);
        $pos_fld    = '';
        $pos_join   = '';
        $pos_uraian = '';
        $fs = '';
        foreach ($fields as $f) {
            $fs = $f;
            if ($f == 'kd_kanwil')
                $fs = 'kd_kanwil';
            else if ($f == 'kd_kppbb')
                $fs = 'kd_kantor';
                
            $pos_fld .= "p.{$f}, ";
            $pos_join .= "p.{$f}=tp.{$fs} and ";
            $pos_uraian .= "tp.{$fs}||";
        }
        $pos_fld = substr($pos_fld, 0, -2);
        $pos_join = substr($pos_join, 0, -4);
        $pos_uraian = substr($pos_uraian, 0, -2);
        
        $user_kd = (isset($_GET['user_kd'])) ? $_GET['user_kd'] : '';
        if ($user_kd != ""){
            if ($user_kd=="0") $where .= " AND p.user_id is null";
            elseif ($user_kd=="-1") $where .= " AND p.user_id is not null";
            else $where .= " AND p.user_id = {$user_kd}";
        }    
         $sql_query_r = "SELECT  
            k.kd_propinsi||'.'||k.kd_dati2||'-'||k.kd_kecamatan||'.'||k.kd_kelurahan ||'-'|| k.kd_blok ||'.'||k.no_urut||'.'|| k.kd_jns_op kode, 
            k.nm_wp_sppt uraian, {$pos_uraian}||':'||tp.nm_tp nm_tp, p.thn_pajak_sppt,
            (coalesce(p.jml_sppt_yg_dibayar,0) - coalesce(p.denda_sppt,0)) pokok, 
            p.denda_sppt denda, p.jml_sppt_yg_dibayar bayar, to_char(p.tgl_pembayaran_sppt,'dd-mm-yyyy') tanggal,
            u.nama
            FROM sppt k 
            INNER JOIN pembayaran_sppt p 
            ON k.kd_propinsi = p.kd_propinsi
            AND k.kd_dati2 = p.kd_dati2 
            AND k.kd_kecamatan = p.kd_kecamatan 
            AND k.kd_kelurahan = p.kd_kelurahan 
            AND k.kd_blok = p.kd_blok 
            AND k.no_urut = p.no_urut 
            AND k.kd_jns_op = p.kd_jns_op 
            AND k.thn_pajak_sppt = p.thn_pajak_sppt 
            LEFT JOIN tempat_pembayaran tp ON {$pos_join}
            LEFT JOIN SEC_USERS u ON u.NIP=p.NIP_REKAM_BYR_SPPT
           $where 
            ORDER BY k.kd_propinsi||'.'||k.kd_dati2||'-'||k.kd_kecamatan||'.'||k.kd_kelurahan ||'-'|| k.kd_blok ||'.'||k.no_urut||'.'|| k.kd_jns_op,k.nm_wp_sppt,{$pos_uraian}||':'||tp.nm_tp ";
            $exec = $this->db->query($sql_query_r);
            $fetch = $exec->result();
            $obj_excel = new PHPExcel;
            $obj_excel->getActiveSheet()->getProtection()->setSheet(true);
 
            $obj_excel->getProperties()->setCreator("Eon");
            $obj_excel->getProperties()->setLastModifiedBy("Eon");
            $obj_excel->getProperties()->setTitle("Data Rincian Harian");
            $obj_excel->removeSheetByIndex(0);
             

            $sheet = $obj_excel->createSheet();
            $active_sheet = $obj_excel->getActiveSheet();
            $sheet->setTitle('sheet_1');
            foreach(range('A','H') as $columnID) {
                $active_sheet->getColumnDimension($columnID)
                    ->setAutoSize(true);
            }
            $hcol =1;
            $active_sheet->getStyle('A'.$hcol.':I'.$hcol)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
             $active_sheet->setCellValue("A".$hcol, "NOP");
             $active_sheet->setCellValue("B".$hcol, "Uraian");
             $active_sheet->setCellValue("C".$hcol, "Tahun Sppt");
             $active_sheet->setCellValue("D".$hcol, "Pokok");
             $active_sheet->setCellValue("E".$hcol, "Denda");
             $active_sheet->setCellValue("F".$hcol, "Bayar");
             $active_sheet->setCellValue("G".$hcol, "Tanggal");
             $active_sheet->setCellValue("H".$hcol, "Tempat Pembayaran");
              $active_sheet->setCellValue("I".$hcol, "User");

            // STYLE HEADER
            $styleArray = array(
                'font'  => array(
                    'bold'  => true,
                    'size'  => 11,
                    'name'  => 'Calibri'
                ));

                $active_sheet->getStyle('A'.$hcol.':I'.$hcol)->applyFromArray($styleArray);
            $i = 2;
            $ii = $i;
            $pokok_sum = array();
            $denda_sum = array();
            $bayar_sum = array();
             foreach ($fetch as $aa) {
             $sheet->setCellValue("A".$i, $aa->KODE);
            $sheet->setCellValue("B".$i, $aa->URAIAN);
            $sheet->setCellValue("C".$i, $aa->THN_PAJAK_SPPT);
            $sheet->setCellValue("D".$i, $aa->POKOK);
            $sheet->setCellValue("E".$i, $aa->DENDA);
            $sheet->setCellValue("F".$i, $aa->BAYAR);
            $sheet->setCellValue("G".$i, date('d-m-Y',strtotime($aa->TANGGAL)));
            $sheet->setCellValue("H".$i, $aa->NM_TP);
            $sheet->setCellValue("I".$i, $aa->NAMA);
            array_push($pokok_sum, $aa->POKOK);
            array_push($denda_sum, $aa->DENDA);
            array_push($bayar_sum, $aa->BAYAR);
             $i++;
             }
             $row_tot = count($fetch)+$ii;
             // $sum_row = $row_tot-1;
              $sheet->setCellValue("A".$row_tot, 'Total');
              $active_sheet->getStyle('A'.$row_tot.':I'.$row_tot)->applyFromArray($styleArray);
              $active_sheet->getStyle('A'.$row_tot)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
             $sheet->setCellValue("D".$row_tot, array_sum($pokok_sum));
              $sheet->setCellValue("E".$row_tot, array_sum($denda_sum));
              $sheet->setCellValue("F".$row_tot, array_sum($bayar_sum));
             // $namafile = "excel_export/RINCIAN_USER".sipkd_user_id().$datetime.".xlsx";
             $namafile = "assets/dok_excel/riu".$datetime.sipkd_user_id().".xlsx";
            // Redirect output to a client’s web browser (Excel5)


            $objWriter = PHPExcel_IOFactory::createWriter($obj_excel, 'Excel2007');
            if(!$objWriter){
            $this->session->set_flashdata('msg_warning', 'Gagal Export File');
            redirect(active_module_url().'rincian_user');

            }else{
            $objWriter->save($namafile);
             $reader = PHPExcel_IOFactory::createReader('Excel2007');
            if ($reader->canRead($namafile)) {
                    //redirect($namafile);
                    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                    header('Content-Disposition: attachment; filename="'.basename($namafile).'"');
                    header('Content-Length: ' . filesize($namafile));
                    readfile($namafile);
                    unlink($namafile); // Hapus setelah dikirim
                }else{
                $this->session->set_flashdata('msg_warning', 'Gagal Export File');
            redirect(active_module_url().'rincian_user');   
                }
            }
            $obj_excel->disconnectWorksheets();
            unset($obj_excel);
    }
    
	public function csv_rekap_harian() {

        $schema_pbb = SCHEMA_PBB.".";
        $buku        = (isset($_POST['buku'])) ? $_POST['buku'] : '11';
        $bukumin     = $this->pospbb_ora_model->rangebuku[substr($buku, 0, 1)][0];
        $bukumax     = $this->pospbb_ora_model->rangebuku[substr($buku, 1, 1)][1];
        $tahun_sppt1 = (isset($_POST['tahun_sppt1'])) ? $_POST['tahun_sppt1'] : date('Y');
        $tahun_sppt2 = (isset($_POST['tahun_sppt2'])) ? $_POST['tahun_sppt2'] : date('Y');
        $kec_kd      = (isset($_POST['kec_kd']) && is_numeric($_POST['kec_kd'])) ? $_POST['kec_kd'] : '000';
        if (get_user_kec_kd() != '000' && get_user_kec_kd() != $kec_kd)
            $kec_kd = get_user_kec_kd();
        
        $kel_kd = (isset($_POST['kel_kd']) && is_numeric($_POST['kel_kd'])) ? $_POST['kel_kd'] : '000';
        
        if (get_user_kel_kd() != '000' && get_user_kel_kd() != $kel_kd)
            $kec_kd = get_user_kel_kd();
        
        $tglm = (isset($_POST['tglawal'])) ? $_POST['tglawal'] : date('d-m-Y');
        $tgls = (isset($_POST['tglakhir'])) ? $_POST['tglakhir'] : date('d-m-Y');
        
        $tglm = substr($tglm, 6, 4) . '-' . substr($tglm, 3, 2) . '-' . substr($tglm, 0, 2);
        $tgls = substr($tgls, 6, 4) . '-' . substr($tgls, 3, 2) . '-' . substr($tgls, 0, 2);
        
        $where = "WHERE p.tgl_pembayaran_sppt BETWEEN TO_DATE('$tglm', 'YYYY-MM-DD') AND TO_DATE('$tgls', 'YYYY-MM-DD')
            AND p.kd_propinsi='" . KD_PROPINSI . "' 
            AND p.kd_dati2='" . KD_DATI2 . "' 
            AND p.thn_pajak_sppt BETWEEN '$tahun_sppt1' AND '$tahun_sppt2'
            AND k.pbb_yg_harus_dibayar_sppt between $bukumin AND $bukumax ";
        
        if ($kec_kd != "000")
            $where .= " AND p.kd_kecamatan='$kec_kd'";
        if ($kel_kd != "000")
            $where .= " AND p.kd_kelurahan='$kel_kd'";
        //
        if (DEF_POS_TYPE==1){
            $pos_fld    = "p.KD_KANWIL,p.KD_KANTOR,p.KD_TP ";
            $pos_join   = "p.KD_KANWIL=tp.KD_KANWIL and p.KD_KANTOR=tp.KD_KANTOR and p.KD_TP=tp.KD_TP "; 
            $pos_uraian = "tp.KD_KANWIL||tp.KD_KANTOR||tp.KD_TP ";                 
        }
        else{
            $pos_fld    = "p.KD_BANK_TUNGGAL,p.KD_BANK_PERSEPSI,p.KD_KANWIL, p.KD_KANTOR,p.KD_TP ";
            $pos_join   = "p.KD_BANK_TUNGGAL=tp.KD_BANK_TUNGGAL and p.KD_BANK_PERSEPSI=tp.KD_BANK_PERSEPSI ";
            $pos_join  .= " and p.KD_KANWIL=tp.KD_KANWIL and p.KD_KANTOR=tp.KD_KANTOR and p.KD_TP=tp.KD_TP "; 
            $pos_uraian = "tp.KD_BANK_TUNGGAL||tp.KD_BANK_PERSEPSI||tp.KD_KANWIL||tp.KD_KANTOR||tp.KD_TP "; 
        }
        //        
        $tp_kd = (isset($_POST['tp_kd'])) ? $_POST['tp_kd'] : '';
        if ($tp_kd != "")
            $where .= " AND {$pos_uraian} = '{$tp_kd}'";
            
        $sql_query_r = "SELECT  to_char(tgl_pembayaran_sppt,'DD-MM-YYYY') kode,{$pos_uraian}||':'||tp.nm_tp uraian, p.thn_pajak_sppt,
            sum(coalesce(p.jml_sppt_yg_dibayar,0) - coalesce(p.denda_sppt,0))  pokok, 
            sum(p.denda_sppt) denda, 
            sum(p.jml_sppt_yg_dibayar) bayar
            FROM S_SPPT k 
            INNER JOIN S_PEMBAYARAN_SPPT p 
            ON k.kd_propinsi = p.kd_propinsi
            AND k.kd_dati2 = p.kd_dati2 
            AND k.kd_kecamatan = p.kd_kecamatan 
            AND k.kd_kelurahan = p.kd_kelurahan 
            AND k.kd_blok = p.kd_blok 
            AND k.no_urut = p.no_urut 
            AND k.kd_jns_op = p.kd_jns_op 
            AND k.thn_pajak_sppt = p.thn_pajak_sppt 
            LEFT JOIN S_TEMPAT_PEMBAYARAN tp ON {$pos_join}
            {$where} 
            GROUP BY 1,2,3
            ORDER BY 1,2,3 ";

        $rptnm = "REKAP HARIAN";
		header("Content-type: text/plain"); 
		header("Cache-Control: no-store, no-cache"); 
		header('Content-Disposition: attachment; filename="'.$rptnm.'.csv"'); 

        if($rows = $this->db->query($sql_query_r)->result_array()){
            $title = array('TANGGAL','URAIAN','THN.SPPT','POKOK','DENDA','BAYAR');
            $this->csv_encode( $rows, $title ); 
        } else {
            echo "Tidak ada data";
        }
        exit;
	}
	
	public function csv_rincian_harian() {

        $schema_pbb = SCHEMA_PBB.".";
        $kec_kd = (isset($_POST['kec_kd']) && is_numeric($_POST['kec_kd'])) ? $_POST['kec_kd'] : '000';
        if (get_user_kec_kd() != '000' && get_user_kec_kd() != $kec_kd)
            $kec_kd = get_user_kec_kd();
        
        $kel_kd = (isset($_POST['kel_kd']) && is_numeric($_POST['kel_kd'])) ? $_POST['kel_kd'] : '000';
        if (get_user_kel_kd() != '000' && get_user_kel_kd() != $kel_kd)
            $kec_kd = get_user_kel_kd();
        
        $buku    = (isset($_POST['buku'])) ? $_POST['buku'] : '11';
        $bukumin = $this->pospbb_ora_model->rangebuku[substr($buku, 0, 1)][0];
        $bukumax = $this->pospbb_ora_model->rangebuku[substr($buku, 1, 1)][1];
        
        $tglm = (isset($_POST['tglawal'])) ? $_POST['tglawal'] : date('d-m-Y');
        $tgls = (isset($_POST['tglakhir'])) ? $_POST['tglakhir'] : date('d-m-Y');
        $tglm = substr($tglm, 6, 4) . '-' . substr($tglm, 3, 2) . '-' . substr($tglm, 0, 2);
        $tgls = substr($tgls, 6, 4) . '-' . substr($tgls, 3, 2) . '-' . substr($tgls, 0, 2);
        
        $tahun_sppt1 = (isset($_POST['tahun_sppt1'])) ? $_POST['tahun_sppt1'] : date('Y');
        $tahun_sppt2 = (isset($_POST['tahun_sppt2'])) ? $_POST['tahun_sppt2'] : date('Y');
        
        $where = "WHERE p.tgl_pembayaran_sppt BETWEEN TO_DATE('$tglm', 'YYYY-MM-DD') AND TO_DATE('$tgls', 'YYYY-MM-DD')
            AND k.kd_propinsi='" . KD_PROPINSI . "' 
            AND k.kd_dati2='" . KD_DATI2 . "' 
            AND p.thn_pajak_sppt BETWEEN '$tahun_sppt1' AND '$tahun_sppt2'
            AND k.pbb_yg_harus_dibayar_sppt between $bukumin AND $bukumax ";
        
        if ($kec_kd != "000") {
            $where .= " AND k.kd_kecamatan='$kec_kd'";
            if ($kel_kd != "000")
                $where .= " AND k.kd_kelurahan='$kel_kd'";
        }
        //
        if (DEF_POS_TYPE==1){
            $pos_fld    = "p.KD_KANWIL,p.KD_KANTOR,p.KD_TP ";
            $pos_join   = "p.KD_KANWIL=tp.KD_KANWIL and p.KD_KANTOR=tp.KD_KANTOR and p.KD_TP=tp.KD_TP "; 
            $pos_uraian = "tp.KD_KANWIL||tp.KD_KANTOR||tp.KD_TP ";                 
        }
        else{
            $pos_fld    = "p.KD_BANK_TUNGGAL,p.KD_BANK_PERSEPSI,p.KD_KANWIL, p.KD_KANTOR,p.KD_TP ";
            $pos_join   = "p.KD_BANK_TUNGGAL=tp.KD_BANK_TUNGGAL and p.KD_BANK_PERSEPSI=tp.KD_BANK_PERSEPSI ";
            $pos_join  .= " and p.KD_KANWIL=tp.KD_KANWIL and p.KD_KANTOR=tp.KD_KANTOR and p.KD_TP=tp.KD_TP "; 
            $pos_uraian = "tp.KD_BANK_TUNGGAL||tp.KD_BANK_PERSEPSI||tp.KD_KANWIL||tp.KD_KANTOR||tp.KD_TP "; 
        }
        //        
        $tp_kd = (isset($_POST['tp_kd'])) ? $_POST['tp_kd'] : '';
        if ($tp_kd != "")
            $where .= " AND {$pos_uraian} = '{$tp_kd}'";
            
        $sql_query_r = "SELECT  
            k.kd_propinsi||'.'||k.kd_dati2||'-'||k.kd_kecamatan||'.'||k.kd_kelurahan ||'-'|| k.kd_blok ||'.'||k.no_urut||'.'|| k.kd_jns_op kode, p.thn_pajak_sppt,
            k.nm_wp_sppt uraian, {$pos_uraian}||':'||tp.nm_tp nm_tp, 
            (coalesce(p.jml_sppt_yg_dibayar,0) - coalesce(p.denda_sppt,0)) pokok, 
            p.denda_sppt denda, p.jml_sppt_yg_dibayar bayar, 
            to_char(p.tgl_pembayaran_sppt,'dd-mm-yyyy') tanggal
            FROM S_SPPT k 
            INNER JOIN S_PEMBAYARAN_SPPT p 
            ON k.kd_propinsi = p.kd_propinsi
            AND k.kd_dati2 = p.kd_dati2 
            AND k.kd_kecamatan = p.kd_kecamatan 
            AND k.kd_kelurahan = p.kd_kelurahan 
            AND k.kd_blok = p.kd_blok 
            AND k.no_urut = p.no_urut 
            AND k.kd_jns_op = p.kd_jns_op 
            AND k.thn_pajak_sppt = p.thn_pajak_sppt 
            LEFT JOIN S_TEMPAT_PEMBAYARAN tp ON {$pos_join}
            {$where} 
            ORDER BY 1,2,3 ";
    

        $rptnm = "RINCIAN HARIAN";
		header("Content-type: text/plain"); 
		header("Cache-Control: no-store, no-cache"); 
		header('Content-Disposition: attachment; filename="'.$rptnm.'.csv"'); 

        if($rows = $this->db->query($sql_query_r)->result_array()){
            $title = array('NOP','THN.SPPT','URAIAN','POKOK','DENDA','BAYAR');
            $this->csv_encode( $rows, $title ); 
        } else {
            echo "Tidak ada data";
        }
        exit;
	}
    
	public function csv_rekap_user() {

        $schema_pbb = SCHEMA_PBB.".";
        $buku        = (isset($_POST['buku'])) ? $_POST['buku'] : '11';
        $bukumin     = $this->pospbb_ora_model->rangebuku[substr($buku, 0, 1)][0];
        $bukumax     = $this->pospbb_ora_model->rangebuku[substr($buku, 1, 1)][1];
        $kec_kd      = (isset($_POST['kec_kd']) && is_numeric($_POST['kec_kd'])) ? $_POST['kec_kd'] : '000';
        if (get_user_kec_kd() != '000' && get_user_kec_kd() != $kec_kd)
            $kec_kd = get_user_kec_kd();
        
        $kel_kd = (isset($_POST['kel_kd']) && is_numeric($_POST['kel_kd'])) ? $_POST['kel_kd'] : '000';
        
        if (get_user_kel_kd() != '000' && get_user_kel_kd() != $kel_kd)
            $kec_kd = get_user_kel_kd();
        
        $tglm = (isset($_POST['tglawal'])) ? $_POST['tglawal'] : date('d-m-Y');
        $tgls = (isset($_POST['tglakhir'])) ? $_POST['tglakhir'] : date('d-m-Y');
        
        $tglm = substr($tglm, 6, 4) . '-' . substr($tglm, 3, 2) . '-' . substr($tglm, 0, 2);
        $tgls = substr($tgls, 6, 4) . '-' . substr($tgls, 3, 2) . '-' . substr($tgls, 0, 2);
        
        $where = "WHERE p.tgl_pembayaran_sppt BETWEEN TO_DATE('$tglm', 'YYYY-MM-DD') AND TO_DATE('$tgls', 'YYYY-MM-DD')
            AND p.kd_propinsi='" . KD_PROPINSI . "' 
            AND p.kd_dati2='" . KD_DATI2 . "' 
            AND k.pbb_yg_harus_dibayar_sppt between $bukumin AND $bukumax ";
        
        if ($kec_kd != "000")
            $where .= " AND p.kd_kecamatan='$kec_kd'";
        if ($kel_kd != "000")
            $where .= " AND p.kd_kelurahan='$kel_kd'";
        //
        if (DEF_POS_TYPE==1){
            $pos_fld    = "p.KD_KANWIL,p.KD_KANTOR,p.KD_TP ";
            $pos_join   = "p.KD_KANWIL=tp.KD_KANWIL and p.KD_KANTOR=tp.KD_KANTOR and p.KD_TP=tp.KD_TP "; 
            $pos_uraian = "tp.KD_KANWIL||tp.KD_KANTOR||tp.KD_TP ";                 
        }
        else{
            $pos_fld    = "p.KD_BANK_TUNGGAL,p.KD_BANK_PERSEPSI,p.KD_KANWIL, p.KD_KANTOR,p.KD_TP ";
            $pos_join   = "p.KD_BANK_TUNGGAL=tp.KD_BANK_TUNGGAL and p.KD_BANK_PERSEPSI=tp.KD_BANK_PERSEPSI ";
            $pos_join  .= " and p.KD_KANWIL=tp.KD_KANWIL and p.KD_KANTOR=tp.KD_KANTOR and p.KD_TP=tp.KD_TP "; 
            $pos_uraian = "tp.KD_BANK_TUNGGAL||tp.KD_BANK_PERSEPSI||tp.KD_KANWIL||tp.KD_KANTOR||tp.KD_TP "; 
        }
        //        
        $user_kd = (isset($_POST['user_kd'])) ? $_POST['user_kd'] : "";

        if ($user_kd == "" || $user_kd != -99999){
            if ($user_kd=="0") $where .= " AND p.user_id is null";
            elseif ($user_kd=="-1") $where .= " AND p.user_id is not null";
            else $where .= " AND p.user_id = {$user_kd}";
        }
        
        $sql_query_r = "SELECT tgl_pembayaran_sppt kode,{$pos_uraian}||':'||tp.nm_tp uraian,
            sum(coalesce(p.jml_sppt_yg_dibayar,0) - coalesce(p.denda_sppt,0))  pokok, 
            sum(p.denda_sppt) denda, 
            sum(p.jml_sppt_yg_dibayar) bayar, u.nama
            FROM S_SPPT k 
            INNER JOIN S_PEMBAYARAN_SPPT p 
            ON k.kd_propinsi = p.kd_propinsi
            AND k.kd_dati2 = p.kd_dati2 
            AND k.kd_kecamatan = p.kd_kecamatan 
            AND k.kd_kelurahan = p.kd_kelurahan 
            AND k.kd_blok = p.kd_blok 
            AND k.no_urut = p.no_urut 
            AND k.kd_jns_op = p.kd_jns_op 
            AND k.thn_pajak_sppt = p.thn_pajak_sppt 
            LEFT JOIN S_TEMPAT_PEMBAYARAN tp ON {$pos_join}
            LEFT JOIN SEC_USERS u ON u.NIP=p.NIP_REKAM_BYR_SPPT
            {$where} 
            GROUP BY tgl_pembayaran_sppt,{$pos_uraian}||':'||tp.nm_tp,u.nama
            ORDER BY tgl_pembayaran_sppt,{$pos_uraian}||':'||tp.nm_tp,u.nama ";    

        $rptnm = "REKAP HARIAN USER";
		header("Content-type: text/plain"); 
		header("Cache-Control: no-store, no-cache"); 
		header('Content-Disposition: attachment; filename="'.$rptnm.'.csv"'); 

        if($rows = $this->db->query($sql_query_r)->result_array()){
            $title = array('TANGGAL','URAIAN','POKOK','DENDA','BAYAR','USER');
            $this->csv_encode( $rows, $title ); 
        } else {
            echo "Tidak ada data";
        }
        exit;
	}
    
	public function csv_rincian_user() {

        $schema_pbb = SCHEMA_PBB.".";
        $kec_kd = (isset($_POST['kec_kd']) && is_numeric($_POST['kec_kd'])) ? $_POST['kec_kd'] : '000';
        if (get_user_kec_kd() != '000' && get_user_kec_kd() != $kec_kd)
            $kec_kd = get_user_kec_kd();
        
        $kel_kd = (isset($_POST['kel_kd']) && is_numeric($_POST['kel_kd'])) ? $_POST['kel_kd'] : '000';
        if (get_user_kel_kd() != '000' && get_user_kel_kd() != $kel_kd)
            $kec_kd = get_user_kel_kd();
        
        $buku    = (isset($_POST['buku'])) ? $_POST['buku'] : '15';
        $bukumin = $this->pospbb_ora_model->rangebuku[substr($buku, 0, 1)][0];
        $bukumax = $this->pospbb_ora_model->rangebuku[substr($buku, 1, 1)][1];
        
        $tglm = (isset($_POST['tglawal'])) ? $_POST['tglawal'] : date('d-m-Y');
        $tgls = (isset($_POST['tglakhir'])) ? $_POST['tglakhir'] : date('d-m-Y');
        $tglm = substr($tglm, 6, 4) . '-' . substr($tglm, 3, 2) . '-' . substr($tglm, 0, 2);
        $tgls = substr($tgls, 6, 4) . '-' . substr($tgls, 3, 2) . '-' . substr($tgls, 0, 2);
        
        $where = "WHERE p.tgl_pembayaran_sppt BETWEEN TO_DATE('$tglm', 'YYYY-MM-DD') AND TO_DATE('$tgls', 'YYYY-MM-DD')
            AND k.kd_propinsi='" . KD_PROPINSI . "' 
            AND k.kd_dati2='" . KD_DATI2 . "' 
            AND k.pbb_yg_harus_dibayar_sppt between $bukumin AND $bukumax ";
        
        if ($kec_kd != "000") {
            $where .= " AND k.kd_kecamatan='$kec_kd'";
            if ($kel_kd != "000")
                $where .= " AND k.kd_kelurahan='$kel_kd'";
        }
        //
        if (DEF_POS_TYPE==1){
            $pos_fld    = "p.KD_KANWIL,p.KD_KANTOR,p.KD_TP ";
            $pos_join   = "p.KD_KANWIL=tp.KD_KANWIL and p.KD_KANTOR=tp.KD_KANTOR and p.KD_TP=tp.KD_TP "; 
            $pos_uraian = "tp.KD_KANWIL||tp.KD_KANTOR||tp.KD_TP ";                 
        }
        else{
            $pos_fld    = "p.KD_BANK_TUNGGAL,p.KD_BANK_PERSEPSI,p.KD_KANWIL, p.KD_KANTOR,p.KD_TP ";
            $pos_join   = "p.KD_BANK_TUNGGAL=tp.KD_BANK_TUNGGAL and p.KD_BANK_PERSEPSI=tp.KD_BANK_PERSEPSI ";
            $pos_join  .= " and p.KD_KANWIL=tp.KD_KANWIL and p.KD_KANTOR=tp.KD_KANTOR and p.KD_TP=tp.KD_TP "; 
            $pos_uraian = "tp.KD_BANK_TUNGGAL||tp.KD_BANK_PERSEPSI||tp.KD_KANWIL||tp.KD_KANTOR||tp.KD_TP "; 
        }
        //        
        $user_kd = (isset($_POST['user_kd'])) ? $_POST['user_kd'] : '';

        if ($user_kd == "" || $user_kd != -99999){

            if ($user_kd=="0") $where .= " AND p.user_id is null";
            elseif ($user_kd=="-1") $where .= " AND p.user_id is not null";
            else $where .= " AND p.user_id = {$user_kd}";
        }    

        $sql_query_r = "SELECT k.kd_propinsi||'.'||k.kd_dati2||'-'||k.kd_kecamatan||'.'||k.kd_kelurahan ||
        '-'|| k.kd_blok ||'.'||k.no_urut||'.'|| k.kd_jns_op as kode, p.thn_pajak_sppt,
            k.nm_wp_sppt as uraian, 
            (coalesce(p.jml_sppt_yg_dibayar,0) - coalesce(p.denda_sppt,0)) as pokok, 
            p.denda_sppt as denda, p.jml_sppt_yg_dibayar as bayar, 
            to_char(p.tgl_pembayaran_sppt,'dd-mm-yyyy') as tanggal,
            {$pos_uraian}||':'||tp.nm_tp as nm_tp, u.nama
            FROM S_SPPT k 
            JOIN S_PEMBAYARAN_SPPT p 
            ON k.kd_propinsi = p.kd_propinsi
            AND k.kd_dati2 = p.kd_dati2 
            AND k.kd_kecamatan = p.kd_kecamatan 
            AND k.kd_kelurahan = p.kd_kelurahan 
            AND k.kd_blok = p.kd_blok 
            AND k.no_urut = p.no_urut 
            AND k.kd_jns_op = p.kd_jns_op 
            AND k.thn_pajak_sppt = p.thn_pajak_sppt 
            LEFT JOIN S_TEMPAT_PEMBAYARAN tp ON {$pos_join}
            LEFT JOIN SEC_USERS u ON u.NIP=p.NIP_REKAM_BYR_SPPT
            {$where} 
            ORDER BY k.kd_propinsi||'.'||k.kd_dati2||'-'||k.kd_kecamatan||'.'||k.kd_kelurahan ||'-'|| k.kd_blok ||'.'||k.no_urut||'.'|| k.kd_jns_op,p.thn_pajak_sppt,k.nm_wp_sppt ";

        $rptnm = "RINCIAN HARIAN USER";
		header("Content-type: text/plain"); 
		header("Cache-Control: no-store, no-cache"); 
		header('Content-Disposition: attachment; filename="'.$rptnm.'.csv"'); 

        if($rows = $this->db->query($sql_query_r)->result_array()){
            $title = array('NOP','THN.SPPT','URAIAN','POKOK','DENDA','BAYAR','TANGGAL','TEMPAT PEMBAYARAN','USER');
            $this->csv_encode( $rows, $title ); 
        } else {
            echo "Tidak ada data";
        }
        exit;
	}
    
	function csv_encode($aaData, $aHeaders = NULL) {
		// output headers
		if ($aHeaders) echo implode('|', $aHeaders ) . "\r\n";

		foreach ($aaData as $aRow) {
			echo implode('|', $aRow) . "\r\n";
		}
	}
}
