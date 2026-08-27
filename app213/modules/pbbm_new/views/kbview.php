<?= $this->load->view('layouts/headers'); ?>
<?= $this->load->view(active_module() . '/sidebar'); ?>

<style>
    .right {
        text-align: right;
    }
</style>

<div class="main-content">
  <div class="page-content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0">Kurang Bayar</h4>
            <div class="page-title-right" id="test">
              <ol class="breadcrumb m-0">
                <li class="breadcrumb-item">
                  <a href="javascript: void(0);">Realisasi</a>
                </li>
                <li class="breadcrumb-item active">Kurang Bayar</li>
              </ol>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <div class="d-flex align-items-center gap-2 mb-2">
                <div class="input-group w-auto">
                  <div class="input-group-prepend">
                    <span class="input-group-text rounded-end-0">Tahun SPPT</span>
                  </div>
                  <select class="form-control select" id="tahun" name="tahun" style="width:80px;">
                    <?php
                    $maxtahun = date('Y');
                    for ($i = $maxtahun; $i > $maxtahun - 10; $i--) {
                      $selected = '';
                      if ($i == $tahun) $selected = " selected";
                      echo "<option value=\"$i\" $selected>$i</option>\n";
                    }
                    ?>
                  </select>
                </div>
              </div>
              <div class="d-flex align-items-center gap-2 mb-2">
                <div class="input-group w-auto">
                  <div class="input-group-prepend">
                    <span class="input-group-text rounded-end-0">Kecamatan</span>
                  </div>
                  <select id="kec_kd" name="kec_kd" class="input form-control select2" style="width:250px;"><?php echo $kecamatans; ?></select>
                </div>
                <div class="input-group w-auto">
                  <div class="input-group-prepend">
                    <span class="input-group-text rounded-end-0">Kelurahan</span>
                  </div>
                  <select id="kel_kd" name="kel_kd" class="input form-control select2" style="width:250px;"><?php echo $kelurahans; ?></select>
                </div>
                <button id="btnprint" name="btnprint" class="btn btn-success waves-effect waves-light" type="button">Print Format</button>
              </div>
              <hr>
              <table id="table1" class="table table-striped table-nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead>
                  <tr>
                    <th rowspan="1">Kode</th>
                    <th rowspan="1">Uraian</th>
                    <th colspan="1">SPPT</th>
                    <th colspan="1">Pokok</th>
                    <th colspan="1">Realisasi</th>
                    <th colspan="1">Sisa</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="2">TOTAL</td>
                    <td><span id="sppt"></span></td>
                    <td><span id="pokok"></span></td>
                    <td><span id="denda"></span></td>
                    <td><span id="total"></span></td>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
  <?= $this->load->view('layouts/foot.php'); ?>
</div>
<?= $this->load->view('layouts/scripts.php'); ?>

<script>
  $(document).ready(function() {

    var oTable = $('#table1').dataTable({
      // "iDisplayLength": 100,
      // "sScrollY": "260px",
      // "bJQueryUI": true,
      // "bAutoWidth": true,
      "bScrollCollapse": false,
      "bLengthChange": false,
      "bPaginate": true,
      "bFilter": true,
      "sPaginationType": "full_numbers",
      "bSort": false,
      "bInfo": true,
      "bServerSide": false,
      "bProcessing": true,
      "sAjaxSource": "<?php echo $data_source ?>",
      "sDom": '<"toolbar">fTl<"clear">rtip',
      "aoColumns": [{
          sWidth: '110pt'
        },
        null,
        {
          sWidth: '20pt',
          sClass: "right"
        },
        {
          sWidth: '25pt',
          sClass: "right"
        },
        {
          sWidth: '25pt',
          sClass: "right"
        },
        {
          sWidth: '25pt',
          "sClass": "right"
        }
      ],
      "oTableTools": {
        "sSwfPath": "<?php echo base_url() ?>assets/datatables/extras/TableTools/media/swf/copy_csv_xls_pdf.swf"
      },
      "oLanguage": {
        "sProcessing": "<img border='0' src='<?php echo base_url('assets/img/ajax-loader-big-circle-ball.gif') ?>' />",
        "sLengthMenu": "Tampilkan _MENU_",
        // "sZeroRecords":  "Tidak ada data",
        "sInfo": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
        "sInfoEmpty": "Menampilkan 0 sampai 0 dari 0 entri",
        "sInfoFiltered": "(disaring dari _MAX_ entri keseluruhan)",
        "sInfoPostFix": "",
        "sSearch": "Cari : ",
        "sUrl": "",
        "oPaginate": {
          "sFirst": "&laquo;",
          "sPrevious": "&lsaquo;",
          "sNext": "&rsaquo;",
          "sLast": "&raquo;",
        }
      },
      "fnInitComplete": function(oSettings, json) {
        $('#sppt').html(json['sppt']);
        $('#pokok').html(json['pokok']);
        $('#denda').html(json['denda']);
        $('#total').html(json['total']);
        oTable.fnAdjustColumnSizing();
      },
    });

    $("#tglawal, #tglakhir").datepicker({
      dateFormat: 'dd-mm-yy',
      changeMonth: true,
      changeYear: true
    });

    $("#btngo").click(function() {
      var tahun = $("#tahun").val();
      var buku = $("#buku").val();
      var tglawal = $("#tglawal").val();
      var tglakhir = $("#tglakhir").val();
      var kec_kd = $("#kec_kd").val();
      var kel_kd = $("#kel_kd").val();
      window.location = "<?php echo active_module_url() . 'kb' ?>/?tahun=" + tahun + "&buku=" + buku + "&tglawal=" + tglawal + "&tglakhir=" + tglakhir + "&kec_kd=" + kec_kd + "&kel_kd=" + kel_kd;
    });


    $("#kec_kd, #kel_kd, #tahun, #buku").change(function() {
      var tahun = $("#tahun").val();
      var buku = $("#buku").val();
      var tglawal = $("#tglawal").val();
      var tglakhir = $("#tglakhir").val();
      var kec_kd = $("#kec_kd").val();

      var params = "?tahun=" + tahun + "&buku=" + buku + "&tglawal=" + tglawal + "&tglakhir=" + tglakhir + "&kec_kd=" + kec_kd;
      if ($(this).attr('id') == 'kel_kd')
        var params = params + "&kel_kd=" + $(this).val();

      window.location = "<?php echo active_module_url() . 'kb' ?>" + params;

    });
    $('#btnprint').click(function() {
      var tahun = $("#tahun").val();
      //var buku = $("#buku").val();
      //var tglawal = $("#tglawal").val();
      //var tglakhir = $("#tglakhir").val();
      var kec_kd = $("#kec_kd").val();
      var kel_kd = $("#kel_kd").val();
      // window.open("<?php echo active_module_url() . "real_rpt/kb" ?>?tahun="+tahun+"&kec_kd=" + kec_kd +"&kel_kd=" + kel_kd ,target="laporan");

      var winparams = 'location=1,status=1,scrollbars=1,resizable=no,width=' + screen.width + ',height=' + screen.height + ',menubar=no,toolbar=no,fullscreen=no';
      window.open("<?php echo active_module_url() . 'real_rpt/cetak/pdf/3' ?>/" + kec_kd + "/" + kel_kd + "/" + tahun, 'Laporan', winparams);
    });

  });
</script>

<?= $this->load->view('layouts/footer.php'); ?>