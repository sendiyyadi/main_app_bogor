<?php
  $name = 'stts'.date('Ymdhis'); //The name of the csv file.
  // Build the headers to push out the file properly.
  //header('Pragma: public');     // required
  header('Expires: 0');         // no cache
  //header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
  //header('Last-Modified: '.gmdate ('D, d M Y H:i:s', filemtime ($path)).' GMT');
  //header('Cache-Control: private',false);
  header('Content-Type: text/csv');  // Add the mime type from Code igniter.
  header('Content-Disposition: attachment; filename="'.$name.'.prn"');  // Add the file name
  //header('Content-Transfer-Encoding: binary');
  //header('Content-Length: '.filesize($output)); // provide file size
  //header('Connection: close');
foreach ($dtCetak as $data) : 
    $nm_tp = $data[8];
    $thn_pajak_sppt = $data[9];
    $nm_wp_sppt = $data[10];
    $nm_kecamatan = $data[11];
    $nm_kelurahan = $data[12];
    $kode = $data[13];
    $jml_sppt_yg_dibayar = $data[14];
    $denda_sppt = $data[15];
    $tgl_jatuh_tempo_sppt = $data[16];
    $tgl_pembayaran_sppt = $data[17];
    $jml_sppt_yg_dibayar = $data[18];
    $luas_bumi_sppt = $data[19];
    $luas_bng_sppt = $data[20];
    
    $jln_wp_sppt = $data[40];
    $blok_kav_no_wp_sppt = $data[41];
    $nm_propinsi = $data[42];
    $nm_dati2 = $data[43];
    
  $sn=date('dmY',strtotime($tgl_pembayaran_sppt));
  $sn.= preg_replace("/[^0-9]/","",$kode).$thn_pajak_sppt;
  $nohuruf1 = terbilang($jml_sppt_yg_dibayar); 
  $nohuruf2 = "";
  while (strlen($nohuruf1)>75){
    $n = strrpos($nohuruf1,' ');
    $nohuruf2 = substr($nohuruf1,$n).$nohuruf2;
    $nohuruf1 = substr($nohuruf1,0,$n);
  }
  $nohuruf1 = '#'.$nohuruf1.'#';
  $nohuruf2 = '#'.trim($nohuruf2).' rupiah #';
?>
  <?php echo str_pad('SURAT TANDA TERIMA SETORAN (STTS)',77," ",STR_PAD_BOTH)?> 
  <?php echo str_pad('BUKTI PEMBAYARAN LUNAS PAJAK PBB-P2',77," ",STR_PAD_BOTH)?> 
  KOTA/KABUPATEN    : <?php echo $nm_dati2?> 
  TEMPAT PEMBAYARAN : <?php echo $nm_tp?> 
  TANGGAL TRANSAKSI : <?php echo str_pad(date('d/m/Y',strtotime($tgl_pembayaran_sppt)),15," ",STR_PAD_RIGHT)?>SN:<?php echo MD5($sn)?> 
  NOP               : <?php echo str_pad("$kode",30," ",STR_PAD_RIGHT)?>THN PAJAK :<?php echo $thn_pajak_sppt?> 
  NAMA WAJIB PAJAK  : <?php echo substr($nm_wp_sppt,0,30)?> 
  ALAMAT WAJIB PAJAK: <?php echo substr($jln_wp_sppt,0,45).' '.substr($blok_kav_no_wp_sppt,10)?> 
  LETAK OBJEK PAJAK                              URAIAN PEMBAYARAN
  KELURAHAN : <?php echo str_pad(substr($nm_kelurahan,0,30),35," ",STR_PAD_RIGHT)?>POKOK : <?php echo str_pad(number_format($jml_sppt_yg_dibayar-$denda_sppt,0,',','.'),15," ",STR_PAD_LEFT)?> 
  KECAMATAN : <?php echo str_pad(substr($nm_kecamatan,0,30),35," ",STR_PAD_RIGHT)?>DENDA : <?php echo str_pad(number_format($denda_sppt,0,',','.'),15," ",STR_PAD_LEFT)?> 
  LUAS TANAH: <?php echo str_pad(number_format($luas_bumi_sppt,0,',','.'),8," ",STR_PAD_LEFT)?> M2                        BAYAR : <?php echo str_pad(number_format($jml_sppt_yg_dibayar,0,',','.'),15," ",STR_PAD_LEFT)?> 
  LUAS BNG  : <?php echo str_pad(number_format($luas_bng_sppt, 0,',','.'),8," ",STR_PAD_LEFT)?> M2  
  TGL JATUH TEMPO : <?php echo str_pad(date('d/m/Y',strtotime($tgl_jatuh_tempo_sppt)),29," ", STR_PAD_RIGHT)?> 
  TERBILANG :                                    PETUGAS BANK
  <?php echo substr($nohuruf1,0,77)?> 
  <?php echo substr($nohuruf2,0,77)?> 
  ------------------------------------------------------------------------------
  SELURUH PEMERINTAH KABUPATEN/KOTA PROPINSI <?php echo $nm_propinsi?> 
  MENYATAKAN RESI INI SEBAGAI BUKTI PEMBAYARAN PAJAK DAERAH YANG SAH.
  PEMBAYARAN PAJAK DAERAH DAPAT DILAKUKAN DI JARINGAN KANTOR BANK TERDEKAT
  ==============================================================================
<?php endforeach; ?>