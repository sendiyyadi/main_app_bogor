<?php $this->load->view('_head'); ?>
<?php $this->load->view(active_module().'/_navbar'); ?>

<script src="<?php echo base_url()?>assets/js_xls/excellentexport.js"></script>
<script src="<?php echo base_url()?>assets/js_pdf/jspdf.min.js"></script>
<script src="<?php echo base_url()?>assets/js_pdf/jspdf.plugin.autotable.src.js"></script>

<style>

.nav-tabs > .active > a, .nav-pills > .active > a:hover {
    color: blue;
}

#table1 {
   /** font-family: Arial, Arial, Helvetica, sans-serif;  **/
    border-collapse: collapse;
    font-size: 12px;
    width: 100%;
}

#table1 td, #table1 th {
    border: 1px solid #ddd;
    padding: 4px;
}

#table1 tr:nth-child(even){background-color: #f2f2f2;}
#table1 tr:hover {background-color: #ffa;}  /** #ddd=abu2  #ffa=kuning   *****/

#table1 th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: center;
    background: #4CAF50;  /* warna hijau */
    color: white;
}

#table2, #table3 {
   /** font-family: Arial, Arial, Helvetica, sans-serif;  **/
    border-collapse: collapse;
    font-size: 12px;
    width: 100%;
}

#table2 td, #table2 th, #table3 td, #table3 th {
    border: 1px solid #ddd;
    padding: 4px;
}

#table2 tr:nth-child(even){background-color: #f2f2f2;}
#table2 tr:hover {background-color: #ffa;}  /** #ddd=abu2  #ffa=kuning   *****/

#table3 tr:nth-child(even){background-color: #f2f2f2;}
#table3 tr:hover {background-color: #ffa;}  /** #ddd=abu2  #ffa=kuning   *****/

#table2 th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: center;
    background: #4CAF50;  /* warna hijau */
    color: white;
}

#table3 th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: center;
    background: #4CAF50;  /* warna hijau */
    color: white;
}
body #cuDialogButton {

    /* new custom width */
    width: 600px;
    /* must be half of the width, minus scrollbar on the left (30px) */
   /** margin-left: 20px;  **/
      height: 75%;
   //** width: 100%;  **/

}

/* Hover tooltips */
.field-tip {
    position:relative;
    border-right: 30px dotted transparent;
    cursor:help;
}
.field-tip .tip-content {
    position:absolute;
    top:-10px; /* - top padding */
    left:9999px;
    width:200px;
    margin-left:-220px; /* width + left/right padding */
    padding:10px;
    color:#fff;
    background:#333;
    border-radius: 6px;

}

/* <http://css-tricks.com/snippets/css/css-triangle/> */
.field-tip .tip-content:before {
    content:' '; /* Must have content to display */
    position:absolute;
    top:50%;
    right:-16px; /* 2 x border width */
    width:0;
    height:0;
    margin-top:-8px; /* - border width */
    border:8px solid transparent;
    border-left-color:#333;
}
.field-tip:hover .tip-content {
    left:-30px;
    opacity:1;
}

.testimonial-group > .row {
  display: flex;
  flex-wrap: nowrap;
  overflow-x: auto;
  margin-left:1px;
  margin-right: 100px;
}

</style>

<script>

function get_judul() {
    var header = ['No.','Kode', 'Module','Path Menu'];
    return header; 
}

function get_data() {

	var d = new Date();
  	var n = d.getUTCMilliseconds();

    //var tabel_id = 'table2';
    //var get_data = oTable2.fnGetData();

    var table = $('#table2').DataTable();
    var get_data = table.fnGetData();
    //var get_data = oTable.fnGetData(); 

    var jason    = JSON.stringify(get_data);
    var get_dtl  = JSON.parse(jason);
    var dt_detil = [];

    for(var c = 0; c < get_dtl.length; c++) {
    	var x = c;
        var detailData = [
        	x,
            get_dtl[c][1],
            get_dtl[c][2],
            get_dtl[c][8]
        ];
        dt_detil.push(detailData);
    }
    /*
    for(var c = 0; c < get_dtl.length; c++) {
    	var x = (n+c);
        var detailData = [
        	x,
            get_dtl[c][1],
            get_dtl[c][2],
            get_dtl[c][8]
        ];
        dt_detil.push(detailData);
    }
	*/
    return dt_detil;
}

function generat_pdf_ori() {

    var judul = get_judul();// ['Kode', 'Kecamatan','Aktif'];
    var data  = get_data();//[];
    var doc   = new jsPDF('p', 'pt');
    doc.autoTable(judul, data);
    doc.save("data_export.pdf");
}

// Long data - shows how the overflow features looks and can be used

 function examples_long() {
//examples.long = function () {
    var doc = new jsPDF('l', 'pt');
    var columnsLong = getColumns().concat([
        {title: shuffleSentence(), dataKey: "text"},
        {title: "Text with a\nlinebreak", dataKey: "text2"}
    ]);

    doc.text("Overflow 'ellipsize' (default)", 10, 40);
    doc.autoTable(columnsLong, getData(), {
        startY: 55,
        margin: {horizontal: 10},
        columnStyles: {text: {columnWidth: 250}}
    });

    doc.text("Overflow 'linebreak'", 10, doc.autoTableEndPosY() + 30);
    doc.autoTable(columnsLong, getData(3), {
        startY: doc.autoTableEndPosY() + 45,
        margin: {horizontal: 10},
        styles: {overflow: 'linebreak'},
        bodyStyles: {valign: 'top'},
        columnStyles: {email: {columnWidth: 'wrap'}},
    });

    return doc;
};

function generat_pdf() {

    var judul = get_judul();// ['Kode', 'Kecamatan','Aktif'];
    var data  = get_data();//[];
    var doc   = new jsPDF('p', 'pt');
    
    doc.setFontSize(12);
    doc.setTextColor(0);
    doc.setFontStyle('bold');

    doc.text("Role Menu Akses", 10, doc.autoTableEndPosY() + 30);
    doc.autoTable(judul, data,{
    	margin: {horizontal: 10},
        styles: {overflow: 'linebreak'},
        bodyStyles: {valign: 'top'},
    });
    doc.save("data_export.pdf");
}

function fn_new_api(format) {

    var file_nm = "data_export";
    var header  = get_judul();
    var dt_main = [header];
    var data = get_data();//[];
    Array.prototype.push.apply(dt_main,data);

    return ExcellentExport.convert({
        anchor: 'anchor_new_api-' + format,
        filename: file_nm,
        format: format
    }, [{
        name: 'Sheet 1',
        from: {
            array: dt_main
        }
    }]);
}

var mID;
var dID;
var oTable;
var oTable2;
var oTable3;

var glo_module = "";
var glo_grup_id = "";
var glo_modul_id = "";
var glo_modules_btn_id = "";
var ket_btn = "";

function get_menu_utama(app_id){
    $.ajax({
        url: "<?php echo active_module_url()?>privileges/get_menu_utama/"+app_id,
        success: function (j) {
            var data = $.parseJSON(j);
            var select = $('#root_id');
            select.html("");
            $.each(data, function(i, val){
                select.append($('<option />', { value: val['ROOT_ID'], text: val['NAMA'] }));
            });
        },
        error: function (xhr, desc, er) {
            alert(er);
        }
    });
}

function btn_tambah_subdtl() {

	if (glo_module == '') {
		alert("Module belum di Pilih...!");
    } else {
		document.getElementById('cuDialogButtonLabel').innerHTML ='Tambah Button'; 
		document.getElementById('dtl_module').value = glo_module; 
		document.getElementById('dtl_modul_id').value = glo_modul_id; 

		document.getElementById('dtl_nama').value = ''; 
		document.getElementById('dtl_kode').value = ''; 
		document.getElementById('dtl_btn_no').value = ''; 

        $('#cuDialogButton').modal('show');    	
    }
};
 
function tambah_btn_detil() {

  	var nama      = document.getElementById('dtl_nama').value;
  	var module_id = glo_modul_id;
  	var kode      = document.getElementById('dtl_kode').value;
  	var btn_no    = document.getElementById('dtl_btn_no').value;

	var params = {
		nama: nama,
		module_id: module_id,
		kode: kode, 
		btn_no: btn_no,
	};
	var data_params = decodeURIComponent($.param(params));
 
	$.ajax({
		url: "<?php echo active_module_url()?>privileges/tambah_btn_detil/?"+data_params,
		async: false,
		success: function (data) {
			//$('#pajak_id').html(data);
			$('#cuDialogButton').modal('hide'); 
		},
		error: function (xhr, desc, er) {
			alert(er);
		}
	});	
 
}
 
$(document).ready(function() {

	oTable = $('#table1').dataTable({
		/* "sScrollY": "380px", */
		"bScrollCollapse": true,
		"bPaginate": false,
		"bJQueryUI": true,
		"sDom": '<"toolbar">frtip',

		"aaSorting": [[ 0, "asc" ]],
		"aoColumnDefs": [
			{ "bSearchable": false, "bVisible": false, "aTargets": [0] }
		],
		"aoColumns": [
			null,
			{ "sWidth": ""},
			{ "sWidth": "" }
            
		],
		"fnRowCallback": function (nRow, aData, iDisplayIndex) {
			$(nRow).on("click", function (event) {
				if ($(this).hasClass('row_selected')) {
	
					glo_module = ""; glo_modul_id = ""; glo_modules_btn_id = "";

				} else {
					var data = oTable.fnGetData( this );
					mID = data[0];
					glo_grup_id = data[0];
					dID = '';
					glo_module = ""; glo_modul_id = ""; glo_modules_btn_id = "";

					oTable.$('tr.row_selected').removeClass('row_selected');
					$(this).addClass('row_selected');
					//
					$('#root_id').val('0');
			    	$('#tp_modul').val("");

			    	var app_id   = $('#apps_id').val();
			    	var grup_id  = glo_grup_id;
			    	var modul_id = glo_modul_id;
			    	var root_id  = '0';
			    	var tp_modul = "";

					var params = {
			        	app_id: app_id, grup_id:grup_id, modul_id: modul_id, tp_modul: tp_modul, root_id: root_id,
					};
					var data_params = decodeURIComponent($.param(params));		
					oTable2.fnReloadAjax('<?php echo active_module_url();?>privileges/grid_go/?'+data_params);	
					oTable3.fnReloadAjax('<?php echo active_module_url();?>privileges/grid_btn_go/?'+data_params);
				}
			})
		},
		"fnInitComplete": function(oSettings, json) {
			if (!glo_grup_id) $('#apps_id').trigger('change');
		},
		"bSort": true,
		"bInfo": false,
		"bFilter": false,
		"bProcessing": false,
		"sAjaxSource": "<?php echo active_module_url();?>privileges/grid_grup_users"
	});

	oTable2 = $('#table2').dataTable({
		/* "sScrollY": "380px", */
		"bScrollCollapse": true,
		"bPaginate": true,
		"bJQueryUI": true,
		"sPaginationType": "full_numbers",
		"iDisplayLength": 10,
		"sDom": '<"toolbar2x">frtip',
		//"aaSorting": [[ 0, "asc" ]],
 		//"aaSorting": [[9,'desc'],[7,'desc'],[0,'desc']]  ,

		"aoColumnDefs": [
			{ "bSearchable": false, "bVisible": false, "aTargets": [0] },
			{ "bSearchable": false, "sClass": "center", "aTargets": [3] },
			{ "bSearchable": false, "sClass": "center", "aTargets": [4] },
			{ "bSearchable": false, "sClass": "center", "aTargets": [5] },
			{ "bSearchable": false, "sClass": "center", "aTargets": [6] },
			{ "bSearchable": false, "sClass": "center", "aTargets": [7] },
			{ "bSearchable": false, "bVisible": false, "aTargets": [9] },
		],
		"aoColumns": [
			null,
			{ "sWidth": "100px" },
			{ "sWidth": "150px" },
			{ "sWidth": "10px" },
			{ "sWidth": "10px" },
			{ "sWidth": "10px" },
			{ "sWidth": "10px" },
			{ "sWidth": "10px" },
			{ "sWidth": "250px" },
			null,
		],
		"fnRowCallback": function (nRow, aData, iDisplayIndex) {
			$(nRow).on("click", function (event) {
				if ($(this).hasClass('row_selected')) {
					/* dID = '';
					$(this).removeClass('row_selected'); */
					glo_module = ""; glo_modul_id = ""; glo_modules_btn_id = "";

				} else {
					var data = oTable2.fnGetData( this );
					dID = data[0];
					glo_module = data[2];
					glo_modul_id = data[0];
					glo_modules_btn_id = "";
					
					oTable2.$('tr.row_selected').removeClass('row_selected');
					$(this).addClass('row_selected');
					//
			    	var app_id   = $('#apps_id').val();
			    	var grup_id  = glo_grup_id;
			    	var modul_id = glo_modul_id;
					var params = {
			        	app_id: app_id, grup_id:grup_id, modul_id: modul_id,
					};
					var data_params = decodeURIComponent($.param(params));		
					oTable3.fnReloadAjax('<?php echo active_module_url();?>privileges/grid_btn_go/?'+data_params);
				}
			
			})
		},

		"bSort": false,
		"bInfo": false,
		"bProcessing": false,
		"bFilter": false,
		"sAjaxSource": "<?php echo active_module_url();?>privileges/grid_go/"
	});

	var tb2_array = ['<div class="btn-group pull-left">'];

	tb2_array.push('<?php echo $select_menu_utama;?>');

	tb2_array.push('<input class="input" type="text" maxlength="1" name="tp_modul" id="tp_modul" style="width:60px" placeholder="M/S/T"/>');
	tb2_array.push('<button id="btn_go" class="btn btn-primary" type="button">Cari</button>');
	tb2_array.push('<strong>&nbsp;&nbsp;</strong>');
	tb2_array.push('<button id="btn_refresh" class="btn btn-primary" type="button">Refresh</button>');
    tb2_array.push('</div>');
    /*
    var param ="return fn_new_api('xls');";
    excel = '<div class="btn-group pull-left">';
    excel = excel + '<a href="#" id="anchor_new_api-xls" onclick="'+param+'" class="btn btn-danger pull-left" type="button">';
    excel = excel + 'xls</a></div>';
    tb2_array.push(excel);

    var param ="return fn_new_api('csv');";
    excel = '<div class="btn-group pull-left">';
    excel = excel + '<a href="#" id="anchor_new_api-csv" onclick="'+param+'" class="btn btn-danger pull-left" type="button">';
    excel = excel + 'csv</a></div>';
    tb2_array.push(excel);
 
    pdf = '<div class="btn-group pull-left">';
    pdf = pdf + '<button id="btn_pdf" onclick="generat_pdf()" class="btn btn-danger pull-left" type="button">';
    pdf = pdf + 'pdf</button></div>';
    tb2_array.push(pdf);
    */
	var tb2 = tb2_array.join(' ');	
	$("div.toolbar2").html(tb2);

	oTable3 = $('#table3').dataTable({
		/* "sScrollY": "380px", */
		"bScrollCollapse": true,
		"bPaginate": false,
		"bJQueryUI": true,
		"sDom": '<"toolbar3x">frtip',
		"aaSorting": [[ 1, "asc" ]],
		"aoColumnDefs": [

			{ "bSearchable": false, "bVisible": false, "aTargets": [0] },
			{ "bSearchable": false, "bSortable": false, "bVisible": true, "sClass": "center", "aTargets": [1] },
			{ "bSearchable": false, "bSortable": false, "bVisible": true, "sClass": "center", "aTargets": [2] },
			{ "bSearchable": false, "bSortable": false, "bVisible": true, "sClass": "center", "aTargets": [3] },
			{ "bSearchable": false, "bSortable": false, "bVisible": true, "aTargets": [4] },
			/*
            {
              "aTargets": [2],  
                "mRender": function ( data, type, row ) {
				return '<span class="field-tip">'+ data  +
				    '<span class="tip-content">'+ row[4] +'</span></span>';  

                },                
            },
			*/
		],

		"aoColumns": [

			null,
			{ "sWidth": "5%" },
			{ "sWidth": "15%" },
			{ "sWidth": "12%" },
			null,			

		],

		"fnRowCallback": function (nRow, aData, iDisplayIndex) {
			$(nRow).on("click", function (event) {
				if ($(this).hasClass('row_selected')) {
					/* dID = '';
					$(this).removeClass('row_selected'); */
				} else {
					var data = oTable3.fnGetData( this );
					//dID = data[0];
					glo_modules_btn_id = data[0];
					//ket_btn = data[4];
					
					oTable3.$('tr.row_selected').removeClass('row_selected');
					$(this).addClass('row_selected');
				}
			});

		},

		"bSort": true,
		"bInfo": false,
		"bProcessing": false,
		"bFilter": false,
		"sAjaxSource": "<?php echo active_module_url();?>privileges/grid_btn_go/"
	});
 
	var tb3_array = [

		<?php //if(is_super_admin()) { 
			if ( $this->session->userdata('userid') == -1 ) {
		?>
		'<div class="btn-group">',
		'	<button id="btn_tambah_dtl" class="btn btn-info" onclick="btn_tambah_subdtl()" type="button">Tambah</button>',
		'	<button id="btn_delete_dtl" class="btn btn-danger" type="button">Hapus</button>',
		'</div>',
		<?php } ?> 
	];

	var tb3 = tb3_array.join(' ');	
	$("div.toolbar3").html(tb3);

	$('#btn_tambah').click(function() {

		// begin parameter  
		var app_id       = $('#apps_id').val();
		var app_selected = $("#apps_id option:selected").text();

		window.location = '<?php echo active_module_url();?>privileges/add/'+$('#apps_id').val()+'/'+app_selected; 

	});

	$('#btn_edit').click(function() {
		
		var app_selected = $("#apps_id option:selected").text();

		if(glo_modul_id) {
			window.location = '<?php echo active_module_url();?>privileges/edit/'+glo_modul_id+'/'+app_selected; 
		}else{
			alert('Silahkan pilih data yang akan diedit');
		}
	});

	$('#btn_delete').click(function() {
		if(glo_modul_id) {
			var hapus = confirm('Hapus data ini?');
			if(hapus==true) {
				window.location = '<?php echo active_module_url();?>privileges/delete/'+glo_modul_id;
			};
		}else{
			alert('Silahkan pilih data yang akan dihapus');
		}
	});

	$('#btn_go').click(function() {

		//alert('SSSSSSSSSSSSSS');
		if (!glo_grup_id) {select_top_row();}

		dID = ''; 
		glo_modul_id = ''; 
		glo_modules_btn_id = "";
		//
    	var app_id   = $('#apps_id').val();
    	var grup_id  = glo_grup_id;
    	var modul_id = glo_modul_id;
    	var root_id  = $('#root_id').val();
    	var tp_modul = $('#tp_modul').val();

		var params = {
        	app_id: app_id, grup_id:grup_id, modul_id: modul_id, tp_modul: tp_modul, root_id: root_id,
		};
		var data_params = decodeURIComponent($.param(params));		
		oTable2.fnReloadAjax('<?php echo active_module_url();?>privileges/grid_go/?'+data_params);	
		oTable3.fnReloadAjax('<?php echo active_module_url();?>privileges/grid_btn_go/?'+data_params);
	});

	$('#btn_refresh').click(function() {

		//alert('SSSSSSSSSSSSSS');
		if (!glo_grup_id) select_top_row();

		dID = ''; 
		glo_modul_id = ''; 
		glo_modules_btn_id = "";

		$('#tp_modul').val("");
		$('#root_id').val("0");
		//
    	var app_id   = $('#apps_id').val();
    	var grup_id  = glo_grup_id;
    	var modul_id = glo_modul_id;
    	var root_id  = '0';
    	var tp_modul = "";

		var params = {
        	app_id: app_id, grup_id:grup_id, modul_id: modul_id, tp_modul: tp_modul, root_id: root_id,
		};
		var data_params = decodeURIComponent($.param(params));		
		oTable2.fnReloadAjax('<?php echo active_module_url();?>privileges/grid_go/?'+data_params);	
		oTable3.fnReloadAjax('<?php echo active_module_url();?>privileges/grid_btn_go/?'+data_params);
	});

	$('#apps_id').change(function() {

		if (!glo_grup_id) select_top_row();
		dID = ''; 
		glo_modul_id = ''; 
		glo_modules_btn_id = "";
		//
    	var app_id   = $('#apps_id').val();
    	var grup_id  = glo_grup_id;
    	var modul_id = glo_modul_id;
    	var root_id  = '0';
    	var tp_modul = "";

		var params = {
        	app_id: app_id, grup_id:grup_id, modul_id: modul_id, tp_modul: tp_modul, root_id: root_id,
		};
		var data_params = decodeURIComponent($.param(params));

		get_menu_utama(app_id);

		oTable2.fnReloadAjax('<?php echo active_module_url();?>privileges/grid_go/?'+data_params);	
		oTable3.fnReloadAjax('<?php echo active_module_url();?>privileges/grid_btn_go/?'+data_params);
	});
		
	function select_top_row() {
		var nTop = $('#table1 tbody tr')[0];
		var iPos = oTable.fnGetPosition( nTop );

		/* Use iPos to select the row */
		var data = oTable.fnGetData(iPos);
		mID = data[0];
		glo_grup_id = data[0];
					
		$('#table1 tbody tr:eq(0)').addClass('row_selected');
	}

    $('#btn_dtl_simpan').click( function (e) {

		var dtl_nama = $('#dtl_nama').val();  
		var dtl_kode = $('#dtl_kode').val();  
		var dtl_btn_no = $('#dtl_btn_no').val();  // document.getElementById('dtl_btn_no').value ;

		if (dtl_kode == '') {	alert("Kode Button harus di isi...!"); return;}
		if (dtl_nama == '') {	alert("Keterangan harus di isi...!"); return;}
		if (dtl_btn_no == '') {	alert("No. Button harus di isi...!"); return;}
		if (dtl_btn_no == '0') {	alert("No. Button harus di isi...!"); return;}

		tambah_btn_detil();

    	var app_id   = $('#apps_id').val();
    	var grup_id  = glo_grup_id;
    	var modul_id = glo_modul_id;

		var params = {
        	app_id: app_id, grup_id:grup_id, modul_id: modul_id,
		};
		var data_params = decodeURIComponent($.param(params));		
		oTable3.fnReloadAjax('<?php echo active_module_url();?>privileges/grid_btn_go/?'+data_params);
    });

	$('#btn_delete_dtl').click(function(e) {

		if(glo_modules_btn_id && glo_modul_id) {
			var hapus = confirm('Hapus data ini?'+glo_modules_btn_id);
			if(hapus==true) {

				delete_btn_detil(glo_modules_btn_id);

		    	var app_id   = $('#apps_id').val();
		    	var grup_id  = glo_grup_id;
		    	var modul_id = glo_modul_id;

				var params = {
		        	app_id: app_id, grup_id:grup_id, modul_id: modul_id,
				};
				var data_params = decodeURIComponent($.param(params));		
				oTable3.fnReloadAjax('<?php echo active_module_url();?>privileges/grid_btn_go/?'+data_params);
			};
		} else{
			alert('Silahkan pilih data yang akan dihapus');
		}
	});

	$("#cuDialogButton").draggable({
         handle: ".modal-header"
    });

});

function update_stat(gid, grup_id, fld, a) {

	var val = Number(a);
	$.ajax({
	  url: '<?php echo active_module_url()?>privileges/update_stat/' + gid +'/' + grup_id +'/' + fld + '/' + val,
	  success: function(data) {
	  }
	});
}

function update_stat_role_btn(group_id, modules_id, modules_btn_id, flg) {

	var val = Number(flg);
	$.ajax({
	  url: '<?php echo active_module_url()?>privileges/upd_stat_role_btn/'+group_id+'/'+modules_id+'/'+modules_btn_id+'/'+val,
	  success: function(data) {
	  }
	});
}

function delete_btn_detil(modules_btn_id) {
	$.ajax({
	  url: '<?php echo active_module_url()?>privileges/hapus_btn_detil/'+modules_btn_id,
	  success: function(data) {
	  }
	});
}

</script>

<div class="content">
    <div class="container-fluid">

		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#"><strong>GROUP PRIVILEGES</strong></a>
			</li>
		</ul>

	  	<div  style="text-align: left; width:1400px">

	  		<?php echo msg_block();?>
	   
			<div class="span3" >
				<div class="span4" style="text-align: left; width:250px">
					<strong>Aplikasi :</strong>
					<select name="apps_id" id="apps_id" style="width:170px;height: 35px;"><?php echo $select_app_modul;?></select>
				</div>

				<table class="table table-bordered" id="table1">
					<thead>
						<tr>
							<th>Index</th>
							<th>Kode</th>
	                        <th>Nama Group</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>

			<div class="span6" style="text-align: left; width:700px;">
				<div style="overflow-x: auto; overflow-y: hidden;">
					<div class="span5" style="width:510px;">
						<div class="toolbar2"></div>
					</div>

	                <table class="table table-bordered" id="table2" style="width:1100px;">
	                    <thead>
	                        <tr>
	                            <th>Index</th>
	                            <th>Kode</th>
	                            <th>Module</th>
	                            <th>Baca</th>
	                            <th>Tambah</th>
	                            <th>Edit</th>
	                            <th>Hapus</th>
	                            <th>Level</th>
	                            <th>Path Menu</th>
	                            <th>root_id</th>
	                        </tr>
	                    </thead>
	                    <tbody>
	                    </tbody>
	                </table>
				</div>
	   		</div>

			<div class="span3" style="text-align: left;">
				<div class="span2" style="height: 35px;">
					<div class="toolbar3"></div>
				</div>
	            <table class="table table-bordered" id="table3">
	                <thead>
	                    <tr>
	                        <th>Index</th>
	                        <th>#</th>
	                        <th>Btn</th>
	                        <th>Hak</th>
	                        <th>Ket.</th>
	                    </tr>
	                </thead>
	                <tbody>
	                </tbody>
	            </table>
			</div>	
			
	  	</div>
	</div>

</div>

<?php $this->load->view('_foot'); ?>