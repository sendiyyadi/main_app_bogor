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
                        <h4 class="mb-0"><?php echo $this->uri->segment(2) == 'dph' ? 'DPH - Entri Data' : 'DPH - Download dan Posting'; ?></h4>
                        <div class="page-title-right" id="test">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">DPH</a>
                                </li>
                                <li class="breadcrumb-item active"><?php echo $this->uri->segment(2) == 'dph' ? 'DPH - Entri Data' : 'DPH - Download dan Posting'; ?></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <?php echo msg_block(); ?>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div class="input-group w-auto">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-end-0">Tahun Bayar</span>
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
                                        <th>Kode</th>
                                        <th>Uraian</th>
                                        <th>Tanggal</th>
                                        <th>Pokok</th>
                                        <th>Denda</th>
                                        <th>Bayar</th>
                                        <th>Posting</th>
                                        <th>Pokok</th>
                                        <th>Denda</th>
                                        <th>Bayar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4">TOTAL</td>
                                        <td><span id="pokok">&nbsp;</span></td>
                                        <td><span id="denda">&nbsp;</span></td>
                                        <td><span id="total">&nbsp;</span></td>
                                        <td colspan="3">&nbsp;</td>
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
                "aTargets": [0, 8, 9, 10]
            }, ],
            "aoColumns": [
                null,
                {
                    "sWidth": "140px",
                    "sClass": "left"
                },
                null,
                {
                    "sWidth": "60px",
                    "sClass": "center"
                },
                {
                    "sWidth": "90px",
                    "sClass": "right"
                },
                {
                    "sWidth": "90px",
                    "sClass": "right"
                },
                {
                    "sWidth": "90px",
                    "sClass": "right"
                },
                {
                    "sWidth": "60px",
                    "sClass": "center"
                },

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
                var total = 0;
                if (aaData.length > 0) {
                    for (var i = 0; i < aaData.length; i++) {
                        pokok += parseFloat(aaData[i][8]);
                        denda += parseFloat(aaData[i][9]);
                        total += parseFloat(aaData[i][10]);
                    }
                }

                var nCells = nRow.getElementsByTagName('td');
                nCells[1].innerHTML = num_thousand(pokok);
                nCells[2].innerHTML = num_thousand(denda);
                nCells[3].innerHTML = num_thousand(total);
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
            <?php if ($this->uri->segment(2) == 'dph') : ?> '<button type="button" id="btn_tambah" class="btn btn-primary waves-effect waves-light">Tambah <i class="uil uil-plus ms-2"></i></button>',
                '<button type="button" id="btn_edit" class="btn btn-warning waves-effect waves-light">Edit <i class="uil uil-edit-alt ms-2"></i></button>',
                '<button type="button" id="btn_delete" class="btn btn-danger waves-effect waves-light">Hapus <i class="uil uil-trash-alt ms-2"></i></button>',
            <?php endif; ?>
            <?php if ($this->uri->segment(2) == 'dph_posting') : ?> '<button id="btn_posting" class="btn btn-success waves-effect waves-light" type="button">Download</button>',
            <?php endif; ?>
        ];
        var tb = tb_array.join(' ');
        $("div.toolbar").html(tb);
        $("div.toolbar").addClass("d-inline-block mb-2");

        $('#btn_tambah').click(function() {
            var kec_kd = $("#kd_kecamatan").val();
            var kel_kd = $("#kd_kelurahan").val();
            window.location = '<?php echo active_module_url($this->uri->segment(2)); ?>add/' + kec_kd + '/' + kel_kd;
        });

        $('#btn_edit').click(function() {
            if (mID) {
                window.location = '<?php echo active_module_url($this->uri->segment(2)); ?>edit/' + mID;
            } else {
                Swal.fire({
                    text: 'Silahkan pilih data yang akan diedit!',
                    icon: 'question',
                    confirmButtonColor: '#5b73e8'
                });
            }
        });

        $('#btn_delete').click(function() {
            if (mID) {
                Swal.fire({
                    title: "Hapus data ini?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#34c38f",
                    cancelButtonColor: "#f46a6a",
                    confirmButtonText: "Yes"
                }).then(function(result) {
                    if (result.value) {
                        window.location = '<?php echo active_module_url($this->uri->segment(2)); ?>delete/' + mID;
                    }
                });
            } else {
                Swal.fire({
                    text: 'Silahkan pilih data yang akan dihapus!',
                    icon: 'question',
                    confirmButtonColor: '#5b73e8'
                });
            }
        });

        $('#btn_posting').click(function() {
            if (mID) {
                var url = '<?php echo active_module_url($this->uri->segment(2)); ?>posting';

                $('#download').val(mID);
                $('#download_form').attr('action', url);
                $('#download_form').submit();
            } else {
                Swal.fire({
                    text: 'Silahkan pilih data yang akan didownload!',
                    icon: 'question',
                    confirmButtonColor: '#5b73e8'
                });
            }
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