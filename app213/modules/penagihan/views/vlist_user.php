<?= $this->load->view('layouts/headers'); ?>
<?= $this->load->view(active_module() . '/layouts/sidebar'); ?>

<style>
  table.dataTable tbody tr.row_selected {
    background-color: #B0BED9 !important;
  }
</style>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">DAFTAR USER</h4>
                        <div class="page-title-right" id="test">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript: void(0);">Distribusi SPPT</a>
                                </li>
                                <li class="breadcrumb-item active">Daftar User</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            echo msg_block();
            if (validation_errors()) {
              echo '<blockquote><strong>Harap melengkapi data berikut :</strong>';
              echo validation_errors('<small>', '</small>');
              echo '</blockquote>';
            }
            ?>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                          <button class="btn btn-success" data-toggle="modal" id="btn_add_users" data-target="#myModalAdd">Tambah User</button>
                          <button class="btn btn-warning" data-toggle="modal" id="btn_edit_users" data-target="#myModalEdit">Edit User</button>
                          <button class="btn btn-danger" data-toggle="modal" id="btn_delete_users">Hapus User</button>

                          <?php echo $c_select_kecamatan; ?>
                          <input class="form-control" type="text" name="c_loginname" id="c_loginname" placeholder="Login Name" maxlength="30" style="display:inline; width:auto;" />
                          <button class="btn btn-info" id="btn_cari">CARI</button>

                          <table class="table table-striped" id="mytable" style="margin-top: 10px">
                            <thead>
                              <tr>
                                <th>LOGINNAME</th>
                                <th>PASSWORD</th>
                                <th>NAMA</th>
                                <th>EMAIL</th>
                                <th>NIP</th>
                                <th>USER GROUP</th>
                                <th>KECAMATAN</th>
                                <th>KELURAHAN</th>
                                <th>KD_GROUP</th>
                                <th>KD_KEC</th>
                                <th>KD KEL</th>
                              </tr>
                            </thead>
                          </table>

<!-- END DIV CARD BODY -->
                        </div>
                    </div>
                </div>
            </div>

        <!-- TUTUP CONTAINER-FLUID -->
        </div>
    </div>

<!-- Modal Add User-->
<form id="add-row-form" action="<?php active_module_url(); ?>list_user/add" method="post">
  <div class="modal fade" id="myModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Tambah User</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

        </div>
        <div class="modal-body">

          <div class="form-group">
            <div class="row mt-2">
              <div class="col-md-2">
                <label class="form-label" for="USER_GROUP" style="margin-top:7px">User Group</label>
              </div>
              <div class="col-md-6">
                <select class="custom-select mr-sm-2" name="USER_GROUP" id="USER_GROUP" onchange="get_change_group(this);">
                  <option value="1">ADMIN</option>
                  <option value="2">PBB</option>
                  <option value="3">KOORD KECAMATAN</option>
                  <option value="4">DESA</option>
                  <option value="5">UPT</option>
                  <option value="6">LOKET</option>
                  <option value="7">PEMDA DS</option>
                  <option value="8">KELURAHAN DS</option>
                </select>
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="row mt-2">
              <div class="col-md-2">
                <label class="form-label" for="LOGIN_NAME" style="margin-top:7px">Login Name</label>
              </div>
              <div class="col-md-8">
                <input class="form-control" type="text" name="LOGIN_NAME" id="LOGIN_NAME" placeholder="Login Name" maxlength="30" required />
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="row mt-2">
              <div class="col-md-2">
                <label class="form-label" for="PASSWOD" style="margin-top:7px">Password</label>
              </div>
              <div class="col-md-8">
                <input class="form-control" type="text" name="PASSWOD" id="PASSWOD" placeholder="Password" maxlength="20" required />
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="row mt-2">
              <div class="col-md-2">
                <label class="form-label" for="NAMA" style="margin-top:7px">Nama</label>
              </div>
              <div class="col-md-8">
                <input class="form-control" type="text" name="NAMA" id="NAMA" placeholder="Nama" maxlength="50" required />
              </div>
            </div>
          </div>

          <div class="form-group" hidden>
            <div class="row mt-2">
              <div class="col-md-2">
                <label class="form-label" for="EMAIL" style="margin-top:7px">Email</label>
              </div>
              <div class="col-md-8">
                <input class="form-control" type="text" name="EMAIL" id="EMAIL" maxlength="10" placeholder="Email" />
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="row mt-2">
              <div class="col-md-2">
                <label class="form-label" for="NIP" style="margin-top:7px">NIP</label>
              </div>
              <div class="col-md-8">
                <input class="form-control" type="text" name="NIP" id="NIP" maxlength="19" placeholder="NIP" />
              </div>
            </div>
          </div>

          <div class="form-group" id="sel_kec" style="display: none;">
            <div class="row mt-2">
              <div class="col-md-2">
                <label class="form-label" for="KD_KEC" style="margin-top:7px">Kecamatan</label>
              </div>
              <div class="col-md-8">
                <?php echo $select_kecamatan; ?>
              </div>
            </div>
          </div>

          <div class="form-group" id="sel_kel" style="display: none;">
            <div class="row mt-2">
              <div class="col-md-2">
                <label class="form-label" for="KD_KEL" style="margin-top:7px">Kelurahan</label>
              </div>
              <div class="col-md-8">
                <?php echo $select_kelurahan; ?>
              </div>
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" id="add-row" class="btn btn-success">Simpan</button>
        </div>
      </div>
    </div>
  </div>
</form>


<!-- Modal Edit User-->
<form id="edit-row-form" action="<?php active_module_url(); ?>list_user/edit" method="post">
  <div class="modal fade" id="myModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Edit User</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

        </div>
        <div class="modal-body">

          <div class="form-group">
            <div class="row mt-2">
              <div class="col-md-2">
                <label class="form-label" for="USER_GROUP_E" style="margin-top:7px">User Group</label>
              </div>
              <div class="col-md-6">
                <select class="input select2 mr-sm-2" name="USER_GROUP_E" id="USER_GROUP_E" onchange="get_change_group_e(this);">
                  <option value="1">ADMIN</option>
                  <option value="2">PBB</option>
                  <option value="3">KOORD KECAMATAN</option>
                  <option value="4">DESA</option>
                  <option value="5">UPT</option>
                  <option value="6">LOKET</option>
                  <option value="7">PEMDA DS</option>
                  <option value="8">KELURAHAN DS</option>
                </select>
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="row mt-2">
              <div class="col-md-2">
                <label class="form-label" for="LOGIN_NAME_E" style="margin-top:7px">Login Name</label>
              </div>
              <div class="col-md-8">
                <input class="form-control" type="text" name="LOGIN_NAME_E" id="LOGIN_NAME_E" placeholder="Login Name" maxlength="30" readonly required />
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="row mt-2">
              <div class="col-md-2">
                <label class="form-label" for="PASSWOD_E" style="margin-top:7px">Password</label>
              </div>
              <div class="col-md-8">
                <input class="form-control" type="text" name="PASSWOD_E" id="PASSWOD_E" placeholder="Password" maxlength="20" />
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="row mt-2">
              <div class="col-md-2">
                <label class="form-label" for="NAMA_E" style="margin-top:7px">Nama</label>
              </div>
              <div class="col-md-8">
                <input class="form-control" type="text" name="NAMA_E" id="NAMA_E" placeholder="Nama" maxlength="50" required />
              </div>
            </div>
          </div>

          <div class="form-group" hidden>
            <div class="row mt-2">
              <div class="col-md-2">
                <label class="form-label" for="EMAIL_E" style="margin-top:7px">Email</label>
              </div>
              <div class="col-md-8">
                <input class="form-control" type="text" name="EMAIL_E" id="EMAIL_E" maxlength="10" placeholder="Email" />
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="row mt-2">
              <div class="col-md-2">
                <label class="form-label" for="NIP_E" style="margin-top:7px">NIP</label>
              </div>
              <div class="col-md-8">
                <input class="form-control" type="text" name="NIP_E" id="NIP_E" maxlength="19" placeholder="NIP" />
              </div>
            </div>
          </div>

          <div class="form-group" id="sel_kec_e" style="display: none;">
            <div class="row mt-2">
              <div class="col-md-2">
                <label class="form-label" for="KD_KEC_E" style="margin-top:7px">Kecamatan</label>
              </div>
              <div class="col-md-8">
                <?php echo $select_kecamatan_e; ?>
              </div>
            </div>
          </div>

          <div class="form-group" id="sel_kel_e" style="display: none;">
            <div class="row mt-2">
              <div class="col-md-2">
                <label class="form-label" for="KD_KEL_E" style="margin-top:7px">Kelurahan</label>
              </div>
              <div class="col-md-8">
                <?php echo $select_kelurahan_e; ?>
              </div>
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" id="add-row" class="btn btn-success">Simpan</button>
        </div>
      </div>
    </div>
  </div>
</form>

<!-- Modal Delete User-->
<form id="delete-row-form" action="<?php active_module_url(); ?>list_user/hapus" method="post">
  <div class="modal fade" id="myModalDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Hapus User</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

        </div>
        <div class="modal-body">

          <div class="form-group" hidden>
            <div class="row">
              <div class="col-md-2">
                <label class="form-label" for="LOGIN_NAME_H" style="margin-top:7px">Login Name</label>
              </div>
              <div class="col-md-8">
                <input class="form-control" type="text" name="LOGIN_NAME_H" id="LOGIN_NAME_H" placeholder="Login Name" maxlength="30" readonly required />
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="row">
              <div class="col-md-12">
                <label class="form-label" style="margin-top:7px">Yakin akan menghapus user ini? </label>
              </div>

            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" id="add-row" class="btn btn-success">Hapus</button>
        </div>
      </div>
    </div>
  </div>
</form>
<!-- End of MODALS -->


    <?= $this->load->view('layouts/foot.php'); ?>
</div>
<?= $this->load->view('layouts/scripts.php'); ?>

<?= $this->load->view('layouts/footer.php'); ?>

<!-- tambahan datatables -->
<script>
  $.fn.dataTableExt.oApi.fnReloadAjax = function(oSettings, sNewSource, fnCallback, bStandingRedraw) {

    if (typeof sNewSource != 'undefined' && sNewSource != null) {
      oSettings.sAjaxSource = sNewSource;
    }

    /* Server-side processing should just call fnDraw */
    if (oSettings.oFeatures.bServerSide) {
      this.fnDraw();
      return;
    }

    this.oApi._fnProcessingDisplay(oSettings, true);
    var that = this;
    var iStart = oSettings._iDisplayStart;
    var aData = [];

    this.oApi._fnServerParams(oSettings, aData);
    oSettings.fnServerData.call(oSettings.oInstance, oSettings.sAjaxSource, aData, function(json) {

      /* Clear the old information from the table */
      that.oApi._fnClearTable(oSettings);

      /* Got the data - add it to the table */
      var aData = (oSettings.sAjaxDataProp !== "") ?
        that.oApi._fnGetObjectDataFn(oSettings.sAjaxDataProp)(json) : json;
      for (var i = 0; i < aData.length; i++) {
        that.oApi._fnAddData(oSettings, aData[i]);
      }
      oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();

      if (typeof bStandingRedraw != 'undefined' && bStandingRedraw === true) {
        oSettings._iDisplayStart = iStart;
        that.fnDraw(false);
      } else {
        that.fnDraw();
      }

      that.oApi._fnProcessingDisplay(oSettings, false);

      /* Callback user function - for event handlers etc */
      if (typeof fnCallback == 'function' && fnCallback != null) {
        fnCallback(oSettings);
      }

    }, oSettings);

  };



  function reload_grid() {

    var loginname = $('#c_loginname').val();
    // var kel    = $('#c_kel').val();
    var kec = $('#C_KD_KEC').val();

    var params = {
      loginname: loginname,
      // kel: kel,
      kec: kec,
    };

    var data_params = decodeURIComponent($.param(params));
    oTable.fnReloadAjax("<?php echo active_module_url(); ?>list_user/get_userdsjson/?" + data_params);

  }



  function refresh_grid() {
    document.getElementById('c_loginname').value = '';
    // document.getElementById('c_kel').value='';
    document.getElementById('C_KD_KEC').value = '999999';
    reload_grid();

  }

  function get_change_group(sel) {
    // alert(sel.value);
    var sel_kec = document.getElementById("sel_kec");
    var sel_kel = document.getElementById("sel_kel");
    var kec = document.getElementById("KD_KEC");
    var kel = document.getElementById("KD_KEL");

    if (sel.value == '8') {
      sel_kec.style.display = "block";
      sel_kel.style.display = "block";
      kec.disabled = false;
      kel.disabled = false;
    } else if(sel.value == '3'){
      sel_kec.style.display = "block";
      sel_kel.style.display = "none";
      kec.disabled = false;
      kel.disabled = true;
    } else {
      sel_kec.style.display = "none";
      sel_kel.style.display = "none";
      kec.disabled = true;
      kel.disabled = true;
    }
  }

  function get_change_group_e(sel) {
    // alert(sel.value);
    var sel_kec_e = document.getElementById("sel_kec_e");
    var sel_kel_e = document.getElementById("sel_kel_e");
    var kec_e = document.getElementById("KD_KEC_E");
    var kel_e = document.getElementById("KD_KEL_E");

    if (sel.value == '8') {
      sel_kec_e.style.display = "block";
      sel_kel_e.style.display = "block";
      kec.disabled = false;
      kel.disabled = false;
    } else if(sel.value == '3'){
      sel_kec_e.style.display = "block";
      sel_kel_e.style.display = "none";
      kec.disabled = false;
      kel_e.disabled = true;
    } else {
      sel_kec_e.style.display = "none";
      sel_kel_e.style.display = "none";
      kec.disabled = true;
      kel.disabled = true;
    }
  }

  function get_kelurahan(kec_id) {
    $.ajax({
      url: "<?php echo active_module_url() ?>list_user/get_kelurahan/" + kec_id,
      success: function(j) {
        var data = $.parseJSON(j);
        var select = $('#KD_KEL');

        select.html("");
        $.each(data, function(i, val) {
          select.append($('<option />', {
            value: val['KD_KELURAHAN'],
            text: val['NM_KELURAHAN']
          }));
        });
      },
      error: function(xhr, desc, er) {
        alert(er);
      }
    });
  }

  function get_kelurahan_e(kec_id) {
    $.ajax({
      url: "<?php echo active_module_url() ?>list_user/get_kelurahan/" + kec_id,
      success: function(j) {
        var data = $.parseJSON(j);
        var select = $('#KD_KEL_E');

        select.html("");
        $.each(data, function(i, val) {
          select.append($('<option />', {
            value: val['KD_KELURAHAN'],
            text: val['NM_KELURAHAN']
          }));
        });
      },
      error: function(xhr, desc, er) {
        alert(er);
      }
    });
  }

  function get_kelurahan_kecamatan_e(kec_id, kel_id) {
    $.ajax({
      url: "<?php echo active_module_url() ?>list_user/get_kelurahan/" + kec_id,
      success: function(j) {
        var data = $.parseJSON(j);
        var select = $('#KD_KEL_E');

        select.html("");
        $.each(data, function(i, val) {
          // if (kel_id==val['KD_KELURAHAN']){
          // select.append($('<option selected  />', { selected, value: val['KD_KELURAHAN'], text: val['NM_KELURAHAN'] }));
          // $('#select').append('<option selected value="123">1111</option>');
          // } else {
          select.append($('<option />', {
            value: val['KD_KELURAHAN'],
            text: val['NM_KELURAHAN']
          }));
          // }

        });

        $('#KD_KEL_E').val(kel_id).change();
        // $("#KD_KEL_E option[value="+kel_id+"]").attr('selected', 'selected');
      },
      error: function(xhr, desc, er) {
        alert(er);
      }
    });
  }


  var LOGINNAME;
  var PASSWOD;
  var NAMA;
  var EMAIL;
  var NIP;
  var USER_GROUP;
  var KD_KEC;
  var KD_KEL;

  $(document).ready(function() {

    $('#USER_GROUP').select2({
      width: '100%', 
      dropdownParent: $('#myModalAdd') 
    });

    $('#USER_GROUP_E').select2({
      width: '100%', 
      dropdownParent: $('#myModalEdit') 
    });

    $('#KD_KEC').select2({
      width: '100%', 
      dropdownParent: $('#myModalAdd') 
    });
    $('#KD_KEL').select2({
      width: '100%', 
      dropdownParent: $('#myModalAdd') 
    });

    $('#KD_KEC_E').select2({
      width: '100%', 
      dropdownParent: $('#myModalEdit') 
    });
    $('#KD_KEL_E').select2({
      width: '100%', 
      dropdownParent: $('#myModalEdit') 
    });

    // Setup datatables
    // $.fn.dataTableExt.oApi.fnPagingInfo = function (oSettings) {
    //     return {
    //         "iStart": oSettings._iDisplayStart,
    //         "iEnd": oSettings.fnDisplayEnd(),
    //         "iLength": oSettings._iDisplayLength,
    //         "iTotal": oSettings.fnRecordsTotal(),
    //         "iFilteredTotal": oSettings.fnRecordsDisplay(),
    //         "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
    //         "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
    //     };
    // };

    // $("#mytable").dataTable({
    //     initComplete: function () {
    //         var api = this.api();
    //         $('#mytable_filter input')
    //             .off('.DT')
    //             .on('input.DT', function () {
    //                 api.search(this.value).draw();
    //             });
    //     },
    //     oLanguage: {
    //         sProcessing: "loading..."
    //     },
    //     processing: true,
    //     serverSide: true,
    //     ajax: {"url": "<?php echo active_module_url() . 'list_user/get_userdsjson' ?>", "type": "POST"},
    //     columns: [
    //         {"data": "LOGINNAME"},
    //         {"data": "PASSWOD"},
    //         {"data": "NAMA"},
    //         {"data": "EMAIL"},
    //         {"data": "NIP"},
    //         {"data": "USER_GROUP"},
    //         {"data": "KD_KEC"},
    //         {"data": "KD_KEL"}
    //     ],
    //     order: [[1, 'asc']],
    //     rowCallback: function (row, data, iDisplayIndex) {
    //         var info = this.fnPagingInfo();
    //         var page = info.iPage;
    //         var length = info.iLength;
    //         $('td:eq(0)', row).html();
    //     }
    //
    // });
    // end setup datatables

    oTable = $('#mytable').dataTable({
      /* "sScrollY": "380px", */
      /* "iDisplayLength": 100, */
      "bScrollCollapse": true,
      "bJQueryUI": true,
      "bPaginate": true,
      "sPaginationType": "full_numbers",
      "sDom": '<"toolbar">frtip',
      "columnDefs": [{
        "defaultContent": "-",
        "targets": "_all"
      }],
      "aoColumnDefs": [{
          "bSearchable": false,
          "bVisible": false,
          "aTargets": [1]
        },
        {
          "bSearchable": false,
          "bVisible": false,
          "aTargets": [3]
        },
        {
          "bSearchable": false,
          "bVisible": false,
          "aTargets": [8]
        },
        {
          "bSearchable": false,
          "bVisible": false,
          "aTargets": [9]
        },
        {
          "bSearchable": false,
          "bVisible": false,
          "aTargets": [10]
        }
      ],
      "order": [
        [5, 'asc']
      ],
      "aoColumns": [
        null,
        { "sWidth": "5%", "sClass": "center", "bVisible": false },
        null,
        { "bVisible": false }, 
        null, null, null,
        { "sWidth": "110px", "sClass": "center" },
        { "bVisible": false },
        { "bVisible": false },
        { "bVisible": false },
      ],
      "fnRowCallback": function(nRow, aData, iDisplayIndex) {
        $(nRow).on("click", function(event) {
          if ($(this).hasClass('row_selected')) {
            /* mID = '';
            $(this).removeClass('row_selected'); */
          } else {
            var data = oTable.fnGetData(this);
            LOGINNAME = data[0];
            PASSWOD = data[1];
            NAMA = data[2];
            EMAIL = data[3];
            NIP = data[4];
            USER_GROUP = data[8];
            KD_KEC = data[9];
            KD_KEL = data[10];

            oTable.$('tr.row_selected').removeClass('row_selected');
            $(this).addClass('row_selected');
          }
        })
      },
      "language": {
        "paginate": {
          "first": "First page"
        },
        "searchPlaceholder": "Search here...",
        "search": "",
        "loadingRecords": "",
        "processing": "<img border='0' src='<?php echo base_url('assets/pad/img/ajax-loader-big-circle-ball.gif') ?>' />",
      },
      "bSort": true,
      "bInfo": true,
      "bProcessing": true,
      "bFilter": false,
      "bAutoWidth": false,
      "bServerSide": true,
      "sAjaxSource": "<?php echo active_module_url(); ?>list_user/get_userdsjson"
    });

    // $('USER_GROUP').on('change', function (e) {
    //     var optionSelected = $("option:selected", this);
    //     var valueSelected = this.value;
    //     alert(valueSelected);
    // });

    $('#btn_add_users').click(function() {

      $('#USER_GROUP').val('6');
      $('#LOGIN_NAME').val('');
      $('#NAMA').val('');
      $('#PASSWOD').val('');
      $('#EMAIL').val('');
      $('#NIP').val('');
      sel_kec.style.display = "none";
      sel_kel.style.display = "none";

      $('#myModalAdd').modal('show');

    });

    $('#btn_edit_users').click(function() {
      var sel_kec_e = document.getElementById("sel_kec_e");
      var sel_kel_e = document.getElementById("sel_kel_e");
      var kec_e = document.getElementById("KD_KEC_E");
      var kel_e = document.getElementById("KD_KEL_E");

      if (LOGINNAME) {

        // alert(NAMA);

        $('#USER_GROUP_E').val(USER_GROUP);
        $('#LOGIN_NAME_E').val(LOGINNAME);
        $('#NAMA_E').val(NAMA);
        $('#PASSWOD_E').val(PASSWOD);
        // $('#PASSWOD_E').val('');
        $('#EMAIL_E').val(EMAIL);
        $('#NIP_E').val(NIP);
        if (USER_GROUP == '8') {
          get_kelurahan_kecamatan_e(KD_KEC, KD_KEL);
          // get_kelurahan_e(KD_KEC);
          sel_kec_e.style.display = "block";
          sel_kel_e.style.display = "block";
          $('#KD_KEC_E').val(KD_KEC);
          // alert(KD_KEL);
          // $('#KD_KEL_E').val(KD_KEL).change();
          $("#KD_KEL_E option[value=" + KD_KEL + "]").attr('selected', 'selected');
          // $('#KD_KEL_E').change();
          // document.getElementById('KD_KEL_E').value=KD_KEL;

          kec_e.disabled = false;
          kel_e.disabled = false;
        } else if(USER_GROUP == '3'){
          sel_kec_e.style.display = "block";
          sel_kel_e.style.display = "none";
          kec_e.disabled = false;
          kel_e.disabled = true;
          $('#KD_KEC_E').val(KD_KEC);
        } else {
          sel_kec_e.style.display = "none";
          sel_kel_e.style.display = "none";

          kec_e.disabled = true;
          kel_e.disabled = true;
        }
        $('#myModalEdit').modal('show');

      } else {
        alert('Pilih user...');
        return false;
      }


    });

    $('#btn_delete_users').click(function() {

      if (LOGINNAME) {
        var hapus = confirm('Hapus data ini?');
        if (hapus == true) {
          window.location = '<?php echo active_module_url(); ?>list_user/hapus/' + LOGINNAME;
        };
      } else {
        alert('Pilih user...');
        return false;
      }

    });

    $("[id=btn_cari]").click(function() {
      reload_grid();
    });


  });
</script>