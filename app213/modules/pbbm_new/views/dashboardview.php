<?php  $this->load->view('_head'); ?>

<?php  $this->load->view(active_module().'/_navbar'); ?>

<div id="modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
</div>
<div class="content">
<script>
$(document).ready(function(){
    $('.isotope-container').isotope({ filter: $('input[name=dashboardview]:checked').val() });
    $('input[name=dashboardview]').change(function(){
        var base = this;
        setTimeout(function(){
            $('.isotope-container').isotope({filter: $(base).val()});},500);
    });
});
</script>

<div class="grid_5 leading" style="height:270px;">
	<fieldset class="fieldset-buttons ui-corner-all" style="margin-left:0px;">
		<legend class="buttonset-legend">
			<span id="dashboardview-filter" class="buttonset">
				<input type="radio" name="dashboardview" id="dashboardview-jmltrans" value=".jml-trans" checked />
				  <label for="dashboardview-jmltrans"><?php echo $subtitle;?></label>
				<input type="radio" name="dashboardview" id="dashboardview-nomtrans" value=".nom-trans" />
				  <label for="dashboardview-nomtrans"><?php echo $subtitle2;?></label>
			</span>
		</legend>
		
		<ul class="isotope-widgets isotope-container">
			<li class="jml-trans">
				<a class="button-gray ui-corner-all" href="#">
					<strong><?php echo $today_trans;?></strong>
					<span><?php echo $today_cap;?></span>
				</a>
			</li>
			<li class="jml-trans">
				<a class="button-blue ui-corner-all" href="#">
					<strong><?php echo $week_trans;?></strong>
					<span><?php echo $week_cap;?></span>
				</a>
			</li>
			<li class="jml-trans">
				<a class="button-orange ui-corner-all" href="#">
					<strong><?php echo $month_trans;?></strong>
					<span><?php echo $month_cap;?></span>
				</a>
			</li>
			<li class="jml-trans">
				<a class="button-green ui-corner-all" href="#">
					<strong><?php echo $year_trans;?></strong>
					<span><?php echo $year_cap;?></span>
				</a>
			</li>
			
			<li class="nom-trans">
				<a class="button-gray ui-corner-all" href="#">
					<strong><?php echo $today_amount;?></strong>
					<span><?php echo $today_cap;?></span>
				</a>
			</li>
			<li class="nom-trans">
				<a class="button-blue ui-corner-all" href="#">
					<strong><?php echo $week_amount;?></strong>
					<span><?php echo $week_cap;?></span>
				</a>
			</li>
			<li class="nom-trans">
				<a class="button-orange ui-corner-all" href="#">
					<strong><?php echo $month_amount;?></strong>
					<span><?php echo $month_cap;?></span>
				</a>
			</li>
			<li class="nom-trans">
				<a class="button-green ui-corner-all" href="#">
					<strong><?php echo $year_amount;?></strong>
					<span><?php echo $year_cap;?></span>
				</a>
			</li>
		</ul>
	</fieldset>
 </div>
</div>
<?php $this->load->view('_foot'); ?>