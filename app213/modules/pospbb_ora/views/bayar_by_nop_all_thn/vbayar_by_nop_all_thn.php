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
                            Cetak STTS Per Tahun
                        </h4>
                        <div class="page-title-right" id="test">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">STTS</a>
                                </li>
                                <li class="breadcrumb-item active">Cetak STTS Per Tahun</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            if (validation_errors()) {
                echo '<blockquote><strong>Harap melengkapi data berikut :</strong>';
                echo validation_errors('<small>', '</small>');
                echo '</blockquote>';
            }
            ?>
            <?php echo msg_block(); ?>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <?php echo form_open($faction, array('id' => 'myform', 'class' => 'form-horizontal', 'method' => 'get')); ?>
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div class="col-md-1">
                                    <input type="text" id="prefix" class="form-control" value="<?= $prefix ?>" name="prefix" autocomplete="off" readonly />
                                </div>
                                <div class="input-group w-auto">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-end-0">NOP</span>
                                    </div>
                                    <input type="text" id="blok" class="form-control" name="blok" autocomplete="off" placeholder="Masukan NOP" />
                                </div>
                                <button id="btn_cari" class="btn btn-primary waves-effect waves-light" type="button">Cari</button>
                                <button id="btn_reset" class="btn btn-danger waves-effect waves-light" type="button">Reset <i class="uil uil-redo ms-2"></i></button>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <button type="button" class="btn btn-primary waves-effect waves-light" id="btn_simpan" name="btn_simpan" disabled><i class="uil-money-bill"></i> Bayar</button>
                                <button type="button" class="btn btn-success waves-effect waves-light" id="btn_cetak" name="btn_cetak"><i class="uil-print"></i> Cetak (Draft)</button>
                                <button type="button" class="btn btn-success waves-effect waves-light" id="btn_cetak4" name="btn_cetak4"><i class="uil-print"></i> Cetak Bank (Draft)</button>
                            </div>
                            </form>
                            <hr>
                            <table id="table1" class="table table-striped table-nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>NOP</th>
                                        <th>Tahun</th>
                                        <th>Pokok</th>
                                        <th>Denda</th>
                                        <th>Jumlah</th>
                                        <th>Nama WP</th>
                                        <th>Alamat WP</th>
                                        <th>Batal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Total : </th>
                                        <th>&nbsp;</th>
                                        <th>&nbsp;</th>
                                        <th>&nbsp;</th>
                                        <th>&nbsp;</th>
                                        <th>&nbsp;</th>
                                        <th>&nbsp;</th>
                                        <th>&nbsp;</th>
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
    var dID;
    var oTable;
    var xRow;
    var xRow2;
    var asInitVals = new Array();

    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    $(document).ready(function() {
        // $('#table1 a.delete').live('click', function(e) {
        //     e.preventDefault();
        //     var nRow = $(this).parents('tr')[0];
        //     oTable.fnDeleteRow(nRow);
        // });

        $('#table1').on('click', 'a.delete', function(e) {
            e.preventDefault();
            var nRow = $(this).parents('tr')[0];
            oTable.fnDeleteRow(nRow);
        });

        oTable = $('#table1').dataTable({
            // "iDisplayLength": 100,
            // "bJQueryUI": true,
            "bScrollCollapse": true,
            "bPaginate": true,
            "bAutoWidth": false,
            "sPaginationType": "full_numbers",
            // "bFilter": false,
            "bLengthChange": false,
            // "sDom": '<"top">rt<"bottom"ilp><"clear">',
            "sDom": '<"toolbar">fT<"clear">lrtip<"clear">',
            // "sDom":'<"toolbar">fT<"clear">lrtip<"clear">',
            "aoColumnDefs": [{
                    "bSortable": false,
                    "bSearchable": false,
                    "bVisible": true,
                    "aTargets": [0]
                },
                {
                    "bSortable": true,
                    "bSearchable": false,
                    "bVisible": true,
                    "aTargets": [1]
                },
                {
                    "bSortable": false,
                    "bSearchable": false,
                    "bVisible": true,
                    "aTargets": [2]
                },
                {
                    "bSortable": false,
                    "bSearchable": false,
                    "bVisible": true,
                    "aTargets": [3]
                },
                {
                    "bSortable": false,
                    "bSearchable": false,
                    "bVisible": true,
                    "aTargets": [4]
                },
                {
                    "bSortable": false,
                    "bSearchable": false,
                    "bVisible": true,
                    "aTargets": [5]
                },
                {
                    "bSortable": false,
                    "bSearchable": false,
                    "bVisible": true,
                    "aTargets": [6]
                },
                {
                    "bSortable": false,
                    "bSearchable": false,
                    "bVisible": true,
                    "aTargets": [7]
                },
                // { "bSortable": false, "bSearchable": false, "bVisible": true, "aTargets": [ 8 ] }
            ],
            "oTableTools": {
                "sSwfPath": "<?php echo base_url() ?>assets/datatables/extras/TableTools/media/swf/copy_csv_xls_pdf.swf"
            },
            "oLanguage": {
                "sProcessing": "<img border='0' src='<?php echo base_url('assets/img/ajax-loader-big-circle-ball.gif') ?>' />",
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
            "bServerSide": false,
            "bProcessing": true,
            "sAjaxSource": "<?php echo active_module_url(); ?>bayar_by_nop_all_thn/cari/",
            /*
            "fnFooterCallback": function( nFoot, aData, iStart, iEnd, aiDisplay ) {
                nFoot.getElementsByTagName('th')[2].innerHTML = aData[10];
                nFoot.getElementsByTagName('th')[3].innerHTML = 10;
                nFoot.getElementsByTagName('th')[4].innerHTML = 15;
            }
            */
            "fnFooterCallback": function(nRow, aaData, iStart, iEnd, aiDisplay) {
                var iTotalPokok = 0;
                var iTotalDenda = 0;
                var iTotalPengurang = 0;
                var iTotalJumlah = 0;
                if (aaData.length > 0) {
                    for (var i = 0; i < aaData.length; i++) {
                        iTotalPokok += parseInt(aaData[i][2].replace(/[^0-9]/gi, ''));
                        iTotalDenda += parseInt(aaData[i][3].replace(/[^0-9]/gi, ''));
                        iTotalPengurang += parseInt(aaData[i][4].replace(/[^0-9]/gi, ''));
                        iTotalJumlah += parseInt(aaData[i][5].replace(/[^0-9]/gi, ''));
                    }
                }
                var nCells = nRow.getElementsByTagName('th');
                nCells[2].innerHTML = numberWithCommas(iTotalPokok);
                nCells[3].innerHTML = numberWithCommas(iTotalDenda);
                nCells[4].innerHTML = numberWithCommas(iTotalPengurang);
                nCells[5].innerHTML = numberWithCommas(iTotalJumlah);
            }
        });

        $("div.toolbar").append($('.asd'));
    });

    $(document).ready(function() {
        var saved = null;
        var cetak = null;
        $("#btn_cari").click(function() {
            $("#btn_simpan,#btn_cetak, #btn_cetak2, #btn_cetak5, #btn_cetak3, #btn_cetak4").attr('disabled', 'disabled');

            var blok = $("#prefix").val() + $("#blok").val();
            // var blok2 = $("#blok2").val();
            // var thn = $("#tahun").val();
            if (blok) {
                saved = null;
                cetak = null;

                document.getElementById("blok").disabled = true;
                $("#btn_simpan").removeAttr('disabled');

                oTable.fnReloadAjax("<?php echo active_module_url(); ?>bayar_by_nop_all_thn/cari/" + blok);
            } else {
                alert('Harap mengisi NOP dengan benar!');
            }
        });

        $("#btn_reset").click(function() {
            $("#btn_simpan,#btn_cetak, #btn_cetak2, #btn_cetak5, #btn_cetak3, #btn_cetak4").attr('disabled', 'disabled');

            $("#blok").val("");
            document.getElementById("blok").disabled = false;
            //Reset Data
            $('#table1').dataTable().fnClearTable();
        });

        // $('#myform').submit(function () {
        // });

        $('#btn_simpan').click(function() {
            $.ajax({
                type: 'POST',
                url: "<?php echo active_module_url('bayar_by_nop_all_thn/simpan') ?>",
                data: $('#myform').serialize(),
                data: "data=" + encodeURIComponent(JSON.stringify(oTable.fnGetData())),
                async: false,
                beforeSend: function() {},
                success: function(msg) {
                    data = JSON.parse(msg);
                    if (data['simpan'] != 'gagal') {
                        saved = data['saved'];
                        cetak = data['cetak'];
                        $('#data').val(JSON.stringify(saved));
                        $("#btn_cetak,#btn_cetak6,#btn_cetak2,#btn_cetak5,#btn_cetak3,#btn_cetak4").removeAttr('disabled');
                        alert('Data telah disimpan.');
                    } else
                        alert('Data gagal disimpan.');
                }
            });
            $(this).attr('disabled', 'disabled');
        });

        $('#btn_cetak').click(function() {
            ajax_download("<?php echo active_module_url('bayar_by_nop_all_thn/cetak'); ?>", {
                'dtCetak': JSON.stringify({
                    "dtCetak": cetak
                })
            });
        });

        $('#btn_cetak4').click(function() {
            ajax_download("<?php echo active_module_url('bayar_by_nop_all_thn/cetak_draft'); ?>", {
                'dtCetak': JSON.stringify({
                    "dtCetak": cetak
                })
            });
        });

    });

    $(document).keypress(function(event) {
        if (event.which == '13') {
            event.preventDefault();
        }
    });
    /*http://stackoverflow.com/questions/4545311/download-a-file-by-jquery-ajax*/
    function ajax_download(url, data) {
        var $iframe,
            iframe_doc,
            iframe_html;
        if (($iframe = $('#download_iframe')).length === 0) {
            $iframe = $("<iframe id='download_iframe'" +
                " style='display: none' src='about:blank'></iframe>"
            ).appendTo("body");
        }

        iframe_doc = $iframe[0].contentWindow || $iframe[0].contentDocument;
        if (iframe_doc.document) {
            iframe_doc = iframe_doc.document;
        }
        iframe_html = "<html><head></head><body><form method='POST' action='" +
            url + "'>"

        Object.keys(data).forEach(function(key) {
            iframe_html += "<input type='hidden' name='" + key + "' value='" + data[key] + "'>";

        });

        iframe_html += "</form><!-- </body></html> -->";

        iframe_doc.open();
        iframe_doc.write(iframe_html);
        $(iframe_doc).find('form').submit();

    }
</script>

<?= $this->load->view('layouts/footer.php'); ?>