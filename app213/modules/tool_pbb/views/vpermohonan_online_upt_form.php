<?php //$this->load->view('_head');?>
<?php //$this->load->view(active_module().'/_navbar');?>
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

function f_chg_div_lamp_regesppt(nop, nik) {
  // //// hapus dulu semua elemen
  // var el1 = document.getElementById("r_ktp_re_1");
  // el1.removeChild();
  // var el2 = document.getElementById("r_sppt_re_1");
  // el2.removeChild();
  // var el3 = document.getElementById("r_stts_re_1");
  // el3.removeChild();

  // im_ktp
  var div_ktp = document.createElement('div');

  div_ktp.className = 'row';
  div_ktp.innerHTML = '<a target="_blank" href="<?php echo active_module_url().'permohonan_online_upt/openblob_reg_esppt/IM_KTP_BLOB/'; ?>'+nop+'/'+nik+'" class="btn btn-primary " data-toggle="tooltip" title="File KTP"></i> Lihat File</a>';
  document.getElementById('r_ktp_re_1').appendChild(div_ktp);

  var element_ktp = document.getElementById("input_ktp_re_2");
  element_ktp.remove();

  // im_sppt
  var div_sppt = document.createElement('div');

  div_sppt.className = 'row';
  div_sppt.innerHTML = '<a target="_blank" href="<?php echo active_module_url().'permohonan_online_upt/openblob_reg_esppt/IM_SPPT_BLOB/'; ?>'+nop+'/'+nik+'" class="btn btn-primary " data-toggle="tooltip" title="File SPPT"></i> Lihat File</a>';
  document.getElementById('r_sppt_re_1').appendChild(div_sppt);

  var element_sppt = document.getElementById("input_sppt_re_2");
  element_sppt.remove();

  // im_stts
  var div_stts = document.createElement('div');

  div_stts.className = 'row';
  div_stts.innerHTML = '<a target="_blank" href="<?php echo active_module_url().'permohonan_online_upt/openblob_reg_esppt/IM_PBB_BLOB/'; ?>'+nop+'/'+nik+'" class="btn btn-primary " data-toggle="tooltip" title="File STTS"></i> Lihat File</a>';
  document.getElementById('r_stts_re_1').appendChild(div_stts);

  var element_stts = document.getElementById("input_stts_re_2");
  element_stts.remove();

}

// function f_btn_cari_nop(nop){
//   $.ajax({
//       url: "<?php echo active_module_url() ?>permohonan_online_upt/get_nop_reg_esppt/" + nop,
//       async: true,
//       success: function(j) {
//         // setTimeout(function(){
//         //   $("#overlay").fadeOut(100);
//         // },500);

//         var data = $.parseJSON(j);
//         if (data['result'] == '400') {
//           // alert(data['msg']);
//           Swal.fire({
//                     icon: "warning",
//                     title: "Data tidak ditemukan",
//                     text: data['msg'],
//                 });
//           $("#id_reg_esppt").val('');
//           $("#nama_wp_re").val('');
//           $("#alamat_op_re").val('');
//           $("#nik_re").val('');
//           $("#no_telp_re").val('');
//           $("#nama_re").val('');
//           $("#email_re").val('');
//           return false;
//         } else if (data['result'] == '201') {
//           // alert(data['msg']);
//           Swal.fire({
//                     icon: "success",
//                     title: "Data ditemukan",
//                     text: data['msg'],
//                 });
//           $('#btn_cari_nop').addClass('hidden');
//           $("#id_reg_esppt").val(data['id_re']);
//           $("#nama_wp_re").val(data['nama_wp_re']);
//           $("#alamat_op_re").val(data['alamat_wp_re']);
//           $("#nik_re").val(data['nik_re']);
//           $("#no_telp_re").val(data['no_telp_re']);
//           $("#nama_re").val(data['nama_re']);
//           $("#email_re").val(data['email_re']);
//           // var xnop = nop.replace('-','').replace('.','');
//           // alert(xnop);
//           // f_chg_div_lamp_regesppt(data['nop'], data['nik_re']);

//           // $('#row_re_2').addClass('hidden');
//           // $('#row_re_1').removeClass('hidden');
//           document.getElementById('no_telp_re').readOnly = false;
//           document.getElementById('email_re').readOnly = false;
          

//         } else if (data['result'] == '202') {
//           // alert(data['msg']);
//           Swal.fire({
//                     icon: "success",
//                     title: "Data ditemukan",
//                     text: data['msg'],
//                 });
//           $('#btn_cari_nop').addClass('hidden');
//           $("#id_reg_esppt").val(data['id_re']);
//           $("#nama_wp_re").val(data['nama_wp_re']);
//           $("#alamat_op_re").val(data['alamat_wp_re']);
//           $("#nik_re").val(data['nik_re']);
//           $("#no_telp_re").val(data['no_telp_re']);
//           $("#nama_re").val(data['nama_re']);
//           $("#email_re").val(data['email_re']);

//           $('#row_re_1').addClass('hidden');
//           $('#row_re_2').removeClass('hidden');
//           // document.getElementById('nama_wp_re').readOnly = false;
//           // document.getElementById('alamat_op_re').readOnly = false;
//           // document.getElementById('nik_re').readOnly = false;
//           // document.getElementById('nama_re').readOnly = false;
//           document.getElementById('no_telp_re').readOnly = false;
//           document.getElementById('email_re').readOnly = false;
//         }
//         else {
//           $("#id_reg_esppt").val('');
//           $("#nama_wp_re").val('');
//           $("#alamat_op_re").val('');
//           $("#nik_re").val('');
//           $("#no_telp_re").val('');
//           $("#nama_re").val('');
//           $("#email_re").val('');
//           // alert('Data tidak ditemukan.. silakan refresh halaman..'); 
//           Swal.fire({
//                     icon: "error",
//                     title: "Data tidak ditemukan",
//                     text: "Data tidak ditemukan.. silakan refresh halaman..",
//                 });
//           return false;
//         }
//       },
//       error: function(xhr, desc, er) {
//         alert(er);
//       }
//     });
// }

// function f_get_dop(nop){
//   $.ajax({
//       url: "<?php echo active_module_url() ?>permohonan_online_upt/get_dat_objek_pajak/" + nop,
//       async: true,
//       success: function(j) {
//         // setTimeout(function(){
//         //   $("#overlay").fadeOut(100);
//         // },500);

//         var data = $.parseJSON(j);
//         if (data['result'] == '200') {
//           $("#nop_lengkap").val(data.data_op.NOP_LKP);
//           $("#jln_op_sppt").val(data.data_op.JALAN_OP);
//           $("#blok_kav_no_op_sppt").val(data.data_op.BLOK_KAV_NO_OP);
//           $("#rt_op_sppt").val(data.data_op.RT_OP);
//           $("#rw_op_sppt").val(data.data_op.RW_OP);
//           $("#kd_znt").val(data.data_op.KD_ZNT);
//           $("#luas_bumi").val(data.data_op.LUAS_BUMI);
//           $("#jns_bumi").val(data.data_op.JNS_BUMI);

//           $("#nik").val(data.data_op.NIK);
//           $("#nm_wp_sppt").val(data.data_op.NM_WP);
//           $("#alamat_wp_sppt").val(data.data_op.JALAN_WP);
//           $("#rt_wp_sppt").val(data.data_op.RT_WP);
//           $("#rw_wp_sppt").val(data.data_op.RW_WP);
//           $("#kelurahan_wp_sppt").val(data.data_op.KELURAHAN_WP);
//           $("#kota_wp_sppt").val(data.data_op.KOTA_WP);
//           $("#kodepos_wp_sppt").val(data.data_op.KD_POS_WP);
//           $("#npwp_wp_sppt").val(data.data_op.NPWP);
//           $("#nohp_wp_sppt").val(data.data_op.TELP_WP);
//           $("#email_wp_sppt").val(data.data_op.EMAIL_WP);
//           $("#pekerjaan_wp_sppt").val(data.data_op.STATUS_PEKERJAAN_WP);
//         } else {
//           $("#nop_lengkap").val('');
//           $("#jln_op_sppt").val('');
//           $("#blok_kav_no_op_sppt").val('');
//           $("#rt_op_sppt").val('');
//           $("#rw_op_sppt").val('');
//           $("#kd_znt").val('');
//           $("#luas_bumi").val('');
//           $("#jns_bumi").val('');

//           $("#nik").val('');
//           $("#nm_wp_sppt").val('');
//           $("#alamat_wp_sppt").val('');
//           $("#rt_wp_sppt").val('');
//           $("#rw_wp_sppt").val('');
//           $("#kelurahan_wp_sppt").val('');
//           $("#kota_wp_sppt").val('');
//           $("#kodepos_wp_sppt").val('');
//           $("#npwp_wp_sppt").val('');
//           $("#nohp_wp_sppt").val('');
//           $("#email_wp_sppt").val('');
//           $("#pekerjaan_wp_sppt").val('');
//           alert('Data tidak ditemukan.. silakan refresh halaman..'); 
//           return false;
//         }
//       },
//       error: function(xhr, desc, er) {
//         alert(er);
//       }
//     });
// }

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
                    <input style="width:100%; height:100% !important;" type="file" id="${item.NM_FIELD}" name="${item.NM_FIELD}" ${item.STS}>
                  </div>
                </div>
              </div>
        `;
    });
    html += `</div>`;

    $("#div_lampiran").html(html);
}


$(document).ready(function() {
  $('#nop_re').formatter({
    'pattern': '{{99}}.{{99}}-{{999}}.{{999}}-{{999}}.{{9999}}.{{9}}',
	});

  $('#nop').formatter({
    'pattern': '{{99}}.{{99}}-{{999}}.{{999}}-{{999}}.{{9999}}.{{9}}',
	});

  $("#btn_cari_nop").click(function () {//The load button
      var nop = $('#nop_re').val();
      $("#nop").val(nop);
      $("#overlay").fadeIn(300);
      
      $.ajax({
        url: "<?php echo active_module_url() ?>permohonan_online_upt/get_nop_reg_esppt/" + nop,
        type: 'POST',
        success: function(j) {
          var data = $.parseJSON(j);
          if (data['result'] == '400') {
            // alert(data['msg']);
            Swal.fire({
                    icon: "warning",
                    title: "Data tidak ditemukan",
                    text: data['msg'],
                });
            $("#id_reg_esppt").val('');
            $("#nama_wp_re").val('');
            $("#alamat_op_re").val('');
            $("#nik_re").val('');
            $("#no_telp_re").val('');
            $("#nama_re").val('');
            $("#email_re").val('');
            return false;
          } else if (data['result'] == '201') {
            // alert(data['msg']);
            Swal.fire({
                    icon: "success",
                    title: "Data ditemukan",
                    text: data['msg'],
                });
            $('#btn_cari_nop').addClass('hidden');
            $("#id_reg_esppt").val(data['id_re']);
            $("#nama_wp_re").val(data['nama_wp_re']);
            $("#alamat_op_re").val(data['alamat_wp_re']);
            $("#nik_re").val(data['nik_re']);
            $("#no_telp_re").val(data['no_telp_re']);
            $("#nama_re").val(data['nama_re']);
            $("#email_re").val(data['email_re']);
            // var xnop = nop.replace('-','').replace('.','');
            // alert(xnop);
            // f_chg_div_lamp_regesppt(data['nop'], data['nik_re']);

            // $('#row_re_2').addClass('hidden');
            // $('#row_re_1').removeClass('hidden');

            document.getElementById('no_telp_re').readOnly = false;
            document.getElementById('email_re').readOnly = false;

          } else if (data['result'] == '202') {
            // alert(data['msg']);
            Swal.fire({
                    icon: "success",
                    title: "Data ditemukan",
                    text: data['msg'],
                });
            $('#btn_cari_nop').addClass('hidden');
            $("#id_reg_esppt").val(data['id_re']);
            $("#nama_wp_re").val(data['nama_wp_re']);
            $("#alamat_op_re").val(data['alamat_wp_re']);
            $("#nik_re").val(data['nik_re']);
            $("#no_telp_re").val(data['no_telp_re']);
            $("#nama_re").val(data['nama_re']);
            $("#email_re").val(data['email_re']);

            $('#row_re_1').addClass('hidden');
            $('#row_re_2').removeClass('hidden');
            // document.getElementById('nama_wp_re').readOnly = false;
            // document.getElementById('alamat_op_re').readOnly = false;
            // document.getElementById('nik_re').readOnly = false;
            // document.getElementById('nama_re').readOnly = false;
            document.getElementById('no_telp_re').readOnly = false;
            document.getElementById('email_re').readOnly = false;
          }
          else {
            $("#id_reg_esppt").val('');
            $("#nama_wp_re").val('');
            $("#alamat_op_re").val('');
            $("#nik_re").val('');
            $("#no_telp_re").val('');
            $("#nama_re").val('');
            $("#email_re").val('');
            // alert('Data tidak ditemukan.. silakan refresh halaman..'); 
            Swal.fire({
                    icon: "warning",
                    title: "Data tidak ditemukan",
                    text: "Data tidak ditemukan.. silakan refresh halaman..",
                });
            return false;
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


  $("#btn_send_re").click(function () {//The load button
      var nopnik = $('#id_reg_esppt').val();
      $("#overlay").fadeIn(300);
      $.ajax({
        url: "<?php echo active_module_url() ?>permohonan_online_upt/send_mail_reg_esppt/" + nopnik,
        success: function(j) {
          var data = $.parseJSON(j);
          alert(data['msg']);
        },
        complete: function () {
            $("#overlay").fadeOut(300);
        },
        error: function(xhr, desc, er) {
          alert(er);
        }
      });
      
  });

  $('#btn_save_re').on('click', function() {
    var data = new FormData(document.getElementById("myform"));
    if (!$('#im_stts_re').val() || !$('#im_sppt_re').val() || !$('#im_ktp_re').val()) {
        alert('Semua file harus diupload (KTP, SPT, dan STTS).');
        return false;
    }

    var nop = $('#nop_re').val();
    var nik = $('#nik_re').val();
    var no_telp = $('#no_telp_re').val();
    var email = $('#email_re').val();
    if (no_telp == '' || email == ''){
      alert('Lengkapi data registrasi dengan benar...');
      return false;
    }

    $("#overlay").fadeIn(300);

    $.ajax({
      url: "<?php echo active_module_url() ?>permohonan_online_upt/save_reg_esppt/",
      type: 'POST',
      data: data,
      processData: false,
      contentType: false,
      success: function(j) {
        var data = $.parseJSON(j);

        if (data['result'] == 200) {
            Swal.fire({
                icon: "success",
                title: "Sukses",
                text: data['msg'],
            });
            $('#row_re_2').addClass('hidden');
            $('#row_re_1').removeClass('hidden');
            $('#p_email').text(email);
            $('#modalOtp').modal('show');
        } else {
            Swal.fire({
                icon: "error",
                title: "Gagal",
                text: data['msg'],
            });
            return false;
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

  $('#btnVerifikasiOtp').on('click', function() {
    var otp = $('#kode_otp').val().trim().toUpperCase();
    var email = $('#email_re').val().trim();
    var nik = $('#nik_re').val().trim();
    var nop = $('#nop_re').val().trim();
    var id_reg_esppt = $('#id_reg_esppt').val().trim();

    // Validasi input dulu
    if (otp === '') {
        alert('Masukkan kode OTP terlebih dahulu.');
        $('#kode_otp').focus();
        return false;
    }

    // Tampilkan loading overlay kalau ada
    $("#overlay").fadeIn(300);

    // Kirim AJAX ke server untuk cek OTP
    $.ajax({
        url: "<?php echo active_module_url(); ?>permohonan_online_upt/verify_otp",
        type: "POST",
        data: {
            otp: otp,
            email: email,
            nik: nik,
            nop: nop,
            nopnik: id_reg_esppt,
        },
        dataType: "json",
        success: function(res) {
            $("#overlay").fadeOut(300);

            if (res.status === "ok") {
                Swal.fire({
                    icon: "success",
                    title: "Verifikasi Berhasil!",
                    text: "Kode OTP sesuai, data Anda telah diverifikasi.",
                    timer: 2500,
                    showConfirmButton: false
                });

                // contoh: disable tombol verifikasi biar gak diklik lagi
                $('#btnVerifikasiOtp').prop('disabled', true);
                $('#modalOtp').modal('hide');
                $('#row_bawah').removeClass('hidden');

                f_chg_div_lamp_regesppt(nop, nik);

                //// get dat objek pajak
                // f_get_dop(nop);
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Kode OTP Salah",
                    text: res.msg || "Kode OTP tidak sesuai atau sudah kedaluwarsa.",
                });
            }
        },
        error: function(xhr, status, err) {
            $("#overlay").fadeOut(300);
            Swal.fire({
                icon: "error",
                title: "Gagal Verifikasi",
                text: "Terjadi kesalahan koneksi: " + err
            });
        }
    });
  });



  
  $('#btn_send_permo').on('click', function() {
    var jns_ply = $('#jns_ply').val();
    if (jns_ply == 999999) {
      Swal.fire({
          icon: "error",
          title: "Error",
          text: "Silahkan Pilih Jenis Pelayanan..."
      });
      return false;
    }

    // var data = new FormData(document.getElementById("myform"));
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
      Swal.fire({
          icon: "error",
          title: "Error",
          text: "Lengkapi data Permohonan Online dengan benar..."
      });
      $("#overlay").fadeOut(300);
      return false;
    }

    // var idppo = $('#dtl_id_ppo').val();
    // if (idppo == '') {
        $.ajax({
          url: "<?php echo active_module_url() ?>permohonan_online_upt/save_permo/",
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
                  text: data['msg']
              }).then((result) => {
                  if (result.isConfirmed) {
                      window.location = '<?php echo active_module_url("permohonan_online_upt/edit"); ?>' + data['dtl_id_ppo'];
                  }
              });
              // $("#cuDialogDetail").modal("show");
              // $('#dtl_nop').val(data['dtl_nop']);
              // $('#dtl_nop_tx').val(data['dtl_nop_tx']);
              // $('#dtl_ply').val(data['dtl_ply']);
              // $('#dtl_ply_tx').val(data['dtl_ply_tx']);
              // $('#dtl_thn_ply').val(data['dtl_thn_ply']);
              // $('#dtl_id_ppo').val(data['dtl_id_ppo']);
            }

          },
          complete: function () {
              $("#overlay").fadeOut(300);
          },
          error: function(xhr, desc, er) {
            alert(er);
          }
        });
    // } else {
    //     $("#overlay").fadeOut(300);
    //     $("#cuDialogDetail").modal("show");
    // }

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
        alert(data['msg']);
        $("#cuDialogDetail").modal("hide");
      },
      complete: function () {
          $("#overlay").fadeOut(300);
      },
      error: function(xhr, desc, er) {
        alert(er);
      }
    });

  });


  $("#cuDialogDetail").draggable({
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

  $("#jns_ply").change(function() {
      let jns_ply = $(this).val();

      $.ajax({
          url: "<?= active_module_url('permohonan_online_upt/get_lampiran_by_pelayanan'); ?>",
          type: "POST",
          data: { jns_ply: jns_ply },
          dataType: "json",
          success: function(res) {
              if (res.result == "200") {
                  buildLampiran(res.lampiran);
              } else {
                  $("#div_lampiran").html("<p>Silakan Pilih Jenis Pelayanan.</p>");
              }
          }
      });
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
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
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
                          
                        </div>
                        <div id="r_ktp_re_2" >
                          <div class="row" id="input_ktp_re_2">
                            <input style="width:100%; height:100% !important;" type="file" id="im_ktp_re" name="im_ktp_re" required >
                          </div>
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
                          
                        </div>
                        <div id="r_sppt_re_2" >
                          <div class="row" id="input_sppt_re_2">
                            <input style="width:100%; height:100% !important;" type="file" id="im_sppt_re" name="im_sppt_re" required >
                          </div>
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
                          
                        </div>
                        <div id="r_stts_re_2" >
                          <div class="row" id="input_stts_re_2">
                            <input style="width:100%; height:100% !important;" type="file" id="im_stts_re" name="im_stts_re" required >
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- END LAMPIRAN FILE DATA REGIS -->
                <div class="row" style="margin-top:40px">
                  <div class="col-md-6" id="row_re_2">
                    <button class="btn btn-success" id="btn_save_re" type="button">Simpan dan Verifikasi OTP</button>
                  </div>
                </div>

              <div id="row_bawah" class="hidden">
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
<div id="cuDialogDetail" class="modal" style="width:600px" tabindex="-1" role="dialog" aria-labelledby="cuDialogDetailLabel" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h3 id="cuDialogDetailLabel">Proses Kirim Pelayanan</h3>
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

<!-- MODAL OTP -->
<!-- Modal Verifikasi OTP -->
<div class="modal fade" id="modalOtp" tabindex="-1" aria-labelledby="modalOtpLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
    <div class="modal-content">

      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="modalOtpLabel">
          <i class="ri-shield-check-line me-1"></i> Verifikasi Kode OTP
        </h5>
        <!-- <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button> -->
      </div>

      <div class="modal-body text-center">
        <p class="text-muted mb-3">Masukkan kode OTP yang telah dikirim ke email Anda <p id="p_email"></p>.</p>

        <div class="mb-3">
          <input type="text" maxlength="6" class="form-control text-center fw-bold fs-4" 
                 id="kode_otp" placeholder="••••••" autocomplete="off" 
                 style="letter-spacing: 5px; text-transform: uppercase;" autofocus>
        </div>

        <div id="otpError" class="text-danger small d-none">Kode OTP salah atau kadaluarsa.</div>
      </div>

      <div class="modal-footer justify-content-between">
        <!-- <button type="button" class="btn btn-light" data-bs-dismiss="modal">
          <i class="ri-close-line me-1"></i> Batal
        </button> -->
        <button type="button" class="btn btn-success" id="btnVerifikasiOtp">
          <i class="ri-check-double-line me-1"></i> Verifikasi
        </button>
      </div>

    </div>
  </div>
</div>

<!-- END MODAL OTP -->

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
