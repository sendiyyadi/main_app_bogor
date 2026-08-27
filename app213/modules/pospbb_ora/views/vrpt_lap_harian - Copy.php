<html>
<head>
</head>
<body>
<?php
//  Result := false;
  $nomor = 0;
  $nom   = 0;
  $hal   = 1;
  $jml1  = 0;
  $jml2  = 0;
  $jml3  = 0;

?>
<pre>
&nbsp;<br>
<?php
	echo str_repeat('&nbsp;',28)."DAFTAR PENERIMAAN HARIAN TANGGAL $tanggal <br>";
	echo "<br>";
	echo "User Rekam        : $user_nm<br>";
	echo "Kelurahan         : $kel_nm<br>";
	echo "Buku              : $buku_nm<br>";
	echo "Tempat Pembayaran : ".str_replace(" "," ",str_pad($bank_nm,30,' ',STR_PAD_RIGHT)).
	     str_replace(" ","&nbsp;",str_pad("Halaman : ".number_format($hal,0,',','.'),48,' ',STR_PAD_LEFT))."<br>";
	echo "==================================================================================================<br>";
	echo "NO.     JAM       NOP              NAMA WP                THN.    KET. PBB      DENDA        TOTAL  <br>";
	echo "==================================================================================================<br>";
	if ($rows)
	{
		foreach ($rows as $row)
		{
			$nop = $row['KD_KECAMATAN'].'.'.
				$row['KD_KELURAHAN'].'.'.
				$row['KD_BLOK'].'-'.
				$row['NO_URUT'].'.'.
				$row['KD_JNS_OP'];
			$nomor +=  1;
			$nom   +=  1;
			$jml1 += $row['PBB_YG_HARUS_DIBAYAR_SPPT'];
			$jml2 += $row['DENDA_SPPT'];
			$jml3 += $row['JML_SPPT_YG_DIBAYAR'];
			echo str_replace(" ","&nbsp;",str_pad(number_format($nomor,0,',','.'),5," ",STR_PAD_LEFT))." ".str_replace(" ","&nbsp;",str_pad($row['JAM'],8,' ',STR_PAD_RIGHT))."&nbsp;$nop&nbsp;".
					  str_replace(" ","&nbsp;",str_pad($row['NM_WP_SPPT'],24,' ',STR_PAD_RIGHT)) .
					  $row['THN_PAJAK_SPPT'].
					  str_replace(" ","&nbsp;",str_pad(number_format($row['PBB_YG_HARUS_DIBAYAR_SPPT'],0,',','.'),12,' ',STR_PAD_LEFT)) .
					  str_replace(" ","&nbsp;",str_pad(number_format($row['DENDA_SPPT'],0,',','.'),11,' ',STR_PAD_LEFT)) .
					  str_replace(" ","&nbsp;",str_pad(number_format($row['JML_SPPT_YG_DIBAYAR'],0,',','.'),13,' ',STR_PAD_LEFT))."<br>";
			if ($nom % 64 == 0 )
			{
				echo "<br>";
				echo "<br>";
				echo "<br>";
				echo "<br>";
				echo "<br>";
				echo "<br>";
				$hal+=1;
				echo str_repeat('&nbsp;',28)."DAFTAR PENERIMAAN HARIAN TANGGAL $tanggal <br>";
				echo "<br>";
				echo "User Rekam        : $user_nm<br>";
				echo "Kelurahan         : $kel_nm<br>";
				echo "Buku              : $buku_nm<br>";
				echo "Tempat Pembayaran : ".str_pad($banknm,30,"&nbsp;",STR_PAD_LEFT).str_repeat('&nbsp;',30)."Halaman : ".number_format($hal,0,',','.')."<br>";
				echo "==================================================================================================<br>";
				echo "NO.  JAM      NOP              NAMA WP                  THN.    KET. PBB      DENDA        TOTAL  <br>";
				echo "==================================================================================================<br>";
			}
		}
	}else
	{
		echo "TIDAK ADA DATA UNTUK PARAMETER YANG DIPILIH<br>";
	}
    echo  "==================================================================================================<br>";
    echo  str_repeat('&nbsp;',7)."JUMLAH :".str_repeat('&nbsp;',46).
                  str_replace(" ","&nbsp;",str_pad(number_format($jml1,0,',','.'),12,' ',STR_PAD_LEFT)) .
                  str_replace(" ","&nbsp;",str_pad(number_format($jml2,0,',','.'),11,' ',STR_PAD_LEFT)) .
                  str_replace(" ","&nbsp;",str_pad(number_format($jml3,0,',','.'),13,' ',STR_PAD_LEFT))."<br>";
    echo  "==================================================================================================<br>";

?>
</pre>
</body>
<html>  

