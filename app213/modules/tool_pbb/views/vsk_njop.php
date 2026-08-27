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
                        <h4 class="mb-0">SK NJOP</h4>
                        <div class="page-title-right" id="test">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Tool PBB</a>
                                </li>
                                <li class="breadcrumb-item active">SK NJOP</li>
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
                              <!-- <div class="input-group w-auto">
                                  <div class="input-group-prepend">
                                      <span class="input-group-text rounded-end-0">Tahun</span>
                                  </div>
                                  <div class="controls">
                                      <input type="text" id="c_tahun" class="form-control" name="c_tahun" placeholder="Cari Tahun">
                                  </div>
                              </div> -->
                              <div class="col-md-1"><button class="btn btn-primary" id="btn_cari">Cari</button></div>
                          </div>

                          <br>
                          <table class="table" id="table1">
                              <thead>
                                  <tr>
                                      <!-- <th>No</th> -->
                                      <th>NOP</th>
                                      <th>Nama WP</th>
                                      <th>Alamat OP</th>
                                      <th>Alamat WP</th>
                                      <th>Action</th>
                                      <!-- <th>Detail</th> -->
                                  </tr>
                              </thead>
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
            <!-- <form id="editForm"> -->
              <form method="post" action="<?php echo active_module_url('sk_njop'); ?>" id="myform" >
                <div class="form-group">
                  <label for="no_sk" class="col-form-label">NO SK</label>
                  <input type="text" class="form-control" id="no_sk" name="no_sk" value="">
                <input type="hidden" name="nop" id="nop" value="">
                  <input type="hidden" name="tahun" id="tahun" value="">
                  <div class="mt-4">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-primary" type="button" id="saveBtn">Simpan</button>
                  </div>
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
        oTable.ajax.url("<?php echo active_module_url(); ?>sk_njop/grid/?" + data_params).load();
    }

    $(document).ready(function() {
        oTable = $('#table1').DataTable({
            "iDisplayLength": 100,
            // "bPaginate": true,
            // "bSort": true,
            // "bInfo": true,
            "sPaginationType": "full_numbers",
            "bAutoWidth": false,
            "sDom": '<"toolbar">frtip',
            "aaSorting": [[ 1, "asc" ]],
            "aoColumnDefs": [
                // { "bSearchable": false, "bVisible": false, "aTargets": [8] },
                // { "bSearchable": false, "bVisible": false, "aTargets": [9] },
                // { "bSearchable": false, "bVisible": false, "aTargets": [10] },
                // { "bSearchable": false, "bVisible": false, "aTargets": [11] },
                // { "bSearchable": false, "bVisible": false, "aTargets": [12] },
                // { "bSearchable": false, "bVisible": false, "aTargets": [13] },
                {
                    "bSearchable": false,
                    "bVisible": true,
                    "aTargets": [4],
                    "mRender": function(data, type, full) {
                        var nop = full[0].trim();
                        var tahun = '2025';
                        var btn_sk = '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter" id="btn_no_sk" name="btn_no_sk" data-id="' + nop + '" data-tahun="' + tahun + '">No SK</button>';
                        //var btn_cetak = '<a href="<?php echo active_module_url()?>sk_njop/detail/'+full[0]+'/'+full[1]+'/'+nama+'/'+alamat+'/'+full[9]+'/'+full[10]+'/'+full[11]+'/'+full[12]+'/'+full[13]+'" type="button" class="btn btn-primary" target="_blank" style="margin-left:5px">Detail</a>';
                        var btn_cetak2 = '<button type="button" class="btn btn-warning" id="btn_cetak" name="btn_cetak" data-id="' + nop + '" data-tahun="' + tahun + '" style="margin-left:5px">Cetak</button>';
                        return btn_sk + btn_cetak2;
                    }
                },
            ],
            "bProcessing": true,
            "bServerSide": true,
            "bFilter": false,
            "sAjaxSource": "<?php echo active_module_url(); ?>sk_njop/grid"
        });

        $('#myform').on('keydown', function(e) {
          // Cek apakah tombol yang ditekan adalah Enter (key code 13)
              if (e.keyCode === 13) {
                  e.preventDefault(); // Mencegah aksi default submit form
                  $('#saveBtn').click(); // Trigger tombol "Simpan"
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

        $("[id=saveBtn]").click(function(){
          var no_sk = $('#no_sk').val();
          var nop = $('#modalNOP').text();
          var tahun = $('#tahun').val();

          var postData = {
            nop: nop,
            no_sk: no_sk,
            tahun: tahun,
          };

          if (no_sk !== '') {
            $.ajax({
                  url: '<?php echo active_module_url('sk_njop/insert_sk'); ?>',
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

    });

    $(document).on('click', '#btn_no_sk', function() {
      // alert('halo');
      var nop = $(this).data('id'); //0
      var tahun = $(this).data('tahun'); 

      $('#exampleModalCenter').modal('show');
      $('#modalNOP').text(nop);
      $('#nop').val(nop);
      $('#tahun').val(tahun);
    });

    $(document).on('click', '#btn_cetak', function() {
        var nop = $(this).data('id'); //0
        var tahun = $(this).data('tahun'); 

        var url = '<?php echo active_module_url(); ?>sk_njop/cetak_sk_njop/' + nop + '/' + tahun;
        var winparams = 'width=' + screen.width + ',height=' + screen.height + ',directories=0,titlebar=0,toolbar=0,location=0,status=0,menubar=0,scrollbars=no,resizable=no';
        window.open(url, 'Laporan', winparams);
    });
</script>