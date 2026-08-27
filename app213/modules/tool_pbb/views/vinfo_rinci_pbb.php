<?= $this->load->view('layouts/headers'); ?>
<?= $this->load->view(active_module() . '/layouts/sidebar'); ?>

<style>

.nav-tabs > .active > a, .nav-pills > .active > a:hover {
    color: blue;
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

</style>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">INFORMASI RINCI PBB</h4>
                        <div class="page-title-right" id="test">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Tool PBB</a>
                                </li>
                                <li class="breadcrumb-item active">Informasi Rinci PBB</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <?php echo msg_block();?>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div class="input-group w-auto">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-end-0">NOP</span>
                                    </div>
                                    <div class="controls">
                                        <input type="text" id="c_nop" class="form-control" name="c_nop" placeholder="Cari NOP" style="width:200px">
                                    </div>
                                </div>
                                <div class="input-group w-auto">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-end-0">Tahun</span>
                                    </div>
                                    <div class="controls">
                                        <input type="text" id="c_tahun" class="form-control" name="c_tahun" placeholder="Cari Tahun">
                                    </div>
                                </div>
                                <div class="col-md-1"><button class="btn btn-primary" id="btn_cari">Cari</button></div>
                            </div>
                            
                            <br>
                            <table class="table table-striped" id="table1">
                                <thead>
                                <tr>
                                    <!-- <th>rowid</th> -->
                                    <th>NOP</th>
                                    <th>TAHUN</th>
                                    <th>NAMA WP</th>
                                    <th>ALAMAT OP</th>
                                    <th>NOPTHN</th>
                                    <th>s1</th>
                                    <th>s2</th>
                                    <th>DETAIL</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                
            
<!--             <hr/>
            <h4 style="font-weight:bold; text-align:center;">INFORMASI RINCI SPPT PBB KOTA BOGOR</h4>
            <hr/> -->

<!--                 <div class="row" style="margin-top:10px; margin-bottom:10px; border: 1px black solid;">
                    <div class="col-md-8 tx-nduwur">
                        NOP : <p id="nop" class="d-inline">32.08.xxx.xxx.xxxx.x</p>
                    </div>
                    <div class="col-md-4 tx-nduwur">
                        TAHUN PAJAK : <p id="tahun" class="d-inline">YYYY</p>
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
                                KOTA :
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
                                KOTA WP :
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
                </div> -->
                


           

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



<script>
    var mNOPEL;
    var mSTS;
    var oTable;

    function fmt_number(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    function reload_grid() {
        var nop = $('#c_nop').val();
        var tahun = $('#c_tahun').val();
        var params = {
            nop: nop,
            tahun: tahun,
        };
        var data_params = decodeURIComponent($.param(params));
        oTable.fnReloadAjax("<?php echo active_module_url(); ?>info_rinci_pbb/grid/?" + data_params);
    }
    
    function f_dtl(nopthn) {
        var url = '<?php echo active_module_url("info_rinci_pbb/detail"); ?>'+nopthn;
        // window.location = '<?php //echo active_module_url("simulasi_sppt/"); ?>'+nopthn;
        window.open(url, "_blank") ;
    }

    function f_dtl_2(nopthn) {
        var url = '<?php echo active_module_url("info_rinci_pbb/detail_2"); ?>'+nopthn;
        // window.location = '<?php //echo active_module_url("simulasi_sppt/"); ?>'+nopthn;
        window.open(url, "_blank") ;
    }

    function f_dtl_3(nopthn) {
        var url = '<?php echo active_module_url("info_rinci_pbb/detail_3"); ?>'+nopthn;
        // window.location = '<?php //echo active_module_url("simulasi_sppt/"); ?>'+nopthn;
        window.open(url, "_blank") ;
    }

    $(document).ready(function() {

        oTable = $('#table1').dataTable({
            "iDisplayLength": 13,
            "sPaginationType": "full_numbers",
            //  "bJQueryUI": true,
            "bAutoWidth": false,
            "sDom": '<"toolbar">frtip',
            "aoColumnDefs": [
                { "aTargets": [0], "bSearchable": true, "bVisible": true, "sWidth": "", "sClass": "" },
                { "aTargets": [1], "bSearchable": true,  "bVisible": true,  "sWidth": "", "sClass": "" },
                { "aTargets": [2], "bSearchable": true,  "bVisible": true,  "sWidth": "", "sClass": "" },
                { "aTargets": [3], "bSearchable": true,  "bVisible": true,  "sWidth": "", "sClass": "" },
                { "aTargets": [4], "bSearchable": false,  "bVisible": false,  "sWidth": "", "sClass": "" },
                { "aTargets": [5], "bSearchable": false,  "bVisible": false,  "sWidth": "", "sClass": "" },
                { "aTargets": [6], "bSearchable": false,  "bVisible": false,  "sWidth": "", "sClass": "" },
                {
                    "bSearchable": false,
                    "bVisible": true,
                    "aTargets": [7],
                    "sWidth": "400px",
                    "sClass": "center",
                    "mRender": function(data, type, full) {
                        var tes = '';
                        var nop = full[0].trim();
                        var tahun = full[1].trim();
                        var nopthn = full[4].trim();
                        var sim = full[5].trim();
                        var tmp = full[6].trim();
                        // if (sim == 0) {
                        //     tes = 'disabled';
                        // }else{
                        //     tes = '';
                        // }
                        // if (tmp == 0) {
                        //     tes = 'disabled';
                        // }else{
                        //     tes = '';
                        // }
                        
                        var simDisabled = sim == 0 ? 'disabled' : '';
                        var tmpDisabled = tmp == 0 ? 'disabled' : '';
                        
                        var s1 = '<button class="btn btn-danger" onclick="f_dtl(\''+nopthn+'\')" type="button">SPPT</button>';
                        var s2 = '<button class="btn btn-warning" onclick="f_dtl_2(\''+nopthn+'\')" type="button" style="margin-left:5px" '+simDisabled+'>SIMULASI MASAL</button>';
                        var s3 = '<button class="btn btn-success" onclick="f_dtl_3(\''+nopthn+'\')" type="button" style="margin-left:5px" '+tmpDisabled+'>SIMULASI DAFNOM</button>';
                        return s1 + s2 + s3;
                    }
                },
            ],
            "oLanguage": {
                "sProcessing": "<img border='0' src='<?php echo base_url('assets/pad/img/ajax-loader-big-circle-ball.gif') ?>' />",
                "sLengthMenu": "Tampilkan _MENU_ entri",
                "sZeroRecords": "Tidak ada data",
                "sInfo": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                "sInfoEmpty": "Menampilkan 0 sampai 0 dari 0 entri",
                "sInfoFiltered": "(disaring dari _MAX_ entri keseluruhan)",
                "sInfoPostFix": "",
                "sSearch": "Cari : ",
                "sUrl": "",
                "oPaginate": {
                    "sFirst": "&laquo;",
                    "sPrevious": "&lsaquo;",
                    "sNext": "&rsaquo;",
                    "sLast": "&raquo;",
                }
            },
            "bProcessing": true,
            "bServerSide": true,
            "bFilter": false,
            "sAjaxSource": "<?php echo active_module_url(); ?>info_rinci_pbb/grid"
        });
        
        $('#c_nop').formatter({
            'pattern': '{{99}}.{{99}}-{{999}}.{{999}}-{{999}}.{{9999}}.{{9}}',
        });

        $('#btn_cari').click(function() {
            var nop = $("#c_nop").val();
            var thn = $("#c_tahun").val();
            reload_grid();

            // if(nop && thn) {
            //     alert('sedang mencari data');
            //     // reload_grid();

            //     $.ajax({
            //         url: "<?php echo active_module_url() . $controller; ?>/get_sppt/" + nop + "/" + thn,
            //         success: function(j) {
            //             var data = $.parseJSON(j);
            //             var aa = data['data'];


            //             $('#alamat_op').html(aa['ALAMAT_OP']);
            //             $('#rtrw_op').html(aa['RTRW_OP']);
            //             $('#kelurahan_op').html(aa['NM_KELURAHAN']);
            //             $('#kecamatan_op').html(aa['NM_KECAMATAN']);
            //             $('#kota_op').html('BOGOR');
                        
            //             $('#nama_wp').html(aa['NM_WP']);
            //             $('#alamat_wp').html(aa['ALAMAT_WP']);
            //             $('#rtrw_wp').html(aa['RTRW_WP']);
            //             $('#kelurahan_wp').html(aa['KELURAHAN_WP']);
            //             $('#kota_wp').html(aa['KOTA_WP']);
            //             $('#nop').html(nop);
            //             $('#tahun').html(thn);

            //             $('#tgl_cetak').html(aa['TGL_CETAK']);
            //             $('#tgl_terbit').html(aa['TGL_TERBIT']);
            //             $('#tgl_jttempo').html(aa['TGL_JTTEMPO']);

                        // $('#luas_bumi').html(fmt_number(aa['LUAS_BUMI_SPPT']));
                        // $('#kelas_bumi').html(aa['KD_KLS_TANAH']);
                        // $('#njop_bumi_perm').html(fmt_number(aa['NJOP_BUMI_PERM']));
                        // $('#njop_bumi').html(fmt_number(aa['NJOP_BUMI_SPPT']));
                        // $('#luas_bng').html(fmt_number(aa['LUAS_BNG_SPPT']));
                        // $('#kelas_bng').html(aa['KD_KLS_BNG']);
                        // $('#njop_bng_perm').html(fmt_number(aa['NJOP_BNG_PERM']));
                        // $('#njop_bng').html(fmt_number(aa['NJOP_BNG_SPPT']));

                        // $('#luas_bumi_bersama').html(fmt_number(aa['LUAS_BUMI_BERSAMA']));
                        // $('#kelas_bumi_bersama').html(aa['KD_KLS_TANAH_BERSAMA']);
                        // $('#njop_bumi_perm_bersama').html(fmt_number(aa['NJOP_BUMI_BERSAMA_PERM']));
                        // $('#njop_bumi_bersama').html(fmt_number(aa['NJOP_BUMI_BERSAMA']));
                        // $('#luas_bng_bersama').html(fmt_number(aa['LUAS_BNG_BERSAMA']));
                        // $('#kelas_bng_bersama').html(aa['KD_KLS_BNG_BERSAMA']);
                        // $('#njop_bng_perm_bersama').html(fmt_number(aa['NJOP_BNG_BERSAMA_PERM']));
                        // $('#njop_bng_bersama').html(fmt_number(aa['NJOP_BNG_BERSAMA']));

                        // var ttl_njop_bumi   = parseInt(aa['NJOP_BUMI_SPPT']) + parseInt(aa['NJOP_BUMI_BERSAMA']);
                        // var ttl_njop_bng    = parseInt(aa['NJOP_BNG_SPPT']) + parseInt(aa['NJOP_BNG_BERSAMA']);
                        // var ttl_njop        = parseInt(ttl_njop_bumi) + parseInt(ttl_njop_bng) ;

                        // var njoptkp         = aa['NJOPTKP_SPPT'];
                        // var njopkp          = parseInt(ttl_njop) - parseInt(njoptkp);

                        // var njkp_pcnt       = aa['NIL_NJKP'];
                        // var tarif_pcnt      = aa['NIL_TARIF'];

                        // var njopkp_njkp     = njkp_pcnt/100*njopkp;

                        // // var njopkp_tarif    = tarif_pcnt/100*njopkp_njkp;
                        
                        // var pbb_terhutang           = aa['PBB_TERHUTANG_SPPT'];
                        // var faktor_pengurang        = aa['FAKTOR_PENGURANG_SPPT'];
                        // var pbb_yg_harus_dibayar    = aa['PBB_YG_HARUS_DIBAYAR_SPPT'];
                        // var denda_yg_sudah_dibayar  = aa['BAYAR_DENDA'];
                        // var pbb_yg_sudah_dibayar    = aa['JML_BAYAR'];

                        // // if ( parseInt(pbb_yg_sudah_dibayar) >= parseInt(pbb_yg_harus_dibayar) ){
                        // //    var selisih                 = parseInt(pbb_yg_harus_dibayar) - parseInt(pbb_yg_sudah_dibayar) ;
                        // //     alert('xxx');
                        // // } else {
                        // //     var selisih                 = 0 ; 
                        // //     alert('zzz');
                        // // }

                        // var selisih                 = parseInt(pbb_yg_harus_dibayar) - parseInt(pbb_yg_sudah_dibayar) ;
                        // if ( parseInt(selisih) < 0 ){
                        //     selisih = 0 ; 
                        // }

                        // // alert(pbb_yg_sudah_dibayar);
                        // // alert(pbb_yg_harus_dibayar);
                        // // alert(selisih);
                        
                        // var txt_c           = '(' + njkp_pcnt + ' % x ' + fmt_number(njopkp) + ')' ;
                        // var txt_e           = '(' + tarif_pcnt + ' % x ' + fmt_number(njopkp_njkp) + ')' ;
                        // var txt_g           = '(' + fmt_number(pbb_terhutang) + ' - ' + fmt_number(faktor_pengurang) + ')' ;
                        
                        // $('#jml_njop_bumi').html(fmt_number(ttl_njop_bumi));
                        // $('#jml_njop_bng').html(fmt_number(ttl_njop_bng));
                        // $('#ttl_njop').html(fmt_number(ttl_njop));
                        // $('#njoptkp').html(fmt_number(njoptkp));
                        // $('#txt_c').html(txt_c);
                        // $('#njopkp').html(fmt_number(njopkp_njkp));
                        // $('#tarif').html(tarif_pcnt + ' %');
                        // $('#txt_e').html(txt_e);
                        // $('#pbb_terhutang').html(fmt_number(pbb_terhutang));
                        // $('#faktor_pengurang').html(fmt_number(faktor_pengurang));
                        // $('#txt_g').html(txt_g);
                        // $('#pbb_yg_harus_dibayar').html(fmt_number(pbb_yg_harus_dibayar));
                        // $('#denda_yg_sudah_dibayar').html(fmt_number(denda_yg_sudah_dibayar));
                        // $('#pbb_yg_sudah_dibayar').html(fmt_number(pbb_yg_sudah_dibayar));
                        // $('#selisih').html(fmt_number(selisih));
            

            //         },
            //         error: function(xhr, desc, er) {
            //             alert(er);
            //         }
            //     });
            // }else{
            //     alert('NOP dan Tahun tidak boleh kosong');
            // }
        });


    });
</script>