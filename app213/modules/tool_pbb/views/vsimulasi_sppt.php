<?= $this->load->view('layouts/headers'); ?>
<?= $this->load->view(active_module() . '/layouts/sidebar'); ?>

<style>

.nav-tabs > .active > a, .nav-pills > .active > a:hover {
    color: blue;
}

</style>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">SIMULASI SPPT</h4>
                        <div class="page-title-right" id="test">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Tool PBB</a>
                                </li>
                                <li class="breadcrumb-item active">Simulasi SPPT</li>
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

                            <?php echo form_open($faction, array('id'=>'myform'));?>
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <div class="input-group w-auto">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text rounded-end-0">NOP</span>
                                        </div>
                                        <div class="controls">
                                            <input type="text" id="nop" class="form-control" name="nop" autocomplete="off" value="<?php echo $dt['nop']?>" style="width:200px">
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <button class="btn btn-primary pull-left" type="submit" id="btn_pros">Proses</button>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <div class="input-group w-auto">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text rounded-end-0">Tahun</span>
                                        </div>
                                        <div class="controls">
                                            <input type="text" id="tahun" class="form-control" name="tahun" maxlength="4" autocomplete="off" value="<?php echo $dt['tahun']?>">
                                        </div>
                                    </div>
                                    <div class="input-group w-auto">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text rounded-end-0">Jt Tempo</span>
                                        </div>
                                        <div class="controls">
                                            <input type="text" id="jatuh_tempo" class="form-control" name="jatuh_tempo"  autocomplete="off" value="<?php echo $dt['jatuh_tempo']?>">
                                        </div>
                                    </div>
                                </div>

                            </form>
                            <br>
                            <table class="table table-striped" id="table1">
                                <thead>
                                <tr>
                                    <th>NOP</th>
                                    <th>TAHUN</th>
                                    <th>NAMA WP</th>
                                    <th>ALAMAT WP</th>
                                    <th>JT TEMPO</th>
                                    <th>TERHUTANG</th>
                                    <th>PENGURANG</th>
                                    <th>TAGIHAN</th>
                                    <th>DENDA</th>
                                    <th>TOTAL PAJAK</th>
                                    <th>ACTION</th>
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
    var mNIK;
    var mSTS;
    var oTable;
    function reload_grid() {
        var statuskd_s = document.getElementById('status_kd');
        var statuskd = statuskd_s.options[statuskd_s.selectedIndex].value;
        var params = {
            status_kd : statuskd
            };

        var data_params = decodeURIComponent($.param(params));
        oTable.ajax.url("<?php echo active_module_url();?>simulasi_sppt/grid/?"+data_params).load();
    }

    function f_dtl(nopthn) {
        var url = '<?php echo active_module_url("simulasi_sppt/detail"); ?>'+nopthn;
        // window.location = '<?php //echo active_module_url("simulasi_sppt/"); ?>'+nopthn;
        window.open(url, "_blank") ;
    }

    $(document).ready(function() {
        oTable = $('#table1').dataTable({
            "iDisplayLength": 13,
            "sPaginationType": "full_numbers",
            //  "bJQueryUI": true,
            "bAutoWidth": false,
            "sDom": '<"toolbar">frtip',
            "aaSorting": [[ 1, "asc" ]],
            "aoColumnDefs": [
                { "aTargets": [0], "bSearchable": true, "bVisible": true, "sWidth": "", "sClass": "" },
                { "aTargets": [1], "bSearchable": true,  "bVisible": true,  "sWidth": "", "sClass": "" },
                { "aTargets": [2], "bSearchable": true,  "bVisible": true,  "sWidth": "", "sClass": "" },
                { "aTargets": [3], "bSearchable": true,  "bVisible": true,  "sWidth": "", "sClass": "" },
                { "aTargets": [4], "bSearchable": true,  "bVisible": true,  "sWidth": "", "sClass": "" },
                { "aTargets": [5], "bSearchable": false,  "bVisible": true,  "sWidth": "", "sClass": "right" },
                { "aTargets": [6], "bSearchable": false,  "bVisible": true,  "sWidth": "", "sClass": "right" },
                { "aTargets": [7], "bSearchable": false,  "bVisible": true,  "sWidth": "", "sClass": "right" },
                { "aTargets": [8], "bSearchable": false,  "bVisible": true,  "sWidth": "", "sClass": "right" },
                { "aTargets": [9], "bSearchable": false,  "bVisible": true,  "sWidth": "", "sClass": "right" },
                { "aTargets": [10], "bSearchable": false,  "bVisible": true,  "sWidth": "", "sClass": "",
                    "mRender": function( data, type, full) {
                        return '<button class="btn btn-danger" onclick="f_dtl(\''+full[10]+'\')" type="button">Detail</button>';
                    }
                },
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
            "sAjaxSource": "<?php echo active_module_url();?>simulasi_sppt/grid"
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

        $("#btn_pros").on("click", function(e){
            var nop    = $("#nop").val();
            var tahun  = $("#tahun").val();
            var jatuh_tempo  = $("#jatuh_tempo").val();
            if( nop == '' || tahun == '' || jatuh_tempo == '' ){
                alert('NOP TAHUN dan JATUH TEMPO Harap diisi dengan benar...'); return false;
            }
            e.preventDefault();
            $('#myform').attr('action', "<?php echo $faction?>").submit();
        });

        

        var jatuh_tempo_dtp = $('#jatuh_tempo').datepicker({
            format: 'dd-mm-yyyy'
        }).on('changeDate', function(ev) {
            jatuh_tempo_dtp.hide();
        }).data('datepicker');


    });
</script>
