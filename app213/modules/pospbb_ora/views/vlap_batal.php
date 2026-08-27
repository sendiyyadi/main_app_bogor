<?php  $this->load->view('_head'); ?>
<?php  $this->load->view(active_module().'/_navbar'); ?>
<script>

$(function() {
    /*
    $( "#tgl_fr, #tgl_to" ).datepicker({
        dateFormat:'dd-mm-yy',
        changeMonth:true,
        changeYear:true
    });
    */
    var tgl_fr_dtp = $('#tgl_fr').datepicker({
        format: 'dd-mm-yyyy'
    }).on('changeDate', function(ev) {
        tgl_fr_dtp.hide();
    }).data('datepicker');

    var tgl_to_dtp = $('#tgl_to').datepicker({
        format: 'dd-mm-yyyy'
    }).on('changeDate', function(ev) {
        tgl_to_dtp.hide();
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
            <li class="active"><a data-toggle="tab" href="#transaksi"><strong>Laporan Pembatalan</strong></a></li>
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
                <span class="span2">Tanggal</span>
                <input class="input" type="text" style="width:70px;" id="tgl_fr" name="tgl_fr" value="<?php echo date('d-m-Y');?>"> s.d. 
                <input class="input" type="text" style="width:70px;" id="tgl_to" name="tgl_to" value="<?php echo date('d-m-Y');?>">
            </div>
            <div class="row">
                <span class="span2">User</span>
                <?php echo $select_tp_users;?>
            </div>
            <br>
            <div class="row">
                <span class="span2">&nbsp;</span>
                <button type="button" class="btn btn-success" id="btn_cetak" name="btn_cetak">Cetak (Draft)</button>
                <!--button type="button" class="btn btn-success" id="btn_cetak2" name="btn_cetak2">Cetak (PDF)</button-->
                <button type="button" class="btn btn-success" id="btn_csv" name="btn_csv">Download (CSV)</button>
            </div>
        </form>
    </div>
</div>
<?php  $this->load->view('_foot'); ?>