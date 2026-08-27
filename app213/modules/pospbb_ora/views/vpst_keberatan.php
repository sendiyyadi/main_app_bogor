<?php $this->load->view('_head'); ?>
<?php $this->load->view(active_module().'/_navbar'); ?>
<style>
.nav-tabs > .active > a, .nav-pills > .active > a:hover {
    color: blue;
}
</style>
<script>
var formatter = new Intl.NumberFormat('id-ID', {
  //style: 'currency',
  //currency: 'IDR ',
  minimumFractionDigits: 0,
});

$(document).ready(function() {

  function data_clear(){
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
      $("#jthtempo").val("");
      $("#denda").val("");
      $("#utang").val("");
      $("#terbilang").val("");
      $("#ke").val("");
      $("#btn_bayar,#btn_cetak,#btn_cetak2,#btn_cetak3").attr('disabled', 'disabled');
  };
  
  $("#nop, #tahun").keypress(function() {
      data_clear();
  });

  $("#btn_cari").click(function() {
      data_clear();
      var nop = $("#prefix").val()+$("#nop").val();
      var thn = $("#tahun").val();
	  var thn_p = $("#thn_pelayanan").val();
	  var bundel_p = $("#bundel_pelayanan").val();
	  var urut_p = $("#no_urut_pelayanan").val();
	  
      if (nop && thn && thn_p && bundel_p && urut_p) {
      $.ajax({
        url: "<?php echo active_module_url('pst_keberatan/cari/')?>"+nop+'/'+thn+'/'+thn_p+'/'+bundel_p+'/'+urut_p,
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
            $("#terhutang").val(formatter.format(data['PBB_TERHUTANG_SPPT']));
            $("#pengurangan").val(formatter.format(data['FAKTOR_PENGURANG_SPPT']));
            $("#pembayaran").val(formatter.format(data['JML_SPPT_YG_DIBAYAR']));
            $("#sisa").val(formatter.format(data['sisa']));
            $("#jthtempo").val(data['TGL_JATUH_TEMPO_SPPT']);
			     $("#id_p").val(formatter.format(data['ID_P']));
			     $("#keberatan").val(formatter.format(data['utang']));
            $("#denda").val(formatter.format(data['denda']));
            $("#utang").val(formatter.format(data['utang']));
            $("#terbilang").val(data['terbilang']);
            if (data['utang']>0)
                $("#btn_bayar").removeAttr('disabled');
            else $("#btn_bayar").attr('disabled', 'disabled');
          } else {
            alert('Data tidak ditemukan');
            $("#nop").focus();
          }
        },
        error: function (xhr, desc, er) {
          alert(er);
        }
      });
    } else {
      alert ('Harap mengisi Nomor Pelayanan, NOP dan Tahun dengan benar!');
    }
    return false;
  });

  $('#myform').submit(function() {
    var sukses='no';
    $.ajax({
      type: 'POST',
      url: $(this).attr('action'),
      data: $(this).serialize(),
      async: false,
      beforeSend: function(){
      },
      success: function(msg) {
        data = JSON.parse(msg);
        if(data['yes']=='yes') {
          alert('Data telah disimpan.');
          $("#ke").val(data['ke']);
        } else
          alert('Data gagal disimpan.');
      }
    });
    return false;
  });

  $('#btn_bayar').click(function() {
        $('#myform').submit();
        $("#btn_cetak,#btn_cetak2,#btn_cetak3").removeAttr('disabled');
        $(this).attr('disabled', 'disabled');
  });

  $('#btn_cetak').click(function() {
    var nop = $("#prefix").val()+$("#nop").val();
    var thn = $("#tahun").val();
    var ke  = $("#ke").val();
    window.open("<?php echo active_module_url('pst_keberatan/cetak')?>"+ nop+'/'+thn+'/'+ke, "Cetak");
    // $(this).attr('disabled', 'disabled');
  });

  $('#btn_cetak2').click(function() {
    var nop = $("#prefix").val()+$("#nop").val();
    var thn = $("#tahun").val();
    var ke  = $("#ke").val();
    window.open("<?php echo active_module_url('pst_keberatan/cetak_draft')?>"+ nop+'/'+thn+'/'+ke, "Cetak Bank");
    // $(this).attr('disabled', 'disabled');
  });

  $('#btn_cetak3').click(function() {
    var nop = $("#prefix").val()+$("#nop").val();
    var thn = $("#tahun").val();
    var ke  = $("#ke").val();
    window.open("<?php echo active_module_url('pst_keberatan/cetak_bank')?>"+ nop+'/'+thn+'/'+ke, "Cetak Bank2");
    // $(this).attr('disabled', 'disabled');
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
      <li class="active"><a href="#"><strong>Keberatan Atas Pajak Terhutang</strong></a></li>
    </ul>

    <?php
    if(validation_errors()){
      echo '<blockquote><strong>Harap melengkapi data berikut :</strong>';
      echo validation_errors('<small>','</small>');
      echo '</blockquote>';
    } ?>

    <?php echo msg_block();?>

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
          <input class="span1" type="text" id="tahun" name="tahun" maxlength="4" placeholder="tahun op" />
          <input class="span1" type="hidden" id="id_p" name="id_p" />
        </div>

        <div class="pull-left" style="margin-left: 5px;">
          <label class="staticfont">&nbsp;</label>
          <button type="button" class="btn btn-info"    id="btn_cari"   name="btn_cari">Cari</button>
          <button type="button" class="btn btn-primary" id="btn_bayar"  name="btn_bayar"  disabled>Bayar</button>
          <button type="button" class="btn btn-success" id="btn_cetak"  name="btn_cetak"  disabled>Cetak (Draft))</button>
          <button type="button" class="btn btn-success" id="btn_cetak2" name="btn_cetak2" disabled>Cetak Bank (Draft)</button>
          <!--button type="button" class="btn btn-success" id="btn_cetak3" name="btn_cetak3" disabled>Cetak PDF </button-->
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
          <label class="staticfont">Pokok Pajak</label>
          <input class="span2" type="text" id="terhutang" name="terhutang" readonly />
        </div>
        <div class="span2" style="margin-left: 5px;">
          <label class="staticfont">Denda Administrasi</label>
          <input class="span2" type="text" id="denda" name="denda" readonly />
        </div>
        <div class="span2" style="margin-left: 5px;">
          <label class="staticfont">PBB Terhutang</label>
          <input class="span2" type="text" id="sisa" name="sisa" readonly />
        </div>
        <div class="span3" style="margin-left: 5px;">
          <label class="staticfont">Nilai Permohonan Keberatan</label>
          <input class="span2" type="text" id="keberatan" name="keberatan" readonly />
        </div>
      </div>

      <div class="row hide">
        <div class="span2">
          <label class="staticfont">PBB Yang Sudah Dibayar</label>
          <input class="span2" type="text" id="pembayaran" name="pembayaran" readonly />
        </div>
        
        <div class="span2" style="margin-left: 5px;">
          <label class="staticfont">Pengurangan</label>
          <input class="span2" type="text" id="pengurangan" name="pengurangan" readonly />
        </div>
      </div>

      <div class="row">
        <div class="span2">
          <label class="staticfont">PBB Yang harus di bayar</label>
          <input class="span2" type="text" id="utang" name="utang" readonly />
        </div>
        <div class="span2" style="margin-left: 5px;">
          <label class="staticfont">Jatuh Tempo</label>
          <input class="span2" type="text" id="jthtempo" name="jthtempo" readonly />
        </div>
      </div>
      <div class="row">
        <div class="span8">
          <label class="staticfont">Dengan Huruf</label>
          <input class="span8" type="text" id="terbilang" name="terbilang" readonly />
        </div>
      </div>
      <input type="hidden" id="ke" name="ke"/>
    </form>
    </div>


</div>
<?php $this->load->view('_foot'); ?>
