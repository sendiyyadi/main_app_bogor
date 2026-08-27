<?php
  $name = 'stts'.date('Ymdhis'); //The name of the csv file.
  // Build the headers to push out the file properly.
  //header('Pragma: public');     // required 
  header('Expires: 0');         // no cache
  //header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
  //header('Last-Modified: '.gmdate ('D, d M Y H:i:s', filemtime ($path)).' GMT');
  //header('Cache-Control: private',false);
  //header('Content-Type: text/csv');  // Add the mime type from Code igniter.
  header('Content-Disposition: attachment; filename="'.$name.'.prn"');  // Add the file name
  //header('Content-Transfer-Encoding: binary');
  //header('Content-Length: '.filesize($output)); // provide file size
  //header('Connection: close');
  $sn=date('dmY',strtotime($TGL_PEMBAYARAN_SPPT));
  $sn.=$KD_PROPINSI.$KD_DATI2.$KD_KECAMATAN.$KD_KELURAHAN.$KD_BLOK.$NO_URUT.$KD_JNS_OP.$THN_PAJAK_SPPT;
  $nohuruf1 = terbilang($JML_SPPT_YG_DIBAYAR); 
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
  KOTA/KABUPATEN    : <?php echo $NM_DATI2?> 
  TEMPAT PEMBAYARAN : <?php echo $NM_TP?> 
  TANGGAL TRANSAKSI : <?php echo str_pad(date('d/m/Y',strtotime($TGL_PEMBAYARAN_SPPT)),15," ",STR_PAD_RIGHT)?>SN:<?php echo MD5($sn)?> 
  NOP               : <?php echo str_pad("$KD_PROPINSI.$KD_DATI2.$KD_KECAMATAN.$KD_KELURAHAN.$KD_BLOK-$NO_URUT.$KD_JNS_OP",30," ",STR_PAD_RIGHT)?>THN PAJAK :<?php echo $THN_PAJAK_SPPT?> 
  NAMA WAJIB PAJAK  : <?php echo substr($NM_WP_SPPT,0,30)?> 
  ALAMAT WAJIB PAJAK: <?php echo substr($JLN_WP_SPPT,0,45).' '.substr($BLOK_KAV_NO_WP_SPPT,10)?> 
  LETAK OBJEK PAJAK                              URAIAN PEMBAYARAN
  KELURAHAN : <?php echo str_pad(substr($NM_KELURAHAN,0,30),35," ",STR_PAD_RIGHT)?>POKOK : <?php echo str_pad(number_format($JML_SPPT_YG_DIBAYAR-$DENDA_SPPT,0,',','.'),15," ",STR_PAD_LEFT)?> 
  KECAMATAN : <?php echo str_pad(substr($NM_KECAMATAN,0,30),35," ",STR_PAD_RIGHT)?>DENDA : <?php echo str_pad(number_format($DENDA_SPPT,0,',','.'),15," ",STR_PAD_LEFT)?> 
  LUAS TANAH: <?php echo str_pad(number_format($LUAS_BUMI_SPPT,0,',','.'),8," ",STR_PAD_LEFT)?> M2                        BAYAR : <?php echo str_pad(number_format($JML_SPPT_YG_DIBAYAR,0,',','.'),15," ",STR_PAD_LEFT)?> 
  LUAS BNG  : <?php echo str_pad(number_format($LUAS_BNG_SPPT, 0,',','.'),8," ",STR_PAD_LEFT)?> M2  
  TGL JATUH TEMPO : <?php echo str_pad(date('d/m/Y',strtotime($TGL_JATUH_TEMPO_SPPT)),29," ", STR_PAD_RIGHT)?> 
  TERBILANG :                                    PETUGAS BANK
  <?php echo substr($nohuruf1,0,77)?> 
  <?php echo substr($nohuruf2,0,77)?> 
  ------------------------------------------------------------------------------
  SELURUH PEMERINTAH KABUPATEN/KOTA PROPINSI <?php echo $NM_PROPINSI?> 
  MENYATAKAN RESI INI SEBAGAI BUKTI PEMBAYARAN PAJAK DAERAH YANG SAH.
  PEMBAYARAN PAJAK DAERAH DAPAT DILAKUKAN DI JARINGAN KANTOR BANK TERDEKAT
  ==============================================================================