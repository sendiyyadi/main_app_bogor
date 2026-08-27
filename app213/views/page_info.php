<?php $this->load->view('_head'); ?>
<?php $this->load->view(active_module().'/_navbar'); ?>

<div class="container-fluid">
	<div class="page-header" style="margin-bottom:8px;">
		<strong>:: Info</strong>	
	</div>
</div>

<div class="container-fluid">
	<?php echo msg_block();?>
</div>	
<div class="container-fluid">
	<a href="<?php echo base_url();?>">Kembali ke Awal</a>
</div>	

<?php $this->load->view('_foot'); ?>