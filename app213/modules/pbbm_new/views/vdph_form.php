<?= $this->load->view('layouts/headers'); ?>
<?= $this->load->view(active_module() . '/sidebar'); ?>

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
                                <li class="breadcrumb-item"><?php echo $this->uri->segment(2) == 'dph' ? 'DPH - Entri Data' : 'DPH - Download dan Posting'; ?></li>
                                <li class="breadcrumb-item active">Tambah</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            if (validation_errors()) {
                echo '<blockquote><strong>Harap melengkapi data berikut :</strong>';
                echo validation_errors('<small style="color:red;">', '</small>');
                echo '</blockquote>';
            } ?>

            <div class="row">
                <div class="col-12">
                    <?= form_open($faction, array('id' => 'myform', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data')); ?>
                    <input type="hidden" name="id" value="<?php echo $dt['id'] ?>" />
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4"><?php echo $this->uri->segment(2) == 'dph' ? 'DPH - Entri Data' : 'DPH - Download dan Posting'; ?></h4>
                            <div class="row">
                                <div class="col-sm-12 col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Nomor Urut</label>
                                        <input class="form-control" type="text" name="tahun" id="tahun" value="<?php echo !empty($dt['tahun']) ? $dt['tahun'] : date('Y'); ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">‎ </label>
                                        <input class="form-control" type="text" name="kode" id="kode" value="<?php echo $dt['kode'] ?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Kecamatan</label>
                                        <select class="form-control select2" id="kd_kecamatan" name="kd_kecamatan"><?php echo $kecamatans; ?></select>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal</label>
                                        <input class="form-control" type="text" name="tgl_bayar" id="tgl_bayar" value="<?php echo !empty($dt['tgl_bayar']) ? $dt['tgl_bayar'] : date('d-m-Y'); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Kelurahan</label>
                                        <select class="form-control select2" id="kd_kelurahan" name="kd_kelurahan"><?php echo $kelurahans; ?></select>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Penanggungjawab</label>
                                        <select class="form-control select2" id="pejabat1_id" name="pejabat1_id">
                                            <?php
                                            foreach ($users as $r) {
                                                $selected = '';
                                                if ($dt['pejabat1_id'] > 0 && $r->id == $dt['pejabat1_id'])
                                                    $selected = " selected";
                                                else
                                        if ((int)$r->id === (int)sipkd_user_id()) $selected = " selected";

                                                echo "<option value=\"" . $r->id . "\" $selected>" . $r->nama . "</option>\n";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Uraian</label>
                                        <input class="form-control" type="text" name="nama" id="nama" value="<?php echo $dt['nama'] ?>" />
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Petugas</label>
                                        <select class="form-control select2" id="pejabat2_id" name="pejabat2_id" class="input-medium">
                                            <?php
                                            foreach ($users2 as $r) {
                                                $selected = '';
                                                if ($dt['pejabat2_id'] > 0 && $r->id == $dt['pejabat2_id'])
                                                    $selected = " selected";
                                                else
                                        if ((int)$r->id === (int)sipkd_user_id()) $selected = " selected";
                                                echo "<option value=\"" . $r->id . "\" $selected>" . $r->nama . "</option>\n";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Data Detail</h4>
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div class="input-group w-auto">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-end-0">Range NOP/Blok</span>
                                    </div>
                                    <input class="form-control input" style="width:150px;" type="text" name="propdati" id="propdati" value="<?php echo KD_PROPINSI . "." . KD_DATI2 . "." . $kec_kd . "." . $kel_kd . "."; ?>" readonly />
                                </div>
                                <input class="form-control input" style="width:110px;" type="text" name="range1" id="range1" value="" placeholder='blok.no_urut' <?php echo $this->uri->segment(3) == 'edit' ? 'autofocus' : '' ?> />
                                <div class="col-xs-1">
                                    <span>s.d</span>
                                </div>
                                <input class="form-control input" style="width:110px;" type="text" name="range2" id="range2" value="" placeholder='blok.no_urut' />
                            </div>
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div class="input-group w-auto">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-end-0">Tahun</span>
                                    </div>
                                    <input class="form-control input" style="width:80px;" type="text" name="tahun1" id="tahun1" value="<?php echo date('Y'); ?>" />
                                </div>
                                <button id="btn_dth_new" name="btn_dth_new" class="btn btn-success waves-effect waves-light" type="button">Tambahkan ke Daftar</button>
                            </div>
                            <hr>
                            <table id="tableDtl" class="table table-striped table-nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>NOP - Tahun</th>
                                        <th>Pemilik</th>
                                        <th>Tgl Jth Tempo</th>
                                        <th>Pokok</th>
                                        <th>Denda</th>
                                        <th>Bayar</th>
                                        <th>Batal</th>
                                        <th>d1</th>
                                        <th>d2</th>
                                        <th>d3</th>
                                        <th>d4</th>
                                        <th>d5</th>
                                        <th>d6</th>
                                        <th>d7</th>
                                        <th>d8</th>
                                        <th>d9</th>
                                        <th>d10</th>
                                        <th>d11</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3">JUMLAH</td>
                                        <td><span id="pokok">&nbsp;</span></td>
                                        <td><span id="denda">&nbsp;</span></td>
                                        <td><span id="total">&nbsp;</span></td>
                                        <td></td>
                                        <td>d1</td>
                                        <td>d2</td>
                                        <td>d3</td>
                                        <td>d4</td>
                                        <td>d5</td>
                                        <td>d6</td>
                                        <td>d7</td>
                                        <td>d8</td>
                                        <td>d9</td>
                                        <td>d10</td>
                                        <td>d11</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <button type="submit" class="btn btn-primary waves-effect waves-light" type="button">Simpan</button>
                                <button id="btn_cancel" name="btn_cancel" class="btn btn-danger waves-effect waves-light" type="button">Batal</button>
                            </div>
                        </div>
                    </div>
                    <?= form_close(); ?>
                </div>
            </div>
        </div>
    </div>
    <?= $this->load->view('layouts/foot.php'); ?>
</div>
<?= $this->load->view('layouts/scripts.php'); ?>

<script>
    var oTableDtl;

    $(document).ready(function() {
        oTableDtl = $('#tableDtl').dataTable({
            "aoColumnDefs": [{
                    "aTargets": [7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17],
                    "bSearchable": false,
                    "bVisible": false,
                    "sWidth": "",
                    "sClass": ""
                },
                {
                    "aTargets": [3, 4, 5],
                    "bSearchable": false,
                    "bVisible": true,
                    "sWidth": "",
                    "sClass": "right"
                },
            ],
            "iDisplayLength": 10,
            // "sScrollY": "180px",
            "bScrollCollapse": false,
            // "bJQueryUI": true,
            "bFilter": false,
            "bPaginate": true,
            "sPaginationType": "full_numbers",
            "bInfo": true,
            "bServerSide": false,
            "bProcessing": true,
            "sDom": '<"toolbar">frtip',
            "sAjaxSource": "<?php echo active_module_url($this->uri->segment(2)) . 'grid_detail/' . $dt['id']; ?>",
            "fnServerData": function(sSource, aoData, fnCallback) {
                $.getJSON(sSource, aoData, function(json) {
                    //Here you can do whatever you want with the additional data
                    console.dir(json);
                    $('#pokok').html(json['pokok']);
                    $('#denda').html(json['denda']);
                    $('#total').html(json['total']);

                    //Call the standard callback to redraw the table
                    fnCallback(json);
                });
            },
        });

        $('#btn_cancel').click(function() {
            var kec_kd = $("#kd_kecamatan").val();
            var kel_kd = $("#kd_kelurahan").val();
            window.location = '<?php echo active_module_url($this->uri->segment(2)); ?>?kec_kd=' + kec_kd + '&kel_kd=' + kel_kd;
        });

        $("#tgl_bayar").datepicker({
            dateFormat: 'dd-mm-yy',
            changeMonth: true,
            changeYear: true
        });

        $("#kd_kecamatan").change(function() {
            var kec_kd = $("#kd_kecamatan").val();
            $.ajax({
                url: "<?php echo active_module_url($this->uri->segment(2)) ?>get_kelurahan/" + kec_kd,
                success: function(data) {
                    var select = $('#kd_kelurahan');
                    select.html(data);

                    $("#kd_kelurahan").trigger('change');
                },
                error: function(xhr, desc, er) {
                    alert(er);
                }
            });
        });

        $("#kd_kelurahan").change(function() {
            var kec_kd = $("#kd_kecamatan").val();
            var kel_kd = $("#kd_kelurahan").val();
            $.ajax({
                url: "<?php echo active_module_url($this->uri->segment(2)) ?>get_pejabat/" + kec_kd + "/" + kel_kd,
                success: function(data) {
                    var select = $('#pejabat1_id');
                    select.html(data);
                    var select = $('#pejabat2_id');
                    select.html(data);
                },
                error: function(xhr, desc, er) {
                    alert(er);
                }
            });
        });

        $('#btn_dth_new').click(function(e) {
            e.preventDefault();

            var pd = $('#propdati').val();
            var r1 = $('#range1').val();
            var r2 = $('#range2').val();
            var th = $('#tahun1').val();
            var is_nop = 0;

            if (r1 == '' || th == '') {
                alert('Harap isi kolom Range NOP/Blok dan Tahun dengan benar!');
                $("#range1").focus();
                return;
            }

            // if (!(pd.length+r1.length==22 || pd.length+r1.length==17)) {
            if (!(pd.length + r1.length == 24 || pd.length + r1.length == 17)) {
                alert('Range NOP/Blok data tidak benar!');
                $("#range1").focus();
                return;
            } else {
                if (pd.length + r1.length == 24) is_nop = 1;
            }

            $.ajax({
                url: "<?php echo active_module_url($this->uri->segment(2)) ?>get_nop_blok/" + th + "/" + is_nop + "/" + pd + r1 + "/" + r2,
                async: false,
                success: function(j) {
                    if (j == false) {
                        alert('Data SPPT tidak ditemukan.');
                        $("#range1").focus();
                        return;
                    }

                    var data = $.parseJSON(j);
                    $.each(data, function(i, val) {
                        var rows = oTableDtl.fnGetNodes();
                        for (var i = 0; i < rows.length; i++)
                            if ($(rows[i]).find("td:eq(0)").html() == val['nop_thn']) return true;;

                        var c;
                        $.ajax({
                            url: "<?php echo active_module_url($this->uri->segment(2)) ?>cek_nop_thn/" + val['nop_thn'],
                            async: false,
                            success: function(ret) {
                                c = ret;
                            }
                        });
                        if (c == 'ada') return true;

                        var aiNew = oTableDtl.fnAddData([
                            val['nop_thn'],
                            val['pemilik'],
                            val['tanggal'],
                            val['pokok'],
                            val['denda1'],
                            val['bayar'],
                            '<a class="delete" href="">Hapus</a>',

                            val['kd_kecamatan'],
                            val['kd_kelurahan'],
                            val['kd_blok'],
                            val['no_urut'],
                            val['kd_jns_op'],
                            val['thn_pajak_sppt'],
                            val['pembayaran_ke'],
                            val['denda'],
                            val['jml_yg_dibayar'],
                            val['tgl_rekam_byr'],
                            val['nip_rekam_byr'],
                        ]);
                        var nRow = oTableDtl.fnGetNodes(aiNew[0]);

                        // var rows = oTableDtl.fnGetNodes();
                        // var denda = 0;
                        // for(var i=0;i<rows.length;i++) {
                        // denda = denda + parseInt($(rows[i]).find("td:eq(15)").html());
                        // alert($(rows[i]).find("td:eq(14)").html());
                        // }
                        // $('#denda').html(denda);
                    });
                },
                error: function(xhr, desc, er) {
                    alert(er);
                }
            });
            $("#range1").focus();
        });

        $('#tableDtl a.delete').live('click', function(e) {
            e.preventDefault();

            var nRow = $(this).parents('tr')[0];
            oTableDtl.fnDeleteRow(nRow);
        });

        $("#range1").focus(function(e) {
            // e.preventDefault();
        });

        $("#range1").keyup(function(e) {
            $("#range2").val($(this).val());
            if (e.which == '13' && $(this).val() != '' && $(this).is(":focus")) {
                e.preventDefault();
                $("#range2").focus();
            }
        });

        $("#range2").keypress(function(e) {
            if (e.which == '13' && $(this).val() != '') {
                e.preventDefault();
                $("#tahun1").focus();
            }
        });
        /*
        $("#tahun1").keypress(function(e) {
            e.preventDefault();
            if (e.which == '13' && $(this).val() != '') {
                $("#btn_dth_new").trigger('click');
            }
        });
         */
        var keckel_change = function() {
            var pd = $('#propdati').val();
            var kc = $('#kd_kecamatan').val();
            var kl = $('#kd_kelurahan').val();
            var new_val = pd.substr(0, 6) + kc + '.' + kl + '.';
            $("#propdati").val(new_val);
        }

        $("#kd_kecamatan, #kd_kelurahan").change(keckel_change).keypress(keckel_change);

        $("#myform").submit(function(eventObj) {
            if ($('#nama').val() == '' || $('#tgl_bayar').val() == '' || $('#pejabat1_id').val() == '' || $('#pejabat2_id').val() == '') {
                alert('Harap melengkapi isian data!');
                return false;
            }
            if ($('#kd_kecamatan').val() == '000' || $('#kd_kelurahan').val() == '000') {
                alert('Silahkan pilih data kecamatan/kelurahan!');
                return false;
            }
            $('#kd_kecamatan').removeAttr('disabled');
            $('#kd_kelurahan').removeAttr('disabled');

            var data = JSON.stringify({
                "dtDetail": oTableDtl.fnGetData()
            });
            $('<input type="hidden" name="dtDetail"/>').val(data).appendTo('#myform');
            return true;
        });
    });

    $(document).keypress(function(e) {
        if (e.which == '13') {
            e.preventDefault();
        }
    });
</script>

<?= $this->load->view('layouts/footer.php'); ?>