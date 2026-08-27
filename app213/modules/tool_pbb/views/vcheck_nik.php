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
                        <h4 class="mb-0">CHECK NIK</h4>
                        <div class="page-title-right" id="test">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Tool PBB</a>
                                </li>
                                <li class="breadcrumb-item active">Check NIK</li>
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
                                        <span class="input-group-text rounded-end-0">NIK</span>
                                    </div>
                                    <div class="controls">
                                        <input type="text" id="c_nik" class="form-control" name="c_nik" placeholder="Cari NIK">
                                    </div>
                                </div>
                                <div class="input-group w-auto">
                                    <button class="btn btn-primary" id="btn_cari">CARI</button>
                                </div>
                            </div>

                            <br>
                            <table class="table" id="table1">
                                <thead>
                                    <tr>
                                        <!-- <th>No</th> -->
                                        <th>NIK</th>
                                        <th>NAMA WP</th>
                                        <th>NOP</th>
                                        <th>ALAMAT WP</th>
                                        <th>ALAMAT OBJEK PAJAK</th>
                                        <th>Action</th>
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
    // $.fn.dataTableExt.oApi.fnReloadAjaxxx = function ( oSettings, sNewSource, fnCallback, bStandingRedraw ){

    //   if ( typeof sNewSource != 'undefined' && sNewSource != null ) {
    //     oSettings.sAjaxSource = sNewSource;
    //   }

    //   /* Server-side processing should just call fnDraw */
    //   if ( oSettings.oFeatures.bServerSide ) {
    //     this.fnDraw();
    //     return;
    //   }

    //   this.oApi._fnProcessingDisplay( oSettings, true );
    //   var that = this;
    //   var iStart = oSettings._iDisplayStart;
    //   var aData = [];

    //   this.oApi._fnServerParams( oSettings, aData );
    //   oSettings.fnServerData.call( oSettings.oInstance, oSettings.sAjaxSource, aData, function(json) {

    //     /* Clear the old information from the table */
    //     that.oApi._fnClearTable( oSettings );

    //     /* Got the data - add it to the table */
    //     var aData =  (oSettings.sAjaxDataProp !== "") ?
    //       that.oApi._fnGetObjectDataFn( oSettings.sAjaxDataProp )( json ) : json;
    //     for ( var i=0 ; i<aData.length ; i++ ){
    //       that.oApi._fnAddData( oSettings, aData[i] );
    //     }
    //     oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();

    //     if ( typeof bStandingRedraw != 'undefined' && bStandingRedraw === true ){
    //       oSettings._iDisplayStart = iStart;
    //       that.fnDraw( false );
    //     }
    //     else{
    //       that.fnDraw();
    //     }

    //     that.oApi._fnProcessingDisplay( oSettings, false );

    //     /* Callback user function - for event handlers etc */
    //     if ( typeof fnCallback == 'function' && fnCallback != null ){
    //       fnCallback( oSettings );
    //     }

    //   }, oSettings );

    // };

    var oTable;

    function reload_grid() {
        var nik = $('#c_nik').val();

        var params = {
            nik : nik,
        };

        var data_params = decodeURIComponent($.param(params));
        console.log("<?php echo active_module_url();?>check_nik/grid/?"+data_params);
        oTable.fnReloadAjax("<?php echo active_module_url();?>check_nik/grid/?"+data_params);
    }

    $(document).ready(function() {
        oTable = $('#table1').dataTable({
            "iDisplayLength": 10,
            "sPaginationType": "full_numbers",
            "bAutoWidth": false,
            // "sDom": '<"toolbar">frtip',
            // "aaSorting": [
            //     [1, "asc"]
            // ],
            // "aoColumnDefs": [
                // { "aTargets": [0], "bSearchable": false, "bVisible": true, "sWidth": "50px", "sClass": "dt-center",
                //   "render": function (data, type, full, meta) {
                //       return meta.row + 1;
                //   }
                // },
                // { "aTargets": [1], "bSearchable": true, "bVisible": true, "sWidth": "", "sClass": "" }, // No
                // { "aTargets": ["nosort"], "bSearchable": true},  // NIK
                // { "aTargets": [6], "bSearchable": false, "bVisible": true}, // No
            // ],
            "aoColumnDefs": [
                // { "bSearchable": false, "bVisible": false, "aTargets": [ 10 ] },
                // { "bSearchable": false, "bVisible": false, "aTargets": [ 11 ] },
                // { "bSearchable": false, "bVisible": false, "aTargets": [ 12 ] },
                { "bSearchable": false, "bVisible": true, "aTargets": [ 5 ], 
                  "mRender": function( data, type, full) {
                    var nik = $('#c_nik').val();

                    var params = {
                      pawal_nik: nik,
                    };
                    var prm = decodeURIComponent($.param(params));
                    var trimmedValue = full[0].trim();
                    var trimmedName = full[1].trim();
                    var btn_detail = '<a href="<?php echo active_module_url()?>check_nik/detail/'+trimmedValue+'/'+trimmedName+'/?'+prm+'" target="_blank" class="btn btn-success" title="Detail" name="'+trimmedName+'" style="margin-right: 5px">Detail</button>';
                    return btn_detail;
                  }
                },
            ],
            "bProcessing": true,
            "bServerSide": true,
            "bFilter": false,
            "sAjaxSource": "<?php echo active_module_url(); ?>check_nik/grid"
        });

        $("[id=btn_cari]").click(function(){
            reload_grid();
        });
    });

    

</script>