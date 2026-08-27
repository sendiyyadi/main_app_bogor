<?= $this->load->view('layouts/headers'); ?>
<?= $this->load->view(active_module() . '/layouts/sidebar'); ?>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Penghapusan Sanksi Administrasi - Kolektif</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Pembayaran Khusus</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);?>">Penghapusan Sanksi Administrasi</a>
                                </li>
                                <li class="breadcrumb-item active">
                                    <a href="<?= active_module_url('pst_penghapusan_kolektif'); ?>">Kolektif</a>
                                </li>
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
                            <?php echo form_open('#', array('id' => 'myform', 'class' => 'form-horizontal')); ?>
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div class="input-group w-auto">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-end-0">Nomor Pelayanan</span>
                                    </div>
                                    <input class="form-control" type="text" id="blok_tahun" name="blok_tahun" maxlength="4" placeholder="Tahun">
                                    <input class="form-control" type="text" id="blok_bundel" name="blok_bundel" maxlength="4" placeholder="Bundel">
                                    <input class="form-control" type="text" id="blok_urut" name="blok_urut" maxlength="3" placeholder="No Urut">
                                </div>
                                <button id="btn_cari" class="btn btn-primary waves-effect waves-light" type="button">Cari</button>
                            </div>
                            <div class="d-flex align-items-center gap-2 mb-2">
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
                                        <th>Pengurangan (%)</th>
                                        <th>Denda Disetujui</th>
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
                                        <th style="text-align: right">Total</th>
                                        <th>&nbsp;</th>
                                        <th style="text-align: right;">&nbsp;</th>
                                        <th style="text-align: right;">&nbsp;</th>
                                        <th>&nbsp;</th>
                                        <th style="text-align: right;">&nbsp;</th>
                                        <th style="text-align: right;">&nbsp;</th>
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

    var saved = null;
    var cetak = null;

    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    $(document).ready(function() {
        $('#table1 a.delete').on('click', function(e) {
            e.preventDefault();
            var nRow = $(this).parents('tr')[0];
            // alert(nRow.toSource());
            oTable.fnDeleteRow(nRow);
        });

        var oTable = $('#table1').dataTable({
            // "iDisplayLength": 100,
            // "sScrollY": "260px",
            // "bJQueryUI": true,
            // "bAutoWidth": true,
            "bScrollCollapse": true,
            "bLengthChange": false,
            "bPaginate": true,
            "bFilter": false,
            "sPaginationType": "full_numbers",
            "bSort": false,
            "bInfo": true,
            "bServerSide": false,
            "bProcessing": true,
            "sAjaxSource": "<?php echo active_module_url(); ?>pst_penghapusan_kolektif/cari/",
            "sDom": '<"toolbar">fT<"clear">lrtip<"clear">',
            // "sDom": '<"H"lfr>t<"F"ip>T',
            // "aoColumns": [{
            //         sWidth: '14%',
            //         sClass: "center"
            //     },
            //     null,
            //     {
            //         sWidth: '6%',
            //         sClass: "center"
            //     },
            //     {
            //         sWidth: '10%',
            //         sClass: "right"
            //     },
            //     {
            //         sWidth: '8%',
            //         sClass: "right"
            //     },
            //     {
            //         sWidth: '10%',
            //         sClass: "right"
            //     },

            //     {
            //         sWidth: '6%',
            //         sClass: "center"
            //     },
            //     null,
            // ],
            "aoColumnDefs": [{
                    "bSortable": false,
                    "bSearchable": false,
                    "bVisible": true,
                    "aTargets": [0]
                },
                {
                    "bSortable": false,
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
                {
                    "bSortable": false,
                    "bSearchable": false,
                    "bVisible": true,
                    "aTargets": [8]
                },
                {
                    "bSortable": false,
                    "bSearchable": false,
                    "bVisible": false,
                    "aTargets": [9]
                }
            ],
            "oTableTools": {
                "sSwfPath": "<?php echo base_url() ?>assets/datatables/extras/TableTools/media/swf/copy_csv_xls_pdf.swf"
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
                var iTotalPokok = 0;
                var iTotalDenda = 0;
                var iTotalDendaPeng = 0;
                var iTotalJumlah = 0;
                if (aaData.length > 0) {
                    for (var i = 0; i < aaData.length; i++) {
                        // alert(aaData[i][2]);
                        iTotalPokok += parseInt(aaData[i][2].replace(/[^0-9]/gi, ''));
                        iTotalDenda += parseInt(aaData[i][3].replace(/[^0-9]/gi, ''));
                        iTotalDendaPeng += parseInt(aaData[i][5].replace(/[^0-9]/gi, ''));
                        iTotalJumlah += parseInt(aaData[i][6].replace(/[^0-9]/gi, ''));
                    }
                }
                /*
                 * render the total row in table footer
                 */
                var nCells = nRow.getElementsByTagName('th');
                nCells[2].innerHTML = numberWithCommas(iTotalPokok);
                nCells[3].innerHTML = numberWithCommas(iTotalDenda);
                nCells[5].innerHTML = numberWithCommas(iTotalDendaPeng);
                nCells[6].innerHTML = numberWithCommas(iTotalJumlah);
            },
        });

        $("div.toolbar").append($('.asd'));

        $("#btn_cari").click(function() {

            $("#btn_simpan,#btn_cetak, #btn_cetak2, #btn_cetak5, #btn_cetak3, #btn_cetak4").attr('disabled', 'disabled');

            var tahun = $("#blok_tahun").val();
            var bundel = $("#blok_bundel").val();
            var urut = $("#blok_urut").val();
            if (tahun && bundel && urut) {
                saved = null;
                cetak = null;
                $("#btn_simpan").removeAttr('disabled');
                oTable.fnReloadAjax("<?php echo active_module_url(); ?>pst_penghapusan_kolektif/cari/" + tahun + '/' + bundel + '/' + urut);
            } else {
                alert('Harap mengisi Nomor Pelayanan dengan benar!');
            }
        });

        // $('#myform').submit(function () {
        // });

        $('#btn_simpan').click(function() {

            var tahun = $("#blok_tahun").val();
            var bundel = $("#blok_bundel").val();
            var urut = $("#blok_urut").val();

            $.ajax({
                type: 'POST',
                url: "<?php echo active_module_url('pst_penghapusan_kolektif/simpan/') ?>" + tahun + '/' + bundel + '/' + urut,
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
            ajax_download("<?php echo active_module_url('pst_penghapusan_kolektif/cetak'); ?>", {
                'dtCetak': JSON.stringify({
                    "dtCetak": cetak
                })
            });
        });

        $('#btn_cetak4').click(function() {
            ajax_download("<?php echo active_module_url('pst_penghapusan_kolektif/cetak_draft'); ?>", {
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