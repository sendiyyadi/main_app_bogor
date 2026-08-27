<?= $this->load->view('layouts/headers'); ?>
<?= $this->load->view(active_module() . '/layouts/sidebar'); ?>


<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">LOKET TERIMA PERMOHONAN PELAYANAN UPT</h4>
                        <div class="page-title-right" id="test">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Tool PBB</a>
                                </li>
                                <li class="breadcrumb-item active">Loket Terima Permohonan Pelayanan UPT</li>
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
            } ?>

            <?php echo msg_block();?>
        
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div class="input-group w-auto">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-end-0">Status</span>
                                    </div>
                                    <div class="controls">
                                        <?php echo $select_status_kd; ?>
                                    </div>
                                </div>
                                <div class="input-group w-auto">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-end-0">Tgl Pelayanan</span>
                                    </div>
                                    <div class="controls">
                                        <input type="text" id="tgl_fr" class="form-control" style="width:100px">
                                    </div>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-end-0">s/d</span>
                                    </div>
                                    <div class="controls">
                                        <input type="text" id="tgl_to" class="form-control" style="width:100px">
                                    </div>
                                </div>
                                <div class="input-group w-auto">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-end-0">Jns Pelayanan</span>
                                    </div>
                                    <div class="controls">
                                        <?php echo $select_jns_ply; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div class="input-group w-auto">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-end-0">No Pelayanan</span>
                                    </div>
                                    <div class="controls">
                                        <input type="text" id="thn_ply" class="form-control" placeholder="Tahun" style="width:100px">
                                    </div>
                                    <div class="controls">
                                        <input type="text" id="bundel_ply" class="form-control" placeholder="Bundel" style="width:100px">
                                    </div>
                                    <div class="controls">
                                        <input type="text" id="urut_ply" class="form-control" placeholder="Urut" style="width:100px">
                                    </div>
                                </div>
                                <div class="input-group w-auto">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-end-0">NOP</span>
                                    </div>
                                    <div class="controls">
                                        <input type="text" id="nop" class="form-control" name="nop" placeholder="Cari NOP" style="width:200px">
                                    </div>
                                </div>
                                <div class="col-md-1"><button class="btn btn-primary" id="btn_cari">Cari</button></div>
                            </div>

                            <div class="row" style="overflow-x:auto;">
                                <table class="table mt-2" id="table1">
                                    <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>NO PLY</th>
                                        <th>NOP</th>
                                        <th>JNS PLY</th>
                                        <th>NAMA PEMOHON</th>
                                        <th>KECAMATAN</th>
                                        <th>KELURAHAN</th>
                                        <th>STATUS</th>
										<th>TGL PERKIRAAN SELESAI</th>
                                        <th>ACTION</th>
                                        <th>sts</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
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
    function reload_grid() {
        var tgl_fr = $('#tgl_fr').val();
        var tgl_to = $('#tgl_to').val();
        var jns_ply = $('#jns_ply').val();
        var thn_ply = $('#thn_ply').val();
        var bundel_ply = $('#bundel_ply').val();
        var urut_ply = $('#urut_ply').val();
        var nop = $('#nop').val();
        var sts_kd = $('#status_kd').val();

        var params = {
            tgl_fr : tgl_fr,
            tgl_to : tgl_to,
            jns_ply : jns_ply,
            thn_ply : thn_ply,
            bundel_ply : bundel_ply,
            urut_ply : urut_ply,
            nop : nop,
            sts_kd: sts_kd
        };

        var data_params = decodeURIComponent($.param(params));
        oTable.fnReloadAjax("<?php echo active_module_url();?>loket_permohonan_online_upt/grid/?"+data_params);
    }

    function f_dtl(id) {
        window.location = '<?php echo active_module_url("loket_permohonan_online_upt/detail"); ?>'+id;
    }

    function f_edit(id, sts) {
        if(sts == '1') {
            window.location = '<?php echo active_module_url("loket_permohonan_online_upt/edit"); ?>'+id;
        } else if(sts == 'F') {
            window.location = '<?php echo active_module_url("loket_permohonan_online_upt/edit"); ?>'+id;
            // alert('<?php echo active_module_url("loket_permohonan_online_upt/edit"); ?>'+id);
        } else {
            alert('Tidak bisa edit data. Status dokumen bukan Kirim WP'); return false;
        }
    }

    $(document).ready(function() {
        $('body').tooltip({
            selector: '[data-toggle="tooltip"]',
            container: 'body'
        });
        
        oTable = $('#table1').dataTable({
            "iDisplayLength": 13,
            "sPaginationType": "full_numbers",
            //  "bJQueryUI": true,
            "bAutoWidth": false,
            "sDom": '<"toolbar">frtip',
            "aaSorting": [[ 0, "desc" ]],
            "aoColumnDefs": [
                { "aTargets": [0], "bSearchable": false, "bVisible": false, "sWidth": "", "sClass": "" },
                { "aTargets": [1], "bSearchable": true, "bVisible": true, "sWidth": "", "sClass": "" },
                { "aTargets": [2], "bSearchable": true,  "bVisible": true,  "sWidth": "", "sClass": "" },
                { "aTargets": [3], "bSearchable": true,  "bVisible": true,  "sWidth": "", "sClass": "" },
                { "aTargets": [4], "bSearchable": true,  "bVisible": true,  "sWidth": "", "sClass": "" },
                { "aTargets": [5], "bSearchable": true,  "bVisible": true,  "sWidth": "", "sClass": "" },
                { "aTargets": [6], "bSearchable": true,  "bVisible": true,  "sWidth": "", "sClass": "" },
                { "aTargets": [7], "bSearchable": false,  "bVisible": true,  "sWidth": "", "sClass": "" },
				{ "aTargets": [8], "bSearchable": false,  "bVisible": true,  "sWidth": "", "sClass": "" },
                { "aTargets": [9], "bSearchable": false,  "bVisible": true,  "sWidth": "70px", "sClass": "",
                    "mRender": function( data, type, full) {
                        var edt = '<button class="btn btn-danger rounded-circle me-1" '+
                                  'onclick="f_edit(\''+full[0]+'\', \''+full[10]+'\')" type="button" ' +
                                  'data-toggle="tooltip" data-placement="top" title="Action" >'+
                                  '<i class="fas fa-pencil-alt"></i></button>';
                        var dtl = '<button class="btn btn-warning rounded-circle me-1" onclick="f_dtl(\''+full[0]+'\')" type="button" '+
                                  'data-toggle="tooltip" data-placement="top" title="Detail" >'+
                                  '<i class="fas fa-search"></i></button>';

                        // var edt = '<button class="btn btn-danger" onclick="f_edit(\''+full[0]+'\', '+full[9]+')" type="button">Action</button>';
                        // var dtl = '<button class="btn btn-warning" onclick="f_dtl(\''+full[0]+'\')" type="button" style="margin-left:5px">Detail</button>';
                        return edt + dtl;
                    }
                },
                { "aTargets": [10], "bSearchable": false,  "bVisible": false,  "sWidth": "", "sClass": "" },
            ],
            "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                $(nRow).on("click", function (event) {
                    if ($(this).hasClass('row_selected')) {
                        mID = ''; 
                        $(this).removeClass('row_selected');
                    } else {
                        var data = oTable.fnGetData( this );
                        mID = data[0];

                        oTable.$('tr.row_selected').removeClass('row_selected');
                        $(this).addClass('row_selected');
                    }
                })
            },
            "fnDrawCallback": function( oSettings ) {
                mID = ''; 
            },
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
            "sAjaxSource": "<?php echo active_module_url();?>loket_permohonan_online_upt/grid"
        });

        var tb_array = [];
        var tb = tb_array.join(' ');
        $("div.toolbar").html(tb);



        $('#nop').formatter({
            'pattern': '{{99}}.{{99}}-{{999}}.{{999}}-{{999}}.{{9999}}.{{9}}',
        });

        $('#tahun').formatter({
            'pattern': '{{9999}}',
        });

        var tgl_fr_dtp = $('#tgl_fr').datepicker({
            format: 'dd-mm-yyyy'
        }).on('changeDate', function(ev) {
            tgl_fr_dtp.hide();
        }).data('datepicker');

        var tgl_to_dtp = $('#tgl_to').datepicker({
            format: 'dd-mm-yyyy'
        }).on('changeDate', function(ev) {
            tgl_to_dtp.hide();
        }).data('datepicker');

        $("[id=btn_cari]").click(function(){
          reload_grid();
        });


    });
</script>