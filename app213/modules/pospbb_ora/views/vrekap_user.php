<?php $this->load->view('_head'); ?>
<?php $this->load->view(active_module().'/_navbar'); ?>
<style type="text/css">
@import "<?php echo base_url()?>assets/css/pbbm.css";
.btn-cari {background-color: #0a25f7; color: white;} *//* Blue */
</style>

<script>

$(document).ready(function() {

    var oTable = $('#datatable').dataTable( {
        "iDisplayLength": 100,
        "sScrollY": "260px",
        "bJQueryUI" : true,
        "bAutoWidth": true,
        "bScrollCollapse": false,
        "bLengthChange": false,
        "bPaginate": true,
        "bFilter": true,
        "sPaginationType" : "full_numbers",
        "bSort": false,
        "bInfo": true,
        "bServerSide": false,
        "bProcessing": true,
        "sAjaxSource": "<?php echo $data_source?>",
        "sDom":'<"toolbar">fTl<"clear">rtip',
        // "sDom": '<"H"lfr>t<"F"ip>T',

        "aoColumns" : [
            { sWidth: '14%', sClass: "center" },   
            null,  
            { sWidth: '10%', sClass: "right" },   
            { sWidth: '8%', sClass: "right" },
            { sWidth: '10%', sClass: "right" },

            { sWidth: '10%', sClass: "right" },
            
        ],
        
        "aoColumnDefs": [ 
            { "bSearchable": false, "aTargets": [ 0 ], "bSortable": true, "aTargets": [ 0 ] },
            { "bSearchable": false, "aTargets": [ 1 ], "bSortable": true, "aTargets": [ 1 ] }
        ],
        
        "oTableTools": {
            "sSwfPath": "<?php echo base_url()?>assets/datatables/extras/TableTools/media/swf/copy_csv_xls_pdf.swf"
        },
        
        "oLanguage": {
            "sProcessing":   "<img border='0' src='<?php echo base_url('assets/img/ajax-loader-big-circle-ball.gif')?>' />",
            "sLengthMenu":   "Tampilkan _MENU_",
            // "sZeroRecords":  "Tidak ada data",
            "sInfo":         "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
            "sInfoEmpty":    "Menampilkan 0 sampai 0 dari 0 entri",
            "sInfoFiltered": "(disaring dari _MAX_ entri keseluruhan)",
            "sInfoPostFix":  "",
            "sSearch":       "Cari : ",
            "sUrl":          "",
        },
        "fnServerData": function ( sSource, aoData, fnCallback ) {
            $.getJSON( sSource, aoData, function (json) {
                //Here you can do whatever you want with the additional data
                // console.dir(json);
                $('#pokok').html(json['pokok']);
                $('#denda').html(json['denda']);
                $('#total').html(json['total']);
                
                //Call the standard callback to redraw the table
                fnCallback(json);
            });
        },
    });

    var tb_array = [
        '<div class="btn-group pull-left">',
        '   <button class="btn btn-success" id="btnprint">Print Format</button>',
        '</div>',
    ];
    var tb = ''; //tb_array.join(' ');
    $("div.toolbar").html(tb);
    /*
    $( "#tglawal, #tglakhir" ).datepicker({
        dateFormat:'dd-mm-yy', 
        changeMonth:true, 
        changeYear:true
    });
    */
    var tglawal_dtp = $('#tglawal').datepicker({
        format: 'dd-mm-yyyy'
    }).on('changeDate', function(ev) {
        tglawal_dtp.hide();
    }).data('datepicker');

    var tglakhir_dtp = $('#tglakhir').datepicker({
        format: 'dd-mm-yyyy'
    }).on('changeDate', function(ev) {
        tglakhir_dtp.hide();
    }).data('datepicker');

    $("#btngo").click(function(){

        var tglawal  = $("#tglawal").val();
        var tglakhir = $("#tglakhir").val();
        var kec_kd   = $("#kec_kd").val();
        var kel_kd   = $("#kel_kd").val();
        var buku     = $("#buku").val();
        var user_kd = $("#user_kd").val();

        var params = "?tglawal="+tglawal+"&tglakhir="+tglakhir+"&kec_kd="+kec_kd;
        params     = params +"&kel_kd=" + kel_kd + "&buku=" + buku + "&user_kd=" + user_kd;
        window.location = "<?php echo active_module_url().'rekap_user'?>" + params;

    });

    $("#kec_kd, #kel_kd").change(function(){

        var tglawal  = $("#tglawal").val();
        var tglakhir = $("#tglakhir").val();
        
        if($(this).attr('name')=='kec_kd') $("#kel_kd").val('000');

        var kec_kd  = $("#kec_kd").val();
        var kel_kd  = $("#kel_kd").val();
        var buku    = $("#buku").val();
        var user_kd = $("#user_kd").val();

        var params = "?tglawal="+tglawal+"&tglakhir="+tglakhir+"&kec_kd="+kec_kd;
        params     = params +"&kel_kd=" + kel_kd + "&buku=" + buku + "&user_kd=" + user_kd;
        window.location = "<?php echo active_module_url().'rekap_user'?>" + params;

    });

    $('#btnprint').click(function() {

        var tglawal = $("#tglawal").val();
        var tglakhir = $("#tglakhir").val();
        var kec_kd = $("#kec_kd").val();
        var kel_kd = $("#kel_kd").val();
        var buku = $("#buku").val();
        var user_kd = $("#user_kd").val();
        var winparams = 'location=1,status=1,scrollbars=1,resizable=no,width='+screen.width+',height='+screen.height+',menubar=no,toolbar=no,fullscreen=no';
        window.open("<?php echo active_module_url().'trans_rpt/cetak/pdf/2'?>/"+ kec_kd +"/"+ kel_kd +"/"+ "/" + buku +"/" + tglawal +"/"+ tglakhir+"/"+user_kd, 'Laporan', winparams);
    });
    
    $('#btn_csv').click(function() {
        var rpt_type = <?php echo $trantypes;?>;
        var url = '<?php echo active_module_url('trans_rpt/csv_rekap_user');?>';
              
        $('#myform').attr('action', url);
        $('#myform').submit();
        return false;
    });

});

</script>

<div class="content">
    <div class="container-fluid">
        <ul class="nav nav-tabs" id="myTab">
            <li class="active"><a data-toggle="tab" href="#"><strong>Transaksi User - Rekap User</strong></a></li>
        </ul>
        <!--div class="form-horizontal"-->
        <?php echo form_open('#',array('id'=>'myform', 'class'=>'form-horizontal'));?>
            <div class="control-group">
                <label class="control-label">Tanggal</label> 
                <div class="controls">
                    <input style="width:80px;" id="tglawal" name="tglawal" width="5" type="text" value="<?php if(isset($tglawal)) echo $tglawal?>"/>
                    s.d. <input style="width:80px;" id="tglakhir" name="tglakhir" type="text" value="<?php if(isset($tglakhir)) echo $tglakhir?>"/>
                    Buku
                    <?php echo $select_buku;?>
                    User
                    <?php echo $select_users;?>
                    <button type="button" class="btn" id="btngo" name="btngo">Go</button>

                </div>
            </div>
        
            <div class="control-group">
                <label class="control-label">Kecamatan</label> 
                <div class="controls">
                    <?php echo $select_kecamatan;?>
                    Kelurahan 
                    <?php echo $select_kelurahan;?>
                    <button type="button" class="btn btn-success" id="btnprint">Print Format</button>
                    <button type="button" class="btn btn-success" id="btn_csv" name="btn_csv">Download (CSV)</button>
                </div>
            </div>
        </form>
        
        <hr>
        
        <table class="display" id="datatable">
            <thead>
                <tr>

                    <th>Tanggal</th>

                    <th>Uraian</th>
                    <th>Pokok</th>
                    <th>Denda</th>
                    <th>Bayar</th>

                    <th>User</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td></td>

                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>

                    <td></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2">TOTAL</td>
                    <td><span id="pokok">&nbsp;</span></td>
                    <td><span id="denda">&nbsp;</span></td>
                    <td><span id="total">&nbsp;</span></td>

                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
<?php $this->load->view('_foot'); ?>