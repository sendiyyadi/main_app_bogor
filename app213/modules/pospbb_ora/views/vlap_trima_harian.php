<?php  $this->load->view('_head'); ?>
<?php  $this->load->view(active_module().'/_navbar'); ?>
<script>
$(function() {
    /*
    $( "#tgl" ).datepicker({
        dateFormat:'dd-mm-yy',
        changeMonth:true,
        changeYear:true
    });
    */
    var tgl_dtp = $('#tgl').datepicker({
        format: 'dd-mm-yyyy'
    }).on('changeDate', function(ev) {
        tgl_dtp.hide();
    }).data('datepicker');

});

$(document).ready(function() {

    $('#btn_cetak').click(function() {
        $.ajax({
            url: "<?php echo $faction;?>",
            type: "POST",
            data: $('#myform').serialize(),
            success: function (msg) {
                if(msg!='No Data') {
                    var rpt = window.open("", "Cetak");
                    if (!rpt)
                        alert('You have a popup blocker enabled. Please allow popups for this site.');
                    else
                        $(rpt.document.body).html(msg);
                } else alert(msg);
            }
        });
    });

    $('#btn_cetak2').click(function() {
        var data= $('#myform').serialize();
        window.open("<?php echo active_module_url('laporan/cetak_pdf')?>?"+ data, "Cetak PDF");
    });

    $('#btn_csv').click(function() {
        var url = '<?php echo active_module_url($this->uri->segment(2));?>csv_download';

        $('#myform').attr('action', url);
        $('#myform').submit();
        return false;
    });
});

</script>

<div class="content">
    <div class="container-fluid">
        <ul class="nav nav-tabs" id="myTab">
            <li class="active"><a data-toggle="tab" href="#transaksi"><strong>Laporan Harian</strong></a></li>
        </ul>

        <?php echo msg_block();?>

        <?php echo form_open($faction, array('id'=>'myform'));?>
            <div class="container-fluid">
                <?php
                if(validation_errors()){
                    echo '<blockquote><strong>Harap melengkapi data berikut :</strong>';
                    echo validation_errors('<small>','</small>');
                    echo '</blockquote>';
                } ?>
            </div>

            <div class="row">
                <span class="span2">Tanggal</span><input class="input-small" type="text" id="tgl" name="tgl" value="<?php echo date('d-m-Y');?>" required>
            </div>
            <div class="row">
                <span class="span2">Buku</span>
                <?php echo $select_buku;?>
            </div>

            <div class="row">
                <span class="span2">Urut</span>
                <?php echo $select_urut;?>
            </div>

            <div class="row">
                <span class="span2">Kelurahan</span>
                <?php echo $select_kelurahan;?>
            </div>

            <div class="row">
                <span class="span2">User Rekam</span>
                <?php echo $select_tp_users;?>
            </div>

            <div class="row">
                <span class="span2">&nbsp;</span>
                <button type="button" class="btn btn-success" id="btn_cetak" name="btn_cetak">Cetak (Draft)</button>
                <!--button type="button" class="btn btn-success" id="btn_cetak2" name="btn_cetak2">Cetak (PDF)</button-->
                <button type="button" class="btn btn-success" id="btn_csv" name="btn_csv">Download (CSV)</button>
            </div>
        </form>
    </div>
</div>
<?php $this->load->view('_foot'); ?>