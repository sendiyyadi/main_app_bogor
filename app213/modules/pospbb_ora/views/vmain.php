<?= $this->load->view('layouts/headers'); ?>
<?= $this->load->view(active_module() . '/layouts/sidebar'); ?>

<div class="main-content">
	<div class="page-content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12">
					<div class="page-title-box d-flex align-items-center justify-content-between">
						<h4 class="mb-0">Dashboard</h4>
						<div class="page-title-right">
							<ol class="breadcrumb m-0">
								<li class="breadcrumb-item">
									<a href="javascript: void(0);">POSPBB Bogor</a>
								</li>
								<li class="breadcrumb-item active">Dashboard</li>
							</ol>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-12">
			<div class="text-center">
				<h3>PEMERINTAH <?= LICENSE_TO ?></h3>
				<h5><?= LICENSE_TO_SUB ?></h5>
				<img src="<?= app_img_logo('assets/img/img_logo.png'); ?>" alt="logo" style="max-height:150px;">
				<h3>Halaman POSPBB</h3>
				<h5>bagian dari module Aplikai PBB BPHTB P2 untuk memproses pembayaran PBB</h5>
				<p>library <a href="<?= active_module_url('download_client/unduh_web2dm'); ?>" target="_blank">WEB to Dot Matrix PRN File watacher</a></p>
			</div>
		</div>
	</div>

	<?= $this->load->view('layouts/foot'); ?>
</div>

<?= $this->load->view('layouts/scripts'); ?>
<?= $this->load->view('layouts/footer'); ?>