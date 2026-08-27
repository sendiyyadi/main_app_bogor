<?php $this->load->view('_head'); ?>
<?php $this->load->view(active_module().'/_navbar'); ?>

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
            background-color: #4CAF50;  /* warna hijau */
            color: white;
        }


        #table2 {
           /** font-family: Arial, Arial, Helvetica, sans-serif;  **/
            border-collapse: collapse;
            font-size: 12px;
            width: 100%;
        }

        #table2 td, #table2 th {
            border: 1px solid #ddd;
            padding: 4px;
        }

        #table2 tr:nth-child(even){background-color: #f2f2f2;}

        #table2 tr:hover {background-color: #ffa;}  /** #ddd=abu2  #ffa=kuning   *****/

        #table2 th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: center;
            background-color: #4CAF50;  /* warna hijau */
            color: white;
        }

</style>

<script>
var mID;
var dID;
var oTable;
var oTable2;

function reload_detail() {
	//
    document.getElementById('nama').value='';
    document.getElementById('user_login').value='';
    document.getElementById('disabled_id').value='0';
    document.getElementById('level_id').value='9';

    $("#in_group").prop("checked", false);

	var group_id = mID;

	if($('#in_group').is(':checked')) {in_grup = 1;} else {in_grup = 0;}

	var sts_disabled = $('#disabled_id').val();
    var usr_login     = $('#user_login').val();
    var nama         = $('#nama').val();
    var lvl_id       = $('#level_id').val();

	var params = {
        group_id:group_id, in_grup:in_grup, sts_disabled:sts_disabled, usr_login:usr_login, nama:nama, lvl_id:lvl_id
	};
	var data_params = decodeURIComponent($.param(params));		
	oTable2.fnReloadAjax('<?php echo active_module_url();?>groups/grid_users_in_grup/?'+data_params);
}

function reload_grid() {
	//
	var group_id = mID;
	if($('#in_group').is(':checked')) {in_grup = 1;} else {in_grup = 0;}

	var sts_disabled = $('#disabled_id').val();
    var usr_login    = $('#user_login').val();
    var nama         = $('#nama').val();
    var lvl_id       = $('#level_id').val();

	var params = {
        group_id:group_id, in_grup:in_grup, sts_disabled:sts_disabled, usr_login:usr_login, nama:nama, lvl_id:lvl_id
	};
	var data_params = decodeURIComponent($.param(params));		
	oTable2.fnReloadAjax('<?php echo active_module_url();?>groups/grid_users_in_grup/?'+data_params);
}

function refresh_grid() {

    document.getElementById('nama').value='';
    document.getElementById('user_login').value='';
    document.getElementById('disabled_id').value='0';
    document.getElementById('level_id').value='9';

    $("#in_group").prop("checked", false);
	reload_grid();	
}

$(document).ready(function() {

	oTable = $('#table1').dataTable({
	//	"sScrollY": "380px",
		"bScrollCollapse": true,
		"bPaginate": false,
	//	"bJQueryUI": true,
		"sDom": '<"toolbarx">frtip',

		"aoColumnDefs": [
			{ "bSearchable": false, "bVisible": false, "aTargets": [ 0 ]
            }
		],
		"aoColumns": [
			null,
			{ "sWidth": "20%"},
			{ "sWidth": "80%" }
		],
		"fnRowCallback": function (nRow, aData, iDisplayIndex) {

			$(nRow).on("click", function (event) {
				if ($(this).hasClass('row_selected')) {

				} else {
					var data = oTable.fnGetData( this );
					mID = data[0];
					dID = '';

					oTable.$('tr.row_selected').removeClass('row_selected');
					$(this).addClass('row_selected');
					reload_detail();
				}
			})
		},
		"fnInitComplete": function(oSettings, json) {
			if (!mID) selecttopRow();
		},
		"bSort": true,
		"bInfo": false,
		"bFilter": false,
		"bProcessing": false,
		"sAjaxSource": "<?php echo active_module_url();?>groups/grid"
	});

	oTable2 = $('#table2').dataTable({
		//"sScrollY": "380px",
		"iDisplayLength": 12,
		"sPaginationType": "full_numbers",
		"bScrollCollapse": true,
	//	"bPaginate": false,
	//	"bJQueryUI": true,
		"sDom": '<"toolbar2x">frtip',

		"aoColumnDefs": [
			{ "bSearchable": false, "bVisible": false, "aTargets": [ 0 ] }
		],
		"aaSorting": [[ 2, "asc" ]],
		"aoColumns": [
			null,
			{ "sWidth": "4%",  "sClass": "center"},
			{ "sWidth": "10%" },
			{ "sWidth": "20%" },
			{ "sWidth": "6%" },   // level_nama
			{ "sWidth": "4%",  "sClass": "center"},
		],
		"fnRowCallback": function (nRow, aData, iDisplayIndex) {
			$(nRow).on("click", function (event) {
				if ($(this).hasClass('row_selected')) {
					/* dID = '';
					$(this).removeClass('row_selected'); */
				} else {
					var data = oTable2.fnGetData( this );
					dID = data[0];

					oTable2.$('tr.row_selected').removeClass('row_selected');
					$(this).addClass('row_selected');
				}
			})
		},
		"bSort": true,
		"bInfo": false,
		"bProcessing": false,
		"bFilter": false,
		"sAjaxSource": "<?php echo active_module_url();?>groups/grid_users_in_grup/"
	});

	$("div.toolbar").attr('style', 'display:block; float: left; margin-bottom:6px; line-height:16px;');

  var tb_array = [
    '<div class="btn-group">',
      '<button id="btn_tambah" class="btn btn-success" type="button">Tambah</button>',
    '</div>',
    '<div class="btn-group">',
      '<button id="btn_edit" class="btn btn-info" type="button">Edit</button>',
    '</div>',
    '<div class="btn-group">',
      '<button id="btn_delete" class="btn btn-danger" type="button">Hapus</button>',
    '</div>',
  ];

  var tb = tb_array.join(' ');
  $("div.toolbar").html(tb);

	var tb2_array = [];
	var tb2 = tb2_array.join(' ');
	$("div.toolbar2").html(tb2);
	$("div.toolbar2").attr('style', 'display:block; float: left; margin-bottom:6px; line-height:16px;');
 
	$('#btn_tambah').click(function() {
		window.location = '<?php echo active_module_url();?>groups/add/';
	});

	$('#btn_edit').click(function() {
		if(mID) {
			window.location = '<?php echo active_module_url();?>groups/edit/'+mID;
		}else{
			alert('Silahkan pilih data yang akan diedit');
		}
	});

	$('#btn_delete').click(function() {
		if(mID) {
			var hapus = confirm('Hapus data ini?');
			if(hapus==true) {
				window.location = '<?php echo active_module_url();?>groups/delete/'+mID;
			};
		}else{
			alert('Silahkan pilih data yang akan dihapus');
		}
	});

	function selecttopRow() {

		var nTop = $('#table1 tbody tr')[0];
		var iPos = oTable.fnGetPosition( nTop );

		/* Use iPos to select the row */
		var data = oTable.fnGetData(iPos);
		mID = data[0];
		dID = '';

		$('#table1 tbody tr:eq(0)').addClass('row_selected');
		reload_detail();
	}

	$("[id=btn_cari]").click(function(){
	 	reload_grid();
	});

	$("[id=btn_refresh]").click(function(){
	 	refresh_grid();
	});

});

function update_stat(gid, id, a) {
	var val = Number(a);
	$.ajax({
	  url: '<?php echo active_module_url()?>groups/update_stat_users_in_grup/' + gid +'/' + id + '/' + val,
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
				<a href="#"><strong>GROUPS USER</strong></a>
			</li>
		</ul>

		<?php echo msg_block();?>

		<div class="row-fluid">
			<div class="span4">
				<div class="toolbar"></div>
			</div>
			<div class="span6">
				<div class="toolbar2"></div>
			</div>
		</div>

		<div class="row-fluid">

			<div class="span4">
				<table class="table" id="table1">
					<thead>
						<tr>
							<th>Index</th>
							<th>Kode</th>
							<th>Nama</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
			<div class="span6">
 			     <div class="controls">
		        	Status User&emsp;&nbsp;&nbsp;&nbsp;
		            <?php echo $select_disabled;?>
		            Level User&emsp;
		            <?php echo $select_level_id;?>
		            &emsp;
		            <div class="btn-group">
				   		<label class="checkbox"><input type="checkbox" id="in_group">&nbsp;Show In-Group Only</label>
					</div>
		        </div>

		        <div class="controls">
		        	User ID&emsp;&emsp;&emsp;&nbsp;&nbsp;
		            <input class="input" type="text" style="width:200px;" name="user_login" id="user_login"/>
		        </div>

		        <div class="controls">
		        	Nama&emsp;&emsp;&emsp;&emsp;&nbsp;
		            <input class="input" type="text" style="width:200px;" name="nama" id="nama"/>
		        </div>

		        <div class="controls">

		            <button id="btn_cari" class="btn btn-primary">Cari</button>
		            <button id="btn_refresh" class="btn btn-primary">Refresh</button>
		        </div>

				<table class="table" id="table2">
					<thead>
						<tr>
							<th>Index</th>
							<th>In Group</th>
							<th>User ID</th>
							<th>Nama</th>
							<th>Level User</th>
							<th>Disabled</th>

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
