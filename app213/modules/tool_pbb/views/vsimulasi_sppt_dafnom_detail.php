<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= APP_TITLE ?></title>

    <link href="<?= base_url('assets/templates/css/custom.css'); ?>" rel="stylesheet" type="text/css" />
    <!-- Bootstrap Css -->
    <link id="bootstrap-style" href="<?= base_url('assets/templates/css/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="<?= base_url('assets/templates/css/icons.min.css'); ?>" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link id="app-style" href="<?= base_url('assets/templates/css/app.min.css'); ?>" rel="stylesheet" type="text/css" />

    <!-- Form Advanced -->
    <link href="<?= base_url('assets/templates/libs/select2/css/select2.min.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('assets/templates/libs/spectrum-colorpicker2/spectrum.min.css'); ?>" rel="stylesheet" type="text/css">
    <link href="<?= base_url('assets/templates/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css'); ?>" rel="stylesheet">
    <link href="<?= base_url('assets/templates/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css'); ?>" rel="stylesheet" />
    <link rel="stylesheet" href="<?= base_url('assets/templates/libs/@chenfengyuan/datepicker/datepicker.min.css'); ?>">
    <!-- datepicker css -->
    <link rel="stylesheet" href="<?= base_url('assets/templates/libs/flatpickr/flatpickr.min.css'); ?>">

    <!-- DataTables -->
    <link href="<?= base_url('assets/templates/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('assets/templates/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css'); ?>" rel="stylesheet" type="text/css" />
    <!-- Responsive datatable examples -->
    <link href="<?= base_url('assets/templates/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css'); ?>" rel="stylesheet" type="text/css" />
    <!-- SweetAlert -->
    <link href="<?= base_url('assets/templates/libs/sweetalert2/sweetalert2.min.css'); ?>" rel="stylesheet" type="text/css" />
    <!-- Toastr -->
    <link type="text/css" href="<?= base_url('assets/templates/libs/toastr/build/toastr.min.css'); ?>" rel="stylesheet">

    <link href="<?= base_url('assets/pad/css/datepicker.css') ?>" rel="stylesheet">

    <style>
        .table-responsive {
            margin-bottom: 0.7rem !important;
        }
    </style>
</head>

<style>

body {
    background-color: #fff;
    color: black;
    line-height: 1.5 !important;
}

.table {
    color: black;
}

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

<script>


    $(document).ready(function() {
       


    });
</script>
    <div class="content" style="margin-right:10%; margin-left:10%; margin-top:20px">
        <div class="container-fluid">

            <h4 style="font-weight:bold; text-align:center;">INFORMASI RINCI SPPT PBB KOTA BOGOR</h4>
            <hr/>

            <!-- <table class="table" id="table1"> -->
                <div class="row" style="margin-top:10px; margin-bottom:10px; border: 1px black solid;">
                    <div class="col-md-8 tx-nduwur">
                        NOP : <p id="nop" class="d-inline"><?php echo $dt['nop']; ?></p>
                    </div>
                    <div class="col-md-4 tx-nduwur">
                        TAHUN PAJAK : <p id="tahun" class="d-inline"><?php echo $dt['thn_pajak']; ?></p>
                    </div>
                </div>

                <div class="row" style="margin-top:10px; margin-bottom:10px;">
                    <div class="col-md-6">
                        <div class="row" style="margin-right:0px; border: 1px black solid;">
                            <div class="col-md-6 tx-kanan" >
                                LETAK OBJEK PAJAK :
                            </div>
                            <div class="col-md-6 tx-kiri">
                                <p id="alamat_op" style="margin-bottom:0px;"><?php echo $dt['alamat_op']; ?></p>
                            </div>
                            <div class="col-md-6 tx-kanan">
                                RT / RW :
                            </div>
                            <div class="col-md-6 tx-kiri">
                                <p id="rtrw_op" style="margin-bottom:0px;"><?php echo $dt['rtrw_op']; ?></p>
                            </div>
                            <div class="col-md-6 tx-kanan">
                                KELURAHAN :
                            </div>
                            <div class="col-md-6 tx-kiri">
                                <p id="kel_op" style="margin-bottom:0px;"><?php echo $dt['kel_op']; ?></p>
                            </div>
                            <div class="col-md-6 tx-kanan">
                                KECAMATAN :
                            </div>
                            <div class="col-md-6 tx-kiri">
                                <p id="kec_op" style="margin-bottom:0px;"><?php echo $dt['kec_op']; ?></p>
                            </div>
                            <div class="col-md-6 tx-kanan">
                                KOTA :
                            </div>
                            <div class="col-md-6 tx-kiri">
                                <p id="kota_op" style="margin-bottom:0px;"><?php echo $dt['kota_op']; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                    <div class="row" style="margin-left:0px; border: 1px black solid;">
                            <div class="col-md-6 tx-kanan" >
                                NAMA WP :
                            </div>
                            <div class="col-md-6 tx-kiri">
                                <p id="nama_wp" style="margin-bottom:0px;"><?php echo $dt['nama_wp']; ?></p>
                            </div>
                            <div class="col-md-6 tx-kanan">
                                ALAMAT WP :
                            </div>
                            <div class="col-md-6 tx-kiri">
                                <p id="alamat_wp" style="margin-bottom:0px;"><?php echo $dt['alamat_wp']; ?></p>
                            </div>
                            <div class="col-md-6 tx-kanan">
                                RT / RW WP :
                            </div>
                            <div class="col-md-6 tx-kiri">
                                <p id="rtrw_wp" style="margin-bottom:0px;"><?php echo $dt['rtrw_wp']; ?></p>
                            </div>
                            <div class="col-md-6 tx-kanan">
                                KELURAHAN WP :
                            </div>
                            <div class="col-md-6 tx-kiri">
                                <p id="kel_wp" style="margin-bottom:0px;"><?php echo $dt['kel_wp']; ?></p>
                            </div>
                            <div class="col-md-6 tx-kanan">
                                KOTA WP :
                            </div>
                            <div class="col-md-6 tx-kiri">
                                <p id="kota_wp" style="margin-bottom:0px;"><?php echo $dt['kota_wp']; ?></p>
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
                        <td class="text-right"><p id="luas_bumi" style="margin-bottom:0px;"><?php echo $dt['luas_bumi']; ?></p></td>
                        <td class="text-center"><p id="kelas_bumi" style="margin-bottom:0px;"><?php echo $dt['kelas_bumi']; ?></p></td>
                        <td class="text-right"><p id="njop_bumi_perm" style="margin-bottom:0px;"><?php echo $dt['njop_bumi_perm']; ?></p></td>
                        <td class="text-right"><p id="njop_bumi" style="margin-bottom:0px;"><?php echo $dt['njop_bumi']; ?></p></td>
                    </tr>
                    <tr>
                        <td class="text-center">BANGUNAN</td>
                        <td class="text-right"><p id="luas_bng" style="margin-bottom:0px;"><?php echo $dt['luas_bng']; ?></p></td>
                        <td class="text-center"><p id="kelas_bng" style="margin-bottom:0px;"><?php echo $dt['kelas_bng']; ?></p></td>
                        <td class="text-right"><p id="njop_bng_perm" style="margin-bottom:0px;"><?php echo $dt['njop_bng_perm']; ?></p></td>
                        <td class="text-right"><p id="njop_bng" style="margin-bottom:0px;"><?php echo $dt['njop_bng']; ?></p></td>
                    </tr>
                    <tr>
                        <td class="text-center">BUMI BERSAMA</td>
                        <td class="text-right"><p id="luas_bumi_bersama" style="margin-bottom:0px;"><?php echo $dt['luas_bumi_bersama']; ?></p></td>
                        <td class="text-center"><p id="kelas_bumi_bersama" style="margin-bottom:0px;"><?php echo $dt['kelas_bumi_bersama']; ?></p></td>
                        <td class="text-right"><p id="njop_bumi_perm_bersama" style="margin-bottom:0px;"><?php echo $dt['njop_bumi_perm_bersama']; ?></p></td>
                        <td class="text-right"><p id="njop_bumi_bersama" style="margin-bottom:0px;"><?php echo $dt['njop_bumi_bersama']; ?></p></td>
                    </tr>
                    <tr>
                        <td class="text-center">BANGUNAN BERSAMA</td>
                        <td class="text-right"><p id="luas_bng_bersama" style="margin-bottom:0px;"><?php echo $dt['luas_bng_bersama']; ?></p></td>
                        <td class="text-center"><p id="kelas_bng_bersama" style="margin-bottom:0px;"><?php echo $dt['kelas_bng_bersama']; ?></p></td>
                        <td class="text-right"><p id="njop_bng_perm_bersama" style="margin-bottom:0px;"><?php echo $dt['njop_bng_perm_bersama']; ?></p></td>
                        <td class="text-right"><p id="njop_bng_bersama" style="margin-bottom:0px;"><?php echo $dt['njop_bng_bersama']; ?></p></td>
                    </tr>
                </table>

                <table class="table table-bordered">
                    <tr>
                        <td style="width:40%">JUMLAH NJOP BUMI</td>
                        <td style="width:30px" class="text-center">=</td>
                        <td class="text-right" colspan="2"><p id="jml_njop_bumi" style="margin-bottom:0px;"><?php echo $dt['jml_njop_bumi']; ?></p></td>
                    </tr>
                    <tr>
                        <td>JUMLAH NJOP BANGUNAN</td>
                        <td class="text-center">=</td>
                        <td class="text-right" colspan="2"><p id="jml_njop_bng" style="margin-bottom:0px;"><?php echo $dt['jml_njop_bng']; ?></p></td>
                    </tr>
                    <tr>
                        <td>(A) TOTAL NJOP PBB-P2</td>
                        <td class="text-center">=</td>
                        <td class="text-right" colspan="2"><p id="ttl_njop" style="margin-bottom:0px;"><?php echo $dt['ttl_njop']; ?></p></td>
                    </tr>
                    <tr>
                        <td>(B) NJOP TIDAK KENA PAJAK</td>
                        <td class="text-center">=</td>
                        <td class="text-right" colspan="2"><p id="njoptkp" style="margin-bottom:0px;"><?php echo $dt['njoptkp']; ?></p></td>
                    </tr>
                    <tr>
                        <td>(C) DASAR PENGENAAN PBB-P2 (%NJOP x (A-B))</td>
                        <td class="text-center">=</td>
                        <td class="text-right"><p id="txt_c" style="margin-bottom:0px;"><?php echo $dt['txt_c']; ?></p></td>
                        <td class="text-right"><p id="njopkp" style="margin-bottom:0px;"><?php echo $dt['njopkp']; ?></p></td>
                    </tr>
                    <tr>
                        <td>(D) TARIF</td>
                        <td class="text-center">=</td>
                        <td class="text-right" colspan="2"><p id="tarif" style="margin-bottom:0px;"><?php echo $dt['tarif']; ?></p></td>
                    </tr>
                    <tr>
                        <td>(E) PBB-P2 YANG TERHUTANG (C x D)</td>
                        <td class="text-center">=</td>
                        <td class="text-right"><p id="txt_e" style="margin-bottom:0px;"><?php echo $dt['txt_e']; ?></p></td>
                        <td class="text-right"><p id="pbb_terhutang" style="margin-bottom:0px;"><?php echo $dt['pbb_terhutang']; ?></p></td>
                    </tr>
                    <tr>
                        <td>(F) FAKTOR PENGURANG</td>
                        <td class="text-center">=</td>
                        <td class="text-right" colspan="2"><p id="faktor_pengurang" style="margin-bottom:0px;"><?php echo $dt['faktor_pengurang']; ?></p></td>
                    </tr>
                    <tr>
                        <td>(G) PBB YANG HARUS DIBAYAR (E - F)</td>
                        <td class="text-center">=</td>
                        <td class="text-right"><p id="txt_g" style="margin-bottom:0px;"><?php echo $dt['txt_g']; ?></p></td>
                        <td class="text-right"><p id="pbb_yg_harus_dibayar" style="margin-bottom:0px;"><?php echo $dt['pbb_yg_harus_dibayar']; ?></p></td>
                    </tr>
                    <tr>
                        <td>(H) DENDA YANG TELAH DIBAYAR</td>
                        <td class="text-center">=</td>
                        <td class="text-right" colspan="2"><p id="denda_yg_sudah_dibayar" style="margin-bottom:0px;"><?php echo $dt['denda_yg_sudah_dibayar']; ?></p></td>
                    </tr>
                    <tr>
                        <td>(I) PBB YANG TELAH DIBAYAR</td>
                        <td class="text-center">=</td>
                        <td class="text-right" colspan="2"><p id="pbb_yg_sudah_dibayar" style="margin-bottom:0px;"><?php echo $dt['pbb_yg_sudah_dibayar']; ?></p></td>
                    </tr>
                    <tr>
                        <td>(J) SELISIH (G - I)</td>
                        <td class="text-center">=</td>
                        <td class="text-right" colspan="2"><p id="selisih" style="margin-bottom:0px;"><?php echo $dt['selisih']; ?></p></td>
                    </tr>
                </table>

                <div class="row" style="margin-top:10px; margin-bottom:10px;">
                    <div class="col-md-6">
                        <table class="table table-bordered" >
                        <!-- style="width:50% !important" -->
                            <tr>
                                <td class="text-right" style="border-right: 0px !important;">TANGGAL JATUH TEMPO</td>
                                <td class="text-left" style="border-left: 0px !important;"><p id="tgl_jttempo" style="margin-bottom:0px;"> : <?php echo $dt['tgl_jttempo']; ?></p></td>
                            </tr>
                            <tr>
                                <td class="text-right" style="border-right: 0px !important;">TANGGAL TERBIT</td>
                                <td class="text-left" style="border-left: 0px !important;"><p id="tgl_terbit" style="margin-bottom:0px;"> : <?php echo $dt['tgl_terbit']; ?></p></td>
                            </tr>
                            <tr>
                                <td class="text-right" style="border-right: 0px !important;">TANGGAL CETAK</td>
                                <td class="text-left" style="border-left: 0px !important;"><p id="tgl_cetak" style="margin-bottom:0px;"> : <?php echo $dt['tgl_cetak']; ?></p></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">

                    </div>

                </div>
                

            <!-- </table> -->


           

        </div>
    </div>
