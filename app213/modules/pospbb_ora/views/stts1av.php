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
?>
<?php echo str_repeat(' ',20)." "?>

<?php echo str_repeat(' ',13).$NM_TP?>

<?php echo str_repeat(' ',20).$THN_PAJAK_SPPT . '           ' . substr($PEMBAYARAN_SPPT_KE,0,5)?>

<?php echo str_repeat(' ',13).substr($NM_WP_SPPT,0,30)?>

<?php echo str_repeat(' ',13).substr($JALAN_OP,0,20) . ', ' . substr($BLOK_KAV_NO_OP,0,10)?>

<?php echo str_repeat(' ',19).substr(str_pad($NM_KELURAHAN,16),0,16).'       '.number_format($LUAS_BUMI_SPPT,0,',','.')?>

<?php echo str_repeat(' ',19).substr(str_pad($NM_KECAMATAN,16),0,16).'       '.number_format($LUAS_BNG_SPPT,0,',','.')?>

<?php echo str_repeat(' ',13)."$KD_PROPINSI.$KD_DATI2.$KD_KECAMATAN.$KD_KELURAHAN.$KD_BLOK-$NO_URUT.$KD_JNS_OP"?>

<?php echo str_repeat(' ',13).number_format($JML_SPPT_YG_DIBAYAR-$DENDA_SPPT,0,',','.')?>

<?php echo str_repeat(' ',1)?>
<?php echo str_repeat(' ',16).date('d/m/Y',strtotime($TGL_JATUH_TEMPO_SPPT))?>

<?php echo str_repeat(' ',1)?>

<?php echo str_repeat(' ',6) . 'TGL PEMBAYARAN    :   ' .str_pad(date('d/m/Y',strtotime($TGL_PEMBAYARAN_SPPT)),16," ",STR_PAD_LEFT)?>

<?php echo str_repeat(' ',6) . 'PEMBAYARAN        :Rp.' .str_pad(number_format($JML_SPPT_YG_DIBAYAR-$DENDA_SPPT+$FAKTOR_PENGURANG_SPPT,0,',','.'), 16, " ", STR_PAD_LEFT)?>

<?php echo str_repeat(' ',6) . 'PENGURANGAN       :Rp.' .str_pad(number_format($FAKTOR_PENGURANG_SPPT,0,',','.'), 16, " ", STR_PAD_LEFT)?>

<?php echo str_repeat(' ',6) . 'DENDA ADMINISTRSI :Rp.' .str_pad(number_format($DENDA_SPPT,0,',','.'), 16, " ", STR_PAD_LEFT)?>

<?php echo str_repeat(' ',6) . 'TOTAL PEMBAYARAN  :Rp.' .str_pad(number_format($JML_SPPT_YG_DIBAYAR,0,',','.'), 16, " ", STR_PAD_LEFT)?>

<?php
  $sn=date('dmY',strtotime($TGL_PEMBAYARAN_SPPT));
  $sn.=$KD_PROPINSI.$KD_DATI2.$KD_KECAMATAN.$KD_KELURAHAN.$KD_BLOK.$NO_URUT.$KD_JNS_OP.$THN_PAJAK_SPPT;
?>

<?php echo str_repeat(' ',6) . 'SN : '. md5($sn)?>

1

<?php echo str_repeat(' ',1)?>

<?php echo str_repeat(' ',20)." "?>

<?php echo str_repeat(' ',1).""?>

<?php echo str_repeat(' ',13).$NM_TP?>

<?php echo str_repeat(' ',20).$THN_PAJAK_SPPT . '           ' . substr($PEMBAYARAN_SPPT_KE,0,5)?>

<?php echo str_repeat(' ',13).substr($NM_WP_SPPT,0,30)?>

<?php echo str_repeat(' ',13).substr($JALAN_OP,0,30) . ', ' . substr($BLOK_KAV_NO_OP,0,5)?>

<?php echo str_repeat(' ',19).substr(str_pad($NM_KELURAHAN,16),0,16).'       '.number_format($LUAS_BUMI_SPPT,0,',','.')?>

<?php echo str_repeat(' ',19).substr(str_pad($NM_KECAMATAN,16),0,16).'       '.number_format($LUAS_BNG_SPPT,0,',','.')?>

<?php echo str_repeat(' ',13)."$KD_PROPINSI.$KD_DATI2.$KD_KECAMATAN.$KD_KELURAHAN.$KD_BLOK-$NO_URUT.$KD_JNS_OP"?>

<?php echo str_repeat(' ',13).date('d/m/Y',strtotime($TGL_PEMBAYARAN_SPPT))?>


<?php echo str_repeat(' ',16).number_format($JML_SPPT_YG_DIBAYAR,0,',','.')?>

<?php echo str_repeat(' ',1)?>

<?php echo str_repeat(' ',1)?>

<?php echo str_repeat(' ',1)?>
