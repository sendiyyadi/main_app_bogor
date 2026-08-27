<?= $this->load->view('layouts/headers'); ?>
<?= $this->load->view(active_module() . '/layouts/sidebar'); ?>

<style type="text/css">
    @import "<?php echo base_url() ?>assets/css/pbbm.css";
</style>


<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0 d-flex align-items-center gap-2">
                            Status Pembayaran
                        </h4>
                        <div class="page-title-right" id="test">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">STTS</a>
                                </li>
                                <li class="breadcrumb-item active">Status Pembayaran</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            // $last_op = 1;
            $last_op = count($data_source) - 1;
            if (!isset($data_source) && !empty($nop_kd)) { ?>
                <div>
                    <div id="msg_helper" class="alert alert-danger" role="alert"><button type="button" class="close" data-dismiss="alert">&times;</button>Data tidak ditemukan !</div>
                </div>
            <?php } ?>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <?= form_open(active_module_url() . 'sts_bayar_op', array('id' => 'myform', 'class' => 'form-horizontal', 'method' => 'get')); ?>
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div class="input-group w-auto">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-end-0">NOP</span>
                                    </div>
                                    <input type="text" id="nop_kd" class="form-control" value="<?= ($nop_kd != 0 ? $nop_kd : ''); ?>" name="nop_kd" autocomplete="off" placeholder="NOP" size="30" />
                                </div>
                                <button type="submit" class="btn btn-primary waves-effect waves-light">Cari</button>
                                <button class="btn btn-success waves-effect waves-light" id="btnprint" type="button">Cetak <i class="uil-print"></i></button>
                            </div>
                            </form>
                            <hr>
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-2">
                                        <h6 class="card-subtitle fw-bold"><i class="uil-list-ul"></i> Objek Pajak <?= !empty($data_source[$last_op]['NOP']) ? " - NOP : " . $data_source[$last_op]['NOP'] : ""; ?></h6>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-2">
                                        <h6 class="card-subtitle fw-bold"><i class="uil-list-ul"></i> Subjek Pajak</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="row">
                                        <p for="ALAMAT_OP" class="col-sm-4 col-form-label">Letak OP</p>
                                        <div class="col-sm-8">
                                            <input type="text" readonly class="form-control-plaintext" id="ALAMAT_OP" value="<?= !empty($data_source[$last_op]['ALAMAT_OP']) ? $data_source[$last_op]['ALAMAT_OP'] : ": "; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="row">
                                        <p for="staticEmail" class="col-sm-4 col-form-label">Nama WP</p>
                                        <div class="col-sm-8">
                                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?= !empty($data_source[$last_op]['NM_WP_SPPT']) ? $data_source[$last_op]['NM_WP_SPPT'] : ": "; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-2 row">
                                        <p for="RT_RW_OP" class="col-sm-4 col-form-label">RT / RW</p>
                                        <div class="col-sm-8">
                                            <input type="text" readonly class="form-control-plaintext" id="RT_RW_OP" value="<?= !empty($data_source[$last_op]['RT_RW_OP']) ? $data_source[$last_op]['RT_RW_OP'] : ": "; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-2 row">
                                        <p for="ALAMAT_WP" class="col-sm-4 col-form-label">Alamat</p>
                                        <div class="col-sm-8">
                                            <input type="text" readonly class="form-control-plaintext" id="ALAMAT_WP" value="<?= !empty($data_source[$last_op]['ALAMAT_WP']) ? $data_source[$last_op]['ALAMAT_WP'] : ": "; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-2 row">
                                        <p for="KELURAHAN_OP" class="col-sm-4 col-form-label">Kelurahan</p>
                                        <div class="col-sm-8">
                                            <input type="text" readonly class="form-control-plaintext" id="KELURAHAN_OP" value="<?= !empty($data_source[$last_op]['KELURAHAN_OP']) ? $data_source[$last_op]['KELURAHAN_OP'] : ": "; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-2 row">
                                        <p for="RT_RW_WP" class="col-sm-4 col-form-label">RT / RW</p>
                                        <div class="col-sm-8">
                                            <input type="text" readonly class="form-control-plaintext" id="RT_RW_WP" value="<?= !empty($data_source[$last_op]['RT_RW_WP']) ? $data_source[$last_op]['RT_RW_WP'] : ": "; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-2 row">
                                        <p for="KECAMATAN_OP" class="col-sm-4 col-form-label">Kecamatan</p>
                                        <div class="col-sm-8">
                                            <input type="text" readonly class="form-control-plaintext" id="KECAMATAN_OP" value="<?= !empty($data_source[$last_op]['KECAMATAN_OP']) ? $data_source[$last_op]['KECAMATAN_OP'] : ": "; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-2 row">
                                        <p for="KELURAHAN_WP" class="col-sm-4 col-form-label">Kelurahan</p>
                                        <div class="col-sm-8">
                                            <input type="text" readonly class="form-control-plaintext" id="KELURAHAN_WP" value="<?= !empty($data_source[$last_op]['KELURAHAN_WP']) ? $data_source[$last_op]['KELURAHAN_WP'] : ": "; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-2 row">
                                        <p for="<?php echo LICENSE_TO; ?>" class="col-sm-4 col-form-label">Kota</p>
                                        <div class="col-sm-8">
                                            <input type="text" readonly class="form-control-plaintext" id="<?php echo LICENSE_TO; ?>" value="<?php echo LICENSE_TO; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-2 row">
                                        <p for="KOTA_WP" class="col-sm-4 col-form-label">Kabupaten / Kota</p>
                                        <div class="col-sm-8">
                                            <input type="text" readonly class="form-control-plaintext" id="KOTA_WP" value="<?php echo  !empty($data_source[$last_op]['KOTA_WP']) ? $data_source[$last_op]['KOTA_WP'] : ": "; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <table id="table1" class="table table-striped table-nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Tahun</th>
                                        <th>Nama WP</th>
                                        <th>Luas Tanah</th>
                                        <th>NJOP Tanah</th>
                                        <th>Luas Bng</th>
                                        <th>NJOP Bng</th>
                                        <th>Ketetapan</th>
                                        <th>Denda</th>
                                        <th>Bayar</th>
                                        <th>Sisa</th>
                                        <th>Tgl. Byr (Akh)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    $tot_ketetapan = 0;
                                    $tot_denda = 0;
                                    $tot_bayar = 0;
                                    $tot_sisa = 0;
                                    if (isset($data_source)) {
                                        $tot_ketetapan = 0;
                                        $tot_denda = 0;
                                        $tot_bayar = 0;
                                        $tot_sisa = 0;
                                        foreach ($data_source as $val) {
                                    ?>
                                            <tr>
                                                <td><?= $val['THN_PAJAK_SPPT']; ?></td>
                                                <td><?= $val['NM_WP_SPPT']; ?></td>
                                                <td align="right"><?= number_format($val['LUAS_TANAH'], 0,  ',', '.'); ?></td>
                                                <td align="right"><?= number_format($val['NJOP_TANAH'], 0,  ',', '.'); ?></td>
                                                <td align="right"><?= number_format($val['LUAS_BNG'], 0,  ',', '.'); ?></td>
                                                <td align="right"><?= number_format($val['NJOP_BNG'], 0,  ',', '.'); ?></td>
                                                <td align="right"><?= number_format($val['KETETAPAN'], 0,  ',', '.'); ?></td>
                                                <td align="right"><?= number_format($val['JML_DENDA'], 0,  ',', '.'); ?></td>
                                                <td align="right"><?= number_format($val['JML_BAYAR'], 0,  ',', '.'); ?></td>
                                                <td align="right"><?= number_format($val['KETETAPAN'] - ($val['JML_BAYAR'] - $val['JML_DENDA']), 0,  ',', '.'); ?></td>
                                                <td align="right"><?= $val['TGL_BAYAR']; ?></td>
                                            </tr>
                                    <?php
                                            $tot_ketetapan += $val['KETETAPAN'];
                                            $tot_denda    += $val['JML_DENDA'];
                                            $tot_bayar    += $val['JML_BAYAR'];
                                            $tot_sisa     += $val['KETETAPAN'] - ($val['JML_BAYAR'] - $val['JML_DENDA']);
                                        }
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="6">TOTAL</td>
                                        <td align="right"><?= number_format($tot_ketetapan, 0,  ',', '.'); ?></td>
                                        <td align="right"><?= number_format($tot_denda, 0,  ',', '.'); ?></td>
                                        <td align="right"><?= number_format($tot_bayar, 0,  ',', '.'); ?></td>
                                        <td align="right"><?= number_format($tot_sisa, 0,  ',', '.'); ?></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div> <!-- end col -->
                </div>
            </div>
        </div>
    </div>
    <?= $this->load->view('layouts/foot.php'); ?>
</div>
<?= $this->load->view('layouts/scripts.php'); ?>

<script>
    $(document).ready(function() {

        var oTable = $('#table1').dataTable({
            // "iDisplayLength": 0,
            // "sScrollY": "200px",
            // "bJQueryUI": true,
            // "bAutoWidth": false,
            "bScrollCollapse": true,
            // "bLengthChange": false,
            "bPaginate": true,
            "sPaginationType": "full_numbers",
            // "bFilter": false,
            // "bLengthChange": false,
            "sDom": '<"H"lfr>t<"F"ip>',
            // "sDom": '<"H"lfr>t<"F"ip>T',
            // "bDestroy": false,
            "aaSorting": [
                [0, "asc"]
            ],
            "aoColumnDefs": [{
                'aTargets': [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                'bSortable': false,
                'bVisible': true,
            }],
            "aoColumns": [{
                    "sWidth": "4%",
                    "sClass": "text-center"
                },
                {
                    "sClass": "text-center"
                },
                // null,
                {
                    "sWidth": "8%",
                    "sClass": "text-center"
                },
                {
                    "sWidth": "10%",
                    "sClass": "text-center"
                },
                {
                    "sWidth": "8%",
                    "sClass": "text-center"
                },
                {
                    "sWidth": "10%",
                    "sClass": "text-center"
                },
                {
                    "sWidth": "8%",
                    "sClass": "text-center"
                },
                {
                    "sWidth": "8%",
                },
                {
                    "sWidth": "8%",
                },
                {
                    "sWidth": "8%",
                },
                {
                    "sWidth": "8%",
                    "sClass": "text-center"
                },
            ],
            "fnRowCallback": function(nRow, aData, iDisplayIndex) {
                $(nRow).on("click", function(event) {
                    if ($(this).hasClass('row_selected')) {
                        mID = '';
                        $(this).removeClass('row_selected');
                    } else {
                        var data = oTable.fnGetData(this);
                        mID = data[0];

                        oTable.$('tr.row_selected').removeClass('row_selected');
                        $(this).addClass('row_selected');
                    }
                })
            },
            "oTableTools": {
                "sSwfPath": "<?php echo base_url() ?>assets/datatables/extras/TableTools/media/swf/copy_csv_xls_pdf.swf"
            },
            "oLanguage": {
                "sProcessing": "<img border='0' src='<?= base_url('assets/img/ajax-loader-big-circle-ball.gif') ?>' />",
                "sLengthMenu": "Tampilkan _MENU_",
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
            "bSort": true,
            "bInfo": true,
            // "bFilter": false,
            "bProcessing": true,
            "fnDrawCallback": function(settings) {
                $("#table1").next().removeClass("card");

                $("#table1")
                    .closest(".dataTables_wrapper")
                    .children("div:eq(0)")
                    .removeClass("row")
                    .addClass(
                        "d-flex align-items-center justify-content-between flex-wrap w-100"
                    )
                    .find(".col-sm-12")
                    .removeAttr("class");

                $("#table1")
                    .closest(".dataTables_wrapper")
                    .children("table.dataTable")
                    // .removeClass("row")
                    // .children()
                    // .removeClass("col-sm-12")
                    // .addClass("table-responsive w-100");
                    .wrap('<div class="table-responsive w-100"></div>');
                // .css("max-height", "500px");

                $("#table1")
                    .closest(".dataTables_wrapper")
                    .children("div:eq(1)")
                    .removeClass("row")
                    .addClass(
                        "d-flex align-items-center justify-content-between flex-wrap w-100 mt-2"
                    )
                    .find(".col-sm-12")
                    .removeAttr("class");
            },
        });

        $('#btnprint').click(function() {
            var nop_kd = $("#nop_kd").val();
            var winparams = 'location=1,status=1,scrollbars=1,resizable=no,width=' + screen.width + ',height=' + screen.height + ',menubar=no,toolbar=no,fullscreen=no';
            window.open('<?php echo active_module_url('sts_bayar_op'); ?>cetak/pdf/' + nop_kd, 'Laporan'); //, winparams);
            return false;
        });

    });
</script>

<?= $this->load->view('layouts/footer.php'); ?>