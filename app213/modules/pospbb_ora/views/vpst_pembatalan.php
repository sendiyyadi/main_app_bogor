<?php $this->load->view('_head'); ?>
<?php $this->load->view(active_module().'/_navbar'); ?>

<script>
var formatter = new Intl.NumberFormat('id-ID', {
  //style: 'currency',
  //currency: 'IDR ',
  minimumFractionDigits: 0,
});

function chgPel(){
		
		if ($("#jns_pel_id").val()=='3'){
			$("#div_angs").show();	
		} 
    else{
			$("#div_angs").hide();	
		}
}

$(document).ready(function() {

  	$("#div_angs").hide();
  	
  	$("#btn_cari").click(function() {
      //
      var nopd     = $("#prefix").val()+$("#nop").val();
      var thn      = $("#tahun").val();
      var thn_p    = $("#thn_pelayanan").val();
      var bundel_p = $("#bundel_pelayanan").val();
      var urut_p   = $("#no_urut_pelayanan").val();
      var jns_p    = $("#jns_pel_id").val();
      var angs_p   = $("#angs_id").val();
      var pmbke    = $("#pmbke").val();
      //
      //alert('vvvvv : ' + nopd);
      var params = {thn:thn,nopd:nopd,thn_p:thn_p,bdl_p:bundel_p,urt_p:urut_p,jns_p:jns_p,pmbke:pmbke,angs_p:angs_p,};
      var data_params = decodeURIComponent($.param(params)); 
      //
  		if (thn_p && bundel_p && urut_p && jns_p) {

  			$.ajax({
  				url: "<?php echo active_module_url('pst_pembatalan/cari')?>"+"/?"+data_params,
  				success: function (json) {
  					data = JSON.parse(json);

  					if(data['found']!=0) {

  						$("#nm_wp").val(data['NM_WP_SPPT']);
  						$("#jln_wp").val(data['JLN_WP_SPPT']);
  						$("#rt_wp").val(data['RT_WP_SPPT']);
  						$("#rw_wp").val(data['RW_WP_SPPT']);
  						$("#lurah_wp").val(data['KELURAHAN_WP_SPPT']);
  						$("#kota_wp").val(data['KOTA_WP_SPPT']);
  						$("#npwp").val(data['NPWP_SPPT']);
              //$("#terhutang").val(data['PBB_TERHUTANG_SPPT']);
              //$("#pengurangan").val(data['FAKTOR_PENGURANG_SPPT']);
              //$("#pembayaran").val(0);
              //$("#pembayaran").val(data['JML_SPPT_YG_DIBAYAR']);
              //$("#sisa").val(data['PBB_TERHUTANG_SPPT']);
              //$("#pmbke").val(data['pmbke']);
              $("#id_p").val(data['ID_P']);
              $("#jthtempo").val(data['TGL_JATUH_TEMPO_SPPT']);
              //$("#denda").val(data['DENDA_SPPT']);
              //$("#utang").val(data['JML_SPPT_YG_DIBAYAR']);
              $("#terbilang").val(data['terbilang']);
              $("#bayar_id").val(data['bayar_id']);

              $("#terhutang").autoNumeric('set', data['PBB_TERHUTANG_SPPT']);
              $("#pengurangan").autoNumeric('set', data['FAKTOR_PENGURANG_SPPT']);
              $("#sisa").autoNumeric('set', data['PBB_TERHUTANG_SPPT']);
              $("#denda").autoNumeric('set', data['DENDA_SPPT']);
              $("#pembayaran").autoNumeric('set', data['JML_SPPT_YG_DIBAYAR']);
              $("#utang").autoNumeric('set', data['JML_SPPT_YG_DIBAYAR']);

  						if (data['jml_sppt_yg_dibayar']==0){
  						  $("#btn_batal").attr('disabled','disabled');
              }
  					  else{
  						  $("#btn_batal").removeAttr('disabled');
              }

  					} 
            else {

  						$("#nm_wp").val("");
  						$("#jln_wp").val("");
  						$("#rt_wp").val("");
  						$("#rw_wp").val("");
  						$("#lurah_wp").val("");
  						$("#kota_wp").val("");
  						$("#npwp").val("");
  						$("#terhutang").val("");
  						$("#pengurangan").val("");
  						$("#pembayaran").val("");
  						$("#sisa").val("");
  						//$("#pmbke").val("");
  						$("#id_p").val("");
  						$("#jthtempo").val("");
  						$("#denda").val("");
  						$("#utang").val("");
  						$("#terbilang").val("");
              $("#bayar_id").val("");
  						alert('Data tidak ditemukan');
  						$("#nop").focus();
  						$("#btn_batal").attr('disabled', 'disabled');
  					}
  				},
  				error: function (xhr, desc, er) {
  					alert(er);
  				}
  			});
  		} 
      else {
  			alert ('Harap mengisi NOP dan Tahun dengan benar!');
  		}
  	});

  	$('#btn_batal').click(function() {
      //
      var sukses='no';
      var nop = $("#prefix").val()+$("#nop").val();
      var thn = $("#tahun").val();
      var thn_p = $("#thn_pelayanan").val();
      var bundel_p = $("#bundel_pelayanan").val();
      var urut_p = $("#no_urut_pelayanan").val();
      var jns_p = $("#jns_pel_id").val();
      var angs_p = $("#angs_id").val();
      var pmbke = $("#pmbke").val();
      var byr_id = $("#bayar_id").val();
      //
      var params = {nop:nop,thn:thn,thn_p:thn_p,bdl_p:bundel_p,urt_p:urut_p,jns_p:jns_p,pmbke:pmbke,angs_p:angs_p,byr_id:byr_id};
      var data_params = decodeURIComponent($.param(params));  
      //
  		if (confirm('Yakin dibatalkan')){
  			$.ajax({
  				type: 'GET',
  				url: "<?php echo active_module_url('pst_pembatalan/proses')?>"+"/?"+data_params,
  				async: false,
  				beforeSend: function(){
  				},
  				success: function(msg) {

  					if(msg=='yes') {
  						alert('Data Berhasil dibatalkan.');
  						//$("#btn_cari").trigger('click');
  					} 
            else if(msg=='no1') {
              alert('Data yg dibatalkan hrs dimulai Pembayaran terakhir..!');
              //$("#btn_cari").trigger('click');
            } 
            else if(msg=='no2') {
              alert('Data yg dibatalkan hrs dimulai Pembayaran Angsuran terakhir..!');
              //$("#btn_cari").trigger('click');
            }
            else{
  						//alert('Data gagal dibatalkan.');
              alert(msg);
            }
  				}
  			});
  			return false;
  		}

  	});

    $('#pmbke').autoNumeric('init', {
        aSep: '.', aDec: ',', vMax: '99.99',  mDec: '0'
    });

    $('#terhutang, #pengurangan, #sisa, #denda, #pembayaran, #utang').autoNumeric('init', {
        aSep: '.', aDec: ',', vMax: '999999999999.99',  mDec: '0'
    });

});

$(document).keypress(function(event){
  if (event.which == '13') {
    event.preventDefault();
  }
});
</script>

<div class="content">
    <div class="container-fluid">
    <ul class="nav nav-tabs" id="myTab">
      <li class="active"><a data-toggle="tab" href="#transaksi"><strong>Pembatalan Pembayaran Khusus</strong></a></li>
    </ul>

    <?php
    if(validation_errors()){
      echo '<blockquote><strong>Harap melengkapi data berikut :</strong>';
      echo validation_errors('<small>','</small>');
      echo '</blockquote>';
    } ?>

    <?php echo msg_block();?>
    <?php //echo $this->session->userdata('groupkd'); ?>

    <?php echo form_open($faction, array('id'=>'myform'));?>
      <div class="row">

        <div class="span2" style="width:170px">
          <label class="staticfont">Nomor Pelayanan</label>
          <input style="width:40px" type="text" id="thn_pelayanan" name="thn_pelayanan" maxlength="4" placeholder="tahun">
          <input style="width:40px" type="text" id="bundel_pelayanan" name="bundel_pelayanan" maxlength="4" placeholder="bundel">
          <input style="width:40px" type="text" id="no_urut_pelayanan" name="no_urut_pelayanan" maxlength="3" placeholder="no.urut">
        </div>

        <div class="span3" style="margin-left: 5px;">
          <label class="staticfont">Nomor Objek Pajak</label>
          <input style="width:35px" type="text" id="prefix" name="prefix" value="<?php echo $prefix;?>" readonly>
          <input style="width:150px" type="text" id="nop" name="nop" maxlength="20">
        </div>

        <div class="span1" style="margin-left: -45px;">
          <label class="staticfont">Tahun</label>
          <input class="span1" type="text" id="tahun" name="tahun" placeholder="tahun op" />
          <input class="span1" type="hidden" id="id_p" name="id_p" />
        </div>

        <div class="span1" style="margin-left: 5px;">
          <label class="staticfont">Pemb.Ke</label>
          <input style="width:30px" type="text" id="pmbke" name="pmbke" />
        </div>

        <div class="span1" style="margin-left: -10px;">
          <label class="staticfont">Pelayanan</label>
          <?php echo $select_jns_pel;?>
        </div>

        <div id="div_angs" class="span1" style="margin-left: 40px;width:30px;">
          <label class="staticfont">Angs.Ke</label>
          <?php echo $select_angsuran;?>
        </div>

        <div class="pull-left" style="margin-left: 40px;">
            <label class="staticfont">&nbsp;</label>
            <button type="button" class="btn btn-info" id="btn_cari"   name="btn_cari">Cari</button>
            <button type="button" class="btn btn-primary" id="btn_batal" name="btn_batal" disabled>Batal STTS</button>
        </div>

      </div>
            
      <hr/>

      <div class="row">
        <div class="span3">
          <label class="staticfont">Nama Wajib Pajak</label>
          <input class="span3" type="text" id="nm_wp" name="nm_wp" readonly />
        </div>
        <div class="span4" style="margin-left: 5px;">
          <label class="staticfont">Alamat Wajib Pajak</label>
          <input class="span4" type="text" id="jln_wp" name="jln_wp" readonly />
        </div>
        <div class="span1" style="margin-left: 5px;">
          <label class="staticfont">RT</label>
          <input class="span1" type="text" id="rt_wp" name="rt_wp" readonly />
        </div>
        <div class="span1" style="margin-left: 5px;">
          <label class="staticfont">RW</label>
          <input class="span1" type="text" id="rw_wp" name="rw_wp" readonly />
        </div>
      </div>

      <div class="row">
        <div class="span3">
          <label class="staticfont">Kelurahan</label>
          <input class="span3" type="text" id="lurah_wp" name="lurah_wp" readonly />
        </div>
        <div class="span3" style="margin-left: 5px;">
          <label class="staticfont">Kota</label>
          <input class="span3" type="text" id="kota_wp" name="kota_wp" readonly />
        </div>
        <div class="span2" style="margin-left: 5px;">
          <label class="staticfont">NPWP</label>
          <input class="span2" type="text" id="npwp" name="npwp" readonly />
        </div>
      </div>

      <div class="row">
        <div class="span2">
          <label class="staticfont">PBB Terhutang</label>
          <input class="span2" type="text" id="terhutang" name="terhutang" readonly />
        </div>
        <div class="span2" style="margin-left: 5px;">
          <label class="staticfont">Denda Administrasi</label>
          <input class="span2" type="text" id="denda" name="denda" readonly />
        </div>
        <div class="span3" style="margin-left: 5px;">
          <label class="staticfont">PBB Yang Sudah Dibayar</label>
          <input class="span2" type="text" id="pembayaran" name="pembayaran" readonly />
        </div>
        <div class="span2" style="margin-left: 5px;">
          <label class="staticfont">Jatuh Tempo</label>
          <input class="span2" type="text" id="jthtempo" name="jthtempo" readonly />
        </div>
      </div>

      <div class="row hide">
        <div class="span2">
          <label class="staticfont">PBB Harus Dibayar</label>
          <input class="span2" type="text" id="sisa" name="sisa" readonly />
        </div>
        
        <div class="span2" style="margin-left: 5px;">
          <label class="staticfont">Pengurangan</label>
          <input class="span2" type="text" id="pengurangan" name="pengurangan" readonly />
        </div>
      </div>

      <div class="row hide">
        <div class="span3">
          <label class="staticfont">PBB Yang harus di bayar</label>
          <input class="span2" type="text" id="utang" name="utang" readonly />
        </div>
      </div>
      <div class="row">
        <div class="span8">
          <label class="staticfont">Dengan Huruf</label>
          <input class="span8" type="text" id="terbilang" name="terbilang" readonly />
        </div>
      </div>
      <input type="hidden" id="ke" name="ke"/>
      <input type="hidden" id="bayar_id" name="bayar_id"/>
    </form>
    </div>


</div>
<?php $this->load->view('_foot'); ?>
