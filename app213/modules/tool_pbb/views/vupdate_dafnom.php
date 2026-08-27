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
                        <h4 class="mb-0">UPDATE DAFNOM</h4>
                        <div class="page-title-right" id="test">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Tool PBB</a>
                                </li>
                                <li class="breadcrumb-item active">Update Dafnom</li>
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
                            <table class="table" id="table1">
                                <thead>
                                    <tr>
                                        <!-- <th>No</th> -->
                                        <th>NOP</th>
                                        <th>Tahun</th>
                                        <th>Nama Wp</th>
                                        <th>Alamat Op</th>
                                        <th>Jenis Bumi</th>
                                        <th>Jpb Bangunan</th>
                                        <th>Status Wp</th>
                                        <th>Kategori Op</th>
                                        <th>Keterangan</th>
                                        <th>Tgl Pembuatan</th>
                                        <th>Nip Perekam</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
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


<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">NOP: <span id="modalNOP"></span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="editForm">
          <div class="form-group">
            <label for="kategori" class="col-form-label">Dafnom Op</label>
            <input type="text" class="form-control" id="kategori" name="kategori" value="" maxlength="1">
            <input type="hidden" name="tahun" id="tahun" value="">
            <input type="hidden" name="nama" id="nama" value="">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary" id="saveBtn" data-id="">Simpan</button>
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
  oTable.ajax.url("<?php echo active_module_url(); ?>update_dafnom/grid/?" + data_params).load();
}

    $(document).ready(function() {
        oTable = $('#table1').DataTable({
            "iDisplayLength": 100,
            "sPaginationType": "full_numbers",
            "bAutoWidth": false,
            "sDom": '<"toolbar">frtip',
            "aaSorting": [[ 1, "asc" ]],
            "aoColumnDefs": [
                // { "aTargets": [0], "bSearchable": true, "bVisible": true, "sWidth": "", "sClass": "" },
                {
                    "bSearchable": false,
                    "bVisible": true,
                    "aTargets": [11],
                    "mRender": function(data, type, full) {
                        var nop = $('#c_nop').val();
                        var tahun = $('#c_tahun').val();
                        var params = {
                            pawal_nop: nop,
                            tahun: tahun,
                        };
                        var prm = decodeURIComponent($.param(params));
                        var nop = full[0].trim();
                        var tahun = full[1];
                        var nama = full[2].trim();
                        var kategori = full[7];
                        var btn_edit = '<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#exampleModalCenter" id="btn_edit" name="btn_edit" data-id="' + nop + '" data-kategori="' + kategori + '" data-tahun="' + tahun + '" data-nama="' + nama + '">Edit</button>'
                        return btn_edit;
                    }
                },
            ],
            "bProcessing": true,
            "bServerSide": true,
            "bFilter": false,
            "sAjaxSource": "<?php echo active_module_url(); ?>update_dafnom/grid"
        });

        $('#editForm').on('keydown', function(e) {
          // Cek apakah tombol yang ditekan adalah Enter (key code 13)
              if (e.keyCode === 13) {
                  e.preventDefault(); // Mencegah aksi default submit form
                  $('#saveBtn').click(); // Trigger tombol "Simpan"
                  // alert('hi');
              }
          });

        $("[id=saveBtn]").click(function(){
          var newKategori = $('#kategori').val();
          var nop = $('#modalNOP').text();
          var tahun = $('#tahun').val();
          var nama = $('#nama').val();

          var postData = {
              nop: nop,
              kategori: newKategori,
              tahun: tahun,
              nama: nama
          };

          if (newKategori !== '') {
            $.ajax({
                  url: '<?php echo active_module_url('update_dafnom/update_kategori'); ?>',
                  type: 'POST',
                  data: postData,
                  dataType: 'JSON',
                  success: function(data) {
                      $('#exampleModalCenter').modal('hide');
                       // Code berhasil 200
                      showAlert(200, 'Berhasil');
                      reload_grid();
                     
                  },
                  error: function() {
                      $('#exampleModalCenter').modal('hide');
                      showAlert(500, 'Gagal');
                      reload_grid();              
                    }
              });
          } 
        });

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
      var nop = $(this).data('id'); //0
      var kategori = $(this).data('kategori'); //7
      var tahun = $(this).data('tahun'); //1
      var nama = $(this).data('nama'); //2

      $('#exampleModalCenter').modal('show');

          // Set the values in the modal
      $('#modalNOP').text(nop);
      $('#kategori').val(kategori);
      $('#tahun').val(tahun);
      $('#nama').val(nama);
    });

</script>