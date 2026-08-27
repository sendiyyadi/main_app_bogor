<?= $this->load->view('layouts/headers'); ?>
<?= $this->load->view(active_module() . '/layouts/sidebar'); ?>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">APPROVE BSRE</h4>
                        <div class="page-title-right" id="test">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">E-Adm</a>
                                </li>
                                <li class="breadcrumb-item active">APPROVE BSRE</li>
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
                                        <span class="input-group-text rounded-end-0">Thn Pajak</span>
                                    </div>
                                    <?php echo $select_tahun; ?>
                                </div>
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
                                    <div class="controls"><input type="text" id="c_nop" class="form-control" name="c_nop" style="width:200px"></div>
                                </div>
                                
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <button onclick="reload_grid('1');" class="btn btn-primary" id="btn_cari">Cari</button>
                                    <button onclick="reload_grid('2');" class="btn btn-info" id="btn_reset">Reset</button>
                                    <button id="btn_detail" class="btn btn-secondary pull-left" type="button">Detail</button>
                                    <button id="btn_bsre_sim" class="btn btn-warning pull-left" type="button">Buat SPPT</button>
                                    <button id="btn_lihat_pdf" class="btn btn-success pull-left" type="button">Lihat PDF</button>
                                </div>
                            </div>
                            <br>
                            <div style="overflow-x:auto; width:100%;">
                                <table class="table table-striped table-nowrap" id="table1" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>rowid</th>
                                            <th>CHK</th>
                                            <th>NOP</th>
                                            <!-- <th>THN</th> -->
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

                </div>

                <!-- Modal -->
                <div class="modal fade" id="cuDialog_esign_sim" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Approve BSRE - Input Passphrase</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form method="post" onsubmit="get_action_sim(this);" accept-charset="utf-8" id="myFormModals" class="form-horizontal" enctype="multipart/form-data">
                                <div class="modal-body">
                                    <div id="rowid_orc" style="display: none;">
                                        <input type="text" style="width: 300px;" name="tmp_id" id="tmp_id">
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputPassword" class="col-sm-2 col-form-label">Passphrase</label>
                                        <div class="col-sm-10">
                                            <input type="password" class="form-control" id="passphrase" name="passphrase" placeholder="Passphrase">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                    <button type="submit" id="btn_submit_bsre" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
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
    var thn_pajak;

    function reload_grid(mode) {
        // mode 1=cari  2=reset

        var status_kd = document.getElementById('status_kd');
        var kec = document.getElementById('kd_kecamatan');
        var kel = document.getElementById('kd_kelurahan');
        var thn_pajak = document.getElementById('thn_pajak');
        
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
        var thn_pajaks = thn_pajak.options[thn_pajak.selectedIndex].value;

        var params = {
            status_kd: statuskds,
            kec: kec,
            kel: kel,
            c_nop: c_nop,
            thn_pajak: thn_pajaks,
        };
        var data_params = decodeURIComponent($.param(params));
        // alert(data_params);
        oTable.fnReloadAjax("<?php echo active_module_url(); ?>sppt_bsre/grid/?" + data_params);
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
    function f_chg_kec_all(kec_id) {
        // var select = $('#kd_kelurahan');
        // select.append($('<option />', { value: '999999', text: 'Semua Kel' }));
        $.ajax({
            url: "<?php echo active_module_url() ?>sppt_bsre/f_chg_kec_all/" + kec_id,
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
            url: "<?php echo active_module_url() ?>sppt_bsre/f_chg_kec_all_sim/" + kec_id,
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

    function get_action_sim(form) {
        // document.getElementById('btn_submit_bsre').disabled = true;
        form.action = '<?php echo active_module_url(); ?>sppt_bsre/buat_sppt_sim';
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
                        if (val[12] == 1) {
                            disabled = 'disabled';
                        }
                        // if(cek_aray == true){
                        //         checked = 'checked';
                        // }
                        return '<input type="checkbox" value="' + val[1] + '"  name="chkbx" id="chkbx" onchange="update_sim(this.checked,' + valo + ')" ' + checked + ' ' + disabled + '>';

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
                    "sWidth": "100px",
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
                    "aTargets": [6],
                    "bSearchable": true,
                    "bVisible": true,
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
                        thn_pajak = '';
                        $(this).removeClass('row_selected');
                    } else {
                        var data = oTable.fnGetData(this);
                        mID = data[0];
                        thn_pajak = data[3];
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
                thn_pajak = '';
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
            "sAjaxSource": "<?php echo active_module_url(); ?>sppt_bsre/grid"
        });

        var tb_array = [];
        // // tb_array.push('<div class="btn-group pull-left"><button id="btn_action" class="btn btn-success pull-left" type="button">Action</button></div>');
        // tb_array.push('<div class="btn-group pull-left"><button id="btn_detail" class="btn btn-primary pull-left" type="button">Detail</button></div>');
        // // tb_array.push('<div class="btn-group pull-left"><button id="btn_bsre_sim" class="btn btn-warning pull-left" type="button">Approve BSRE</button></div>');
        // tb_array.push('<div class="btn-group pull-left"><button id="btn_bsre_sim" class="btn btn-warning pull-left" type="button">CREATE SPPT</button></div>');
        // tb_array.push('<div class="btn-group pull-left"><button id="btn_lihat_pdf" class="btn btn-success pull-left" type="button">Lihat PDF</button></div>');

        var tb = tb_array.join(' ');
        $("div.toolbar").html(tb);


        $('#btn_view').click(function() {
            if (mID) {
                window.location = '<?php echo active_module_url(); ?>sppt_bsre/view/' + mNIK;
            } else {
                alert('Silahkan pilih data yang akan diview');
            }
        });

        $('#btn_lihat_pdf').click(function() {
            if (mID) {
                // alert(flg_bsre);
                if (flg_bsre != 1) {
                    alert("Data belum diapprove TTE");
                } else {
                    window.location = '<?php echo active_module_url(); ?>sppt_bsre/pdf_look/' + mniknop + '/' + thn_pajak;
                }

            } else {
                alert('Silahkan pilih data yang akan diihat');
            }
        });
        $('#btn_try_pdf').click(function() {
            if (mID) {
                window.location = '<?php echo active_module_url(); ?>sppt_bsre/cetak_orc/' + mniknop;

            } else {
                alert('Silahkan pilih data yang akan diihat');
            }
        });

        $('#btn_action').click(function() {
            if (mID) {
                if (mSTS == 0) {
                    // var params = {
                    //     row_id: mID.toString(),
                    // };
                    // var data_params = decodeURIComponent($.param(params));
                    // // alert(data_params);
                    // window.location = '<?php echo active_module_url(); ?>sppt_bsre/action/?'+data_params;
                    window.location = '<?php echo active_module_url(); ?>sppt_bsre/action/' + mNIK;
                } else {
                    alert('Status Registrasi bukan Draft (0)')
                }
            } else {
                alert('Silahkan pilih data yang akan diedit');
            }
        });

        $('#btn_bsre_sim').click(function() {
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
                window.location = '<?php echo active_module_url(); ?>sppt_bsre/detail/' + mniknop;
            } else {
                alert('Silahkan pilih data yang akan diedit');
            }
        });

            // $('#status_kd').change(function() {
            //     reload_grid();
            // });


    });
</script>
