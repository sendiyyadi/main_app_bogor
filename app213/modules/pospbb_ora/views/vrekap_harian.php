<?php $this->load->view('_head'); ?>
<?php $this->load->view('_navbar'); ?>

<style type="text/css">

@import "<?php echo base_url()?>assets/css/pbbm.css";

.btn-cari {background-color: #0a25f7; color: white;} *//* Blue */
</style>
<script src="<?php echo base_url()?>assets/js_xls/excellentexport.js"></script>
<script src="<?php echo base_url()?>assets/js_pdf/jspdf.min.js"></script>
<script src="<?php echo base_url()?>assets/js_pdf/jspdf.plugin.autotable.src.js"></script>

<script>

var oTable;

   function get_judul(param) {
    var header1 = ['Tanggal', 'Uraian','Thn.SPPT','Pokok','Denda','Bayar'];
    var header2 = [
        {title: "Tanggal", dataKey: "tanggal"},
        {title: "Uraian", dataKey: "uraian"},
        {title: "Thn.SPPT", dataKey: "thn_sppt"},
        {title: "Pokok", dataKey: "pokok"},
        {title: "Denda", dataKey: "denda"},
        {title: "Bayar", dataKey: "bayar"}
    ];
    if(param == 3){
        return header2; 
    }else{
        return header1; 
    }
    
}
function formatRupiah(angka){
          
    var number_string = angka.toString(),
    sisa    = number_string.length % 3,
    rupiah  = number_string.substr(0, sisa),
    ribuan  = number_string.substr(sisa).match(/\d{3}/g);
        
    if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }
    return rupiah;
}

function get_data(param) {

    var table = $('#datatable').DataTable();
    var get_data = table.fnGetData();
    var jason    = JSON.stringify(get_data);
    var get_dtl  = JSON.parse(jason);
    var dt_detil = [];
    var sum_pokok =0;
    var sum_denda= 0;
    var sum_bayar= 0;
    var data = [];
    var rp_pokok = $('#pokok').html();
    var rp_denda = $('#denda').html();
    var rp_bayar = $('#total').html();
    var tambahan = ["TOTAL","","",rp_pokok,rp_denda,rp_bayar];
    get_dtl.push(tambahan);
    if(param == 3){
        for (var a = 0; a < get_dtl.length; a++) {
        data.push({
            tanggal: get_dtl[a][0],
            uraian: get_dtl[a][1],
            thn_sppt: get_dtl[a][2],
            pokok: get_dtl[a][3],
            denda: get_dtl[a][4],
            bayar: get_dtl[a][5]
        });
    }
        return data;
    }else{
        for (var i = 0; i < get_dtl.length; i++) {
            var pokok = get_dtl[i][3].replace(/[,.]/gi,'');
            var denda = get_dtl[i][4].replace(/[,.]/gi,'');
            var bayar = get_dtl[i][5].replace(/[,.]/gi,'');
            dt_detil.push([get_dtl[i][0],
            get_dtl[i][1],
            get_dtl[i][2],
            parseFloat(pokok),
            parseFloat(denda),
            parseFloat(bayar)
            ]);
        }
        return dt_detil;    
    }
}

function generat_pdf(){
    var doc = new jsPDF('p', 'pt');
    var judul;
    var data;
    var namafile;
        judul = get_judul(3);
        data = get_data(3);
        namafile = 'Rekap_Harian.pdf';
        doc.text("Transaksi Pembayaran - Rekap Harian", 160, 50);
    
    // for(var c = 0; c < data.length; c++)
    var t_row = data.length-1;
   
    // var res = doc.autoTableHtmlToJson(document.getElementById("datatable"));
    // console.log(data.length);
    doc.autoTable(judul, data, {
        startY: 60,
        margin: {horizontal: 5},
        styles: {overflow: 'linebreak'},
        bodyStyles: {valign: 'top',fontSize:9},
        columnStyles: {fontSize:9},
       createdCell: function (cell, data) {
            if (data.column.dataKey === 'pokok') {
                cell.styles.halign = 'right';
            }
             if (data.column.dataKey === 'denda') {
                cell.styles.halign = 'right';
            }  
             if (data.column.dataKey === 'bayar') {
                cell.styles.halign = 'right';
            } 
        }

    });
    // return doc;
    doc.save(namafile);
}

function fn_new_api(format) {
    var file_nm = "data_export";
    var header;
    var data;
    var namafile;
        header = get_judul(1);
        data = get_data(1);
        namafile = "Rekap_harian";
    
    var dt_main = [header];
    
    Array.prototype.push.apply(dt_main,data);

    return ExcellentExport.convert({
        anchor: 'anchor_new_api-' + format,
        filename: namafile,
        format: format
    }, [{
        name: 'Sheet 1',
        from: {
            array: dt_main
        }
    }]);
}
    $(document).ready(function() {
        
        oTable = $('#datatable').dataTable( {
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
            // "sDom":'<"toolbar">fTl<"clear">rtip',
            "sDom":'<"toolbar">frtip',
            // "sDom": '<"H"lfr>t<"F"ip>T',

            "aoColumns" : [
                { sWidth: '14%', sClass: "center" },   
                null,  
                { sWidth: '6%', sClass: "center" },
                { sWidth: '10%', sClass: "right" },   
                { sWidth: '8%', sClass: "right" },
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

        var tb_array = [];
        var param ="return fn_new_api('xls');";
        excel = '<div class="pull-left">';
        excel = excel + '<a href="#" id="anchor_new_api-xls" onclick="'+param+'" class="btn pull-left" type="button">';
        excel = excel + 'xls</a></div>';
        tb_array.push(excel);

        var param ="return fn_new_api('csv');";
        excel = '<div class="pull-left">';
        excel = excel + '<a href="#" id="anchor_new_api-csv" onclick="'+param+'" class="btn pull-left" type="button">';
        excel = excel + 'csv</a></div>';
        tb_array.push(excel);
     
        pdf = '<div class=" pull-left">';
        pdf = pdf + '<button id="btn_pdf" onclick="generat_pdf()" class="btn pull-left" type="button">';
        pdf = pdf + 'pdf</button></div>';
        tb_array.push(pdf);
        var tb = tb_array.join(' ');
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

        $("#btngo").click(function() {

            var tglawal  = $("#tglawal").val();
            var tglakhir = $("#tglakhir").val();
            var kec_kd   = $("#kec_kd").val();
            var kel_kd   = $("#kel_kd").val();
            var buku     = $("#buku").val();
            var tahun_sppt1 = $("#tahun_sppt1").val();
            var tahun_sppt2 = $("#tahun_sppt2").val();
            var tp          = $("#tp_kd").val();

            var params = "?tglawal="+tglawal+"&tglakhir="+tglakhir+"&tahun_sppt1="+tahun_sppt1+"&tahun_sppt2="+tahun_sppt2+"&kec_kd="+kec_kd;
            params     = params +"&kel_kd=" + kel_kd + "&buku=" + buku + "&tp_kd=" + tp;
            window.location = "<?php echo active_module_url().'rekap_harian'?>" + params;

        });

        $("#kec_kd, #kel_kd").change(function(){
            
            var tglawal  = $("#tglawal").val();
            var tglakhir = $("#tglakhir").val();
            
            if($(this).attr('name')=='kec_kd'){ $("#kel_kd").val('000');}

            var kec_kd = $("#kec_kd").val();
            var kel_kd = $("#kel_kd").val();
            var buku   = $("#buku").val();
            var tahun_sppt1 = $("#tahun_sppt1").val();
            var tahun_sppt2 = $("#tahun_sppt2").val();
            var tp          = $("#tp_kd").val();

            var params = "?tglawal="+tglawal+"&tglakhir="+tglakhir+"&tahun_sppt1="+tahun_sppt1+"&tahun_sppt2="+tahun_sppt2+"&kec_kd="+kec_kd;
            params     = params +"&kel_kd=" + kel_kd + "&buku=" + buku + "&tp_kd=" + tp;
            window.location = "<?php echo active_module_url().'rekap_harian'?>" + params;
            
        });

        $('#btnprint').click(function() {

            var tglawal = $("#tglawal").val();
            var tglakhir = $("#tglakhir").val();
            var tahun_sppt1 = $("#tahun_sppt1").val();
            var tahun_sppt2 = $("#tahun_sppt2").val();
            var kec_kd = $("#kec_kd").val();
            var kel_kd = $("#kel_kd").val();
            var buku = $("#buku").val();
            var tp = $("#tp_kd").val();

            var winparams = 'location=1,status=1,scrollbars=1,resizable=no,width='+screen.width+',height='+screen.height+',menubar=no,toolbar=no,fullscreen=no';
            window.open("<?php echo active_module_url().'trans_rpt/cetak/pdf/2'?>/"+ kec_kd +"/"+ kel_kd +"/"+ tahun_sppt1 +"/"+ tahun_sppt2+ "/" + buku +"/" + tglawal +"/"+ tglakhir+"/"+tp, 'Laporan', winparams);

        });
        
        $('#btn_csv').click(function() {
            var rpt_type = <?php echo $trantypes;?>;
            var url = '<?php echo active_module_url('trans_rpt/csv_rekap_harian');?>';
                    
            $('#myform').attr('action', url);
            $('#myform').submit();
            return false;
        });

    });

</script>

<div class="content">
    <div class="container-fluid">
        <ul class="nav nav-tabs" id="myTab">
            <li class="active"><a data-toggle="tab" href="#transaksi"><strong>Transaksi Pembayaran - Rekap Harian</strong></a></li>
        </ul>
        <!--div class="form-horizontal"-->
        <?php echo form_open('#',array('id'=>'myform', 'class'=>'form-horizontal'));?>
            <div class="control-group">
                <label class="control-label">Tanggal</label> 
                <div class="controls">
                    <input style="width:80px;" id="tglawal" name="tglawal" width="5" type="text" value="<?php if(isset($tglawal)) echo $tglawal?>"/>
                    s.d. <input style="width:80px;" id="tglakhir" name="tglakhir" type="text" value="<?php if(isset($tglakhir)) echo $tglakhir?>"/>
                </div>
            </div>
        
            <div class="control-group">
                <label class="control-label">Thn. SPPT</label> 
                <div class="controls">
                <?php echo $select_thn_sppt1;?> 
                s.d
                <?php echo $select_thn_sppt2;?> 
                Buku
                <?php echo $select_buku;?>
                TP Bayar
                <?php echo $select_tp_bayar;?> 
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
                    <th>Thn.SPPT</th>
                    <th>Pokok</th>
                    <th>Denda</th>
                    <th>Bayar</th>

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
                </tr>
            </tbody>
            <tfoot>
                <tr>

                    <td colspan="3">TOTAL</td>
                    <td><span id="pokok">&nbsp;</span></td>
                    <td><span id="denda">&nbsp;</span></td>
                    <td><span id="total">&nbsp;</span></td>

                </tr>
            </tfoot>
        </table>
    </div>
</div>
<?php $this->load->view('_foot'); ?>
