<?= $this->load->view('layouts/headers'); ?>
<?= $this->load->view(active_module() . '/layouts/sidebar'); ?>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Kirim SPPT</h4>
                        <div class="page-title-right" id="test">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">E-Adm</a>
                                </li>
                                <li class="breadcrumb-item active">Kirim SPPT</li>
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
                                        <span class="input-group-text rounded-end-0">Status</span>
                                    </div>
                                    <?php echo $select_status; ?>
                                </div>
                                <div class="input-group w-auto">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-end-0">Kecamatan</span>
                                    </div>
                                    <?php echo $select_kecamatan; ?>
                                </div>
                                <div class="input-group w-auto">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-end-0">Kelurahan</span>
                                    </div>
                                    <?php echo $select_kelurahan; ?>
                                </div>
                                <div class="input-group w-auto">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-end-0">NOP</span>
                                    </div>
                                    <input type="text" id="c_nop" class="form-control" name="c_nop" style="width:200px">
                                    <input type="hidden" id="token" class="form-control" name="token" value="<?= $token_api ?>">
                                </div>
                            </div>

                            <div style="margin-top:10px;">
                                <button onclick="reload_grid('1');" class="btn btn-primary" id="btn_cari">Cari</button>
                                <button onclick="reload_grid('2');" class="btn btn-info" id="btn_reset">Reset</button>
                                <!-- <button class="btn btn-warning" id="btn_kirim">Kirim</button> -->
                                <button class="btn btn-warning" id="btn_kirim_api">Kirim</button>
                                <button class="btn btn-success" onclick="btn_cari_cetak_sim()" data-toggle="modal" id="">Kirim Simultan</button>
                            </div>

                            <br>
                            <table class="table table-striped table-nowrap" id="table1" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>rowid</th>
                                        <th>CHK</th>
                                        <th>NOP</th>
                                        <th>ALAMAT OP</th>
                                        <th>NIK WP</th>
                                        <th>NAMA WP</th>
                                        <th>ALAMAT WP</th>
                                        <th>KELURAHAN WP</th>
                                        <th>KOTA WP</th>
                                        <th>STS REG</th>
                                        <th>STS</th>
                                        <th>NIKNOP</th>
                                        <th>FLG_SPPT</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

                <!-- Modal -->
                <!-- Modal Cetak simultan -->
                <div id="cuDialogCetakSimultan" class="modal" style="width:1100px; height:auto; margin-top:10px; margin-left:120px; background:white;" tabindex="-1" role="dialog" aria-labelledby="cuDialogCetakSimultanLabel" aria-hidden="true" data-backdrop="static">
                    <div class="modal-header">
                        <h3 id="cuDialogCetakSimultanLabel">Kirim SPPT Simultan</h3>
                        <input class="input" type="hidden" style="width:150px;" name="varid_ctk" id="varid_ctk" placeholder="Proses" />
                    </div>

                    <div class="modal-body">

                        <div class="control-group">
                            <div class="row">

                                <div class="x_src" style="margin-left:10px; width:45px;">
                                    <div class="controls">Status</div>
                                </div>
                                <div class="x_src">
                                    <div class="controls"><?php echo $select_status_sim; ?></div>
                                </div>

                                <div class="x_src" style="margin-left:10px; width:25px;">
                                    <div class="controls">Kec</div>
                                </div>
                                <div class="x_src">
                                    <div class="controls"><?php echo $select_kecamatan_sim; ?></div>
                                </div>

                                <div class="x_src" style="margin-left:10px; width:25px;">
                                    <div class="controls">Kel</div>
                                </div>
                                <div class="x_src">
                                    <div class="controls"><?php echo $select_kelurahan_sim; ?></div>
                                </div>
                                <div class="x_src" style="margin-left:10px; width:30px;">
                                    <div class="controls">Nop</div>
                                </div>
                                <div class="controls">
                                    <input type="text" id="c_nop_sim" class="form-control" name="c_nop_sim">
                                </div>

                                <div class="x_src" style="margin-left:10px">
                                    <button class="btn btn-primary" id="btn_kirim_sppt_sim">Cari</button>
                                </div>
                                <div class="x_src" style="margin-left:5px">
                                    <button class="btn btn-info" id="btn_refresh_ctk_sim">Reset</button>
                                </div>
                            </div>

                        </div>

                        <table class="table table-bordered" id="table_cs">
                            <thead>
                                <tr>
                                    <th>rowid</th>
                                    <th>CHK</th>
                                    <th>NOP</th>
                                    <th>ALAMAT OP</th>
                                    <th>NIK WP</th>
                                    <th>NAMA WP</th>
                                    <th>ALAMAT WP</th>
                                    <th>KELURAHAN WP</th>
                                    <th>KOTA WP</th>
                                    <th>STS REG</th>
                                    <th>STS</th>
                                    <th>NIKNOP</th>
                                    <th>FLG_SPPT</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>

                    <div class="modal-footer" style="width:600px;">
                        <button id="btn_kirim_sppt_simultan" class="btn btn-secondary"> Kirim SPPT Simultan</button>
                        <!-- <button id="btn_proses_cetak_spsimultan" class="btn btn-secondary">Cetak SP Simultan</button> -->
                        <button class="btn btn-info" data-dismiss="modal" aria-hidden="true">Batal</button>
                    </div>

                </div>
                <!-- End Modal -->
            </div>

        <!-- TUTUP CONTAINER-FLUID -->
        </div>
    </div>
    <?= $this->load->view('layouts/foot.php'); ?>
</div>
<?= $this->load->view('layouts/scripts.php'); ?>

<?= $this->load->view('layouts/footer.php'); ?>


<script>
    var mID;
    var mNIK;
    var mSTS;
    var oTable;
    var tmp_id_sim = [];
    var mniknop;
    var flg_bsre;

    function reload_grid(mode) {
        // mode 1=cari  2=reset

        var status_kd = document.getElementById('status_kd');
        var kec = document.getElementById('kd_kecamatan');
        var kel = document.getElementById('kd_kelurahan');

        if (mode == '2') {
            status_kd.value = '999';
            status_kd.dispatchEvent(new Event('change'));

            kec.value = '999999';
            kec.dispatchEvent(new Event('change'));

            kel.value = '999999';
            kel.dispatchEvent(new Event('change'));
            $('#c_nop').val('');
            // c_nop.dispatchEvent(new Event('change'));
        }

        var c_nop = document.getElementById('c_nop').value;
        var statuskds = status_kd.options[status_kd.selectedIndex].value;
        var kec = kec.options[kec.selectedIndex].value;
        var kel = kel.options[kel.selectedIndex].value;

        var params = {
            status_kd: statuskds,
            kec: kec,
            kel: kel,
            c_nop: c_nop,
        };
        var data_params = decodeURIComponent($.param(params));
        // alert(data_params);
        oTable.fnReloadAjax("<?php echo active_module_url(); ?>kirim_sppt/grid/?" + data_params);
    }
    // function reload_grid() {
    //     var status_kd = document.getElementById('status_kd');
    //     var statuskd = status_kd.options[status_kd.selectedIndex].value;
    //     var kec = document.getElementById('kd_kecamatan');
    //     var kel = document.getElementById('kd_kelurahan');
    //     kec.value = '999999';
    //     kec.dispatchEvent(new Event('change'));

    //     kel.value = '999999';
    //     kel.dispatchEvent(new Event('change'));
    //     var params = {
    //         status_kd: statuskd,
    //         kec: kec,
    //         kel: kel,
    //     };

    //     var data_params = decodeURIComponent($.param(params));
    // }

    function f_chg_kec_all(kec_id) {
        // var select = $('#kd_kelurahan');
        // select.append($('<option />', { value: '999999', text: 'Semua Kel' }));
        $.ajax({
            url: "<?php echo active_module_url() ?>kirim_sppt/f_chg_kec_all/" + kec_id,
            success: function(j) {
                var data = $.parseJSON(j);
                var select = $('#kd_kelurahan');

                select.html("");
                $.each(data, function(i, val) {
                    select.append($('<option />', {
                        value: val['KD_KELURAHAN'],
                        text: val['NM_KELURAHAN']
                    }));
                });
            },
            error: function(xhr, desc, er) {
                alert(er);
            }
        });
    }
    function f_chg_kec_all_sim(kec_id) {
        // var select = $('#kd_kelurahan');
        // select.append($('<option />', { value: '999999', text: 'Semua Kel' }));
        $.ajax({
            url: "<?php echo active_module_url() ?>kirim_sppt/f_chg_kec_all_sim/" + kec_id,
            success: function(j) {
                var data = $.parseJSON(j);
                var select = $('#kd_kelurahan_sim');

                select.html("");
                $.each(data, function(i, val) {
                    select.append($('<option />', {
                        value: val['KD_KELURAHAN'],
                        text: val['NM_KELURAHAN']
                    }));
                });
            },
            error: function(xhr, desc, er) {
                alert(er);
            }
        });
    }

    function btn_cari_cetak_sim() {

        var yyy = new Date();

        var jam = yyy.getHours();
        var menit = yyy.getMinutes();
        var detik = yyy.getSeconds();

        var bulan = (yyy.getMonth() + 1);
        var tanggal = yyy.getDate();
        bulan = bulan < 10 ? '0' + bulan : bulan;
        tanggal = tanggal < 10 ? '0' + tanggal : tanggal;
        jam = jam < 10 ? '0' + jam : jam;
        menit = menit < 10 ? '0' + menit : menit;
        detik = detik < 10 ? '0' + detik : detik;

        var proses_id = yyy.getFullYear() + '' + bulan + '' + tanggal + '' + jam + '' + menit + '' + detik;

        document.getElementById('varid_ctk').value = proses_id;
        //document.getElementById('prm_tgl_sk_sim').value= '';
        reload_grid_cetak_simultan();

        $('#cuDialogCetakSimultan').modal('show');

    }

    function reload_grid_cetak_simultan() { // EdSen 3-7-18

        // model ==>> 1=select all  2=reset all
        var model_id = 0;
        var kec = $('#kd_kecamatan_sim').val();
        var kel = $('#kd_kelurahan_sim').val();
        var status_kd = $('#status_kd_sim').val();
        var proses_id = $('#varid_ctk').val();
        var c_nop = $('#c_nop_sim').val();
        // alert ('tes'+c_nop);
        var params = {

            kec: kec,
            kel: kel,
            c_nop: c_nop,
            status_kd: status_kd,
            proses_id:proses_id
        };
        // alert (proses_id);

        var data_params = decodeURIComponent($.param(params));
        //alert(data_params);
        oTable_CS.fnReloadAjax('<?php echo active_module_url(); ?>kirim_sppt/grid_sim/?' + data_params);
    }
    function reload_grid_select_kirim_simultan(model_id) { // EdSen 3-7-18
        // model_id ==>> 1=select all  2=reset all

        var kec = $('#kd_kecamatan_sim').val();
        var kel = $('#kd_kelurahan_sim').val();
        var c_nop = $('#c_nop_sim').val();
        var status_kd = $('#status_kd_sim').val();
        var proses_id = $('#varid_ctk').val();

        // alert ('tes'+proses_id+cari_subjek);
        var params = {
            kec: kec,
            kel: kel,
            c_nop: c_nop,
            status_kd: status_kd,
            proses_id: proses_id,
            model_id: model_id,
        };
        // alert(model_id);
        var data_params = decodeURIComponent($.param(params));
        oTable_CS.fnReloadAjax('<?php echo active_module_url(); ?>kirim_sppt/grid_sim/?' + data_params);
    }


    function updateKirimSim(value, niknop) {
        niknop=BigInt(niknop);
        // alert(niknop);
        var varflag = 0;
        $('#reset_all').attr('checked', false);

        if (value == true) {
            varflag = 1;
        }

        proses_id = document.getElementById('varid_ctk').value;
        // alert(proses_id);
        update_tmp_kirim_sim(proses_id, varflag, niknop);
    }

    function update_tmp_kirim_sim(prs_id, flag, niknop) { //, thn, nopd, masa) {
        //alert(niknop);
        $.ajax({
            url: "<?php echo active_module_url() ?>kirim_sppt/update_tmp_kirim_sim/" + prs_id + "/" + flag + "/" + niknop,
            async: false,
            success: function(j) {
                ///alert('TTTTTT : '+j);
                //alert('result  : ' + g_result_data);
                //alert('msg  : ' + g_result_msg);
            },
            error: function(xhr, desc, er) {
                alert(er);
                alert('error ' + prs_id)
            }
        });
        //alert(e);
    }

    function update_sim(value, idd) { //,sptpdno,nopd,masa){           // FUNCTION CHECKBOX                _EdSen  4-7-18
        var prs_id = 0;
        var new_tmp = [];
        if (value == true) {
            prs_id = 1;
            tmp_id_sim.push(idd);
        } else {
            index_id = tmp_id_sim.indexOf(idd);
            tmp_id_sim.splice(index_id, 1);
            // tmp_id_sim = new_tmp;
        }
        console.log(tmp_id_sim);

    }

    function get_action_sim(form) {
        // document.getElementById('btn_submit_bsre').disabled = true;
        form.action = '<?php echo active_module_url(); ?>kirim_sppt/buat_sppt_sim';
    }
    $(document).ready(function() {
        oTable = $('#table1').dataTable({
            "iDisplayLength": 13,
            "sPaginationType": "full_numbers",
            //  "bJQueryUI": true,
            "bAutoWidth": false,
            "sDom": '<"toolbar">frtip',
            "aaSorting": [
                [1, "asc"]
            ],
            "aoColumnDefs": [{
                    "aTargets": [0],
                    "bSearchable": false,
                    "bVisible": false,
                    "sWidth": "",
                    "sClass": ""
                },
                {
                    "aTargets": [1],
                    "bSearchable": false,
                    "bVisible": true,
                    "sWidth": "",
                    "sClass": "",
                    "mRender": function(source, type, val) {

                        var disabled = '';
                        var checked = '';
                        var valo = "'" + val[0] + "'";
                        var cek_aray = true;
                        if (val[12] == 1 ) {
                            disabled = 'disabled';
                        //     if(flg_bsre == 0){
                        //     disabled = 'disabled';
                        // }
                        }
                        // if(flg_bsre != 1){
                        //     disabled = 'disabled';
                        // }
                        // if(cek_aray == true){
                        //         checked = 'checked';
                        // }
                        return '<input type="checkbox" value="' + val[0] + '"  name="chkbx" id="chkbx" onchange="update_sim(this.checked,' + valo + ')" ' + checked + ' ' + disabled + '>';

                    }
                },
                {
                    "aTargets": [2],
                    "bSearchable": false,
                    "bVisible": true,
                    "sWidth": "",
                    "sClass": ""
                },
                {
                    "aTargets": [3],
                    "bSearchable": true,
                    "bVisible": true,
                    "sWidth": "",
                    "sClass": ""
                },
                {
                    "aTargets": [4],
                    "bSearchable": true,
                    "bVisible": true,
                    "sWidth": "",
                    "sClass": ""
                },
                {
                    "aTargets": [5],
                    "bSearchable": true,
                    "bVisible": true,
                    "sWidth": "",
                    "sClass": ""
                },
                {
                    "aTargets": [10],
                    "bSearchable": false,
                    "bVisible": false,
                    "sWidth": "",
                    "sClass": ""
                },
                {
                    "aTargets": [11],
                    "bSearchable": false,
                    "bVisible": false,
                    "sWidth": "",
                    "sClass": ""
                },
                {
                    "aTargets": [12],
                    "bSearchable": false,
                    "bVisible": false,
                    "sWidth": "",
                    "sClass": ""
                },
                {
                    "aTargets": [13],
                    "bSearchable": false,
                    "bVisible": false,
                    "sWidth": "",
                    "sClass": ""
                },
            ],
            "fnRowCallback": function(nRow, aData, iDisplayIndex) {
                $(nRow).on("click", function(event) {
                    if ($(this).hasClass('row_selected')) {
                        mID = '';
                        mNIK = '';
                        mSTS = '';
                        mniknop = '';
                        flg_bsre = '';
                        $(this).removeClass('row_selected');
                    } else {
                        var data = oTable.fnGetData(this);
                        mID = data[0];
                        mNIK = data[4];
                        mSTS = data[10];
                        mniknop = data[11];
                        flg_bsre = data[13];
                        oTable.$('tr.row_selected').removeClass('row_selected');
                        $(this).addClass('row_selected');
                    }
                })
            },
            "fnDrawCallback": function(oSettings) {
                mID = '';
                mNIK = '';
                mSTS = '';
                mniknop = '';
                flg_bsre = '';
            },
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
            "sAjaxSource": "<?php echo active_module_url(); ?>kirim_sppt/grid"
        });
        oTable_CS = $('#table_cs').dataTable({
            "iDisplayLength": 5,
            "sPaginationType": "full_numbers",
            //  "bJQueryUI": true,
            "bAutoWidth": false,
            "bFilter": false, // buang input search
            "sDom": '<"toolbar2">frtip',
            "aaSorting": [
                [10, "dsc"]
            ],
            "aoColumnDefs": [{
                    "aTargets": [0],
                    "bSearchable": false,
                    "bVisible": false,
                    "sWidth": "",
                    "sClass": ""
                },
                {
                    "aTargets": [1],
                    "bSearchable": false,
                    "bVisible": true,
                    "sWidth": "",
                    "sClass": "",
                    "mRender": function(source, type, val) {

                        var disabled = '';
                        // var checked = '';
                        // var valo = "'" + val[11] + "'";
                        // var cek_aray = true;
                        if (val[12] == 1) {
                            disabled = 'disabled';
                        }
                        // if(cek_aray == true){
                        //         checked = 'checked';
                        // // }
                        if (val[14] == 1) {
                            var cekbox = "checked";
                        } else {
                            var cekbox = "";
                        }
                        // return '<input type="checkbox" value="'+val[1]+'"  name="chkbx" id="chkbx" onchange="updateCetakSim(this.checked, \''+txt_nop+'\')" '+cekbox+'>';
                        return '<input type="checkbox" value="' + val[11] + '"  name="chkbx" id="chkbx" onchange="updateKirimSim(this.checked,' + val[11] + ')" ' + cekbox +  ' ' + disabled +'>';
                        // return '<input type="checkbox" value="' + val[12] + '"  name="chkbx" id="chkbx" onchange="updateKirimSim(this.checked,' + valo + ')" ' + checked + ' ' + disabled + '>';

                    }
                },
                {
                    "aTargets": [2],
                    "bSearchable": false,
                    "bVisible": true,
                    "sWidth": "",
                    "sClass": ""
                },
                {
                    "aTargets": [3],
                    "bSearchable": true,
                    "bVisible": true,
                    "sWidth": "",
                    "sClass": ""
                },
                {
                    "aTargets": [4],
                    "bSearchable": true,
                    "bVisible": true,
                    "sWidth": "",
                    "sClass": ""
                },
                {
                    "aTargets": [5],
                    "bSearchable": true,
                    "bVisible": true,
                    "sWidth": "",
                    "sClass": ""
                },
                {
                    "aTargets": [10],
                    "bSearchable": false,
                    "bVisible": false,
                    "sWidth": "",
                    "sClass": ""
                },
                {
                    "aTargets": [11],
                    "bSearchable": false,
                    "bVisible": false,
                    "sWidth": "",
                    "sClass": ""
                },
                {
                    "aTargets": [12],
                    "bSearchable": false,
                    "bVisible": false,
                    "sWidth": "",
                    "sClass": ""
                },
                {
                    "aTargets": [13],
                    "bSearchable": false,
                    "bVisible": false,
                    "sWidth": "",
                    "sClass": ""
                },
                {
                    "aTargets": [14],
                    "bSearchable": false,
                    "bVisible": false,
                    "sWidth": "",
                    "sClass": ""
                },
            ],
            "fnRowCallback": function(nRow, aData, iDisplayIndex) {
                $(nRow).on("click", function(event) {
                    if ($(this).hasClass('row_selected')) {
                        mID = '';
                        mNIK = '';
                        mSTS = '';
                        mniknop = '';
                        flg_bsre = '';
                        $(this).removeClass('row_selected');
                    } else {
                        var data = oTable.fnGetData(this);
                        mID = data[0];
                        mNIK = data[4];
                        mSTS = data[10];
                        mniknop = data[11];
                        flg_bsre = data[12];
                        oTable.$('tr.row_selected').removeClass('row_selected');
                        $(this).addClass('row_selected');
                    }
                })
            },
            "fnDrawCallback": function(oSettings) {
                mID = '';
                mNIK = '';
                mSTS = '';
                mniknop = '';
                flg_bsre = '';
            },
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
            "sAjaxSource": "<?php echo active_module_url(); ?>kirim_sppt/grid_sim"
        });


        var tb_array = [];
        var tb_array2 = [
            '<div class="btn-group pull-left">',
            '<button id="btn_select_all_ctk_sim" class="btn btn-primary">Select All</button>',
            '</div>',
            '<div class="btn-group pull-left">',
            '<button id="btn_reset_all_ctk_sim" class="btn btn-primary">Reset All</button>',
            '</div>'
        ];
        var tb2 = tb_array2.join(' ');
        $("div.toolbar2").html(tb2);


        var tb = tb_array.join(' ');
        $("div.toolbar").html(tb);


        $('#btn_view').click(function() {
            if (mID) {
                window.location = '<?php echo active_module_url(); ?>kirim_sppt/view/' + mNIK;
            } else {
                alert('Silahkan pilih data yang akan diview');
            }
        });

        $('#btn_kirim').click(function() {
            if (mID) {
                if (flg_bsre != 1) {
                    alert("Data belum diapprove TTE");
                } else {
                    window.location = '<?php echo active_module_url(); ?>kirim_sppt/kirim_email_sppt/' + mniknop;
                }

            } else {
                alert(mID);
                alert('Silahkan pilih data yang akan diihat');
            }
        });

        $('#btn_kirim_api').click(function() {
            if (mID) {
                if (flg_bsre != 1) {
                    alert("Data belum diapprove TTE");
                } else {
                    //alert(mniknop);
                    window.location = '<?php echo active_module_url(); ?>kirim_sppt/kirim_email_api/' + mniknop;
                    // window.location = '<?php echo active_module_url(); ?>kirim_sppt/get_token_api/';
                    // window.location = '<?php echo active_module_url(); ?>kirim_sppt/show_token/';
                }

            } else {
                // alert(mID);
                alert('Silahkan pilih data yang akan diihat');
            }
        });

        $('#btn_try_pdf').click(function() {
            if (mID) {
                window.location = '<?php echo active_module_url(); ?>kirim_sppt/cetak_orc/' + mniknop;

            } else {
                alert('Silahkan pilih data yang akan diihat');
            }
        });

        $('#btn_action').click(function() {
            if (mID) {
                if (mSTS == 0) {

                    window.location = '<?php echo active_module_url(); ?>kirim_sppt/action/' + mNIK;
                } else {
                    alert('Status Registrasi bukan Draft (0)')
                }
            } else {
                alert('Silahkan pilih data yang akan diedit');
            }
        });
        $("[id=btn_select_all_ctk_sim]").click(function() {
            reload_grid_select_kirim_simultan("1");
            //select_list_all_cetak_simultan();
        });

        $("[id=btn_reset_all_ctk_sim]").click(function() {
            reload_grid_select_kirim_simultan("2");
            //reset_list_all_cetak_simultan
        });
        $('#btn_kirim_sppt_simultan').click(function() {
            var varidnya_kirim = $('#varid_ctk').val();
            window.location = '<?php echo active_module_url(); ?>kirim_sppt/kirim_email_sppt_sim/' + varidnya_kirim;
            alert(varidnya_kirim);
        });

        $('#btn_kirim_sm').click(function() {
            var forrm = '';

            if (tmp_id_sim.length > 0) {
                if (tmp_id_sim.length <= 3) {
                    for (var i = 0; i < tmp_id_sim.length; i++) {
                        forrm += "<input type='text' name='rowidd[]' id='rowidd' value='" + tmp_id_sim[i] + "' >";
                    }
                    $('#cuDialog_esign_sim').modal('show');
                    $('#rowid_orc').html(forrm);
                } else {
                    alert("Maksimal 3 data");
                }

            } else {
                alert('Pilih data yang akan di Approve');
            }

        });

        $('#btn_detail').click(function() {
            if (mID) {
                window.location = '<?php echo active_module_url(); ?>kirim_sppt/detail/' + mniknop;
            } else {
                alert('Silahkan pilih data yang akan diedit');
            }
        });
        
        $("[id=btn_kirim_sppt_sim]").click(function() {
            reload_grid_cetak_simultan();
        });


    });
</script>
