<?= $this->load->view('layouts/headers'); ?>
<?= $this->load->view(active_module() . '/layouts/sidebar'); ?>

<style>
.nav-tabs > .active > a, .nav-pills > .active > a:hover {
    color: blue;
}

#table1 {
   /** font-family: Arial, Arial, Helvetica, sans-serif;  **/
    border-collapse: collapse;
    font-size: 12px;
    width: 100%;
}

#table1 td, #table1 th {
    border: 1px solid #ddd;
    padding: 4px;
}

#table1 tr:nth-child(even){background-color: #f2f2f2;}
#table1 tr:hover {background-color: #ffa;}  /** #ddd=abu2  #ffa=kuning   *****/
#table1 th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: center;
    background-color: #4CAF50;  /* warna hijau */
    color: white;
}

@media (min-width: 768px) {
    .tx-kanan {
        text-align:right;
    }
}

.tx-kiri {
    padding-left:0px;
}

.tx-nduwur {
    font-weight: bold;
    font-size: medium;
    padding-top: 5px;
    padding-bottom: 5px;
    text-align: center !important;
}

.table-bordered {
    margin-right: -0.75rem !important;
    margin-left: -0.75rem !important;
    width: -webkit-fill-available !important;
}

.table-bordered th, .table-bordered td {
    border: 1px solid #000 !important;
}

.table th, .table td {
    padding: 0.25rem !important;
}
</style>
<?php //include_once('_side_menu.php'); 
?> <!-- MENU SIDEBAR -->

<?php //include_once('_navbar.php'); 
?> <!-- NAVBAR MENU -->

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Cek SPPT Detail: <?= $nop ?> - <?= $tahun ?></h4>
                        <div class="page-title-right" id="test">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Tool PBB</a>
                                </li>
                                <li class="breadcrumb-item active">Cek SPPT Detail</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-4">
                                    <a href="<?= base_url('/tool_pbb/cek_sppt') ?>" id="btn_batal" class="btn btn-danger">Kembali</a>                    
                                </div>
                            </div>

                            <!-- <hr/> -->
                            <h4 style="font-weight:bold; text-align:center;">INFORMASI RINCI SPPT</h4>
                            <hr/>

                            <div class="row" style="margin-top:10px; margin-bottom:10px; border: 1px black solid;">
                                    <div class="col-md-8 tx-nduwur">
                                        NOP : <p id="nop" class="d-inline"></p>
                                    </div>
                                    <div class="col-md-4 tx-nduwur">
                                        TAHUN PAJAK : <p id="tahun" class="d-inline"></p>
                                    </div>
                                </div>

                                <div class="row" style="margin-top:10px; margin-bottom:10px;">
                                    <div class="col-md-6">
                                        <div class="row" style="margin-right:0px; border: 1px black solid;">
                                            <div class="col-md-6 tx-kanan" >
                                                LETAK OBJEK PAJAK :
                                            </div>
                                            <div class="col-md-6 tx-kiri">
                                                <p id="alamat_op" style="margin-bottom:0px;"> </p>
                                            </div>
                                            <div class="col-md-6 tx-kanan">
                                                RT / RW :
                                            </div>
                                            <div class="col-md-6 tx-kiri">
                                                <p id="rtrw_op" style="margin-bottom:0px;"> </p>
                                            </div>
                                            <div class="col-md-6 tx-kanan">
                                                KELURAHAN :
                                            </div>
                                            <div class="col-md-6 tx-kiri">
                                                <p id="kelurahan_op" style="margin-bottom:0px;"> </p>
                                            </div>
                                            <div class="col-md-6 tx-kanan">
                                                KECAMATAN :
                                            </div>
                                            <div class="col-md-6 tx-kiri">
                                                <p id="kecamatan_op" style="margin-bottom:0px;"> </p>
                                            </div>
                                            <div class="col-md-6 tx-kanan">
                                                KABUPATEN :
                                            </div>
                                            <div class="col-md-6 tx-kiri">
                                                <p id="kota_op" style="margin-bottom:0px;"> </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                    <div class="row" style="margin-left:0px; border: 1px black solid;">
                                            <div class="col-md-6 tx-kanan" >
                                                NAMA WP :
                                            </div>
                                            <div class="col-md-6 tx-kiri">
                                                <p id="nama_wp" style="margin-bottom:0px;"> </p>
                                            </div>
                                            <div class="col-md-6 tx-kanan">
                                                ALAMAT WP :
                                            </div>
                                            <div class="col-md-6 tx-kiri">
                                                <p id="alamat_wp" style="margin-bottom:0px;"> </p>
                                            </div>
                                            <div class="col-md-6 tx-kanan">
                                                RT / RW WP :
                                            </div>
                                            <div class="col-md-6 tx-kiri">
                                                <p id="rtrw_wp" style="margin-bottom:0px;"> </p>
                                            </div>
                                            <div class="col-md-6 tx-kanan">
                                                KELURAHAN WP :
                                            </div>
                                            <div class="col-md-6 tx-kiri">
                                                <p id="kelurahan_wp" style="margin-bottom:0px;"> </p>
                                            </div>
                                            <div class="col-md-6 tx-kanan">
                                                KABUPATEN WP :
                                            </div>
                                            <div class="col-md-6 tx-kiri">
                                                <p id="kota_wp" style="margin-bottom:0px;"> </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <table class="table table-bordered">
                                    <tr>
                                        <td class="text-center"></td>
                                        <td class="text-center">LUAS (M2)</td>
                                        <td class="text-center">KELAS</td>
                                        <td class="text-center">NJOP PER M2</td>
                                        <td class="text-center">TOTAL NJOP</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">BUMI</td>
                                        <td class="text-right"><p id="luas_bumi" style="margin-bottom:0px;"> </p></td>
                                        <td class="text-center"><p id="kelas_bumi" style="margin-bottom:0px;"> </p></td>
                                        <td class="text-right"><p id="njop_bumi_perm" style="margin-bottom:0px;"> </p></td>
                                        <td class="text-right"><p id="njop_bumi" style="margin-bottom:0px;"> </p></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">BANGUNAN</td>
                                        <td class="text-right"><p id="luas_bng" style="margin-bottom:0px;"> </p></td>
                                        <td class="text-center"><p id="kelas_bng" style="margin-bottom:0px;"> </p></td>
                                        <td class="text-right"><p id="njop_bng_perm" style="margin-bottom:0px;"> </p></td>
                                        <td class="text-right"><p id="njop_bng" style="margin-bottom:0px;"> </p></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">BUMI BERSAMA</td>
                                        <td class="text-right"><p id="luas_bumi_bersama" style="margin-bottom:0px;"> </p></td>
                                        <td class="text-center"><p id="kelas_bumi_bersama" style="margin-bottom:0px;"> </p></td>
                                        <td class="text-right"><p id="njop_bumi_perm_bersama" style="margin-bottom:0px;"> </p></td>
                                        <td class="text-right"><p id="njop_bumi_bersama" style="margin-bottom:0px;"> </p></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">BANGUNAN BERSAMA</td>
                                        <td class="text-right"><p id="luas_bng_bersama" style="margin-bottom:0px;"> </p></td>
                                        <td class="text-center"><p id="kelas_bng_bersama" style="margin-bottom:0px;"> </p></td>
                                        <td class="text-right"><p id="njop_bng_perm_bersama" style="margin-bottom:0px;"> </p></td>
                                        <td class="text-right"><p id="njop_bng_bersama" style="margin-bottom:0px;"> </p></td>
                                    </tr>
                                </table>

                                <table class="table table-bordered">
                                    <tr>
                                        <td style="width:40%">JUMLAH NJOP BUMI</td>
                                        <td style="width:30px" class="text-center">=</td>
                                        <td class="text-right" colspan="2"><p id="jml_njop_bumi" style="margin-bottom:0px;"> </p></td>
                                    </tr>
                                    <tr>
                                        <td>JUMLAH NJOP BANGUNAN</td>
                                        <td class="text-center">=</td>
                                        <td class="text-right" colspan="2"><p id="jml_njop_bng" style="margin-bottom:0px;"> </p></td>
                                    </tr>
                                    <tr>
                                        <td>(A) TOTAL NJOP PBB-P2</td>
                                        <td class="text-center">=</td>
                                        <td class="text-right" colspan="2"><p id="ttl_njop" style="margin-bottom:0px;"> </p></td>
                                    </tr>
                                    <tr>
                                        <td>(B) NJOP TIDAK KENA PAJAK</td>
                                        <td class="text-center">=</td>
                                        <td class="text-right" colspan="2"><p id="njoptkp" style="margin-bottom:0px;"> </p></td>
                                    </tr>
                                    <tr>
                                        <td>(C) DASAR PENGENAAN PBB-P2 (%NJOP x (A-B))</td>
                                        <td class="text-center">=</td>
                                        <td class="text-right"><p id="txt_c" style="margin-bottom:0px;"> </p></td>
                                        <td class="text-right"><p id="njopkp" style="margin-bottom:0px;"> </p></td>
                                    </tr>
                                    <tr>
                                        <td>(D) TARIF</td>
                                        <td class="text-center">=</td>
                                        <td class="text-right" colspan="2"><p id="tarif" style="margin-bottom:0px;"> </p></td>
                                    </tr>
                                    <tr>
                                        <td>(E) PBB-P2 YANG TERHUTANG (C x D)</td>
                                        <td class="text-center">=</td>
                                        <td class="text-right"><p id="txt_e" style="margin-bottom:0px;"> </p></td>
                                        <td class="text-right"><p id="pbb_terhutang" style="margin-bottom:0px;"> </p></td>
                                    </tr>
                                    <tr>
                                        <td>(F) FAKTOR PENGURANG</td>
                                        <td class="text-center">=</td>
                                        <td class="text-right" colspan="2"><p id="faktor_pengurang" style="margin-bottom:0px;"> </p></td>
                                    </tr>
                                    <tr>
                                        <td>(G) PBB YANG HARUS DIBAYAR (E - F)</td>
                                        <td class="text-center">=</td>
                                        <td class="text-right"><p id="txt_g" style="margin-bottom:0px;"> </p></td>
                                        <td class="text-right"><p id="pbb_yg_harus_dibayar" style="margin-bottom:0px;"> </p></td>
                                    </tr>
                                    <tr>
                                        <td>(H) DENDA YANG TELAH DIBAYAR</td>
                                        <td class="text-center">=</td>
                                        <td class="text-right" colspan="2"><p id="denda_yg_sudah_dibayar" style="margin-bottom:0px;"> </p></td>
                                    </tr>
                                    <tr>
                                        <td>(I) PBB YANG TELAH DIBAYAR</td>
                                        <td class="text-center">=</td>
                                        <td class="text-right" colspan="2"><p id="pbb_yg_sudah_dibayar" style="margin-bottom:0px;"> </p></td>
                                    </tr>
                                    <tr>
                                        <td>(J) SELISIH (G - I)</td>
                                        <td class="text-center">=</td>
                                        <td class="text-right" colspan="2"><p id="selisih" style="margin-bottom:0px;"> </p></td>
                                    </tr>
                                </table>

                                <div class="row" style="margin-top:10px; margin-bottom:10px;">
                                    <div class="col-md-6">
                                        <table class="table table-bordered" >
                                        <!-- style="width:50% !important" -->
                                            <tr>
                                                <td class="text-right" style="border-right: 0px !important;">TANGGAL JATUH TEMPO</td>
                                                <td class="text-left" style="border-left: 0px !important;"><p id="tgl_jttempo" style="margin-bottom:0px;"> : </p></td>
                                            </tr>
                                            <tr>
                                                <td class="text-right" style="border-right: 0px !important;">TANGGAL TERBIT</td>
                                                <td class="text-left" style="border-left: 0px !important;"><p id="tgl_terbit" style="margin-bottom:0px;"> : </p></td>
                                            </tr>
                                            <tr>
                                                <td class="text-right" style="border-right: 0px !important;">TANGGAL CETAK</td>
                                                <td class="text-left" style="border-left: 0px !important;"><p id="tgl_cetak" style="margin-bottom:0px;"> : </p></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">

                                    </div>

                                </div>
                              <?php echo msg_block();?>
                            <br>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TUTUP CONTAINER-FLUID -->
        </div>
    </div>

<?= $this->load->view('layouts/foot.php'); ?>
</div>
<?= $this->load->view('layouts/scripts.php'); ?>

<?= $this->load->view('layouts/footer.php'); ?>

<!-- tambahan datatables -->
<script>
    function fmt_number(x) {
        if (x !== undefined && x !== null) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        } else {
            return "Invalid number";
        }
    }

    $(document).ready(function() {
        
            var nop = "<?php echo $nop; ?>";
            var tahun = "<?php echo $tahun; ?>"; 
            var nopleng = "<?php echo $nopleng; ?>";

                $.ajax({
                    url: "<?php echo active_module_url() . $controller; ?>/get/" + nop + "/" + tahun,
                    success: function(response) {
                        var data = $.parseJSON(response);
                        var aa = data['data'];

                        $('#alamat_op').html(aa['ALAMAT_OP']);
                        $('#rtrw_op').html(aa['RTRW_OP']);
                        $('#kelurahan_op').html(aa['NM_KELURAHAN']);
                        $('#kecamatan_op').html(aa['NM_KECAMATAN']);
                        $('#kota_op').html('BOGOR');
                        
                        $('#nama_wp').html(aa['NM_WP_SPPT']); //change
                        $('#alamat_wp').html(aa['ALAMAT_WP']); //change
                        $('#rtrw_wp').html(aa['RTRW_WP']); //change
                        $('#kelurahan_wp').html(aa['KELURAHAN_WP_SPPT']); //change
                        $('#kota_wp').html(aa['KOTA_WP_SPPT']); //change
                        $('#nop').html(nopleng);
                        $('#tahun').html(tahun);

                        $('#tgl_cetak').html(aa['TGL_CETAK']);
                        $('#tgl_terbit').html(aa['TGL_TERBIT']);
                        $('#tgl_jttempo').html(aa['TGL_JTTEMPO']);

                        $('#luas_bumi').html(fmt_number(aa['LUAS_BUMI_SPPT']));
                        $('#kelas_bumi').html(aa['KD_KLS_TANAH']);
                        $('#njop_bumi_perm').html(fmt_number(aa['NJOP_BUMI_PERM']));
                        $('#njop_bumi').html(fmt_number(aa['NJOP_BUMI_SPPT']));
                        $('#luas_bng').html(fmt_number(aa['LUAS_BNG_SPPT']));
                        $('#kelas_bng').html(aa['KD_KLS_BNG']);
                        $('#njop_bng_perm').html(fmt_number(aa['NJOP_BNG_PERM']));
                        $('#njop_bng').html(fmt_number(aa['NJOP_BNG_SPPT']));

                        $('#luas_bumi_bersama').html(fmt_number(aa['LUAS_BUMI_BERSAMA']));
                        $('#kelas_bumi_bersama').html(aa['KD_KLS_TANAH_BERSAMA']); //gada
                        $('#njop_bumi_perm_bersama').html(fmt_number(aa['NJOP_BUMI_BERSAMA_PERM']));
                        $('#njop_bumi_bersama').html(fmt_number(aa['NJOP_BUMI_BERSAMA']));
                        $('#luas_bng_bersama').html(fmt_number(aa['LUAS_BNG_BERSAMA']));
                        $('#kelas_bng_bersama').html(aa['KD_KLS_BNG_BERSAMA']); //gada
                        $('#njop_bng_perm_bersama').html(fmt_number(aa['NJOP_BNG_BERSAMA_PERM']));
                        $('#njop_bng_bersama').html(fmt_number(aa['NJOP_BNG_BERSAMA']));

                        var ttl_njop_bumi   = parseInt(aa['NJOP_BUMI_SPPT']) + parseInt(aa['NJOP_BUMI_BERSAMA']);
                        var ttl_njop_bng    = parseInt(aa['NJOP_BNG_SPPT']) + parseInt(aa['NJOP_BNG_BERSAMA']);
                        var ttl_njop        = parseInt(ttl_njop_bumi) + parseInt(ttl_njop_bng) ;

                        var njoptkp         = aa['NJOPTKP_SPPT'];
                        var njopkp          = parseInt(ttl_njop) - parseInt(njoptkp);

                        var njkp_pcnt       = aa['NIL_NJKP'];
                        var tarif_pcnt      = aa['NIL_TARIF'];

                        var njopkp_njkp     = njkp_pcnt/100*njopkp;

                        // var njopkp_tarif    = tarif_pcnt/100*njopkp_njkp;
                        
                        var pbb_terhutang           = aa['PBB_TERHUTANG_SPPT'];
                        var faktor_pengurang        = aa['FAKTOR_PENGURANG_SPPT'];
                        var pbb_yg_harus_dibayar    = aa['PBB_YG_HARUS_DIBAYAR_SPPT'];
                        var denda_yg_sudah_dibayar  = aa['BAYAR_DENDA'];
                        var pbb_yg_sudah_dibayar    = aa['JML_BAYAR'];

                        var selisih                 = parseInt(pbb_yg_harus_dibayar) - parseInt(pbb_yg_sudah_dibayar) ;
                        if ( parseInt(selisih) < 0 ){
                            selisih = 0 ; 
                        }

                        var txt_c           = '(' + njkp_pcnt + ' % x ' + fmt_number(njopkp) + ')' ;
                        var txt_e           = '(' + tarif_pcnt + ' % x ' + fmt_number(njopkp_njkp) + ')' ;
                        var txt_g           = '(' + fmt_number(pbb_terhutang) + ' - ' + fmt_number(faktor_pengurang) + ')' ;
                        
                        $('#jml_njop_bumi').html(fmt_number(ttl_njop_bumi));
                        $('#jml_njop_bng').html(fmt_number(ttl_njop_bng));
                        $('#ttl_njop').html(fmt_number(ttl_njop));
                        $('#njoptkp').html(fmt_number(njoptkp));
                        $('#txt_c').html(txt_c);
                        $('#njopkp').html(fmt_number(njopkp_njkp));
                        $('#tarif').html(tarif_pcnt + ' %');
                        $('#txt_e').html(txt_e);
                        $('#pbb_terhutang').html(fmt_number(pbb_terhutang));
                        $('#faktor_pengurang').html(fmt_number(faktor_pengurang));
                        $('#txt_g').html(txt_g);
                        $('#pbb_yg_harus_dibayar').html(fmt_number(pbb_yg_harus_dibayar));
                        $('#denda_yg_sudah_dibayar').html(fmt_number(denda_yg_sudah_dibayar));
                        $('#pbb_yg_sudah_dibayar').html(fmt_number(pbb_yg_sudah_dibayar));
                        $('#selisih').html(fmt_number(selisih));
                    },
                    error: function(xhr, desc, er) {
                        alert(er);
                    }
                });
    });
</script>