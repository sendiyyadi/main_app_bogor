<?= $this->load->view('layouts/headers'); ?>
<?= $this->load->view(active_module() . '/layouts/sidebar'); ?>

<style>
    .bar {
        background-color: #B4F5B4;
        width: 0%;
        height: 20px;
        border-radius: 3px;
    }

    .percent {
        /* position: absolute; */
        display: inline-block;
        top: 3px;
        left: 48%;
    }
</style>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Cetak STTS by Upload NOP</h4>
                        <div class="page-title-right" id="test">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">STTS</a>
                                </li>
                                <li class="breadcrumb-item active">Cetak STTS by Upload NOP</li>
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
                            <?php //echo form_open($faction, array('id' => 'myform', 'class' => 'form-horizontal', 'method' => 'get'));
                            ?>
                            <?php echo form_open($faction, array('id' => 'myform', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data'));
                            ?>
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div class="col-sm-1">
                                    <span>File Sumber</span>
                                </div>
                                <div class="input-group w-auto">
                                    <input class="form-control btn btn-success waves-effect waves-light" type="file" id="userfile" name="userfile[]" accept=".csv, .txt" />
                                </div>
                                <button type="submit" class="btn btn-info waves-effect waves-light" id="btn_upload" name="btn_upload"><i class="uil-file-upload"></i> Upload</button>
                                <div class="col-md-2">
                                    <span>Upload Terakhir : </span>
                                    <span class="text-danger" id="last_upload" name="last_upload">No File</span>
                                </div>
                            </div>
                            <!-- <hr>
                            <div class="progress">
                                <div class="bar progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"><span class="percent">0%</span></div>
                            </div> -->
                            <hr>
                            <div class="progress">
                                <div class="bar"></div>
                                <div class="percent">0%</div>
                            </div>
                            <hr>
                            <div class="d-flex align-items-center gap-2">
                                <button type="button" class="btn btn-primary waves-effect waves-light" id="btn_simpan" name="btn_simpan" disabled><i class="uil-money-bill"></i> Bayar</button>
                                <button type="button" class="btn btn-success waves-effect waves-light" id="btn_cetak" name="btn_cetak"><i class="uil-print"></i> Cetak (Draft)</button>
                                <button type="button" class="btn btn-success waves-effect waves-light" id="btn_cetak4" name="btn_cetak4"><i class="uil-print"></i> Cetak Bank (Draft)</button>
                                <input class="input" type="hidden" id="tgljam" name="tgljam" value="<?= $tgljam; ?>" />
                            </div>
                            <?php form_close() ?>
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
    // function buat refresh
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

    $(document).ready(function() {

        // console.log(jQuery.fn.jquery);

        var saved = null;
        var cetak = null;
        var bar = $('.bar');
        var percent = $('.percent');
        var status = $('#status');

        oTable = $('#table1').dataTable({
            // "iDisplayLength": 8,
            "aaSorting": [
                [0, "desc"]
            ],
            // "bJQueryUI": true,
            "bProcessing": true,
            // "sScrollY": "325px",
            "bScrollCollapse": true,
            "bPaginate": false,
            "sPaginationType": "full_numbers",
            "bFilter": false,
            "bLengthChange": false,
            "sDom": '<"toolbar">fT<"clear">lrtip<"clear">',
            "aoColumnDefs": [{
                "bSortable": false,
                "bSearchable": false,
                "bVisible": true,
                "aTargets": [0, 1, 2, 3, 4, 5, 6, 7]
            }, ],
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
        });

        $("div.toolbar").append($('.asd'));

        // ----
        $('#myform').ajaxForm({

            beforeSubmit: function() {

                if (!$('#userfile').val()) {
                    alert('Silahkan pilih kembali, file yang akan diupload.....');
                    return false;
                }
            },

            beforeSend: function() {
                $("#btn_simpan,#btn_cetak,#btn_cetak6, #btn_cetak2, #btn_cetak5,#btn_cetak3,#btn_cetak4").attr('disabled', 'disabled');

                status.empty();
                var percentVal = '0%';
                bar.width(percentVal)
                percent.html(percentVal);

                oTable.fnClearTable();
            },
            uploadProgress: function(event, position, total, percentComplete) {
                var percentVal = percentComplete + '%';
                bar.width(percentVal)
                percent.html(percentVal);
                console.log(percentVal, position, total);
            },
            success: function(response) {
                var percentVal = '100%';
                bar.width(percentVal)
                percent.html(percentVal);

                var file_upload_long = $('#userfile').val(); // result selalu C:\fakepath\... nama filenya 
                var file_upload = file_upload_long.substr(12, 150);

                var tgljam_prs = $('#tgljam').val();
                var file_prs = tgljam_prs + file_upload;

                var params = {
                    p_tgljam_prs: tgljam_prs,
                    p_file_upload: file_upload,
                };

                var data_params = decodeURIComponent($.param(params));
                oTable.fnReloadAjax("<?php echo active_module_url(); ?>upload_nop/read_upload_recs/?" + data_params);

                alert(response);
                //
                $("#btn_simpan").removeAttr('disabled');
                // arig 2021-02-27
                $('#userfile').val(""); // setelah di upload , file upload dikosongkan biar ga langsung di ulang..
                //reset label nama file
                $('#userfile').parent().next('.file-input-name').remove();

                document.getElementById("last_upload").innerHTML = file_upload;
            },
            complete: function(xhr) {
                // alert(xhr.responseText);
            },
            error: function(xhr) {
                alert(xhr.responseText);
            },
        });

        $('#btn_simpan').click(function() {
            // button bayar
            $.ajax({
                type: 'POST',
                url: "<?php echo active_module_url('upload_nop/simpan') ?>",
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
                    } else {
                        alert('Data gagal disimpan.');
                    }
                }
            });

            $(this).attr('disabled', 'disabled');

        });

        $('#btn_cetak').click(function() {
            ajax_download("<?php echo active_module_url('upload_nop/cetak'); ?>", {
                'dtCetak': JSON.stringify({
                    "dtCetak": cetak
                })
            });
        });

        $('#btn_cetak4').click(function() {
            ajax_download("<?php echo active_module_url('upload_nop/cetak_draft'); ?>", {
                'dtCetak': JSON.stringify({
                    "dtCetak": cetak
                })
            });
        });

        $('input[type=file]').bootstrapFileInput();

    });

    $(document).keypress(function(event) {
        if (event.which == '13') {
            event.preventDefault();
        }
    });
    $('#rptform').submit(function() {
        return false;
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

        iframe_html = "<html><head></head><body><form method='POST' action='" + url + "'>"

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