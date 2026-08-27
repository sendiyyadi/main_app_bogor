<?php $this->load->view('_head'); ?>
<?php $this->load->view('_navbar'); ?>
<style>
.page-header {
    padding: 4px;
    background-color: #D5D5D5;
    margin: 8px 0px 0px 0px;
    border-bottom: 1px solid #000000;
}
</style>
<style type="text/css">@import "<?php echo base_url()?>assets/css/pbbm.css";</style>

<script>

$(document).ready(function() {

        var oTable = $('#datatable').dataTable( {
        "iDisplayLength": 0,
        "sScrollY": "140px",
        "bJQueryUI" : true,
        "bAutoWidth": false,
        "bScrollCollapse": true,
        "bLengthChange": false,
        "bPaginate": false,
        "sPaginationType" : "full_numbers",
        "bFilter": false,
        "bLengthChange": false,
        "sDom": '<"H"lfr>t<"F"ip>',
        // "sDom": '<"H"lfr>t<"F"ip>T',
        
        "aoColumns" : [   
            { "sWidth": "4%" },   
            null,  
            { "sWidth": "8%" },  
            { "sWidth": "10%", "sClass": "right" },   
            { "sWidth": "8%", "sClass": "right" },  
            { "sWidth": "10%", "sClass": "right" }, 
            { "sWidth": "8%", "sClass": "right" }, 
            { "sWidth": "8%", "sClass": "right" }, 
            { "sWidth": "8%", "sClass": "right" }, 
            { "sWidth": "8%", "sClass": "right" }, 
            { "sWidth": "8%", "sClass": "right" } 
        ] ,
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
    });


	$("tfoot").removeClass();
	
      $('#btnprint').click(function() {

         var nop_kd = $("#nop_kd").val();
          
		 var winparams = 'location=1,status=1,scrollbars=1,resizable=no,width='+screen.width+',height='+screen.height+',menubar=no,toolbar=no,fullscreen=no';
		 window.open('<?php echo active_module_url('sts_bayar_op');?>cetak/pdf/'+nop_kd, 'Laporan'); //, winparams);
		 return false;
       });

} );

</script>
<div class="content">
    <div class="container-fluid">
        <ul class="nav nav-tabs" id="myTab">
            <li class="active"><a data-toggle="tab" href="#op"><strong>Objek Pajak</strong></a></li>
        </ul>
        <?php echo form_open(active_module_url().'sts_bayar_op',array('id'=>'myform', 'class'=>'form-horizontal','method'=>'get'));?>
			<div class="control-group">
				<label class="control-label"><strong>N O P</strong></label> 
				<div class="controls">
					<input type="text" id="nop_kd" class="small autocompleteIconTextfield" value="<?php echo ($nop_kd != 0 ? $nop_kd : '');?>" name="nop_kd" autocomplete="off" placeholder="NOP" size="30"/>

					<button class="btn btn-info" type="submit">Cari</button>
					<button class="btn btn-success" id="btnprint">Cetak</button>
				</div>
			</div>
        </form>   
		
		<?php 
            $last_op = count($data_source)-1;
            if(!isset($data_source) && !empty($nop_kd)) { ?>
            <div><div id="msg_helper" class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>Data tidak ditemukan !</div></div>
		<?php } ?>
		
        <div class="row">
            <div class="span6">
                <div class="page-header">
                    <strong><i class="icon-th-list"></i> Objek Pajak<?php echo !empty($data_source[$last_op]['NOP']) ? " - NOP : ".$data_source[$last_op]['NOP'] : "";?></strong>
                </div>
                <div class="form-horizontal">
                    <div class="control-group">
                        <label class="control-label">Letak OP</label>
                        <div class="controls">
                            <label class="input">: <?php echo  !empty($data_source[$last_op]['ALAMAT_OP']) ? $data_source[$last_op]['ALAMAT_OP'] : "" ;?></label>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">RT/RW</label>
                        <div class="controls">
                            <label class="input">: <?php echo  !empty($data_source[$last_op]['RT_RW_OP']) ? $data_source[$last_op]['RT_RW_OP'] : "" ;?></label>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Kelurahan</label>
                        <div class="controls">
                            <label class="input">: <?php echo  !empty($data_source[$last_op]['KELURAHAN_OP']) ? $data_source[$last_op]['KELURAHAN_OP'] : "" ;?></label>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Kecamatan</label>
                        <div class="controls">
                            <label class="input">: <?php echo  !empty($data_source[$last_op]['KECAMATAN_OP']) ? $data_source[$last_op]['KECAMATAN_OP'] : "" ;?></label>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Kota</label>
                        <div class="controls">
                            <label class="input">: <?php echo LICENSE_TO;?></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="span6">
                <div class="page-header">
                    <strong><i class="icon-th-list"></i> Subjek Pajak</strong>
                </div>
                <div class="form-horizontal">
                    <div class="control-group">
                        <label class="control-label">Nama WP</label>
                        <div class="controls">
                            <label class="input">: <?php echo  !empty($data_source[$last_op]['NM_WP_SPPT']) ? $data_source[$last_op]['NM_WP_SPPT'] : "" ;?></label>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Alamat</label>
                        <div class="controls">
                            <label class="input">: <?php echo  !empty($data_source[$last_op]['ALAMAT_WP']) ? $data_source[$last_op]['ALAMAT_WP'] : "" ;?></label>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">RT/RW</label>
                        <div class="controls">
                            <label class="input">: <?php echo  !empty($data_source[$last_op]['RT_RW_WP']) ? $data_source[$last_op]['RT_RW_WP'] : "" ;?></label>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Kelurahan</label>
                        <div class="controls">
                            <label class="input">: <?php echo  !empty($data_source[$last_op]['KELURAHAN_WP']) ? $data_source[$last_op]['KELURAHAN_WP'] : "" ;?></label>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Kabupaten/Kota</label>
                        <div class="controls">
                            <label class="input">: <?php echo  !empty($data_source[$last_op]['KOTA_WP']) ? $data_source[$last_op]['KOTA_WP'] : "" ;?></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		
        <div class="page-header">
            <strong><i class="icon-list"></i> SPPT</strong>  
        </div>
		
        <table class="display dataTables" id="datatable">
            <thead>
                <tr>
                    <th>Tahun</th>
                    <th>Nama WP</th>
                    <th>Luas Tanah</th>
                    <th>NJOP Tanah</th>
                    <th>Luas Bng</th>
                    <th>NJOP Bng</th>
                    <th>Ketetapan</th>
                    <th>Denda</th>
                    <th>Bayar</th>
                    <th>Sisa</th>
                    <th>Tgl. Byr (Akh)</th>
                </tr>
            </thead>
            <tbody>
                <?php

                    $tot_ketetapan=0; $tot_denda=0; $tot_bayar=0; $tot_sisa=0;
                    if(isset($data_source)) {
                        $tot_ketetapan=0; $tot_denda=0; $tot_bayar=0; $tot_sisa=0;
                    foreach($data_source as $val) {
                    ?>
                <tr>
                    <td><?php echo $val['THN_PAJAK_SPPT'];?></td>
                    <td><?php echo $val['NM_WP_SPPT'];?></td>
                    <td align="right"><?php echo number_format ($val['LUAS_TANAH'], 0 ,  ',' , '.' );?></td>
                    <td align="right"><?php echo number_format ($val['NJOP_TANAH'], 0 ,  ',' , '.' );?></td>
                    <td align="right"><?php echo number_format ($val['LUAS_BNG'], 0 ,  ',' , '.' );?></td>
                    <td align="right"><?php echo number_format ($val['NJOP_BNG'], 0 ,  ',' , '.' );?></td>
                    <td align="right"><?php echo number_format ($val['KETETAPAN'], 0 ,  ',' , '.' );?></td>
                    <td align="right"><?php echo number_format ($val['JML_DENDA'], 0 ,  ',' , '.' );?></td>
                    <td align="right"><?php echo number_format ($val['JML_BAYAR'], 0 ,  ',' , '.' );?></td>
                    <td align="right"><?php echo number_format ($val['KETETAPAN']-($val['JML_BAYAR']-$val['JML_DENDA']), 0 ,  ',' , '.' );?></td>
                    <td align="right"><?php echo $val['TGL_BAYAR'];?></td>
                </tr>
                <?php
                    $tot_ketetapan+= $val['KETETAPAN']; 
                    $tot_denda    += $val['JML_DENDA'];
                    $tot_bayar    += $val['JML_BAYAR'] ;
                    $tot_sisa     += $val['KETETAPAN'] - ($val['JML_BAYAR'] - $val['JML_DENDA']);
                    }
                    }
                    ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6">TOTAL</td>
                    <td align="right"><?php echo number_format ($tot_ketetapan, 0 ,  ',' , '.' );?></td>
                    <td align="right"><?php echo number_format ($tot_denda, 0 ,  ',' , '.' );?></td>
                    <td align="right"><?php echo number_format ($tot_bayar, 0 ,  ',' , '.' );?></td>
                    <td align="right"><?php echo number_format ($tot_sisa, 0 ,  ',' , '.' );?></td>
                    <td>&nbsp;</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<?php $this->load->view('_foot'); ?>



