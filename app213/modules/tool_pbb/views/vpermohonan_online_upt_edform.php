<?php $this->load->view('_head.php'); ?>       <!-- CSS JS -->
<?php include_once('_side_menu.php'); ?>    <!-- MENU SIDEBAR -->
<?php $this->load->view('_navbar'); ?>      <!-- NAVBAR MENU -->
<?php $this->load->view('_js.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
.nav-tabs > .active > a, .nav-pills > .active > a:hover {
    color: blue;
}
label {
  margin-top: 5px;
  margin-bottom: 0px;
}
input class="form-control" {
  width: 100%;
  border-radius: 6px !important;
}
.well {
  margin-top:20px;
  padding: 10px;
  min-height: 10px;
  background-color: #5D6385;
  color: #FFF;
  width: 100%;
  border-radius: 10px !important;
}

@media (min-width: 768px) and (max-width: 1366px) {
  .col-md-8 {
    /* width: 53% !important; */
    opacity: 0.875;
    margin-left: 5px;
  }
}

.row {
  margin-top: 3px;
  margin-bottom: 3px;
}

.teks_red{
  color: red;
}
.geser_kanan{
  margin-left: 10px;
}

/* SPINNER */
#overlay{	
  position: fixed;
  top: 0;
  z-index: 100;
  width: 100%;
  height:100%;
  display: none;
  background: rgba(0,0,0,0.6);
}
.cv-spinner {
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;  
}
.spinner {
  width: 40px;
  height: 40px;
  border: 4px #ddd solid;
  border-top: 4px #2e93e6 solid;
  border-radius: 50%;
  animation: sp-anime 0.8s infinite linear;
}
@keyframes sp-anime {
  100% { 
    transform: rotate(360deg); 
  }
}
.is-hide{
  display:none;
}
/* END SPINNER */

</style>
<script>

var oTable;
var oTable2;


function get_rt_wp(rt){
  if(rt.length == 3){
    var ret = rt;
  } else if(rt.length == 2){
    var ret = '0'+rt;
  } else if(rt.length == 1){
    var ret = '00'+rt;
  }
  $('#rt_wp').val(ret);
}

function get_rw_wp(rw){
  if(rw.length == 2){
    var ret = rw;
  } else if(rw.length == 1){
    var ret = '0'+rw;
  }
  $('#rw_wp').val(ret);
}

function get_rt_op(rt){
  if(rt.length == 3){
    var ret = rt;
  } else if(rt.length == 2){
    var ret = '0'+rt;
  } else if(rt.length == 1){
    var ret = '00'+rt;
  }
  $('#rt_op').val(ret);
}

function get_rw_op(rw){
  if(rw.length == 2){
    var ret = rw;
  } else if(rw.length == 1){
    var ret = '0'+rw;
  }
  $('#rw_op').val(ret);
}

function reload_grid_detail() {
  oTable.fnReloadAjax("<?php echo active_module_url('permohonan_online_upt/grid_dtl_bng_ol').$dt['rowid'].'?iDisplayLength=50'; ?>");
}

function reload_grid_detail_fasilitas(id_head) {
  oTable2.fnReloadAjax("<?php echo active_module_url('permohonan_online_upt/grid_dtl_fas_ol'); ?>" + id_head);
}

function hanyaAngka(evt) {
  var charCode = (evt.which) ? evt.which : event.keyCode
  if (charCode > 31 && (charCode < 48 || charCode > 57))
    return false;
  return true;
}


function f_guna_bng(id){
  var jdl = document.getElementById("div_tambahan");
  var d02 = document.getElementById("div_jpb02");
  var d03 = document.getElementById("div_jpb03");
  var d04 = document.getElementById("div_jpb04");
  var d05 = document.getElementById("div_jpb05");
  var d06 = document.getElementById("div_jpb06");
  var d07 = document.getElementById("div_jpb07");
  var d08 = document.getElementById("div_jpb08");
  var d09 = document.getElementById("div_jpb09");
  var d12 = document.getElementById("div_jpb12");
  var d13 = document.getElementById("div_jpb13");
  var d14 = document.getElementById("div_jpb14");
  var d15 = document.getElementById("div_jpb15");
  var d16 = document.getElementById("div_jpb16");
  if (id == '01' || id == '10' || id == '11' || id == '') {
    jdl.style.display = "none"; d02.style.display = "none"; d03.style.display = "none"; d04.style.display = "none"; 
    d05.style.display = "none"; d06.style.display = "none"; d07.style.display = "none"; d08.style.display = "none"; 
    d09.style.display = "none"; d12.style.display = "none"; d13.style.display = "none"; d14.style.display = "none"; 
    d15.style.display = "none"; d16.style.display = "none";
  } else if (id == '02') {
    jdl.style.display = "block"; d02.style.display = "block"; d03.style.display = "none"; d04.style.display = "none"; 
    d05.style.display = "none"; d06.style.display = "none"; d07.style.display = "none"; d08.style.display = "none"; 
    d09.style.display = "none"; d12.style.display = "none"; d13.style.display = "none"; d14.style.display = "none"; 
    d15.style.display = "none"; d16.style.display = "none";
  } else if (id == '03') {
    jdl.style.display = "block"; d02.style.display = "none"; d03.style.display = "block"; d04.style.display = "none"; 
    d05.style.display = "none"; d06.style.display = "none"; d07.style.display = "none"; d08.style.display = "none"; 
    d09.style.display = "none"; d12.style.display = "none"; d13.style.display = "none"; d14.style.display = "none"; 
    d15.style.display = "none"; d16.style.display = "none";
  } else if (id == '04') {
    jdl.style.display = "block"; d02.style.display = "none"; d03.style.display = "none"; d04.style.display = "block"; 
    d05.style.display = "none"; d06.style.display = "none"; d07.style.display = "none"; d08.style.display = "none"; 
    d09.style.display = "none"; d12.style.display = "none"; d13.style.display = "none"; d14.style.display = "none"; 
    d15.style.display = "none"; d16.style.display = "none";
  } else if (id == '05') {
    jdl.style.display = "block"; d02.style.display = "none"; d03.style.display = "none"; d04.style.display = "none"; 
    d05.style.display = "block"; d06.style.display = "none"; d07.style.display = "none"; d08.style.display = "none"; 
    d09.style.display = "none"; d12.style.display = "none"; d13.style.display = "none"; d14.style.display = "none"; 
    d15.style.display = "none"; d16.style.display = "none";
  } else if (id == '06') {
    jdl.style.display = "block"; d02.style.display = "none"; d03.style.display = "none"; d04.style.display = "none"; 
    d05.style.display = "none"; d06.style.display = "block"; d07.style.display = "none"; d08.style.display = "none"; 
    d09.style.display = "none"; d12.style.display = "none"; d13.style.display = "none"; d14.style.display = "none"; 
    d15.style.display = "none"; d16.style.display = "none";
  } else if (id == '07') {
    jdl.style.display = "block"; d02.style.display = "none"; d03.style.display = "none"; d04.style.display = "none"; 
    d05.style.display = "none"; d06.style.display = "none"; d07.style.display = "block"; d08.style.display = "none"; 
    d09.style.display = "none"; d12.style.display = "none"; d13.style.display = "none"; d14.style.display = "none"; 
    d15.style.display = "none"; d16.style.display = "none";
  } else if (id == '08') {
    jdl.style.display = "block"; d02.style.display = "none"; d03.style.display = "none"; d04.style.display = "none"; 
    d05.style.display = "none"; d06.style.display = "none"; d07.style.display = "none"; d08.style.display = "block"; 
    d09.style.display = "none"; d12.style.display = "none"; d13.style.display = "none"; d14.style.display = "none"; 
    d15.style.display = "none"; d16.style.display = "none";
  } else if (id == '09') {
    jdl.style.display = "block"; d02.style.display = "none"; d03.style.display = "none"; d04.style.display = "none"; 
    d05.style.display = "none"; d06.style.display = "none"; d07.style.display = "none"; d08.style.display = "none"; 
    d09.style.display = "block"; d12.style.display = "none"; d13.style.display = "none"; d14.style.display = "none"; 
    d15.style.display = "none"; d16.style.display = "none";
  } else if (id == '12') {
    jdl.style.display = "block"; d02.style.display = "none"; d03.style.display = "none"; d04.style.display = "none"; 
    d05.style.display = "none"; d06.style.display = "none"; d07.style.display = "none"; d08.style.display = "none"; 
    d09.style.display = "none"; d12.style.display = "block"; d13.style.display = "none"; d14.style.display = "none"; 
    d15.style.display = "none"; d16.style.display = "none";
  } else if (id == '13') {
    jdl.style.display = "block"; d02.style.display = "none"; d03.style.display = "none"; d04.style.display = "none"; 
    d05.style.display = "none"; d06.style.display = "none"; d07.style.display = "none"; d08.style.display = "none"; 
    d09.style.display = "none"; d12.style.display = "none"; d13.style.display = "block"; d14.style.display = "none"; 
    d15.style.display = "none"; d16.style.display = "none";
  } else if (id == '14') {
    jdl.style.display = "block"; d02.style.display = "none"; d03.style.display = "none"; d04.style.display = "none"; 
    d05.style.display = "none"; d06.style.display = "none"; d07.style.display = "none"; d08.style.display = "none"; 
    d09.style.display = "none"; d12.style.display = "none"; d13.style.display = "none"; d14.style.display = "block"; 
    d15.style.display = "none"; d16.style.display = "none";
  } else if (id == '15') {
    jdl.style.display = "block"; d02.style.display = "none"; d03.style.display = "none"; d04.style.display = "none"; 
    d05.style.display = "none"; d06.style.display = "none"; d07.style.display = "none"; d08.style.display = "none"; 
    d09.style.display = "none"; d12.style.display = "none"; d13.style.display = "none"; d14.style.display = "none"; 
    d15.style.display = "block"; d16.style.display = "none";
  } else if (id == '16') {
    jdl.style.display = "block"; d02.style.display = "none"; d03.style.display = "none"; d04.style.display = "none"; 
    d05.style.display = "none"; d06.style.display = "none"; d07.style.display = "none"; d08.style.display = "none"; 
    d09.style.display = "none"; d12.style.display = "none"; d13.style.display = "none"; d14.style.display = "none"; 
    d15.style.display = "none"; d16.style.display = "block";
  }

}

function f_view_detail(id_dob) {
    $.ajax({
      url: '<?php echo active_module_url('permohonan_online_upt'); ?>/get_dtl_bng/' + id_dob,
      async: false,
      success: function (j) {
        var data = $.parseJSON(j);
        // alert(data['NO_BNG']);
        // $("#hit_total_nilai").autoNumeric('set',data['total_nilai']);
        $('#dtl_id').val(id_dob);
        $('#dtl_model').val('edit');
        $('#dtl_no_bng').val(data['NO_BNG']);
        $('#dtl_luas_bng').val(data['LUAS_BNG']);
        $('#dtl_guna_bng').val(data['KD_JPB']);
        $('#dtl_thn_bng').val(data['THN_DIBANGUN_BNG']);
        $('#dtl_thn_renov').val(data['THN_RENOVASI_BNG']);
        $('#dtl_jml_lantai').val(data['JML_LANTAI_BNG']);
        $('#dtl_kondisi_bng').val(data['KONDISI_BNG']);
        $('#dtl_jns_konstr').val(data['JNS_KONSTRUKSI_BNG']);
        $('#dtl_jns_atap').val(data['JNS_ATAP_BNG']);
        $('#dtl_jns_dinding').val(data['KD_DINDING']);
        $('#dtl_jns_lantai').val(data['KD_LANTAI']);
        $('#dtl_jns_langit').val(data['KD_LANGIT_LANGIT']);

        //// CHANGE JPB JPB
        f_guna_bng(data['KD_JPB']);
        
        //// DTL JPB JPB
        $('#jpb02_kls_bng').val(data['KLS_JPB02']);
        $('#jpb03_tinggi').val(data['TING_KOLOM_JPB3']);
        $('#jpb03_daya').val(data['DAYA_DUKUNG_LANTAI_JPB3']);
        $('#jpb03_lebar').val(data['LBR_BENT_JPB3']);
        $('#jpb03_keliling').val(data['KELILING_DINDING_JPB3']);
        $('#jpb03_luas').val(data['LUAS_MEZZANINE_JPB3']);
        $('#jpb03_konstruksi').val(data['TYPE_KONSTRUKSI_JPB3']);
        
        $('#jpb04_kls_bng').val(data['KLS_JPB4']);
        $('#jpb05_kls_bng').val(data['KLS_JPB05']);
        $('#jpb05_ruang_ac').val(data['LUAS_KMR_JPB05_DGN_AC_SENT']);
        $('#jpb05_ruang_lain').val(data['LUAS_RNG_LAIN_JPB5_DGN_AC_SENT']);
        $('#jpb06_kls_bng').val(data['KLS_JPB06']);
        $('#jpb07_jns_hotel').val(data['JNS_JPB7']);
        $('#jpb07_bintang').val(data['BINTANG_JPB7']);
        $('#jpb07_jml_kamar').val(data['JML_KMR_JPB7']);
        $('#jpb07_ruang_ac').val(data['LUAS_KMR_JPB7_DGN_AC_SENT']);
        $('#jpb07_ruang_lain').val(data['LUAS_KMR_LAIN_JPB7_DGN_AC_SENT']);
        
        $('#jpb08_tinggi').val(data['TING_KOLOM_JPB8']);
        $('#jpb08_daya').val(data['DAYA_DUKUNG_LANTAI_JPB8']);
        $('#jpb08_lebar').val(data['LBR_BENT_JPB8']);
        $('#jpb08_keliling').val(data['KELILING_DINDING_JPB8']);
        $('#jpb08_luas').val(data['LUAS_MEZZANINE_JPB8']);
        $('#jpb08_konstruksi').val(data['TYPE_KONSTRUKSI_JPB8']);

        $('#jpb09_kls_bng').val(data['KLS_JPB09']);
        $('#jpb12_kls_bng').val(data['TYPE_JPB12']);
        $('#jpb13_kls_bng').val(data['KLS_JPB13']);
        $('#jpb13_jml_apart').val(data['JML_JPB13']);
        $('#jpb13_ruang_ac').val(data['LUAS_JPB13_DGN_AC_SENT']);
        $('#jpb13_ruang_lain').val(data['LUAS_JPB13_LAIN_DGN_AC_SENT']);
        $('#jpb14_luas').val(data['LUAS_KANOPI_JPB14']);
        $('#jpb15_letak_tangki').val(data['LETAK_TANGKI_JPB15']);
        $('#jpb15_kapasitas').val(data['KAPASITAS_TANGKI_JPB15']);
        $('#jpb16_kls_bng').val(data['KLS_JPB16']);
        

      },
      error: function (xhr, desc, er) {
        alert(er);
      }
    });

    // Buat Judul Entry
    document.getElementById('cuDialogDetailLabel').innerHTML = 'DETAIL DATA BANGUNAN';
    $('#cuDialogDetail').modal('show');
}

function f_edit_detail(id_dob) {
    $.ajax({
      url: '<?php echo active_module_url('permohonan_online_upt'); ?>/get_dtl_bng/' + id_dob,
      async: false,
      success: function (j) {
        var data = $.parseJSON(j);
        // alert(data['NO_BNG']);
        // $("#hit_total_nilai").autoNumeric('set',data['total_nilai']);
        $('#dtl_id').val(id_dob);
        $('#dtl_model').val('edit');
        $('#dtl_no_bng').val(data['NO_BNG']);
        $('#dtl_luas_bng').val(data['LUAS_BNG']);
        $('#dtl_guna_bng').val(data['KD_JPB']);
        $('#dtl_thn_bng').val(data['THN_DIBANGUN_BNG']);
        $('#dtl_thn_renov').val(data['THN_RENOVASI_BNG']);
        $('#dtl_jml_lantai').val(data['JML_LANTAI_BNG']);
        $('#dtl_kondisi_bng').val(data['KONDISI_BNG']);
        $('#dtl_jns_konstr').val(data['JNS_KONSTRUKSI_BNG']);
        $('#dtl_jns_atap').val(data['JNS_ATAP_BNG']);
        $('#dtl_jns_dinding').val(data['KD_DINDING']);
        $('#dtl_jns_lantai').val(data['KD_LANTAI']);
        $('#dtl_jns_langit').val(data['KD_LANGIT_LANGIT']);

        //// CHANGE JPB JPB
        f_guna_bng(data['KD_JPB']);
        
        //// DTL JPB JPB
        $('#jpb02_kls_bng').val(data['KLS_JPB02']);
        $('#jpb03_tinggi').val(data['TING_KOLOM_JPB3']);
        $('#jpb03_daya').val(data['DAYA_DUKUNG_LANTAI_JPB3']);
        $('#jpb03_lebar').val(data['LBR_BENT_JPB3']);
        $('#jpb03_keliling').val(data['KELILING_DINDING_JPB3']);
        $('#jpb03_luas').val(data['LUAS_MEZZANINE_JPB3']);
        $('#jpb03_konstruksi').val(data['TYPE_KONSTRUKSI_JPB3']);
        
        $('#jpb04_kls_bng').val(data['KLS_JPB4']);
        $('#jpb05_kls_bng').val(data['KLS_JPB05']);
        $('#jpb05_ruang_ac').val(data['LUAS_KMR_JPB05_DGN_AC_SENT']);
        $('#jpb05_ruang_lain').val(data['LUAS_RNG_LAIN_JPB5_DGN_AC_SENT']);
        $('#jpb06_kls_bng').val(data['KLS_JPB06']);
        $('#jpb07_jns_hotel').val(data['JNS_JPB7']);
        $('#jpb07_bintang').val(data['BINTANG_JPB7']);
        $('#jpb07_jml_kamar').val(data['JML_KMR_JPB7']);
        $('#jpb07_ruang_ac').val(data['LUAS_KMR_JPB7_DGN_AC_SENT']);
        $('#jpb07_ruang_lain').val(data['LUAS_KMR_LAIN_JPB7_DGN_AC_SENT']);
        
        $('#jpb08_tinggi').val(data['TING_KOLOM_JPB8']);
        $('#jpb08_daya').val(data['DAYA_DUKUNG_LANTAI_JPB8']);
        $('#jpb08_lebar').val(data['LBR_BENT_JPB8']);
        $('#jpb08_keliling').val(data['KELILING_DINDING_JPB8']);
        $('#jpb08_luas').val(data['LUAS_MEZZANINE_JPB8']);
        $('#jpb08_konstruksi').val(data['TYPE_KONSTRUKSI_JPB8']);

        $('#jpb09_kls_bng').val(data['KLS_JPB09']);
        $('#jpb12_kls_bng').val(data['TYPE_JPB12']);
        $('#jpb13_kls_bng').val(data['KLS_JPB13']);
        $('#jpb13_jml_apart').val(data['JML_JPB13']);
        $('#jpb13_ruang_ac').val(data['LUAS_JPB13_DGN_AC_SENT']);
        $('#jpb13_ruang_lain').val(data['LUAS_JPB13_LAIN_DGN_AC_SENT']);
        $('#jpb14_luas').val(data['LUAS_KANOPI_JPB14']);
        $('#jpb15_letak_tangki').val(data['LETAK_TANGKI_JPB15']);
        $('#jpb15_kapasitas').val(data['KAPASITAS_TANGKI_JPB15']);
        $('#jpb16_kls_bng').val(data['KLS_JPB16']);
        

      },
      error: function (xhr, desc, er) {
        alert(er);
      }
    });

    // Buat Judul Entry
    document.getElementById('cuDialogDetailLabel').innerHTML = 'EDIT DATA BANGUNAN';
    $('#cuDialogDetail').modal('show');
}

function f_hapus_detail(id_dob) {
    var hapus = confirm('Hapus data detail bangunan ini?');
    if (hapus == true) {
        $.ajax({
          url: '<?php echo active_module_url('permohonan_online_upt'); ?>/delete_dtl_bng/' + id_dob,
          async: false,
          success: function (j) {
            // var data = $.parseJSON(j);
            alert(j);
            reload_grid_detail();
          },
          error: function (xhr, desc, er) {
            alert(er);
          }
        });
    }
}

function f_hapus_detail_fas(id_fas) {
    var hapus = confirm('Hapus data detail fasilitas bangunan ini?');
    if (hapus == true) {
        $.ajax({
          url: '<?php echo active_module_url('permohonan_online_upt'); ?>/delete_dtl_fas_bng/' + id_fas,
          async: false,
          success: function (j) {
            // var data = $.parseJSON(j);
            alert(j);
            var id_dob = $('#dtlfas_id_head').val();
            reload_grid_detail_fasilitas(id_dob);
          },
          error: function (xhr, desc, er) {
            alert(er);
          }
        });
    }
}


function f_fas_detail(id_dob) {
    $('#cuDialogDetailFas').modal('show');
    $('#dtlfas_id_head').val(id_dob);
    reload_grid_detail_fasilitas(id_dob);
}


function buildLampiran(list) {
    $("#div_lampiran").empty(); // hapus lama

    let html = `<div class="row">`;
    list.forEach(function(item) {
        html += `
              <div class="col-md-6">
                <div class="row">
                  <div class="col-md-4" style="padding-left:20px;">
                    <label for="${item.NM_FIELD}">${item.NM_LAMPIRAN}</label>
                  </div>
                  <div class="col-md-7">
                    <a target="_blank" href="<?php echo active_module_url().'monitoring_permo_upt/openblob_permo/${item.NM_FIELD}/'.$dt['id_ppo']; ?>" class="btn btn-primary " data-toggle="tooltip" title="File ${item.NM_LAMPIRAN}"></i> Lihat File</a>
                    <label style="width:80px; display:inline-table; margin-top:0px;" class="btn btn-warning btn-block" style="cursor:pointer;">
                            Ubah
                      <input type="file" id="${item.NM_FIELD}" name="${item.NM_FIELD}" style="display:none;">
                    </label>
                  </div>
                </div>
              </div>
        `;
    });
    html += `</div>`;

    $("#div_lampiran").html(html);
}

function f_chg_lamp(id_lamp) {
    $.ajax({
        url: "<?= active_module_url('permohonan_online_upt/get_lampiran_by_pelayanan'); ?>",
        type: "POST",
        data: { jns_ply: id_lamp },
        dataType: "json",
        success: function(res) {
            if (res.result == "200") {
                buildLampiran(res.lampiran);
            } else {
                $("#div_lampiran").html("<p>Silakan Pilih Jenis Pelayanan.</p>");
            }
        }
    });
}

function init_awal(kd_ply) {
    if (kd_ply == '02') {
        $("#nik_wp_sppt").prop("readonly", false);
        $("#nm_wp_sppt").prop("readonly", false);
        $("#jln_wp_sppt").prop("readonly", false);
        $("#blok_kav_no_wp_sppt").prop("readonly", false);
        $("#rt_wp_sppt").prop("readonly", false);
        $("#rw_wp_sppt").prop("readonly", false);
        $("#kelurahan_wp_sppt").prop("readonly", false);
        $("#kota_wp_sppt").prop("readonly", false);
        $("#kd_pos_wp_sppt").prop("readonly", false);
        $("#nohp").prop("readonly", false);
        $("#email_wp_sppt").prop("readonly", false);

        $("#luas_tanah").prop("readonly", true);
        $("#jln_op_sppt").prop("readonly", true);
        $("#blok_kav_no_op_sppt").prop("readonly", true);
        $("#rt_op_sppt").prop("readonly", true);
        $("#rw_op_sppt").prop("readonly", true);

    } else if (kd_ply == '03') {
        $("#nik_wp_sppt").prop("readonly", true);
        $("#nm_wp_sppt").prop("readonly", true);
        $("#jln_wp_sppt").prop("readonly", true);
        $("#blok_kav_no_wp_sppt").prop("readonly", true);
        $("#rt_wp_sppt").prop("readonly", true);
        $("#rw_wp_sppt").prop("readonly", true);
        $("#kelurahan_wp_sppt").prop("readonly", true);
        $("#kota_wp_sppt").prop("readonly", true);
        $("#kd_pos_wp_sppt").prop("readonly", true);
        $("#nohp").prop("readonly", true);
        $("#email_wp_sppt").prop("readonly", true);

        $("#luas_tanah").prop("readonly", false);
        $("#jln_op_sppt").prop("readonly", false);
        $("#blok_kav_no_op_sppt").prop("readonly", false);
        $("#rt_op_sppt").prop("readonly", false);
        $("#rw_op_sppt").prop("readonly", false);
    }
}


$(document).ready(function() {

  ///// DETAIL UNTUK NOP
  /***begin group detil **********************************************************************************/

  oTable = $('#tableKD').dataTable({
    "iDisplayLength": 9,
    "bJQueryUI": true,
    "bAutoWidth": false,
    "sPaginationType": "full_numbers",
    "sDom": '<"toolbar">frtip',
    "aaSorting": [[ 0, "asc" ]],
    "aoColumnDefs": [
        { "aTargets": [0], "bSearchable": false, "bVisible": false },
        { "aTargets": [1], "bSearchable": false, "bVisible": false },
        { "aTargets": [2], "bSearchable": true,  "bVisible": true, "sWidth": "50px" },
        { "aTargets": [3], "bSearchable": true,  "bVisible": true, "sWidth": "350px", "sClass": "" },
        { "aTargets": [4], "bSearchable": true,  "bVisible": true, "sWidth": "100px", "sClass": "right" },
        { "aTargets": [5], "bSearchable": false,  "bVisible": false, "sWidth": "100px", "sClass": "right" },
        { "aTargets": [6], "bSearchable": true,  "bVisible": true, "sWidth": "100px", "sClass": "center", 
            "mRender": function ( source, type, val ) {
                <?php if($dt['kd_jns_ply'] == '03') { ?>
                  return '<button class="btn btn-success" type="button" onclick="f_edit_detail('+val[0]+')" >Ubah</button>';
                <?php } else { ?>
                  return '<button class="btn btn-success" type="button" onclick="f_view_detail('+val[0]+')" >Detail</button>';
                <?php } ?>
            }
        },
        { "aTargets": [7], "bSearchable": true,  "bVisible": <?php echo $dt['kd_jns_ply'] == '03' ? 'true' : 'false' ; ?>, "sWidth": "100px", "sClass": "center", 
            "mRender": function ( source, type, val ) {
                <?php if($dt['kd_jns_ply'] == '03') { ?>
                  return '<button class="btn btn-danger" type="button" onclick="f_hapus_detail('+val[0]+')" >Hapus</button>';
                <?php } else { ?> 
                  return '';
                <?php } ?>
            }
        },
        { "aTargets": [8], "bSearchable": true,  "bVisible": true, "sWidth": "180px", "sClass": "center", 
            "mRender": function ( source, type, val ) {
                return '<button class="btn btn-warning" type="button" onclick="f_fas_detail('+val[0]+')" >Detail Fasilitas</button>';
            }
        },
    ],
    "sAjaxSource": "<?php echo active_module_url('permohonan_online_upt/grid_dtl_bng_ol').$dt['rowid'].'?iDisplayLength=50';?>"
  });

  $('#btn_tambah_detail').click(function() {
      // Buat Judul Entry
      document.getElementById('cuDialogDetailLabel').innerHTML ='TAMBAH DATA BANGUNAN';
      //
      // jenis_bayar = jns_byr;
      mode_input_detail = "add";
      // initial data awal blank
      var random_id = Date.now();
      $('#dtl_id').val('');
      $('#dtl_model').val('add');
      $('#dtl_no_bng').val('');
      $('#dtl_luas_bng').val('');
      $('#dtl_guna_bng').val('');
      $('#dtl_thn_bng').val('');
      $('#dtl_thn_renov').val('');
      $('#dtl_jml_lantai').val('');
      $('#dtl_kondisi_bng').val('');
      $('#dtl_jns_konstr').val('');
      $('#dtl_jns_atap').val('');
      $('#dtl_jns_dinding').val('');
      $('#dtl_jns_lantai').val('');
      $('#dtl_jns_langit').val('');

      f_guna_bng('');

      //// dtl jpb
      $('#jpb02_kls_bng').val('');
      $('#jpb03_tinggi').val('');
      $('#jpb03_daya').val('');
      $('#jpb03_lebar').val('');
      $('#jpb03_keliling').val('');
      $('#jpb03_luas').val('');
      $('#jpb03_konstruksi').val('');
      $('#jpb04_kls_bng').val('');
      $('#jpb05_kls_bng').val('');
      $('#jpb05_ruang_ac').val('');
      $('#jpb05_ruang_lain').val('');
      $('#jpb06_kls_bng').val('');
      $('#jpb07_jns_hotel').val('');
      $('#jpb07_bintang').val('');
      $('#jpb07_jml_kamar').val('');
      $('#jpb07_ruang_ac').val('');
      $('#jpb07_ruang_lain').val('');
      $('#jpb08_tinggi').val('');
      $('#jpb08_daya').val('');
      $('#jpb08_lebar').val('');
      $('#jpb08_keliling').val('');
      $('#jpb08_luas').val('');
      $('#jpb08_konstruksi').val('');
      $('#jpb09_kls_bng').val('');
      $('#jpb12_kls_bng').val('');
      $('#jpb13_kls_bng').val('');
      $('#jpb13_jml_apart').val('');
      $('#jpb13_ruang_ac').val('');
      $('#jpb13_ruang_lain').val('');
      $('#jpb14_luas').val('');
      $('#jpb15_letak_tangki').val('');
      $('#jpb15_kapasitas').val('');
      $('#jpb16_kls_bng').val('');


      //document.getElementById('satuan').innerHTML='';
      $('#cuDialogDetail').modal('show');
  });


  $('#btn_save_dtl').click(function(e) {
    e.preventDefault();
    var id_ppo            = $('#id_ppo').val();
    var id_dop            = $('#id_mut_dop').val();
    var urut_mutasi       = $('#urut_mutasi').val();
    var paramm            = $('#paramm').val();
    var dtl_id            = $('#dtl_id').val();

    var dtl_model         = $('#dtl_model').val();
    var dtl_no_bng        = $('#dtl_no_bng').val();
    var dtl_luas_bng      = $('#dtl_luas_bng').val();
    var dtl_guna_bng      = $('#dtl_guna_bng').val();
    var dtl_thn_bng       = $('#dtl_thn_bng').val();
    var dtl_thn_renov     = $('#dtl_thn_renov').val();
    var dtl_jml_lantai    = $('#dtl_jml_lantai').val();
    var dtl_kondisi_bng   = $('#dtl_kondisi_bng').val();
    var dtl_jns_konstr    = $('#dtl_jns_konstr').val();
    var dtl_jns_atap      = $('#dtl_jns_atap').val();
    var dtl_jns_dinding   = $('#dtl_jns_dinding').val();
    var dtl_jns_lantai    = $('#dtl_jns_lantai').val();
    var dtl_jns_langit    = $('#dtl_jns_langit').val();

    //// dtl jpb
    var jpb02_kls_bng     = $('#jpb02_kls_bng').val();
    var jpb03_tinggi      = $('#jpb03_tinggi').val();
    var jpb03_daya        = $('#jpb03_daya').val();
    var jpb03_lebar       = $('#jpb03_lebar').val();
    var jpb03_keliling    = $('#jpb03_keliling').val();
    var jpb03_luas        = $('#jpb03_luas').val();
    var jpb03_konstruksi  = $('#jpb03_konstruksi').val();
    var jpb04_kls_bng     = $('#jpb04_kls_bng').val();
    var jpb05_kls_bng     = $('#jpb05_kls_bng').val();
    var jpb05_ruang_ac    = $('#jpb05_ruang_ac').val();
    var jpb05_ruang_lain  = $('#jpb05_ruang_lain').val();
    var jpb06_kls_bng     = $('#jpb06_kls_bng').val();
    var jpb07_jns_hotel   = $('#jpb07_jns_hotel').val();
    var jpb07_bintang     = $('#jpb07_bintang').val();
    var jpb07_jml_kamar   = $('#jpb07_jml_kamar').val();
    var jpb07_ruang_ac    = $('#jpb07_ruang_ac').val();
    var jpb07_ruang_lain  = $('#jpb07_ruang_lain').val();
    var jpb08_tinggi      = $('#jpb08_tinggi').val();
    var jpb08_daya        = $('#jpb08_daya').val();
    var jpb08_lebar       = $('#jpb08_lebar').val();
    var jpb08_keliling    = $('#jpb08_keliling').val();
    var jpb08_luas        = $('#jpb08_luas').val();
    var jpb08_konstruksi  = $('#jpb08_konstruksi').val();
    var jpb09_kls_bng     = $('#jpb09_kls_bng').val();
    var jpb12_kls_bng     = $('#jpb12_kls_bng').val();
    var jpb13_kls_bng     = $('#jpb13_kls_bng').val();
    var jpb13_jml_apart   = $('#jpb13_jml_apart').val();
    var jpb13_ruang_ac    = $('#jpb13_ruang_ac').val();
    var jpb13_ruang_lain  = $('#jpb13_ruang_lain').val();
    var jpb14_luas        = $('#jpb14_luas').val();
    var jpb15_letak_tangki= $('#jpb15_letak_tangki').val();
    var jpb15_kapasitas   = $('#jpb15_kapasitas').val();
    var jpb16_kls_bng     = $('#jpb16_kls_bng').val();

    if(dtl_thn_bng == ''){
      alert('Tahun Bangunan Harap diisi...'); return false;
    }
    if(dtl_guna_bng == ''){
      alert('Penggunaan Bangunan Harap diisi...'); return false;
    }
    if(dtl_kondisi_bng == ''){
      alert('Kondisi Bangunan Harap diisi...'); return false;
    }

    if(dtl_luas_bng == '' || dtl_jml_lantai == '' || dtl_jns_konstr == '' || dtl_jns_atap == '' || dtl_jns_dinding == '' 
    || dtl_jns_lantai == '' || dtl_jns_langit == '' ){
      alert('Harap isi semua data dengan benar...'); return false;
    }

    if(dtl_guna_bng == '03' && (jpb03_lebar == '' || jpb03_tinggi == '' || jpb03_daya == '')){
      alert('JPB03 - Tinggi Lebar dan Daya Harap diisi...'); return false;
    }
    if(dtl_guna_bng == '04' && jpb04_kls_bng == ''){
      alert('JPB04 - Kelas Bangunan Harap diisi...'); return false;
    }
    if(dtl_guna_bng == '05' && jpb05_kls_bng == ''){
      alert('JPB05 - Kelas Bangunan Harap diisi...'); return false;
    }
    if(dtl_guna_bng == '06' && jpb06_kls_bng == ''){
      alert('JPB06 - Kelas Bangunan Harap diisi...'); return false;
    }
    if(dtl_guna_bng == '07' && (jpb07_jns_hotel == '' || jpb07_bintang == '' || jpb07_jml_kamar == '')){
      alert('JPB07 - Jenis Hotel, Bintang dan Jumlah Kamar Harap diisi...'); return false;
    }
    if(dtl_guna_bng == '08' && (jpb08_lebar == '' || jpb08_tinggi == '' || jpb08_daya == '')){
      alert('JPB08 - Tinggi Lebar dan Daya Harap diisi...'); return false;
    }
    if(dtl_guna_bng == '09' && jpb09_kls_bng == ''){
      alert('JPB09 - Kelas Bangunan Harap diisi...'); return false;
    }
    if(dtl_guna_bng == '12' && jpb12_kls_bng == ''){
      alert('JPB12 - Kelas Bangunan Harap diisi...'); return false;
    }
    if(dtl_guna_bng == '13' && jpb13_kls_bng == ''){
      alert('JPB13 - Kelas Bangunan Harap diisi...'); return false;
    }
    if(dtl_guna_bng == '14' && jpb14_luas == ''){
      alert('JPB14 - Luas Kanopi Harap diisi...'); return false;
    }
    if(dtl_guna_bng == '15' && (jpb15_letak_tangki == '' || jpb15_kapasitas == '')){
      alert('JPB15 - Letak dan Kapasitas Tangki Harap diisi...'); return false;
    }
    if(dtl_guna_bng == '16' && jpb16_kls_bng == ''){
      alert('JPB16 - Kelas Bangunan Harap diisi...'); return false;
    }

    $.ajax({
        url: '<?php echo active_module_url('permohonan_online_upt'); ?>/save_dtl_bangunan/',
        type: "POST",    
        data: {
          id_ppo: id_ppo,
          id_dop: id_dop,
          urut_mutasi: urut_mutasi,
          paramm: paramm,
          dtl_id: dtl_id,
          dtl_model: dtl_model,
          dtl_no_bng: dtl_no_bng,
          dtl_luas_bng: dtl_luas_bng,
          dtl_guna_bng: dtl_guna_bng,
          dtl_thn_bng: dtl_thn_bng,
          dtl_thn_renov: dtl_thn_renov,
          dtl_jml_lantai: dtl_jml_lantai,
          dtl_kondisi_bng: dtl_kondisi_bng,
          dtl_jns_konstr: dtl_jns_konstr,
          dtl_jns_atap: dtl_jns_atap,
          dtl_jns_dinding: dtl_jns_dinding,
          dtl_jns_lantai: dtl_jns_lantai,
          dtl_jns_langit: dtl_jns_langit,
          jpb02_kls_bng: jpb02_kls_bng,
          jpb03_tinggi: jpb03_tinggi,
          jpb03_daya: jpb03_daya,
          jpb03_lebar: jpb03_lebar,
          jpb03_keliling: jpb03_keliling,
          jpb03_luas: jpb03_luas,
          jpb03_konstruksi: jpb03_konstruksi,
          jpb04_kls_bng: jpb04_kls_bng,
          jpb05_kls_bng: jpb05_kls_bng,
          jpb05_ruang_ac: jpb05_ruang_ac,
          jpb05_ruang_lain: jpb05_ruang_lain,
          jpb06_kls_bng: jpb06_kls_bng,
          jpb07_jns_hotel: jpb07_jns_hotel,
          jpb07_bintang: jpb07_bintang,
          jpb07_jml_kamar: jpb07_jml_kamar,
          jpb07_ruang_ac: jpb07_ruang_ac,
          jpb07_ruang_lain: jpb07_ruang_lain,
          jpb08_tinggi: jpb08_tinggi,
          jpb08_daya: jpb08_daya,
          jpb08_lebar: jpb08_lebar,
          jpb08_keliling: jpb08_keliling,
          jpb08_luas: jpb08_luas,
          jpb08_konstruksi: jpb08_konstruksi,
          jpb09_kls_bng: jpb09_kls_bng,
          jpb12_kls_bng: jpb12_kls_bng,
          jpb13_kls_bng: jpb13_kls_bng,
          jpb13_jml_apart: jpb13_jml_apart,
          jpb13_ruang_ac: jpb13_ruang_ac,
          jpb13_ruang_lain: jpb13_ruang_lain,
          jpb14_luas: jpb14_luas,
          jpb15_letak_tangki: jpb15_letak_tangki,
          jpb15_kapasitas: jpb15_kapasitas,
          jpb16_kls_bng: jpb16_kls_bng,
        },
        success: function(response) {
            alert(response);
            $('#cuDialogDetail').modal('hide');
            reload_grid_detail();

        },
        error: function() {
            alert("error");
        }    
    });    
  });

  /////// dtl table fasilitas
  oTable2 = $('#tableKDFas').dataTable({
    "iDisplayLength": 9,
    "bJQueryUI": true,
    "bAutoWidth": false,
    "sPaginationType": "full_numbers",
    "sDom": '<"toolbar">frtip',
    "aaSorting": [[ 0, "asc" ]],
    "aoColumnDefs": [
        { "aTargets": [0], "bSearchable": false, "bVisible": false },
        { "aTargets": [1], "bSearchable": false, "bVisible": false },
        { "aTargets": [2], "bSearchable": true,  "bVisible": true, "sWidth": "" },
        { "aTargets": [3], "bSearchable": true,  "bVisible": true, "sWidth": "", "sClass": "" },
        { "aTargets": [4], "bSearchable": false,  "bVisible": false, "sWidth": "100px", "sClass": "right" },
        { "aTargets": [5], "bSearchable": true,  "bVisible": <?php echo $dt['kd_jns_ply'] == '03' ? 'true' : 'false' ; ?>, "sWidth": "100px", "sClass": "center", 
            "mRender": function ( source, type, val ) {
              <?php if ($dt['kd_jns_ply'] == '03') { ?>
                return '<button class="btn btn-danger" type="button" onclick="f_hapus_detail_fas('+val[0]+')" >Hapus</button>';
              <?php } else { ?>
                return '';
              <?php } ?>
            }
        },
    ],
  });

  $('#btn_save_dtl_fas').click(function(e) {
    e.preventDefault();
    var id_ppo            = $('#id_ppo').val();
    var paramm            = $('#paramm').val();
    var id_head           = $('#dtlfas_id_head').val();
    var dtlfas_kd_fas     = $('#dtlfas_kd_fasilitas').val();
    var dtlfas_satuan     = $('#dtlfas_satuan').val();

    $.ajax({
        url: '<?php echo active_module_url('permohonan_online_upt'); ?>/save_dtl_fasilitas_bangunan/',
        type: "POST",    
        data: {
          id_ppo: id_ppo,
          paramm: paramm,
          id_head: id_head,
          dtlfas_kd_fas: dtlfas_kd_fas,
          dtlfas_satuan: dtlfas_satuan,
        },
        success: function(response) {
            alert(response);
            // $('#cuDialogDetailFas').modal('hide');
            reload_grid_detail_fasilitas(id_head);
            $('#dtlfas_kd_fasilitas').val('');
            $('#dtlfas_satuan').val('');

        },
        error: function() {
            alert("error");
        }    
    });    
  });

  $("#cuDialogDetail").draggable({
    handle: ".modal-header"
  });

  $("#cuDialogDetailFas").draggable({
    handle: ".modal-header"
  });
  /***end group detil   **********************************************************************************/

  //// END DTL NOP


  //// init
  var id_lamp = $('#jns_ply').val();
  f_chg_lamp(id_lamp);
  init_awal(id_lamp);

  $('#nop_re').formatter({
    'pattern': '{{99}}.{{99}}-{{999}}.{{999}}-{{999}}.{{9999}}.{{9}}',
	});

  $('#nop').formatter({
    'pattern': '{{99}}.{{99}}-{{999}}.{{999}}-{{999}}.{{9999}}.{{9}}',
	});
  
  $('#btn_send_permo').on('click', function() {
    var form = document.getElementById("myform");
    // Check HTML5 required
    if (!form.checkValidity()) {
        form.reportValidity();
        return false;
    }

    var data = new FormData(form);

    $("#overlay").fadeIn(300);

    var nop = $('#nop').val();
    var nama = $('#nama_pemohon').val();
    var telp = $('#telp').val();
    var thn_permo = $('#thn_permohonan').val();
    var alamat = $('#alamat_pemohon').val();
    var ket = $('#keterangan_pemohon').val();
    if (nop == '' || nama == '' || telp == '' || thn_permo == '' || alamat == '' || ket == ''){
      alert('Lengkapi data Permohonan Online dengan benar...');
      return false;
    }

    $.ajax({
      url: "<?php echo active_module_url() ?>permohonan_online_upt/update/",
      type: 'POST',
      data: data,
      processData: false,
      contentType: false,
      success: function(j) {
        var data = $.parseJSON(j);
        if(data['result'] == 400){
          Swal.fire({
                  icon: "error",
                  title: "Error",
                  text: data['msg']
              }); 
          return false;
        } else {
          Swal.fire({
                  icon: "success",
                  title: "Sukses",
                  text: data['msg'],
                  timer: 2000,
                  showConfirmButton: false
              }).then((result) => {
                  if (result.dismiss === Swal.DismissReason.timer) {
                    $("#cuDialogDet").modal("show");
                    $('#dtl_nop').val(data['dtl_nop']);
                    $('#dtl_nop_tx').val(data['dtl_nop_tx']);
                    $('#dtl_ply').val(data['dtl_ply']);
                    $('#dtl_ply_tx').val(data['dtl_ply_tx']);
                    $('#dtl_thn_ply').val(data['dtl_thn_ply']);
                    $('#dtl_id_ppo').val(data['dtl_id_ppo']);
                  }
              });
          
        }

      },
      complete: function () {
          $("#overlay").fadeOut(300);
      },
      error: function(xhr, desc, er) {
        alert(er);
      }
    });

  });


  $('#btn_dtl_simpan').on('click', function() {
    
    $("#overlay").fadeIn(300);

    var id = $('#dtl_id_ppo').val();
    var nop = $('#dtl_nop').val();
    var kd_ply = $('#dtl_ply').val();
    var thn_ply = $('#dtl_thn_ply').val();

    $.ajax({
      url: "<?php echo active_module_url() ?>permohonan_online_upt/appr_permo/"+id,
      // url: "<?php echo active_module_url() ?>permohonan_online_upt/appr_permo/"+nop+"/"+thn_ply+"/"+kd_ply,
      type: 'POST',
      success: function(j) {
        var data = $.parseJSON(j);
        Swal.fire({
            icon: "success",
            title: "Sukses",
            text: data['msg'],
        }).then((result) => {
            if (result.isConfirmed) {
                $("#cuDialogDet").modal("hide");
                window.location = '<?php echo active_module_url("permohonan_online_upt"); ?>';
            }
        });
        
      },
      complete: function () {
          $("#overlay").fadeOut(300);
      },
      error: function(xhr, desc, er) {
        alert(er);
      }
    });

  });


  $("#cuDialogDet").draggable({
      handle: ".modal-header"
  });
  

  // // OVERLAY SPINNER 
  $(document).on({
      ajaxStart: function(){
          $("#overlay").fadeIn(300);　
      },
      ajaxStop: function(){ 
          $("#overlay").fadeOut(300);　
      }    
  });



});

</script>

<div class="content">
  <div class="container-fluid">
    <ul class="nav nav-tabs" id="myTab">
      <li class="active"><a href="#"><strong>PERMOHONAN ONLINE UPT</strong></a></li>
    </ul>

    <?php //echo KD_KANWIL; ?>

    <?php
    if (validation_errors()) {
        echo '<blockquote><strong>Harap melengkapi data berikut :</strong>';
        echo validation_errors('<small>', '</small>');
        echo '</blockquote>';
    } ?>

    <?php echo msg_block();?>

    <?php echo form_open($faction, array('id'=>'myform', 'enctype'=>'multipart/form-data'));?>

      <!-- SUBJEK / WAJIB PAJAK -->
      <!-- SUBJEK / WAJIB PAJAK -->
      <div class="panel">

          <div class="row" style="margin-right:0px; margin-left:0px; background-image:url(<?php echo site_url('assets/img/stadion_pakansari.jpg'); ?>);
            background-repeat:no-repeat; background-size:cover; ">
            <!-- <div class="col-md-2" style=""></div> -->
            <div class="col-md-12 ">

                <!-- DATA REGISTRASI -->
                <div class="row" style="margin-right:0px; margin-left:0px; margin-bottom:10px;">
                  <div class="well">
                    <center><font style="font-size:13pt"><strong>DATA REGISTRASI</strong></font></center>
                  </div>
                </div>

                <!-- <form id="form_reg_esppt" class="form_reg_esppt" enctype="multipart/form-data" method="post"> -->
                <div class="row">
                  <div class="col-md-6">
                    <div class="row">
                      <div class="col-md-4" style="padding-left:20px;">
                        <label for="nop_re">NOP PBB</label>
                      </div>
                      <div class="col-md-7">
                        <input class="form-control" type="text" id="nop_re" name="nop_re" autocomplete="off" value="<?php echo $dt['nop_re']?>" >
                        <input class="form-control" type="hidden" id="id_reg_esppt" name="id_reg_esppt" autocomplete="off" value="<?php echo $dt['id_reg_esppt']?>" >
                        <input class="form-control" type="hidden" id="id_ppo" name="id_ppo" autocomplete="off" value="<?php echo $dt['id_ppo']?>" >
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 hidden">
                    <div class="row">
                      <button class="btn btn-danger" id="btn_cari_nop" type="button">Cari NOP</button>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="row">
                      <div class="col-md-4" style="padding-left:20px;">
                        <label for="nama_wp_re">NAMA WAJIB PAJAK</label>
                      </div>
                      <div class="col-md-7">
                        <input class="form-control" type="text" id="nama_wp_re" name="nama_wp_re" autocomplete="off" value="<?php echo $dt['nama_wp_re']?>" readonly >
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="row">
                      <div class="col-md-4" style="padding-left:20px;">
                        <label for="alamat_op_re">ALAMAT OBJEK PAJAK</label>
                      </div>
                      <div class="col-md-7">
                        <input class="form-control" type="text" id="alamat_op_re" name="alamat_op_re" autocomplete="off" value="<?php echo $dt['alamat_op_re']?>" readonly >
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="row">
                      <div class="col-md-4" style="padding-left:20px;">
                        <label for="nik_re">NIK</label>
                      </div>
                      <div class="col-md-7">
                        <input class="form-control" type="text" id="nik_re" name="nik_re" autocomplete="off" value="<?php echo $dt['nik_re']?>" readonly >
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="row">
                      <div class="col-md-4" style="padding-left:20px;">
                        <label for="no_telp_re">NO TELP</label>
                      </div>
                      <div class="col-md-7">
                        <input class="form-control" type="text" id="no_telp_re" name="no_telp_re" autocomplete="off" value="<?php echo $dt['no_telp_re']?>" readonly >
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="row">
                      <div class="col-md-4" style="padding-left:20px;">
                        <label for="nama_re">NAMA LENGKAP</label>
                      </div>
                      <div class="col-md-7">
                        <input class="form-control" type="text" id="nama_re" name="nama_re" autocomplete="off" value="<?php echo $dt['nama_re']?>" readonly >
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="row">
                      <div class="col-md-4" style="padding-left:20px;">
                        <label for="email_re">ALAMAT EMAIL</label>
                      </div>
                      <div class="col-md-7">
                        <input class="form-control" type="text" id="email_re" name="email_re" autocomplete="off" value="<?php echo $dt['email_re']?>" readonly >
                      </div>
                    </div>
                  </div>
                </div>
                <!-- END DATA REGISTRASI -->

                
                <!-- LAMPIRAN FILE DATA REGIS -->
                <div class="row" style="margin-right:0px; margin-left:0px; margin-bottom:10px;">
                  <div class="well">
                    <center><font style="font-size:13pt"><strong>LAMPIRAN FILE DATA REGISTRASI</strong></font></center>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-4">
                    <div class="row">
                      <div class="col-md-4" style="padding-left:20px;">
                        <label for="im_ktp_re">KTP</label>
                      </div>
                      <div class="col-md-7">
                        <div id="r_ktp_re_1" >  
                          <a target="_blank" href="<?php echo active_module_url().'permohonan_online_upt/openblob_reg_esppt/IM_KTP_BLOB/'.$dt['nop_re'].'/'.$dt['nik_re']; ?>" class="btn btn-primary " data-toggle="tooltip" title="File KTP"></i> Lihat File</a>
                          <label style="width:80px; display:inline-table; margin-top:0px;" class="btn btn-warning btn-block" style="cursor:pointer;">
                            Ubah
                            <input type="file" id="im_ktp_re" name="im_ktp_re" style="display:none;" >
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="row">
                      <div class="col-md-4" style="padding-left:20px;">
                        <label for="im_sppt_re">SPPT</label>
                      </div>
                      <div class="col-md-7">
                        <div id="r_sppt_re_1" >  
                          <a target="_blank" href="<?php echo active_module_url().'permohonan_online_upt/openblob_reg_esppt/IM_SPPT_BLOB/'.$dt['nop_re'].'/'.$dt['nik_re']; ?>" class="btn btn-primary " data-toggle="tooltip" title="File SPPT"></i> Lihat File</a>
                          <label style="width:80px; display:inline-table; margin-top:0px;" class="btn btn-warning btn-block" style="cursor:pointer;">
                            Ubah
                            <input type="file" id="im_sppt_re" name="im_sppt_re" style="display:none;">
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="row">
                      <div class="col-md-4" style="padding-left:20px;">
                        <label for="im_stts_re">STTS</label>
                      </div>
                      <div class="col-md-7">
                        <div id="r_stts_re_1" >  
                          <a target="_blank" href="<?php echo active_module_url().'permohonan_online_upt/openblob_reg_esppt/IM_PBB_BLOB/'.$dt['nop_re'].'/'.$dt['nik_re']; ?>" class="btn btn-primary " data-toggle="tooltip" title="File STTS"></i> Lihat File</a>
                          <label style="width:80px; display:inline-table; margin-top:0px;" class="btn btn-warning btn-block" style="cursor:pointer;">
                            Ubah
                            <input type="file" id="im_stts_re" name="im_stts_re" style="display:none;" >
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- END LAMPIRAN FILE DATA REGIS -->

              <div id="row_bawah" class="">
                <!-- DATA PERMOHONAN ONLINE -->
                <div class="row" style="margin-right:0px; margin-left:0px; margin-bottom:10px;">
                  <div class="well">
                    <center><font style="font-size:13pt"><strong>DATA PERMOHONAN ONLINE</strong></font></center>
                  </div>
                </div>

                <!-- <form id="form_permo"> -->
                <div class="row">
                  <div class="col-md-6">
                    <div class="row">
                      <div class="col-md-4" style="padding-left:20px;">
                        <label for="nopel">NO PELAYANAN</label>
                      </div>
                      <div class="col-md-7">
                        <input class="form-control" type="text" id="nopel" name="nopel" autocomplete="off" value="<?php echo $dt['nopel']?>" readonly >
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="row">
                      <div class="col-md-4" style="padding-left:20px;">
                        <label for="jns_pelayanan">JENIS PELAYANAN</label>
                      </div>
                      <div class="col-md-7">
                        <?php echo $select_jns_ply; ?>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="row">
                      <div class="col-md-4" style="padding-left:20px;">
                        <label for="no_permohonan">NO PERMOHONAN</label>
                      </div>
                      <div class="col-md-7">
                        <input class="form-control" type="text" id="no_permohonan" name="no_permohonan" autocomplete="off" value="<?php echo $dt['no_permohonan']?>" readonly >
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="row">
                      <div class="col-md-4" style="padding-left:20px;">
                        <label for="thn_permohonan">THN PERMOHONAN</label>
                      </div>
                      <div class="col-md-7">
                        <input class="form-control" type="text" id="thn_permohonan" name="thn_permohonan" autocomplete="off" value="<?php echo $dt['thn_permohonan']?>" readonly >
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="row">
                      <div class="col-md-4" style="padding-left:20px;">
                        <label for="nop">NOP</label>
                      </div>
                      <div class="col-md-7">
                        <input class="form-control" type="text" id="nop" name="nop" autocomplete="off" value="<?php echo $dt['nop']?>" readonly>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="row">
                      <div class="col-md-4" style="padding-left:20px;">
                        <label for="tgl_permohonan">TGL PERMOHONAN</label>
                      </div>
                      <div class="col-md-7">
                        <input class="form-control" type="text" id="tgl_permohonan" name="tgl_permohonan" autocomplete="off" value="<?php echo $dt['tgl_permohonan']?>" readonly >
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="row">
                      <div class="col-md-4" style="padding-left:20px;">
                        <label for="nama_pemohon">NAMA PEMOHON</label>
                      </div>
                      <div class="col-md-7">
                        <input class="form-control" type="text" id="nama_pemohon" name="nama_pemohon" autocomplete="off" value="<?php echo $dt['nama_pemohon']?>" >
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="row">
                      <div class="col-md-4" style="padding-left:20px;">
                        <label for="alamat_pemohon">ALAMAT PEMOHON</label>
                      </div>
                      <div class="col-md-7">
                        <input class="form-control" type="text" id="alamat_pemohon" name="alamat_pemohon" autocomplete="off" value="<?php echo $dt['alamat_pemohon']?>" >
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="row">
                      <div class="col-md-4" style="padding-left:20px;">
                        <label for="telp">NO TELP</label>
                      </div>
                      <div class="col-md-7">
                        <input class="form-control" type="text" id="telp" name="telp" autocomplete="off" value="<?php echo $dt['telp']?>" >
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="row">
                      <div class="col-md-4" style="padding-left:20px;">
                        <label for="keterangan">KETERANGAN</label>
                      </div>
                      <div class="col-md-7">
                        <input class="form-control" type="text" id="keterangan" name="keterangan" autocomplete="off" value="<?php echo $dt['keterangan']?>" >
                      </div>
                    </div>
                  </div>
                </div>
                <!-- END DATA PERMOHONAN ONLINE -->

                <!-- DATA SUBJEK PAJAK -->
                <div class="row" style="margin-right:0px; margin-left:0px; margin-bottom:10px;">
                  <div class="well" >
                    <center><font style="font-size:13pt"><strong>DATA WAJIB PAJAK / SUBJEK PAJAK</strong></font></center>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <label for="nik_wp_sppt">NIK</label><br>
                    <input class="form-control" type="text" id="nik_wp_sppt" name="nik_wp_sppt" maxlength="16" autocomplete="off" value="<?php echo $dt['nik_wp_sppt']?>" readonly >
                  </div>
                  <div class="col-md-6">
                    <label for="nm_wp_sppt">NAMA LENGKAP</label><br>
                    <input class="form-control" type="text" id="nm_wp_sppt" name="nm_wp_sppt" maxlength="30" autocomplete="off" value="<?php echo $dt['nm_wp_sppt']?>" readonly >
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-9">
                    <label for="jln_wp_sppt">ALAMAT LENGKAP</label><br>
                    <input class="form-control"  type="text" id="jln_wp_sppt" name="jln_wp_sppt" maxlength="30" autocomplete="off" value="<?php echo $dt['jln_wp_sppt']?>" readonly >
                  </div>
                  <div class="col-md-3">
                    <label for="blok_kav_no_wp_sppt">BLOK / NO</label><br>
                    <input class="form-control"  type="text" id="blok_kav_no_wp_sppt" name="blok_kav_no_wp_sppt" maxlength="15" autocomplete="off" value="<?php echo $dt['blok_kav_no_wp_sppt']?>" readonly >
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-3">
                    <label for="rt_wp_sppt">RT</label><br>
                    <input class="form-control" type="text" id="rt_wp_sppt" name="rt_wp_sppt" autocomplete="off" maxlength="3" value="<?php echo $dt['rt_wp_sppt']?>" readonly >
                  </div>
                  <div class="col-md-3">
                    <label for="rw_wp_sppt">RW</label><br>
                    <input class="form-control" type="text" id="rw_wp_sppt" name="rw_wp_sppt" autocomplete="off" maxlength="2" value="<?php echo $dt['rw_wp_sppt']?>" readonly >
                  </div>
                  <div class="col-md-6">
                    <label for="kelurahan_wp_sppt">KELURAHAN</label><br>
                    <input class="form-control" type="text" id="kelurahan_wp_sppt" name="kelurahan_wp_sppt" maxlength="30" autocomplete="off" value="<?php echo $dt['kelurahan_wp_sppt']?>" readonly >
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <label for="kota_wp_sppt">KABUPATEN / KOTA</label><br>
                    <input class="form-control" type="text" id="kota_wp_sppt" name="kota_wp_sppt" maxlength="30" autocomplete="off" value="<?php echo $dt['kota_wp_sppt']?>" readonly >
                  </div>
                  <div class="col-md-6">
                    <label for="kd_pos_wp_sppt">KODE POS</label><br>
                    <input class="form-control" type="text" id="kd_pos_wp_sppt" name="kd_pos_wp_sppt" maxlength="5" autocomplete="off" value="<?php echo $dt['kd_pos_wp_sppt']?>" readonly >
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <label for="nohp">NO HP (AKTIF)</label><br>
                    <input class="form-control" type="text" id="nohp" name="nohp" maxlength="15" autocomplete="off" value="<?php echo $dt['nohp']?>" readonly >
                  </div>
                  <div class="col-md-6">
                    <label for="email_wp_sppt">ALAMAT EMAIL</label><br>
                    <input class="form-control" type="text" id="email_wp_sppt" name="email_wp_sppt" maxlength="30" autocomplete="off" value="<?php echo $dt['email_wp_sppt']?>" readonly >
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <label for="">STATUS OBJEK PAJAK</label><br>
                    <?php echo $select_sts_op; ?>
                    <!-- <input class="form-control" type="text" id="sts_objek_pajak" name="sts_objek_pajak" maxlength="15" autocomplete="off" value="<?php //echo $dt['sts_objek_pajak']?>" readonly > -->
                  </div>
                  <div class="col-md-6">
                    <label for="">PEKERJAAN</label><br>
                    <?php echo $select_pekerjaan_wp; ?>
                    <!-- <input class="form-control" type="text" id="pekerjaan_wp" name="pekerjaan_wp" maxlength="30" autocomplete="off" value="<?php //echo $dt['pekerjaan_wp']?>" readonly > -->
                  </div>
                </div>


                <!-- OBJEK PAJAK -->
                <div class="row" style="margin-right:0px; margin-left:0px; margin-bottom:10px;">
                  <div class="well" >
                    <center><font style="font-size:13pt"><strong>DATA OBJEK PAJAK</strong></font></center>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <label for="nops">NOP</label><br>
                    <input class="form-control" type="text" id="nops" name="nops" autocomplete="off" value="<?php echo $dt['nops']?>" readonly >
                  </div>
                  <div class="col-md-6">
                    <label for="">Luas Tanah</label><br>
                    <input class="form-control" type="text" id="luas_tanah" name="luas_tanah" autocomplete="off" value="<?php echo $dt['luas_tanah']?>" readonly >
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-9">
                    <label for="jln_op_sppt">ALAMAT LENGKAP</label><br>
                    <input class="form-control" type="text" id="jln_op_sppt" name="jln_op_sppt" maxlength="30" autocomplete="off" value="<?php echo $dt['jln_op_sppt']?>" readonly >
                  </div>
                  <div class="col-md-3">
                    <label for="blok_kav_no_op_sppt">BLOK / NO</label><br>
                    <input class="form-control" type="text" id="blok_kav_no_op_sppt" name="blok_kav_no_op_sppt" maxlength="15" autocomplete="off" value="<?php echo $dt['blok_kav_no_op_sppt']?>" readonly >
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-3">
                    <label for="rt_op_sppt">RT</label><br>
                    <input class="form-control" type="text" id="rt_op_sppt" name="rt_op_sppt" maxlength="3" autocomplete="off" value="<?php echo $dt['rt_op_sppt']?>" readonly >
                  </div>
                  <div class="col-md-3">
                    <label for="rw_op_sppt">RW</label><br>
                    <input class="form-control" type="text" id="rw_op_sppt" name="rw_op_sppt" maxlength="2" autocomplete="off" value="<?php echo $dt['rw_op_sppt']?>" readonly >
                  </div>
                  <div class="col-md-6">
                    <label for="alamat_op_1">Jenis Tanah</label><br>
                    <?php echo $select_jns_tanah; ?>
                    <!-- <input class="form-control" type="text" id="" name="" value="<?php //echo $dt['jns_tanah']?>" readonly > -->
                  </div>
                </div>

                <!-- <div class="row">
                  <div class="col-md-6">
                    <label for="nop_ttg_1">NOP TETANGGA 1</label><br>
                    <input class="form-control" type="text" id="nop_ttg_1" name="nop_ttg_1" autocomplete="off" value="<?php //echo $dt['nop_ttg_1']?>" readonly >
                  </div>
                  <div class="col-md-6">
                    <label for="alamat_op_2">NAMA WP TETANGGA 1</label><br>
                    <input class="form-control" type="text"  id="nama_wp_1" name="nama_wp_1" autocomplete="off" value="<?php //echo $dt['nama_wp_1']?>" readonly >
                  </div>
                </div> -->

                <!-- Close Objek pajak -->

                <!-- DATA BANGUNAN -->
                <div class="row" style="margin-right:0px; margin-left:0px; margin-bottom:10px;">
                  <div class="well" >
                    <center><font style="font-size:13pt"><strong>DATA BANGUNAN</strong></font></center>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-12">
                    <table class="table" id="tableKD">
                        <thead>
                            <tr>
                                <th>dtl_id</th>
                                <th>dtl_model</th>
                                <th>No Bangunan</th>
                                <th>Jns Penggunaan</th>
                                <th>Luas Bangunan</th>
                                <th>kd_jpb</th>
                                <th>Ubah</th>
                                <th>Hapus</th>
                                <th>Fasilitas</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                  </div>
                  
                </div>
                <!-- END DATA BANGUNAN -->

                <!-- LAMPIRAN FILE -->
                <div class="row" style="margin-right:0px; margin-left:0px; margin-bottom:10px;">
                  <div class="well" >
                    <center><font style="font-size:13pt"><strong>LAMPIRAN FILE</strong></font></center>
                  </div>
                </div>

                <div id="div_lampiran"></div>

                <div class="row" style="margin-top:40px">
                  <div class="col-md-6">
                    <button class="btn btn-success" id="btn_send_permo" type="button">Kirim Permohonan</button>
                  </div>
                </div>
                <!-- </form> -->

              </div>

            </div>
          </div>

      </div>

    </form>

    </div>
    </div>


<!-- Begin Modal Dialog entry Detail -->
<div id="cuDialogDet" class="modal" style="width:600px" tabindex="-1" role="dialog" aria-labelledby="cuDialogDetLabel" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h3 id="cuDialogDetLabel">Proses Kirim Pelayanan</h3>
          </div>
          <div class="modal-body">
              <div class="form-horizontal">

                  <div class="row">
                    <div class="col-md-3">
                      NOP
                    </div>
                    <div class="col-md-7">
                      <input class="form-control" type="text" name="dtl_nop_tx" id="dtl_nop_tx" readonly />
                      <input class="form-control" type="hidden" name="dtl_nop" id="dtl_nop" readonly />
                      <input class="form-control" type="hidden" name="dtl_thn_ply" id="dtl_thn_ply" readonly />
                      <input class="form-control" type="hidden" name="dtl_id_ppo" id="dtl_id_ppo" readonly />
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-3">
                      Jenis Pelayanan
                    </div>
                    <div class="col-md-7">
                      <input class="form-control" type="text" name="dtl_ply_tx" id="dtl_ply_tx" readonly />
                      <input class="form-control" type="hidden" name="dtl_ply" id="dtl_ply" readonly />
                    </div>
                  </div>

              </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-primary" id="btn_dtl_simpan">Kirim Data</button>
          </div>
      </div>
  </div>
</div>
<!-- end Modal Dialog entry Detail -->

<!-- MODAL -->
  <div class="modal fade" id="cuDialogDetail" tabindex="-1" role="dialog" aria-labelledby="cuDialogDetailLabel" aria-hidden="true" style="width:900px; left:250px; overflow-y:hidden;">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title" id="cuDialogDetailLabel">DATA BANGUNAN</h3>
        </div>
        <div class="modal-body" style="overflow-y: scroll; height: 450px;">
          <div class="row" style="margin-right:0px; margin-left:0px">
            <div class="well" style="padding:10px;min-height:10px; background-color:#5D6385; color:#FFF;">
              <center>
                <font style="font-size:13pt"><strong>DETAIL DATA BANGUNAN</strong></font>
              </center>
            </div> 
          </div>

          <div class="row" style="margin-left:0px; margin-bottom:6px;">
            <div class="col-md-6">
              <label for="">NO BANGUNAN</label>
              <input class="form-control" type="text" id="dtl_no_bng" name="dtl_no_bng" readonly value="">
              <input class="form-control" type="hidden" id="dtl_model" name="dtl_model">
              <input class="form-control" type="hidden" id="dtl_id" name="dtl_id">
            </div>
            <div class="col-md-6">
              <label for="">JENIS KONSTRUKSI</label>
              <?php echo $select_konstr_bng; ?>
            </div>
          </div>

          <div class="row" style="margin-left:0px; margin-bottom:6px;">
            <div class="col-md-6">
              <label for="">TAHUN BANGUNAN</label>
              <input class="form-control" onkeypress="return hanyaAngka(event)" type="text" id="dtl_thn_bng" name="dtl_thn_bng" value="">
            </div>
            <div class="col-md-6">
              <label for="">JENIS ATAP</label>
              <?php echo $select_atap_bng; ?>
            </div>
          </div>

          <div class="row" style="margin-left:0px; margin-bottom:6px;">
            <div class="col-md-6">
              <label for="">TAHUN RENOVASI</label>
              <input class="form-control" onkeypress="return hanyaAngka(event)" type="text" id="dtl_thn_renov" name="dtl_thn_renov" value="">
            </div>
            <div class="col-md-6">
              <label for="">JENIS DINDING</label>
              <?php echo $select_dinding_bng; ?>
            </div>
          </div>

          <div class="row" style="margin-left:0px; margin-bottom:6px;">
            <div class="col-md-6">
              <label for="">LUAS BANGUNAN</label>
              <input class="form-control" onkeypress="return hanyaAngka(event)" type="text" id="dtl_luas_bng" name="dtl_luas_bng" value="">
            </div>
            <div class="col-md-6">
              <label for="">JENIS LANTAI</label>
              <?php echo $select_jns_lantai; ?>
            </div>
          </div>

          <div class="row" style="margin-left:0px; margin-bottom:6px;">
            <div class="col-md-6">
              <label for="">JUMLAH LANTAI</label>
              <input class="form-control" onkeypress="return hanyaAngka(event)" type="text" id="dtl_jml_lantai" name="dtl_jml_lantai" value="">
            </div>
            <div class="col-md-6">
              <label for="">JENIS LANGIT-LANGIT</label>
              <?php echo $select_langit; ?>
            </div>
          </div>

          <div class="row" style="margin-left:0px; margin-bottom:6px;">
            <div class="col-md-6">
              <label for="">KONDISI BANGUNAN</label>
              <?php echo $select_kondisi_bng; ?>
            </div>
            <div class="col-md-6">
              <label for="">PENGGUNAAN BANGUNAN</label>
              <?php echo $select_guna_bng; ?>
            </div>
          </div>

          <div class="row" id="div_tambahan" style="margin-right:0px; margin-left:0px; display:none">
            <div class="well" style="padding:10px;min-height:10px; background-color:#5D6385; color:#FFF;">
              <center>
                <font style="font-size:13pt"><strong>DATA BANGUNAN TAMBAHAN</strong></font>
              </center>
            </div>
          </div>

          <div class="row" id="div_jpb02" style="margin-left:0px; margin-bottom:6px; display:none">
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">DATA BANGUNAN TAMBAHAN</label>
                <input class="form-control" type="text" disabled value="(PERKANTORAN SWASTA)">
              </div>
            </div>
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">KELAS BANGUNAN</label>
                <?php echo $select_jpb02_kls_bng; ?>
              </div>
            </div>
          </div>

          <div class="row" id="div_jpb03" style="margin-left:0px; margin-bottom:6px; display:none">
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">DATA BANGUNAN TAMBAHAN</label>
                <input class="form-control" type="text" disabled value="(PABRIK)">
              </div>
            </div>
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">TINGGI KOLOM (M)</label>
                <input class="form-control" onkeypress="return hanyaAngka(event)" type="text" id="jpb03_tinggi" name="jpb03_tinggi" value="">
              </div>
            </div>
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">DAYA DUKUNG LANTAI Kg/M2</label>
                <input class="form-control" onkeypress="return hanyaAngka(event)" type="text" id="jpb03_daya" name="jpb03_daya" value="">
              </div>
            </div>
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">LEBAR BENTANG (M)</label>
                <input class="form-control" onkeypress="return hanyaAngka(event)" type="text" id="jpb03_lebar" name="jpb03_lebar" value="">
              </div>
            </div>
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">KELILING DINDING (M)</label>
                <input class="form-control" onkeypress="return hanyaAngka(event)" type="text" id="jpb03_keliling" name="jpb03_keliling" value="">
              </div>
            </div>
            <div class="row" style="margin-left:0px; margin-bottom:6px;">   
              <div class="col-md-6">
                <label for="">LUAS MEZZANINE (M)</label>
                <input class="form-control" onkeypress="return hanyaAngka(event)" type="text" id="jpb03_luas" name="jpb03_luas" value="">
              </div>
            </div>
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">TIPE KONSTRUKSI</label>
                <?php echo $select_jpb03_kons; ?>
              </div>
            </div>
          </div>

          <div class="row" id="div_jpb04" style="margin-left:0px; margin-bottom:6px; display:none">
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">DATA BANGUNAN TAMBAHAN</label>
                <input class="form-control" type="text" disabled value="(TOKO/APOTIK/PASAR/RUKO)">
              </div>
            </div>
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">KELAS BANGUNAN</label>
                <?php echo $select_jpb04_kls_bng; ?>
              </div>
            </div>
          </div>

          <div class="row" id="div_jpb05" style="margin-left:0px; margin-bottom:6px; display:none">
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">DATA BANGUNAN TAMBAHAN</label>
                <input class="form-control" type="text" disabled value="(RUMAH SAKIT/KLINIK)">
              </div>
            </div>
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">KELAS BANGUNAN</label>
                <?php echo $select_jpb05_kls_bng; ?>
              </div>
            </div>
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">LUAS KAMAR DENGAN AC CENTRAL (M2)</label>
                <input class="form-control" onkeypress="return hanyaAngka(event)" type="text" id="jpb05_ruang_ac" name="jpb05_ruang_ac" value="">
              </div>
            </div>
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">LUAS RUANG LAIN DENGAN AC CENTRAL (M2)</label>
                <input class="form-control" onkeypress="return hanyaAngka(event)" type="text" id="jpb05_ruang_lain" name="jpb05_ruang_lain" value="">
              </div>
            </div>
          </div>

          <div class="row" id="div_jpb06" style="margin-left:0px; margin-bottom:6px; display:none">
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">DATA BANGUNAN TAMBAHAN</label>
                <input class="form-control" type="text" disabled value="(OLAH RAGA/REKREASI)">
              </div>
            </div>
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">KELAS BANGUNAN</label>
                <?php echo $select_jpb06_kls_bng; ?>
              </div>
            </div>
          </div>

          <div class="row" id="div_jpb07" style="margin-left:0px; margin-bottom:6px; display:none">
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">DATA BANGUNAN TAMBAHAN</label>
                <input class="form-control" type="text" disabled value="(HOTEL/WISMA)">
              </div>
            </div>
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">JENIS HOTEL</label>
                <?php echo $select_jpb07_jns_hotel; ?>
              </div>
            </div>
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">JUMLAH BINTANG</label>
                <?php echo $select_jpb07_bintang; ?>
              </div>
            </div>
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">JUMLAH KAMAR</label>
                <input class="form-control" onkeypress="return hanyaAngka(event)" type="text" id="jpb07_jml_kamar" name="jpb07_jml_kamar" value="">
              </div>
            </div>
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">LUAS KAMAR DENGAN AC CENTRAL (M2)</label>
                <input class="form-control" onkeypress="return hanyaAngka(event)" type="text" id="jpb07_ruang_ac" name="jpb07_ruang_ac" value="">
              </div>
            </div>
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">LUAS RUANG LAIN DENGAN AC CENTRAL (M2)</label>
                <input class="form-control" onkeypress="return hanyaAngka(event)" type="text" id="jpb07_ruang_lain" name="jpb07_ruang_lain" value="">
              </div>
            </div>
          </div>

          <div class="row" id="div_jpb08" style="margin-left:0px; margin-bottom:6px; display:none">
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">DATA BANGUNAN TAMBAHAN</label>
                <input class="form-control" type="text" disabled value="(BENGKEL/GUDANG/PERTANIAN)">
              </div>
            </div>
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">TINGGI KOLOM (M)</label>
                <input class="form-control" onkeypress="return hanyaAngka(event)" type="text" id="jpb08_tinggi" name="jpb08_tinggi" value="">
              </div>
            </div>
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">DAYA DUKUNG LANTAI (Kg/M2)</label>
                <input class="form-control" onkeypress="return hanyaAngka(event)" type="text" id="jpb08_daya" name="jpb08_daya" value="">
              </div>
            </div>
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">LEBAR BENTANG (M)</label>
                <input class="form-control" onkeypress="return hanyaAngka(event)" type="text" id="jpb08_lebar" name="jpb08_lebar" value="">
              </div>
            </div>
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">KELILING DINDING (M)</label>
                <input class="form-control" onkeypress="return hanyaAngka(event)" type="text" id="jpb08_keliling" name="jpb08_keliling" value="">
              </div>
            </div>
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">LUAS MEZZANINE (M)</label>
                <input class="form-control" onkeypress="return hanyaAngka(event)" type="text" id="jpb08_luas" name="jpb08_luas" value="">
              </div>
            </div>
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">TIPE KONSTRUKSI</label>
                <?php echo $select_jpb08_kons; ?>
              </div>
            </div>
          </div>

          <div class="row" id="div_jpb09" style="margin-left:0px; margin-bottom:6px; display:none">
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">DATA BANGUNAN TAMBAHAN</label>
                <input class="form-control" type="text" disabled value="(GEDUNG PEMERINTAH)">
              </div>
            </div>
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">KELAS BANGUNAN</label>
                <?php echo $select_jpb09_kls_bng; ?>
              </div>
            </div>
          </div>

          <div class="row" id="div_jpb12" style="margin-left:0px; margin-bottom:6px; display:none">
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">DATA BANGUNAN TAMBAHAN</label>
                <input class="form-control" type="text" disabled value="(BANGUNAN PARKIR)">
              </div>
            </div>
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">KELAS BANGUNAN</label>
                <?php echo $select_jpb12_kls_bng; ?>
              </div>
            </div>
          </div>

          <div class="row" id="div_jpb13" style="margin-left:0px; margin-bottom:6px; display:none">
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">DATA BANGUNAN TAMBAHAN</label>
                <input class="form-control" type="text" disabled value="(APARTEMEN)">
              </div>
            </div>
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">KELAS BANGUNAN</label>
                <?php echo $select_jpb13_kls_bng; ?>
              </div>
            </div>
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">JUMLAH APARTEMEN</label>
                <input class="form-control" onkeypress="return hanyaAngka(event)" type="text" id="jpb13_jml_apart" name="jpb13_jml_apart" value="">
              </div>
            </div>
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">LUAS KAMAR DENGAN AC CENTRAL (M2)</label>
                <input class="form-control" onkeypress="return hanyaAngka(event)" type="text" id="jpb13_ruang_ac" name="jpb13_ruang_ac" value="">
              </div>
            </div>
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">LUAS RUANG LAIN DENGAN AC CENTRAL (M2)</label>
                <input class="form-control" onkeypress="return hanyaAngka(event)" type="text" id="jpb13_ruang_lain" name="jpb13_ruang_lain" value="">
              </div>
            </div>
          </div>

          <div class="row" id="div_jpb14" style="margin-left:0px; margin-bottom:6px; display:none">
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">DATA BANGUNAN TAMBAHAN</label>
                <input class="form-control" type="text" disabled value="(POMPA BENSIN)">
              </div>
            </div>
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">LUAS KANOPI (M2)</label>
                <input class="form-control" onkeypress="return hanyaAngka(event)" type="text" id="jpb14_luas" name="jpb14_luas" value="">
              </div>
            </div>
          </div>

          <div class="row" id="div_jpb15" style="margin-left:0px; margin-bottom:6px; display:none">
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">DATA BANGUNAN TAMBAHAN</label>
                <input class="form-control" type="text" disabled value="(TANGKI MINYAK)">
              </div>
            </div>
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">LETAK TANGKI</label>
                <?php echo $select_jpb15_letak_tangki; ?>
              </div>
            </div>
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">KAPASITAS TANGKI</label>
                <input class="form-control" onkeypress="return hanyaAngka(event)" type="text" id="jpb15_kapasitas" name="jpb15_kapasitas" value="">
              </div>
            </div>
          </div>

          <div class="row" id="div_jpb16" style="margin-left:0px; margin-bottom:6px; display:none">
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">DATA BANGUNAN TAMBAHAN</label>
                <input class="form-control" type="text" disabled value="(GEDUNG SEKOLAH)">
              </div>
            </div>
            <div class="row" style="margin-left:0px; margin-bottom:6px;">  
              <div class="col-md-6">
                <label for="">KELAS BANGUNAN</label>
                <?php echo $select_jpb16_kls_bng; ?>
              </div>
            </div>
          </div>



        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
          <?php if ($dt['kd_jns_ply'] == '03') : ?>
            <button type="button" class="btn btn-primary" id="btn_save_dtl">Simpan</button>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>

  <!-- END MODAL -->


  <!-- MODAL FASILITAS -->
  <div class="modal fade" id="cuDialogDetailFas" tabindex="-1" role="dialog" aria-labelledby="cuDialogDetailFasLabel" aria-hidden="true" style="width:900px; left:250px;">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title" id="cuDialogDetailLabel">DATA FASILITAS BANGUNAN</h3>
        </div>

        <div class="modal-body">
          <div class="row" style="margin-right:0px; margin-left:0px">
            <div class="well" style="padding:10px;min-height:10px; background-color:#5D6385; color:#FFF;">
              <center>
                <font style="font-size:13pt"><strong>DETAIL DATA FASILITAS BANGUNAN</strong></font>
              </center>
            </div>
          </div>

          <div class="row" style="margin-left:0px; margin-bottom:6px;">
            <div class="">
              <table class="table" id="tableKDFas">
                  <thead>
                      <tr>
                          <th>dtl_id</th>
                          <th>dtl_model</th>
                          <th>Nama Fasilitas</th>
                          <th>Jumlah Satuan</th>
                          <th>kd_fas</th>
                          <th>Hapus</th>
                      </tr>
                  </thead>
                  <tbody>
                  </tbody>
              </table>
            </div>
          </div>
          <?php if ($dt['kd_jns_ply'] == '03') { ?>
          <div class="row" style="margin-right:0px; margin-left:0px">
            <div class="well" style="padding:10px;min-height:10px; background-color:#5D6385; color:#FFF;">
              <center>
                <font style="font-size:13pt"><strong>TAMBAH DATA FASILITAS BANGUNAN</strong></font>
              </center>
            </div>
          </div>

          <div class="row hide" style="margin-left:0px; margin-bottom:6px;">
            <div class="col-md-6">
              <input class="form-control" type="text" id="dtlfas_id_head" name="dtlfas_id_head">
            </div>
          </div>

          <div class="row" style="margin-left:0px; margin-bottom:6px;">
            <div class="col-md-4">
              <label for="">FASILITAS</label>
              <?php echo $select_dtl_fas; ?>
            </div>
            <div class="col-md-4">
              <label for="">SATUAN</label>
              <input class="form-control" onkeypress="return hanyaAngka(event)" type="text" id="dtlfas_satuan" name="dtlfas_satuan" value="">
            </div>
            <div class="col-md-4">
                <label for="">&nbsp;</label>
                <button type="button" class="btn btn-primary" id="btn_save_dtl_fas">Simpan Fasilitas</button>
            </div>
          </div>
          
          <?php } ?>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
        </div>
      </div>
    </div>
  </div>

  <!-- END MODAL FASILITAS -->

<div id="overlay">
  <div class="cv-spinner">
    <span class="spinner"></span>
  </div>
</div>


<!-- </div> -->
<?php //$this->load->view('_foot');?>
<!-- Footer -->
<?php $this->load->view('_foot.php'); ?>
<!-- End of Footer -->

<!-- Logout Modal-->
<?php $this->load->view('_logout_modal.php'); ?>
