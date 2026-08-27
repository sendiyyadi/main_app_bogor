<?= $this->load->view('layouts/headers'); ?>
<?= $this->load->view(active_module() . '/layouts/sidebar'); ?>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Catatan Pembayaran</h4>
                        <div class="page-title-right" id="test">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">E-Adm</a>
                                </li>
                                <li class="breadcrumb-item active">Catatan Pembayaran</li>
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

                        <div class="row">
                            <div class="input-group w-auto">
                                <div class="input-group-prepend">
                                    <span class="input-group-text rounded-end-0">NOP</span>
                                </div>
                                <div class="controls"><input type="text" id="nop" class="form-control" name="nop"></div>
                            </div>

                            <div class="col-md-4">
                                <button class="btn btn-primary" id="btn_cari">Cari</button>
                                <button class="btn btn-info" id="btn_ctk_pmb">Cetak Pembayaran</button>
                                <button class="btn btn-warning" id="btn_ctk_kurang_byr">Cetak Kurang Bayar</button>
                            </div>
                            <!-- <div class="col-md-2"></div> -->
                            <!-- <div class="col-md-2"></div> -->
                        </div>


                        <br>
                        <div style="overflow-x:auto; width:100%;">
                            <table class="table table-striped table-nowrap" id="table1" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>TAHUN</th>
                                        <th>NAMA WP</th>
                                        <th>LUAS TANAH</th>
                                        <th>NJOP TANAH</th>
                                        <th>LUAS BNG</th>
                                        <th>NJOP BNG</th>
                                        <th>KETETAPAN</th>
                                        <th>JML BAYAR</th>
                                        <th>DENDA BAYAR</th>
                                        <th>BLN TELAT</th>
                                        <th>DENDA BERJALAN</th>
                                        <th>SISA</th>
                                        <th>TGL BAYAR</th>
                                        <th>SISA 2</th>
                                        <th>STATUS TAGIHAN</th>
                                        <th>TERHUTANG</th>
                                        <th>PENGURANG</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th style="text-align:center" colspan="6">TOTAL</th>
                                        <th> </th>
                                        <th> </th>
                                        <th> </th>
                                        <th> </th>
                                        <th> </th>
                                        <th> </th>
                                        <th> </th>
                                        <th> </th>
                                        <th> </th>
                                        <th> </th>
                                        <th> </th>
                                    </tr>
                                </tfoot>
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
    var mNOPEL;
    var mSTS;
    var oTable;
    var statusLunas;
    var persen = 0;

    function test() {
        const today = new Date();
        const ymd = today.getFullYear().toString() +
            String(today.getMonth() + 1).padStart(2, '0') +
            String(today.getDate()).padStart(2, '0');

        console.log(ymd);
    }

    function reload_grid() {
        var nop = document.getElementById('nop').value;
        var params = {
            nop: nop,
        };

        var data_params = decodeURIComponent($.param(params));
        oTable.fnReloadAjax("<?php echo active_module_url(); ?>catatan_pembayaran/grid/?" + data_params);
    }

    function cek_lunas() {
        var nop = document.getElementById('nop').value;

        $.ajax({
            url: '<?php echo active_module_url('catatan_pembayaran/cek_lunas'); ?>',
            method: 'POST',
            data: {
                nop: nop
            },
            dataType: 'json',
            success: function(response) {
                statusLunas = response.lunas;
                console.log("Status lunas:", statusLunas);
            },
            error: function(xhr, status, error) {
                console.error("Error saat cek lunas:", error);
            }
        });
    }

    function format_number(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    function cetak(nop, rpt) {
        var url = '<?php echo active_module_url(); ?>catatan_pembayaran/cetak_rpt/' + rpt + '/' + nop;
        var winparams = 'width=' + screen.width + ',height=' + screen.height + ',directories=0,titlebar=0,toolbar=0,location=0,status=0,menubar=0,scrollbars=no,resizable=no';
        window.open(url, 'Laporan', winparams);
    }

    $(document).ready(function() {
        oTable = $('#table1').dataTable({
            "iDisplayLength": 100,
            "sPaginationType": "full_numbers",
            //  "bJQueryUI": true,
            "bAutoWidth": false,
            "sDom": '<"toolbar">frtip',
            "aaSorting": [
                [0, "desc"]
            ],
            "aoColumnDefs": [{
                    "aTargets": [0],
                    "bSearchable": true,
                    "bVisible": true,
                    "sWidth": "50px",
                    "sClass": ""
                },
                {
                    "aTargets": [1],
                    "bSearchable": true,
                    "bVisible": true,
                    "sWidth": "",
                    "sClass": ""
                },
                {
                    "aTargets": [2],
                    "bSearchable": false,
                    "bVisible": true,
                    "sWidth": "70px",
                    "sClass": "right"
                },
                {
                    "aTargets": [3],
                    "bSearchable": false,
                    "bVisible": true,
                    "sWidth": "",
                    "sClass": "right",
                    "mRender": function(data, type, full) {
                        return format_number(full[3]);
                    }
                },
                {
                    "aTargets": [4],
                    "bSearchable": false,
                    "bVisible": true,
                    "sWidth": "70px",
                    "sClass": "right"
                },
                {
                    "aTargets": [5],
                    "bSearchable": false,
                    "bVisible": true,
                    "sWidth": "",
                    "sClass": "right",
                    "mRender": function(data, type, full) {
                        return format_number(full[5]);
                    }
                },
                {
                    "aTargets": [6],
                    "bSearchable": false,
                    "bVisible": true,
                    "sWidth": "",
                    "sClass": "right"
                },
                {
                    "aTargets": [7],
                    "bSearchable": false,
                    "bVisible": true,
                    "sWidth": "",
                    "sClass": "right",
                    "mRender": function(data, type, full) {
                        return format_number(full[7]);
                    }
                },
                {
                    "aTargets": [8],
                    "bSearchable": false,
                    "bVisible": true,
                    "sWidth": "90px",
                    "sClass": "right",
                    "mRender": function(data, type, full) {
                        return format_number(full[8]);
                    }
                },
                {
                    "aTargets": [9],
                    "bSearchable": false,
                    "bVisible": false,
                    "sWidth": "50px",
                    "sClass": "center"
                },
                {
                    "aTargets": [10],
                    "bSearchable": false,
                    "bVisible": true,
                    "sWidth": "90px",
                    "sClass": "right",
                    "mRender": function(data, type, full) {
                        const today = new Date();
                        const thn = full[0];
                        const ymd = today.getFullYear().toString() +
                            String(today.getMonth() + 1).padStart(2, '0') +
                            String(today.getDate()).padStart(2, '0');

                        if(full[13] > 0){
                            return full[10];
                        } else {
                            return 0;
                        }
                    }
                },
                {
                    "aTargets": [11],
                    "bSearchable": false,
                    "bVisible": true,
                    "sWidth": "",
                    "sClass": "right"
                },
                {
                    "aTargets": [12],
                    "bSearchable": false,
                    "bVisible": true,
                    "sWidth": "80px",
                    "sClass": "center"
                },
                {
                    "aTargets": [13],
                    "bSearchable": false,
                    "bVisible": false,
                    "sWidth": "",
                    "sClass": "right"
                },
                {
                    "aTargets": [14],
                    "bSearchable": false,
                    "bVisible": false,
                    "sWidth": "",
                    "sClass": "right"
                },
                {
                    "aTargets": [15],
                    "bSearchable": false,
                    "bVisible": false,
                    "sWidth": "",
                    "sClass": "right"
                },
                {
                    "aTargets": [16],
                    "bSearchable": false,
                    "bVisible": false,
                    "sWidth": "",
                    "sClass": "right"
                },
            ],
            "fnRowCallback": function(nRow, aData, iDisplayIndex) {
                $(nRow).on("click", function(event) {
                    if ($(this).hasClass('row_selected')) {

                        $(this).removeClass('row_selected');
                    } else {
                        var data = oTable.fnGetData(this);

                        oTable.$('tr.row_selected').removeClass('row_selected');
                        $(this).addClass('row_selected');
                    }
                })
            },
            "fnDrawCallback": function(oSettings) {

            },
            "fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {
                var ttlKetetapan = 0;
                var ttlJmlByr = 0;
                var ttlDendaByr = 0;
                var ttlDendaBrjln = 0;
                var ttlSisa = 0;
                var ab = 0;
                var cd = 0;
                var ef = 0;
                var gh = 0;
                var ij = 0;
                for ( var i=0 ; i<aaData.length ; i++ ) {
                    ab = String(aaData[i][6]) ;
                    ab = ab.replace(/\./g,'');
                    // alert(ab);
                    ttlKetetapan += parseInt(ab);
                    
                    cd = String( aaData[i][7] ) ;
                    cd = cd.replace(/\./g,'');
                    ttlJmlByr += parseInt(cd);

                    ef = String( aaData[i][8] ) ;
                    ef = ef.replace(/\./g,'');
                    ttlDendaByr += parseInt(ef);

                    if(aaData[i][13] > 0){
                        gh = String( aaData[i][10] ) ;
                        gh = gh.replace(/\./g,'');
                    } else {
                        gh = 0;
                    }
                    // alert(gh);
                    
                    ttlDendaBrjln += parseInt(gh);

                    ij = String( aaData[i][11] ) ;
                    ij = ij.replace(/\./g,'');
                    ttlSisa += parseInt(ij);
                }
                
                
                
                /* Modify the footer row to match what we want */
                var nCells = nRow.getElementsByTagName('th');
                nCells[1].innerHTML = format_number(ttlKetetapan) ;
                nCells[2].innerHTML = format_number(ttlJmlByr) ;
                nCells[3].innerHTML = format_number(ttlDendaByr) ;
                nCells[4].innerHTML = format_number(ttlDendaBrjln) ;
                nCells[5].innerHTML = format_number(ttlSisa) ;
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
            "sAjaxSource": "<?php echo active_module_url(); ?>catatan_pembayaran/grid"
        });

        var tb_array = [];

        var tb = tb_array.join(' ');
        $("div.toolbar").html(tb);


        $('#btn_cari').click(function() {
            var nop = $("#nop").val();
            if (nop) {
                reload_grid()
                cek_lunas()
            } else {
                alert('NOP tidak boleh kosong');
            }
        });

        $('#btn_ctk_pmb').click(function() {
            var nop = $("#nop").val();
            if (nop) {
                cetak(nop, 'catatan_pembayaran');
            } else {
                alert('NOP tidak boleh kosong');
            }
        });

        $('#btn_ctk_kurang_byr').click(function() {
            // var nop = $("#nop").val();
            // var rpt = 'catatan_kurang_bayar';
            // if (nop) {
            //     var url = '<?php echo active_module_url(); ?>catatan_pembayaran/cetak_rpt_new/' + rpt + '/' + nop;
            //     var winparams = 'width=' + screen.width + ',height=' + screen.height + ',directories=0,titlebar=0,toolbar=0,location=0,status=0,menubar=0,scrollbars=no,resizable=no';
            //     window.open(url, 'Laporan', winparams);
            // } else {
            //     alert('NOP tidak boleh kosong');
            // }
            var nop = $("#nop").val();
            if(nop) {
                cetak(nop, 'catatan_kurang_bayar');
            }else{
                alert('NOP tidak boleh kosong');
            }
        });

        // test();

    });
</script>

