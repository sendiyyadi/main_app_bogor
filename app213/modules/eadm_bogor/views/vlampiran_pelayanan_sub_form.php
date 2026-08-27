<?= $this->load->view('layouts/headers'); ?>
<?= $this->load->view(active_module() . '/layouts/sidebar'); ?>

<style>

hr {
    border: 0;
    border-bottom: 1px solid #dddddd;
}

td input.form-control {
    transition: all 0.2s ease;
}

</style>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Referensi Lampiran Pelayanan</h4>
                        <div class="page-title-right" id="test">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">E-Adm</a>
                                </li>
                                <li class="breadcrumb-item active">Referensi Lampiran Pelayanan</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            echo msg_block();
            if(validation_errors()){
                echo '<blockquote><strong>Harap melengkapi data berikut :</strong>';
                echo validation_errors('<small>','</small>');
                echo '</blockquote>';
            }
            ?>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <?php echo form_open($faction, array('id'=>'myform','class'=>'form-horizontal'));?>

                            <div class="form-group row mt-2">
                                <div class="col-md-2 col-sm-4 mb-2" for="kd_propinsi" style="align-self:center;">Kode Pelayanan</div>
                                <div class="col-sm-5">
                                    <input class="form-control" type="text" name="kd_jns_pelayanan" id="kd_jns_pelayanan" value="<?php echo $dt['kd_jns_pelayanan']?>" readonly/>
                                </div>
                            </div>

                            <div class="form-group row mt-2">
                                <div class="col-md-2 col-sm-4 mb-2" for="kd_kecamatan" style="align-self:center;">Nama Pelayanan</div>
                                <div class="col-sm-5">
                                    <input class="form-control" type="text" name="nm_pelayanan" id="nm_pelayanan" value="<?php echo $dt['nm_pelayanan']?>" readonly/>
                                </div>
                            </div>

                            <div class="form-group row mt-2">
                                <div class="col-md-2 col-sm-4 mb-2" for="sub_ply" style="align-self:center;">Sub Pelayanan</div>
                                <div class="col-sm-5">
                                    <?php echo $select_sub_ply; ?>
                                </div>
                            </div>

                            <hr />

                            <div class="card">
                                <div class="card-body">

                                    <table class="table table-striped table-nowrap" id="table1" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                        <tr>
                                            <th>id</th>
                                            <th>Nama Field</th>
                                            <th>Keterangan</th>
                                            <th>Sts Mandatory</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <hr />

                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <button type="button" class="btn btn-dark" id="btn_cancel">Batal / Kembali</button>
                            <?php echo form_close();?>

                        </div>
                    </div>
                </div>
            </div>


            <!-- Modal Form -->
            <div class="modal fade" id="lampiranModal" tabindex="-1" aria-labelledby="lampiranModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="lampiranModalLabel">Tambah Lampiran</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="lampiranForm">
                            <div class="modal-body">
                                <input type="hidden" id="kd_jns_pelayanan_m" name="kd_jns_pelayanan_m">
                                <input type="hidden" id="sub_jns_pelayanan_m" name="sub_jns_pelayanan_m">

                                <div class="mb-3">
                                    <label for="nm_field" class="form-label">Pilih Field</label>
                                    <select class="form-select" id="nm_field" name="nm_field" required>
                                        <option value="">-- Pilih --</option>
                                        <option value="L_SKKP_PBB1">L_SKKP_PBB1</option>
                                        <option value="L_SPMKP_PBB1">L_SPMKP_PBB1</option>
                                        <option value="L_SURAT_KUASA1">L_SURAT_KUASA1</option>
                                        <option value="L_PERMOHONAN1">L_PERMOHONAN1</option>
                                        <option value="L_STTS1">L_STTS1</option>
                                        <option value="L_SK_KEBERATAN1">L_SK_KEBERATAN1</option>
                                        <option value="L_SPPT_STTS1">L_SPPT_STTS1</option>
                                        <option value="L_KTP_WP1">L_KTP_WP1</option>
                                        <option value="L_SERTIFIKAT_TANAH1">L_SERTIFIKAT_TANAH1</option>
                                        <option value="L_IMB1">L_IMB1</option>
                                        <option value="L_AKTE_JUAL_BELI1">L_AKTE_JUAL_BELI1</option>
                                        <option value="L_SPPT1">L_SPPT1</option>
                                        <option value="L_SK_PENGURANGAN1">L_SK_PENGURANGAN1</option>
                                        <option value="L_LAIN_LAIN1">L_LAIN_LAIN1</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="nm_lampiran" class="form-label">Nama Lampiran</label>
                                    <input type="text" class="form-control" id="nm_lampiran" name="nm_lampiran" placeholder="Masukkan nama lampiran" required>
                                </div>

                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="sts_lampiran" name="sts_lampiran" value="1">
                                    <label class="form-check-label" for="sts_lampiran" style="padding-top:2.5px;">Status Lampiran Mandatory</label>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- END Modal Form -->

        <!-- TUTUP CONTAINER-FLUID -->
        </div>
    </div>
    <?= $this->load->view('layouts/foot.php'); ?>
</div>
<?= $this->load->view('layouts/scripts.php'); ?>

<?= $this->load->view('layouts/footer.php'); ?>


<script>
    var mID;
    var oTable;

    // fungsi checkbos
    function f_edit(id) {
        const el = event.currentTarget; // checkbox yang diklik
        const isChecked = el.checked ? 1 : 0;

        $.post(
            '<?php echo active_module_url("lampiran_pelayanan/update_status"); ?>',
            { id: id, sts_lampiran: isChecked },
            function (res) {
                if (res.status === 'success') {
                    toastr.success(res.message);
                } else {
                    el.checked = !el.checked;
                    toastr.error(res.message);
                }
            },
            'json'
        ).fail(function () {
            el.checked = !el.checked;
            Swal.fire('Error', 'Terjadi kesalahan sistem', 'error');
        });
    }


    function f_delete(id) {
        Swal.fire({
            title: 'Konfirmasi',
            text: 'Yakin akan menghapus data ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?php echo active_module_url("lampiran_pelayanan/delete_detail_lamp"); ?>',
                    type: 'POST',
                    data: { id: id },
                    dataType: 'json',
                    success: function (response) {
                        if (response.status === 'success') {
                            toastr.success('Data referensi lampiran berhasil dihapus');
                            oTable.ajax.reload(null, false);
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('AJAX Error:', error);
                        toastr.error('Terjadi kesalahan saat menghapus data');
                    }
                });
            }
        });
    }

    function f_chg_sub(sub_id) {
        var url_grid = "<?php echo active_module_url(); ?>lampiran_pelayanan/grid_lamp/<?php echo $dt['kd_jns_pelayanan']; ?>/" + sub_id;
        oTable.ajax.url(url_grid).load(null, false);               
    }


    $(document).ready(function() {
        $('#btn_cancel').click(function() {
            window.location = '<?php echo active_module_url();?>lampiran_pelayanan';
        });

        var sub_id = $('#sub_ply').val();

        oTable = $('#table1').DataTable({
            "iDisplayLength": 10,
            "sPaginationType": "full_numbers",
            //  "bJQueryUI": true,
            "bAutoWidth": false,
            "sDom": '<"toolbar">frtip',
            "aaSorting": [[ 0, "asc" ]],
            "aoColumnDefs": [
                { "aTargets": [0], "bSearchable": false, "bVisible": false, "sWidth": "", "sClass": "" },
                { "aTargets": [1], "bSearchable": true,  "bVisible": true,  "sWidth": "", "sClass": "" },
                { "aTargets": [2], "bSearchable": true,  "bVisible": true,  "sWidth": "", "sClass": "" },
                // { "aTargets": [3], "bSearchable": true,  "bVisible": true,  "sWidth": "", "sClass": "" },
                { "aTargets": [3], "bSearchable": false,  "bVisible": true,  "sWidth": "", "sClass": "",
                  "mRender" : function (data, type, row) {
                        if (row[3] == 1) {
                            var chxbx = `checked`;
                        } else {
                            var chxbx = '';
                        }
                        return `<input type="checkbox" class="chk-status" onclick="f_edit('${row[0]}')" `+chxbx+` />`;
                    }
                },
                { "aTargets": [4], "bSearchable": false,  "bVisible": true,  "sWidth": "", "sClass": "",
                  "mRender" : function (data, type, row) {
                        return `<button type="button" class="btn btn-sm btn-danger" onclick="f_delete('${row[0]}')" ><i class="uil uil-trash"></i></button>`;
                    }
                },
            ],
            "oLanguage": {
                "sProcessing":   "<img border='0' src='<?php echo base_url('assets/pad/img/ajax-loader-big-circle-ball.gif')?>' />",
                "sLengthMenu":   "Tampilkan _MENU_ entri",
                "sZeroRecords":  "Tidak ada data",
                "sInfo":         "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                "sInfoEmpty":    "Menampilkan 0 sampai 0 dari 0 entri",
                "sInfoFiltered": "(disaring dari _MAX_ entri keseluruhan)",
                "sInfoPostFix":  "",
                "sSearch":       "Cari : ",
                "sUrl":          "",
                "oPaginate": {
                    "sFirst":    "&laquo;",
                    "sPrevious": "&lsaquo;",
                    "sNext":     "&rsaquo;",
                    "sLast":     "&raquo;",
                }
            },
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": "<?php echo active_module_url();?>lampiran_pelayanan/grid_lamp/<?php echo $dt['kd_jns_pelayanan']?>/"+sub_id
        });
        var tb_array = [];
        tb_array.push('<div class="btn-group pull-left"><button id="btn_action" class="btn btn-success pull-left" type="button">Tambah</button></div>');
    
        var tb = tb_array.join(' ');
        $("div.toolbar").html(tb);

        $('#btn_action').click(function() {
            var kd_jns_pelayanan = $('#kd_jns_pelayanan').val(); 
            var sub_jns_pelayanan = $('#sub_ply').val(); 
            $('#kd_jns_pelayanan_m').val(kd_jns_pelayanan); 
            $('#sub_jns_pelayanan_m').val(sub_jns_pelayanan); 
            $('#lampiranModal').modal('show');
        });

        // Handle form submission via AJAX
        $('#lampiranForm').submit(function(e) {
            e.preventDefault(); 
            var formData = $(this).serialize();

            $.ajax({
                url: '<?php echo active_module_url();?>lampiran_pelayanan/insert_lampiran_sub', 
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        
                        // alert('Data berhasil disimpan');
                        toastr.success('Data berhasil disimpan');
                        $('#lampiranModal').modal('hide');  
                        $('#lampiranForm')[0].reset(); 
                        oTable.ajax.reload(null, false);
                        // window.location = "<?php echo active_module_url();?>lampiran_pelayanan/edit/<?php echo $dt['kd_jns_pelayanan']?>";
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                    toastr.error('Terjadi kesalahan saat menyimpan data.');
                }
            });
        });

        // Event Handler untuk edit inline (kolom ke 2 = Keterangan)
        $('#table1 tbody').on('dblclick', 'td:nth-child(2)', function() { 
            var cell = $(this);
            var originalValue = cell.text().trim(); 
            var row = oTable.row(cell.closest('tr')); 
            var rowData = row.data(); 

            cell.html('<input type="text" class="form-control" value="' + originalValue + '" style="width:100%;">');
            var input = cell.find('input');
            input.focus().select(); 

            input.on('blur keypress', function(e) {
                if (e.type === 'blur' || (e.type === 'keypress' && e.which === 13)) {  // Enter key
                    var newValue = $(this).val().trim();
                    if (newValue !== originalValue) {
                      
                        $.ajax({
                            url: '<?php echo active_module_url("lampiran_pelayanan/update_lampiran"); ?>', 
                            type: 'POST',
                            data: {
                                id: rowData[0], 
                                column: 'NM_LAMPIRAN', 
                                value: newValue
                            },
                            dataType: 'json',
                            success: function(response) {
                                if (response.status === 'success') {        //// update datatables kalo berhasil
                                    rowData[1] = newValue; 
                                    row.invalidate().draw(false); 
                                    // alert('Data berhasil diperbarui');
                                    toastr.success('Data berhasil diperbarui');
                                } else {                                    //// balikin kalo gagal
                                    // alert('Error: ' + response.message);
                                    toastr.error('Error: ' + response.message);
                                    cell.text(originalValue); 
                                }
                            },
                            error: function() {
                                // alert('Terjadi kesalahan saat menyimpan data.');
                                toastr.error('Terjadi kesalahan saat menyimpan data.');
                                cell.text(originalValue); 
                            }
                        });
                    } else {
                        cell.text(originalValue);
                    }
                }
            });
        });


    });

    $(document).keypress(function(event){
        if (event.which == '13') {
            event.preventDefault();
        }
    });

</script>

