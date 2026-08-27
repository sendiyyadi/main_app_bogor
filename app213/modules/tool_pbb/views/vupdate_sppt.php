<?= $this->load->view('layouts/headers'); ?>
<?= $this->load->view(active_module() . '/layouts/sidebar'); ?>

<style>
.nav-tabs > .active > a, .nav-pills > .active > a:hover {
    color: blue;
}
</style>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">UPDATE STATUS SPPT</h4>
                        <div class="page-title-right" id="test">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Tool PBB</a>
                                </li>
                                <li class="breadcrumb-item active">Update Status SPPT</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <?php echo msg_block();?>
            <div id="show_alert"></div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div class="input-group w-auto">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-end-0">NOP</span>
                                    </div>
                                    <div class="controls">
                                        <input type="text" id="c_nop" class="form-control" name="c_nop" placeholder="Cari NOP" style="width:200px">
                                    </div>
                                </div>
                                <div class="input-group w-auto">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-end-0">Tahun</span>
                                    </div>
                                    <div class="controls">
                                        <input type="text" id="c_tahun" class="form-control" name="c_tahun" placeholder="Cari Tahun">
                                    </div>
                                </div>
                                <div class="col-md-1"><button class="btn btn-primary" id="btn_cari">Cari</button></div>
                            </div>

                            <br>
                            <div class="row" style="overflow-x:auto;">
                                <table class="table table-striped" id="table1">
                                    <thead>
                                        <tr>
                                            <!-- <th>No</th> -->
                                            <th>NOP</th>
                                            <th>Tahun</th>
                                            <th>Nama WP</th>
                                            <th>ALAMAT WP</th>
                                            <th>Jatuh Tempo</th>
                                            <th>Terhutang</th>
                                            <th>Pengurang</th>
                                            <th>Tagihan</th>
                                            <th>Status</th>
                                            <th>Pembayaran ke</th>
                                            <th>Action</th>
                                            <!-- <th>Detail</th> -->
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TUTUP CONTAINER-FLUID -->
        </div>
    </div>

<?= $this->load->view('layouts/foot.php'); ?>
</div>
<?= $this->load->view('layouts/scripts.php'); ?>

<?= $this->load->view('layouts/footer.php'); ?>

<div class="modal fade" id="exampleModalCenter" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">NOP: <span id="modalNOP"></span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <form method="post" action="<?php echo active_module_url('update_sppt'); ?>" id="myform">
            <div class="mb-3 row">
                
                <label for="example-text-input" class="col-md-4 col-sm-4 col-form-label">Status Pembayaran SPPT</label>
                <div class="col-md-4 col-sm-4">
                    <input class="form-control" type="text" name="sts" id="sts" id="example-text-input">
                    <input type="hidden" name="nop" id="nop">
                    <input type="hidden" name="tahun" id="tahun">
                </div>
            </div>

          <!-- Tombol -->
          <div class="text-end mt-4">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button class="btn btn-primary" type="button" id="saveBtn">Simpan</button>
          </div>

        </form>
      </div>

    </div>
  </div>
</div>


<!-- tambahan datatables -->
<script>
    var oTable;

    function reload_grid() {
        var nop = $('#c_nop').val();
        var tahun = $('#c_tahun').val();
        var params = {
            nop: nop,
            tahun: tahun,
        };
        var data_params = decodeURIComponent($.param(params));
        oTable.ajax.url("<?php echo active_module_url(); ?>update_sppt/grid/?" + data_params).load();
    }

    $(document).ready(function() {
        oTable = $('#table1').DataTable({
            "iDisplayLength": 100,
            "sPaginationType": "full_numbers",
            // "bPaginate": true,
            // "bSort": true,
            // "bInfo": true,
            "bAutoWidth": false,
            "sDom": '<"toolbar">frtip',
            "aaSorting": [[ 1, "asc" ]],
            "aoColumnDefs": [
                {
                    "bSearchable": false,
                    "bVisible": true,
                    "aTargets": [10],
                    "mRender": function(data, type, full) {
                        var nop = $('#c_nop').val();
                        var tahun = $('#c_tahun').val();
                        var params = {
                            pawal_nop: nop,
                            tahun: tahun,
                        };
                        var prm = decodeURIComponent($.param(params));
                        var trimmedValue = full[0].trim();
                        var trimmedName = full[8].trim();
                        var address = full[3];
                        var btn_edit = '<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#exampleModalCenter" id="btn_edit" name="btn_edit" data-status="' + trimmedName + '" data-id="' + trimmedValue + '" data-tahun="' + full[1] + '">Edit</button>'
                        return btn_edit;
                    }
                },
            ],
            "bProcessing": true,
            "bServerSide": true,
            "bFilter": false,
            "sAjaxSource": "<?php echo active_module_url(); ?>update_sppt/grid"
            // "mData": null
            // "defaultContent": "<i>Not set</i>"
        });

        $('#myform').on('keydown', function(e) {
          // Cek apakah tombol yang ditekan adalah Enter (key code 13)
              if (e.keyCode === 13) {
                  e.preventDefault(); // Mencegah aksi default submit form
                  $('#saveBtn').click(); // Trigger tombol "Simpan"
              }
          });

        $("[id=saveBtn]").click(function(){
          var newStatus = $('#sts').val();
          var nop = $('#modalNOP').text();
          var tahun = $('#tahun').val();

          var postData = {
            nop: nop,
            status: newStatus,
            tahun: tahun,
          };

          if (newStatus !== '') {
            $.ajax({
                  url: '<?php echo active_module_url('update_sppt/update_status'); ?>',
                  type: 'POST',
                  data: postData,
                  dataType: 'JSON',
                  success: function(data) {
                      $('#exampleModalCenter').modal('hide');
                        showAlert(data.code, data.msg);

                       // // Code berhasil 200
                       // if(data.code == '200'){
                       //    showAlert('success', data.msg);
                       // }else if(data.code == '404'){
                       //    showAlert('warning', data.msg);
                       // }
                      reload_grid();
                     
                  },
                  error: function(request, status, error) {
                      $('#exampleModalCenter').modal('hide');
                      // showAlert('danger', 'Gagal');
                      showAlert(500, request.responseText);
                      reload_grid();              
                    }
              });
          } 
        });

         // $("[id=saveBtn]").click(function(){
        //   var newStatus = $('#status').val();
        //   var nop = $('#modalNOP').text();
        //   var tahun = $('#tahun').val();

        //   var postData = {
        //       nop: nop,
        //       status: newStatus,
        //       tahun: tahun,
        //   };

        //   if (newStatus !== '') {
        //     $.ajax({
        //           url: '<?php echo active_module_url('update_sppt/update_status'); ?>',
        //           type: 'POST',
        //           data: postData,
        //           dataType: 'JSON',
        //           success: function(response) {
        //               $('#exampleModalCenter').modal('hide');
        //               reload_grid();
        //           },
        //           error: function(xhr, status, error) {
        //               $('#exampleModalCenter').modal('hide');
        //               reload_grid();
        //           }
        //       });
        //   } 

        //   // reload_grid();

        // });

         // $('#myform').on('submit', function(e){
         //    e.preventDefault();

         //    $.ajax({
         //            url: $(this).attr('action'),
         //            type: $(this).attr('method'),
         //            data: $(this).serialize(),
         //            dataType: 'json',
         //            success: function(response) {
         //                if (response === 'success') {
         //            // Menampilkan pesan sukses
         //            alert('Data telah diubah');
         //            $('#exampleModalCenter').modal('hide');
         //        } else if (response === 'warning') {
         //            // Menampilkan pesan peringatan
         //            alert('Tidak ada perubahan data');
         //        } else {
         //            // Menampilkan pesan error
         //            alert('Data gagal diubah');
         //        }
         //            },
         //            error: function() {
         //                alert('Terjadi kesalahan saat mengubah data.');
         //                // $this->session->set_flashdata('msg_error', 'Data gagal diubah');
         //            }
         //        });
            // });

        $("[id=btn_cari]").click(function() {
          var nop = $("#c_nop").val();
          var tahun = $("#c_tahun").val();
          if(!nop){
            alert('harap mengisi nop');
          }else{
            reload_grid();
          }
        });

    });

    $(document).on('click', '#btn_edit', function() {
      // alert('halo');
      var trimmedValue = $(this).data('id'); //0
      var trimmedName = $(this).data('status'); //8
      // var address = $(this).data('address'); //3
      var tahun = $(this).data('tahun'); //1
      // var nama = $(this).data('nama'); //2
      // var jatuh = $(this).data('jatuh'); //4
      // var terhutang = $(this).data('terhutang'); //5
      // var pengurang = $(this).data('pengurang'); //6
      // var tagihan = $(this).data('tagihan'); //7

      $('#exampleModalCenter').modal('show');

          // Set the values in the modal
      $('#modalNOP').text(trimmedValue);
      $('#nop').val(trimmedValue);
      $('#sts').val(trimmedName);
      // $('#alamat').val(address);
      $('#tahun').val(tahun);
      // $('#alamat').val(address);
      // $('#nama').val(nama);
      // $('#jatuh').val(jatuh);
      // $('#terhutang').val(terhutang);
      // $('#pengurang').val(pengurang);
      // $('#tagihan').val(tagihan);

    });
</script>