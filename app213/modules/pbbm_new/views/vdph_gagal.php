<?= $this->load->view('layouts/headers'); ?>
<?= $this->load->view(active_module() . '/sidebar'); ?>

<style>
    .right {
        text-align: right;
    }
</style>


<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Gagal Transaksi</h4>
                        <div class="page-title-right" id="test">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">DPH</a>
                                </li>
                                <li class="breadcrumb-item active">Gagal Transaksi</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <?php echo msg_block(); ?>

            <form id="download_form" method="post" action="" class="hide">
                <input type="hidden" id="download" name="download" />
            </form>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div class="input-group w-auto">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-end-0">Tahun</span>
                                    </div>
                                    <input class="form-control input" style="width:80px;" id="tahun" name="tahun" type="text" value="<?php echo isset($tahun) ? $tahun : date('Y'); ?>" />
                                </div>
                                <button id="btngo" name="btngo" class="btn btn-primary waves-effect waves-light" type="button">Cari</button>
                            </div>
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div class="input-group w-auto">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-end-0">Kecamatan</span>
                                    </div>
                                    <select id="kec_kd" name="kec_kd" class="input form-control select2" style="width:250px;"><?php echo $kecamatans; ?></select>
                                </div>
                                <div class="input-group w-auto">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-end-0">Kelurahan</span>
                                    </div>
                                    <select id="kel_kd" name="kel_kd" class="input form-control select2" style="width:250px;"><?php echo $kelurahans; ?></select>
                                </div>
                            </div>
                            <hr>
                            <table id="table1" class="table table-striped table-nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Kode DPH</th>
                                        <th>NOP</th>
                                        <th>Tahun</th>
                                        <th>Pokok</th>
                                        <th>Denda</th>
                                        <th>Jumlah</th>
                                        <th>Status SPPT</th>
                                        <th>Jml. Bayar</th>
                                        <th>pokok</th>
                                        <th>denda</th>
                                        <th>jumlah</th>
                                        <th>bayar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4">TOTAL</td>
                                        <td><span id="pokok">&nbsp;</span></td>
                                        <td><span id="denda">&nbsp;</span></td>
                                        <td><span id="jumlah">&nbsp;</span></td>
                                        <td>&nbsp;</td>
                                        <td><span id="bayar">&nbsp;</span></td>
                                        <td colspan="4">&nbsp;</td>
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
    var mID;
    var oTable;
    var xRow;

    function num_thousand(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    function num_clean(x) {
        return x.toString().replace(/^\D+/g, '');;
    }

    function reload_grid() {
        var tahun = $("#tahun").val();
        var kec_kd = $("#kd_kecamatan").val();
        var kel_kd = $("#kd_kelurahan").val();
        window.location = "<?php echo active_module_url($this->uri->segment(2)); ?>?tahun=" + tahun + "&kec_kd=" + kec_kd + "&kel_kd=" + kel_kd;
    }

    $(document).ready(function() {

        var oTable = $('#table1').dataTable({
            // "iDisplayLength": 100,
            // "sScrollY": "260px",
            // "bJQueryUI": true,
            // "bAutoWidth": true,
            "bScrollCollapse": false,
            "bLengthChange": false,
            "bPaginate": true,
            "bFilter": true,
            "sPaginationType": "full_numbers",
            "bSort": false,
            "bInfo": true,
            "bServerSide": false,
            "bProcessing": true,
            "sAjaxSource": "<?php echo $data_source ?>",
            "sDom": '<"toolbar">fTl<"clear">rtip',
            "aoColumnDefs": [{
                "bSearchable": false,
                "bVisible": false,
                "aTargets": [0, 9, 10, 11, 12]
            }, ],
            "aoColumns": [
                null,
                {
                    "sWidth": "12%",
                    "sClass": "left"
                },
                {
                    "sWidth": "15%",
                    "sClass": "left"
                },
                {
                    "sWidth": "5%",
                    "sClass": "center"
                },
                {
                    "sWidth": "10%",
                    "sClass": "right"
                },
                {
                    "sWidth": "10%",
                    "sClass": "right"
                },
                {
                    "sWidth": "10%",
                    "sClass": "right"
                },
                {
                    "sWidth": "10%",
                    "sClass": "center"
                },
                {
                    "sWidth": "10%",
                    "sClass": "right"
                },
                null,
                null,
                null,
                null,
            ],
            "oTableTools": {
                "sSwfPath": "<?php echo base_url() ?>assets/datatables/extras/TableTools/media/swf/copy_csv_xls_pdf.swf"
            },
            "fnRowCallback": function(nRow, aData, iDisplayIndex) {
                $(nRow).on("click", function(event) {
                    if (aData[0] != xRow) {
                        if ($(this).hasClass('row_selected')) {
                            $(this).removeClass('row_selected');
                        } else {
                            oTable.$('tr.row_selected').removeClass('row_selected');
                            $(this).addClass('row_selected');
                        }

                        var data = oTable.fnGetData(this);
                        mID = data[0];
                    }
                    xRow = aData[0];
                })
            },
            "oLanguage": {
                "sProcessing": "<img border='0' src='<?php echo base_url('assets/img/ajax-loader-big-circle-ball.gif') ?>' />",
                "sLengthMenu": "Tampilkan _MENU_",
                // "sZeroRecords":  "Tidak ada data",
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
            "fnFooterCallback": function(nRow, aaData, iStart, iEnd, aiDisplay) {
                var pokok = 0;
                var denda = 0;
                var jumlah = 0;
                var bayar = 0;
                if (aaData.length > 0) {
                    for (var i = 0; i < aaData.length; i++) {
                        pokok += parseFloat(aaData[i][9]);
                        denda += parseFloat(aaData[i][10]);
                        jumlah += parseFloat(aaData[i][11]);
                        bayar += parseFloat(aaData[i][12]);
                    }
                }

                var nCells = nRow.getElementsByTagName('td');
                nCells[1].innerHTML = num_thousand(pokok);
                nCells[2].innerHTML = num_thousand(denda);
                nCells[3].innerHTML = num_thousand(jumlah);
                nCells[5].innerHTML = num_thousand(bayar);
            },
        });

        oTable.parent().find(".dataTables_filter").addClass("d-inline-block float-end mt-2");
        oTable.parent().find(".dataTables_info").addClass("d-inline-block");
        oTable.parent().find(".dataTables_paginate").addClass("d-inline-block float-end");

        // Settings Table Scroll Responsive
        let parent = $("#appTable").parent();
        let table_responsive = $("<div>").addClass("table-responsive mb-2").appendTo(parent);
        $("#appTable").appendTo("div.table-responsive");
        table_responsive.after($("#appTable_info"));
        $("#appTable_info").after($("#appTable_paginate"));

        var tb_array = [
            '<button id="btn_cetak" class="btn btn-success waves-effect waves-light" type="button">Cetak</button>',
        ];
        var tb = tb_array.join(' ');
        $("div.toolbar").html(tb);
        $("div.toolbar").addClass("d-inline-block mb-2");

        $('#btn_cetak').click(function() {
            var rpt = 'dph_gagal';
            var rptparams = {
                rpt: rpt,
                thn: $("#tahun").val(),
                kec: $("#kec_kd").val(),
                kel: $("#kel_kd").val(),
            }
            var rptdata = decodeURIComponent($.param(rptparams));
            var winparams = 'location=1,status=1,scrollbars=1,resizable=no,width=' + screen.width + ',height=' + screen.height + ',menubar=no,toolbar=no,fullscreen=no';
            window.open('<?php echo active_module_url($this->uri->segment(2)); ?>cetak/pdf/?' + rptdata, 'Laporan', winparams);
        });

        $("#btngo").click(function() {
            reload_grid();
        });

        $("#kec_kd, #kel_kd").change(function() {
            var tahun = $("#tahun").val();
            var kec_kd = $("#kec_kd").val();
            var params = "?tahun=" + tahun + "&kec_kd=" + kec_kd;

            if ($(this).attr('name') == 'kel_kd')
                params = params + "&kel_kd=" + $("#kel_kd").val();

            window.location = "<?php echo active_module_url($this->uri->segment(2)); ?>" + params;
        });

    });
</script>

<?= $this->load->view('layouts/footer.php'); ?>