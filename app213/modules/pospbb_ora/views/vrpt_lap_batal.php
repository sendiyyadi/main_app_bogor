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
	echo str_repeat('&nbsp;',2)."DAFTAR PEMBATALAN TRANSAKSI TANGGAL $tanggal_fr S.D. $tanggal_to<br>";
	echo "<br>";
    
	echo "===================================================================<br>";
	echo "NO.      TANGGAL     NOP                                      NILAI<br>";
	echo "===================================================================<br>";
	if ($rows)
	{
		foreach ($rows as $row)
		{
			$nop = KD_PROPINSI.'.'.KD_DATI2.'.'.
                $row['KD_KECAMATAN'].'.'.
				$row['KD_KELURAHAN'].'.'.
				$row['KD_BLOK'].'-'.
				$row['NO_URUT'].'.'.
				$row['KD_JNS_OP'].'-'.				
				$row['THN_PAJAK_SPPT'];
			$nomor +=  1;
			$nom   +=  1;
			$jml1 += $row['JML_BATAL'];
            
			echo str_replace(" ","&nbsp;",str_pad(number_format($nomor,0,',','.'),7," ",STR_PAD_LEFT)).
                 str_replace(" ","&nbsp;",str_pad(date('d-m-Y', strtotime($row['TGL_BATAL'])),12," ",STR_PAD_LEFT)).
                 "&nbsp;&nbsp;{$nop}&nbsp;&nbsp;".
			     str_replace(" ","&nbsp;",str_pad(number_format($row['JML_BATAL'],0,',','.'),15,' ',STR_PAD_LEFT))."<br>";
			if ($nom % 50 == 0 )
			{
				echo "<br>";
				echo "<br>";
				echo "<br>";
				echo "<br>";
				echo "<br>";
				echo "<br>";
				echo "<br>";
				echo "<br>";
				echo "<br>";
				$hal+=1;
				echo str_repeat('&nbsp;',28)."DAFTAR PENERIMAAN HARIAN TANGGAL $tanggal <br>";
				echo "<br>";
                echo "===================================================================<br>";
                echo "NO.      TANGGAL     NOP                                      NILAI<br>";
                echo "===================================================================<br>";
			}
		}
	}else
	{
		echo "TIDAK ADA DATA UNTUK PARAMETER YANG DIPILIH<br>";
	}
    echo  "===================================================================<br>";
    echo  str_repeat('&nbsp;',9)."JUMLAH :".str_repeat('&nbsp;',38).
                  str_replace(" ","&nbsp;",str_pad(number_format($jml1,0,',','.'),12,' ',STR_PAD_LEFT))."<br>";
    echo  "===================================================================<br>";

?>
</pre>
</body>
<html>  

