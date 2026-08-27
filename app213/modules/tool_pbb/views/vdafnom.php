<?= $this->load->view('layouts/headers'); ?>
<?= $this->load->view(active_module() . '/layouts/sidebar'); ?>

<style>
  table.dataTable tbody tr.row_selected {
    background-color: #B0BED9 !important;
  }

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
                        <h4 class="mb-0">Rekap Dafnom</h4>
                        <div class="page-title-right" id="test">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Tool PBB</a>
                                </li>
                                <li class="breadcrumb-item active">Rekap Dafnom</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <div id="show_alert"></div>

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
                            </div>

                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div class="input-group w-auto">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-end-0">Kecamatan</span>
                                    </div>
                                    <div class="controls">
                                        <div class="controls"><?php echo $select_kecamatan; ?></div>
                                    </div>
                                </div>
                                <div class="input-group w-auto">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-end-0">Kelurahan</span>
                                    </div>
                                    <div class="controls">
                                        <div class="controls"><?php echo $select_kelurahan; ?></div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                  <button class="btn btn-primary" id="btn_cari">Cari</button>
                                  <button class="btn btn-success" id="btn_excel">Export to Excel</button>
                                </div>
                                
                            </div>

                            <div id="msg_helper"></div>

                            <!-- <?php 
                              if(empty($result)) { ?>
                              <div><div id="msg_helper" class="alert alert-error"><button type="button" class="close" data-bs-dismiss="alert">&times;</button>Data tidak ditemukan !</div></div>
                            <?php } ?> -->

                            <br>
                            <div class="row" style="overflow-x:auto;">
                              <table class="table table-striped" id="table1">
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
                                          <th>NOPTHN</th>
                                          <!-- <th>Action</th> -->
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

<!-- MODAL -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">NOP: <span id="modalNOP"></span></h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
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
<!-- END MODAL -->


<!-- tambahan datatables -->
<script>
var oTable;
var mID;

function reload_grid() {
  var nop = $('#c_nop').val();
  var tahun = $('#c_tahun').val();
  var kec = $('#KD_KEC').val();
  var kel = $('#KD_KEL').val();

  var params = {
      nop: nop,
      tahun: tahun,
      kec: kec,
      kel: kel,
  };
  var data_params = decodeURIComponent($.param(params));
  oTable.ajax.url("<?php echo active_module_url(); ?>dafnom/grid/?" + data_params).load();

}

function get_kelurahan(kec_id) {
  $.ajax({
    url: "<?php echo active_module_url()?>dafnom/get_kelurahan/"+kec_id,
    success: function (j) {
      var data = $.parseJSON(j);
      var select = $('#KD_KEL');

      select.html("");
            select.append($('<option />', { value: '999999', text: 'SEMUA KELURAHAN' }));
      $.each(data, function(i, val){
        select.append($('<option />', { value: val['KD_KELURAHAN'], text: val['NM_KELURAHAN'] }));
      });
    },
    error: function (xhr, desc, er) {
      alert(er);
    }
  });
}

    $(document).ready(function() {
        oTable = $('#table1').DataTable({
            "iDisplayLength": 100,
            "sPaginationType": "full_numbers",
            "bAutoWidth": false,
            "sDom": '<"toolbar">frtip',
            "aaSorting": [[ 1, "asc" ]],
            "aoColumnDefs": [
              { "aTargets": [11], "bSearchable": false,  "bVisible": false,  "sWidth": "", "sClass": "" },
            ],
            "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                    $(nRow).on("click", function (event) {
                        if ($(this).hasClass('row_selected')) {
                            mID = '';
                            $(this).removeClass('row_selected');
                        } else {
                            var data = oTable.fnGetData(this);
                            mID = data[11];
                            oTable.$('tr.row_selected').removeClass('row_selected');
                            $(this).addClass('row_selected');
                        }
                    })
            },
            "fnDrawCallback": function( oSettings ) {
                    mID = '';
            },
            "bProcessing": true,
            "bServerSide": true,
            "bFilter": false,
            "sAjaxSource": "<?php echo active_module_url(); ?>dafnom/grid?nop=99.99.999.999.999.9999.9",
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
                  url: '<?php echo active_module_url('dafnom/update_kategori'); ?>',
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
          // var nop = $("#c_nop").val();
          // var tahun = $("#c_tahun").val();
          // if(!nop){
          //   alert('harap mengisi nop');
          // }else{
          //   reload_grid();
          // }
            reload_grid();
          
        });

        $("[id=btn_excel]").click(function() {
          // alert(mID);
          // if(mID) {
          //     // window.location = '<?php echo active_module_url();?>dafnom/excel/'+mID;
          //     var url = '<?php echo active_module_url($this->router->fetch_class()); ?>exp_excel_csv/?' + mID;
          //     window.open(url);
          //     // alert(mID);
          //   }else{
          //     alert('Silahkan pilih data yang akan di export');
          // }

          var nop = $('#c_nop').val();
          var tahun = $('#c_tahun').val();
          var kec = $('#KD_KEC').val();
          var kel = $('#KD_KEL').val();
          var filex = "xls";

          var params = {
              nop: nop,
              tahun: tahun,
              kec: kec,
              kel: kel,
              filex: filex,
          };
          //

          // if(mID){
          //   var data = decodeURIComponent($.param(params));
          //   var url = '<?php echo active_module_url($this->router->fetch_class()); ?>exp_excel_csv/?' + data;
          //   window.open(url);
          // }else{
          //   alert('Silahkan pilih data yang akan di export');
          // }
          var data = decodeURIComponent($.param(params));
          var url = '<?php echo active_module_url($this->router->fetch_class()); ?>exp_excel_csv/?' + data;
          window.open(url);

        });

        $("[id=btn_tes]").click(function() {
          var tes = $("#KD_KEC").val();
          alert(tes);
        });
    });

    $(document).on('click', '#btn_edit', function() {
      // alert('halo');
      var nop = $(this).data('id'); //0
      var kategori = $(this).data('kategori'); //7
      var tahun = $(this).data('tahun'); //1
      var nama = $(this).data('nama'); //2

          // Set the values in the modal
      $('#modalNOP').text(nop);
      $('#kategori').val(kategori);
      $('#tahun').val(tahun);
      $('#nama').val(nama);
    });

</script>