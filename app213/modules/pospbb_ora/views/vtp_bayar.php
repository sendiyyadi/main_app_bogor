<?php $this->load->view('_head'); ?>
<?php $this->load->view(active_module() . '/_navbar'); ?>

<script>
	var mID;
	var oTable;

	$(document).ready(function() {
		oTable = $('#table1').dataTable({
			"sScrollY": "380px",
			"bScrollCollapse": true,
			"bPaginate": false,
			"bJQueryUI": true,
			"sDom": '<"toolbar">frtip',

			"aoColumnDefs": [{
					"bSearchable": true,
					"bVisible": true,
					"aTargets": [0]
				},
				{
					"bSearchable": true,
					"bVisible": true,
					"aTargets": [4]
				},
				{
					"bSearchable": true,
					"bVisible": true,
					"aTargets": [5]
				},
			],
			"aoColumns": [{
					"sWidth": "8%"
				},
				{
					"sWidth": "8%"
				},
				{
					"sWidth": "8%"
				},
				{
					"sWidth": "8%"
				},
				{
					"sWidth": "30%"
				},
				null,
			],
			"fnRowCallback": function(nRow, aData, iDisplayIndex) {
				$(nRow).on("click", function(event) {
					if ($(this).hasClass('row_selected')) {
						/* mID = '';
						$(this).removeClass('row_selected'); */
					} else {
						var data = oTable.fnGetData(this);
						mID = data[0];

						oTable.$('tr.row_selected').removeClass('row_selected');
						$(this).addClass('row_selected');
					}
				})
			},
			"bSort": true,
			"bInfo": false,
			"bProcessing": false,
			"sAjaxSource": "<?php echo active_module_url(); ?>tp_bayar/grid"
		});

		/*
		var tb_array  = ['<div class="btn-group pull-left">'];
		if ("<?php echo $hak_add ?>" == 1)  {tb_array.push('<button id="btn_tambah" class="btn pull-left" type="button">Tambah</button>');}
		if ("<?php echo $hak_edit ?>" == 1) {tb_array.push(' <button id="btn_edit" class="btn pull-left" type="button">Edit</button>');}
		if ("<?php echo $hak_delete ?>" == 1){tb_array.push('   <button id="btn_delete" class="btn pull-left" type="button">Hapus</button>');}
		if ("<?php echo $hak_view ?>" == 1) {tb_array.push('<button id="btn_view" class="btn pull-left" type="button">View</button>');}
		tb_array.push('</div>');
		var tb = tb_array.join(' ');
		$("div.toolbar").html(tb);
		*/

		$('#btn_tambah').click(function() {
			window.location = '<?php echo active_module_url(); ?>tp_bayar/add/';
		});

		$('#btn_edit').click(function() {
			if (mID) {
				window.location = '<?php echo active_module_url(); ?>tp_bayar/edit/' + mID;
			} else {
				alert('Silahkan pilih data yang akan diedit');
			}
		});

		$('#btn_delete').click(function() {
			if (mID) {
				var hapus = confirm('Hapus data ini?');
				if (hapus == true) {
					window.location = '<?php echo active_module_url(); ?>tp_bayar/delete/' + mID;
				};
			} else {
				alert('Silahkan pilih data yang akan dihapus');
			}
		});
	});
</script>

<div class="content">
	<div class="container-fluid">
		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#"><strong>TEMPAT PEMBAYARAN</strong></a>
			</li>
		</ul>

		<?php echo msg_block(); ?>

		<table class="table" id="table1">
			<thead>
				<tr>
					<th>Kode</th>
					<th>Kanwil</th>
					<th>Kantor</th>
					<th>Tipe</th>
					<th>Nama TP</th>
					<th>Alamat TP</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</div>
</div>
<?php $this->load->view('_foot'); ?>