<?php $this->load->view('_head'); ?>
<?php $this->load->view(active_module().'/_navbar'); ?>

<script>

function show_rpt(rpt){

	var id = "0";
    var rptparams = {rpt: rpt, id: id, }
 	//
    var data = decodeURIComponent($.param(rptparams));
    var url  = '<?php echo active_module_url(); ?>pos_user/cetak_draft/pdf/?'+data;
    //
    var winparams = 'width='+screen.width+',height='+screen.height+',directories=0,titlebar=0,toolbar=0,location=0,status=0,menubar=0,scrollbars=no,resizable=no';
    window.open(url, 'Laporan', winparams);
}

var mID;
var oTable;

$(document).ready(function() {

	oTable = $('#table1').dataTable({

		"sScrollY": "380px",
		"bScrollCollapse": true,
		"bPaginate": false,
		"bJQueryUI": true,
		"sDom": '<"toolbar">frtip',

		"aoColumnDefs": [
			{ "bSearchable": false, "bVisible": false, "aTargets": [0]}
		],
		"aoColumns": [
			{ "sWidth": "6%" },
			{ "sWidth": "12%" },
			{ "sWidth": "12%" },
			{ "sWidth": "16%" },
			{ "sWidth": "16%" },
			null, null, null,
		],
		"fnRowCallback": function (nRow, aData, iDisplayIndex) {
			$(nRow).on("click", function (event) {
				if ($(this).hasClass('row_selected')) {
					/* mID = '';
					$(this).removeClass('row_selected'); */
				} else {
					var data = oTable.fnGetData( this );
					mID = data[0];
					
					oTable.$('tr.row_selected').removeClass('row_selected');
					$(this).addClass('row_selected');
				}
			})
		},
		"bSort": true,
		"bInfo": false,
		"bProcessing": false,
		"sAjaxSource": "<?php echo active_module_url();?>pos_user/grid"
	});

	var tb_array  = ['<div class="btn-group pull-left">'];
	if ("<?php echo $hak_edit?>" == 1) {tb_array.push(' <button id="btn_edit" class="btn pull-left" type="button">Edit Tp Bayar</button>');}
	tb_array.push('<button id="btn_cetak" class="btn pull-left" type="button">Tes CETAK</button>');
	tb_array.push('</div>');
	var tb = tb_array.join(' ');
	$("div.toolbar").html(tb);


	$('#btn_edit').click(function() {
		if(mID) {
			window.location = '<?php echo active_module_url();?>pos_user/edit/'+mID;
		}else{
			alert('Silahkan pilih data yang akan diedit');
		}
	});

    $("[id=btn_cetak]").click(function(){
            show_rpt('rpt');

    });	

});

function update_unit(id, a) {
	var val = Number(a);
	$.ajax({
	  url: '<?php echo active_module_url()?>pos_user/update_unit/' + id + '/' + val,
	  success: function(data) {
		/*  */
	  }
	});
}

function disable_user(id, a) {
	var val = Number(a);
	$.ajax({
	  url: '<?php echo active_module_url()?>pos_user/disable_user/' + id + '/' + val,
	  success: function(data) {
		/*  */
	  }
	});
}
</script>

<div class="content">
    <div class="container-fluid">
		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#"><strong>USERS</strong></a>
			</li>
		</ul>
		
		<?php echo msg_block();?>
		
		<table class="table" id="table1">
			<thead>
				<tr>
					<th>Index</th>
					<th>User ID</th>
					<th>Nama</th>
					<th>Nip</th>
					<th>Nama Pegawai(PBB)</th>
					<th>Jabatan</th>
					<th>Tempat Pembayaran</th>
					<th>Alamat Tempat Pembayaran</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</div>
</div>
<?php $this->load->view('_foot'); ?>