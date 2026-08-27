<?= $this->load->view('layouts/headers'); ?>
<?= $this->load->view(active_module() . '/layouts/sidebar'); ?>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Kecamatan</h4>
                        <div class="page-title-right" id="test">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">E-Adm</a>
                                </li>
                                <li class="breadcrumb-item active">Kecamatan</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <?php echo msg_block();?>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <table class="table table-striped table-nowrap" id="table1" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                <tr>
                                    <th>rowid</th>
                                    <th>Propinsi</th>
                                    <th>Dati2</th>
                                    <th>Kode Kecamatan</th>
                                    <th>Nama Kecamatan</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
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
    var oTable;

    $(document).ready(function() {
        oTable = $('#table1').dataTable({
            "iDisplayLength": 10,
            "sPaginationType": "full_numbers",
          //  "bJQueryUI": true,
            "bAutoWidth": false,
            "sDom": '<"toolbar">frtip',
            "aaSorting": [[ 1, "asc" ]],
            "aoColumnDefs": [
                { "aTargets": [0], "bSearchable": false, "bVisible": false, "sWidth": "", "sClass": "" },
                { "aTargets": [1], "bSearchable": false,  "bVisible": true,  "sWidth": "", "sClass": "" },
                { "aTargets": [2], "bSearchable": true,  "bVisible": true,  "sWidth": "", "sClass": "" },
                { "aTargets": [3], "bSearchable": true,  "bVisible": true,  "sWidth": "", "sClass": "" },
                { "aTargets": [4], "bSearchable": true,  "bVisible": true,  "sWidth": "", "sClass": "" },
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
            "sAjaxSource": "<?php echo active_module_url();?>kecamatan/grid"
        });

        var tb_array = [];
        tb_array.push('<div class="btn-group pull-left"><button id="btn_tambah" class="btn btn-success pull-left" type="button">Tambah</button></div>');
        tb_array.push('<div class="btn-group pull-left"><button id="btn_edit" class="btn btn-info pull-left" type="button">Edit</button></div>');
        tb_array.push('<div class="btn-group pull-left"><button id="btn_delete" class="btn btn-danger pull-left" type="button">Hapus</button></div>');

        var tb = tb_array.join(' ');
        $("div.toolbar").html(tb);


        $('#btn_view').click(function() {
            if(mID) {
                window.location = '<?php echo active_module_url();?>kecamatan/view/'+mID;
            }else{
                alert('Silahkan pilih data yang akan diview');
            }
        });

        $('#btn_tambah').click(function() {
            window.location = '<?php echo active_module_url();?>kecamatan/add/';
        });

        $('#btn_edit').click(function() {
            if(mID) {
                window.location = '<?php echo active_module_url();?>kecamatan/edit/'+mID;
            }else{
                alert('Silahkan pilih data yang akan diedit');
            }
        });

        $('#btn_delete').click(function() {
            if(mID) {
                var hapus = confirm('Hapus data ini?');
                if(hapus==true) {
                    window.location = '<?php echo active_module_url();?>kecamatan/delete/'+mID;
                };
            }else{
                alert('Silahkan pilih data yang akan dihapus');
            }
        });

    });
</script>
