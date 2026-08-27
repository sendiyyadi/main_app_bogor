<?= $this->load->view('layouts/headers'); ?>
<?= $this->load->view(active_module() . '/layouts/sidebar'); ?>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Cetak STTS per Blok SPPT</h4>
                        <div class="page-title-right" id="test">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">STTS</a>
                                </li>
                                <li class="breadcrumb-item active">Cetak STTS per Blok SPPT</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <?php echo form_open("", array('id' => 'rptform', 'target' => '_blank', 'style' => 'display:none')); ?>
            <input type="hidden" id="data" name="data">
            <?php echo form_close(); ?>

            <?php
            if (validation_errors()) {
                echo '<blockquote><strong>Harap melengkapi data berikut :</strong>';
                echo validation_errors('<small style="color:red;">', '</small>');
                echo '</blockquote>';
            } ?>

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
                                        <span class="input-group-text rounded-end-0">Blok Objek Pajak</span>
                                    </div>
                                    <input type="text" id="blok" class="form-control" name="blok" autocomplete="off" placeholder="Masukan NOP" />
                                </div>
                                <div class="input-group w-auto">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-end-0">Tahun</span>
                                    </div>
                                    <input type="text" id="tahun" class="form-control" name="tahun" autocomplete="off" placeholder="Masukan Tahun" maxlength="4" />
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
                                        <th>Pengurangan</th>
                                        <th>Jumlah</th>
                                        <th>Nama WP</th>
                                        <th>Alamat WP</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
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
    // $.fn.dataTableExt.oApi.fnReloadAjax = function(oSettings, sNewSource, fnCallback, bStandingRedraw) {
    $.fn.dataTableExt.oApi.reload = function(oSettings, sNewSource, fnCallback, bStandingRedraw) {
        if (typeof sNewSource != 'undefined' && sNewSource != null) {
            oSettings.sAjaxSource = sNewSource;
        }

        /* Server-side processing should just call fnDraw */
        if (oSettings.oFeatures.bServerSide) {
            this.fnDraw();
            return;
        }

        this.oApi._fnProcessingDisplay(oSettings, true);
        var that = this;
        var iStart = oSettings._iDisplayStart;
        var aData = [];

        this.oApi._fnServerParams(oSettings, aData);

        oSettings.fnServerData.call(oSettings.oInstance, oSettings.sAjaxSource, aData, function(json) {
            /* Clear the old information from the table */
            that.oApi._fnClearTable(oSettings);

            /* Got the data - add it to the table */
            var aData = (oSettings.sAjaxDataProp !== "") ?
                that.oApi._fnGetObjectDataFn(oSettings.sAjaxDataProp)(json) : json;

            for (var i = 0; i < aData.length; i++) {
                that.oApi._fnAddData(oSettings, aData[i]);
            }

            oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();

            if (typeof bStandingRedraw != 'undefined' && bStandingRedraw === true) {
                oSettings._iDisplayStart = iStart;
                that.fnDraw(false);
            } else {
                that.fnDraw();
            }

            that.oApi._fnProcessingDisplay(oSettings, false);

            /* Callback user function - for event handlers etc */
            if (typeof fnCallback == 'function' && fnCallback != null) {
                fnCallback(oSettings);
            }
        }, oSettings);
    };

    var dID;
    var oTable;
    var xRow;
    var xRow2;
    var asInitVals = new Array();

    $(document).ready(function() {
        oTable = $('#table1').dataTable({
            // "iDisplayLength": 15,
            // "bJQueryUI": true,
            // "sScrollY": "325px",
            "bScrollCollapse": true,
            "bPaginate": true,
            "sPaginationType": "full_numbers",
            "bFilter": false,
            "bLengthChange": false,
            // "sDom": '<"top">rt<"bottom"ilp><"clear">',
            "sDom": '<"toolbar">fT<"clear">lrtip<"clear">',
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
                }
            ],
            // "aoColumns": [{
            //         "sWidth": "15%"
            //     },
            //     {
            //         "sWidth": "10%"
            //     },
            //     {
            //         "sWidth": "10%",
            //         "sClass": "right"
            //     },
            //     {
            //         "sWidth": "10%",
            //         "sClass": "right"
            //     },
            //     {
            //         "sWidth": "10%",
            //         "sClass": "right"
            //     },
            //     {
            //         "sWidth": "10%",
            //         "sClass": "right"
            //     },
            //     {
            //         "sWidth": "20%"
            //     },
            //     {
            //         "sWidth": "25%"
            //     }
            // ],
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
            "bSort": false,
            "bInfo": true,
            "bServerSide": false,
            "bProcessing": true,
            "sAjaxSource": "<?php echo active_module_url(); ?>bayar_by_blok_thn/cari/"
            /*"fnFooterCallback": function( nFoot, aData, iStart, iEnd, aiDisplay ) {
                nFoot.getElementsByTagName('th')[2].innerHTML = aData[10];
                nFoot.getElementsByTagName('th')[3].innerHTML = 10;
                nFoot.getElementsByTagName('th')[4].innerHTML = 15;
            }*/
        });

        $("div.toolbar").append($('.asd'));

        $("thead input").keypress(function(event) {
            if (event.which == 13) {
                oTable.fnFilter(this.value, $("thead input").index(this));
            }
        });

        /*
         * Support functions to provide a little bit of 'user friendlyness' to the textboxes in
         * the footer
         */
        $("thead input").each(function(i) {
            asInitVals[i] = this.value;
        });

        $("thead input").focus(function() {
            if (this.className == "search_init") {
                this.className = "";
                this.value = "";
            }
        });

        $("thead input").blur(function(i) {
            if (this.value == "") {
                this.className = "search_init";
                this.value = asInitVals[$("thead input").index(this)];
            }
        });

    });

    $(document).ready(function() {

        var saved = null;
        var cetak = null;

        $("#btn_cari").click(function() {
            // alert('ok');
            $("#btn_simpan,#btn_cetak, #btn_cetak2, #btn_cetak5,#btn_cetak3,#btn_cetak4").attr('disabled', 'disabled');

            var blok = $("#prefix").val() + $("#blok").val();
            var thn = $("#tahun").val();
            if (blok && thn) {
                saved = null;
                cetak = null;
                $("#btn_simpan").removeAttr('disabled');

                document.getElementById("blok").disabled = true;
                document.getElementById("tahun").disabled = true;

                oTable.fnReloadAjax("<?php echo active_module_url(); ?>bayar_by_blok_thn/cari/" + blok + '/' + thn);
            } else {
                alert('Harap mengisi Blok dan Tahun dengan benar!');
            }
        });

        $("#btn_reset").click(function() {
            $("#btn_simpan,#btn_cetak, #btn_cetak2, #btn_cetak5,#btn_cetak3,#btn_cetak4").attr('disabled', 'disabled');

            $("#blok").val("");
            $("#tahun").val("");
            document.getElementById("blok").disabled = false;
            document.getElementById("tahun").disabled = false;
            //Reset Data
            $('#table1').dataTable().fnClearTable();
        });

        $('#myform').submit(function() {
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: $(this).serialize(),
                async: false,
                beforeSend: function() {},
                success: function(msg) {
                    data = JSON.parse(msg);
                    if (data['simpad'] != 'gagal') {
                        saved = data['saved'];
                        cetak = data['cetak'];
                        $('#data').val(JSON.stringify(saved));
                        alert('Data telah disimpan.');
                    } else
                        alert('Data gagal disimpan.');
                }
            });
            return false;
        });

        $('#btn_simpan').click(function() {
            $('#myform').submit();
            $("#btn_cetak,#btn_cetak2,#btn_cetak5,#btn_cetak3,#btn_cetak4").removeAttr('disabled');
            $(this).attr('disabled', 'disabled');
        });

        $('#btn_cetak').click(function() {
            ajax_download("<?php echo active_module_url('bayar_by_blok_thn/cetak'); ?>", {
                'dtCetak': JSON.stringify({
                    "dtCetak": cetak
                })
            });
        });

        $('#btn_cetak4').click(function() {
            ajax_download("<?php echo active_module_url('bayar_by_blok_thn/cetak_draft'); ?>", {
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