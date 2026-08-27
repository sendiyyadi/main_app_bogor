<?php $this->load->view('_head'); ?>
<?php //$this->load->view('_navbar'); ?>

<style>
.form-horizontal .control-group {
    margin-bottom: 10px;
}
legend .control-group {
    margin-top: 20px;
}
.form-horizontal .controls {
    margin-left: 180px;
}
label {
    display: block;
    margin-bottom: 5px;
}
label, input, button, select, textarea {
    font-size: 14px;
    font-weight: normal;
    line-height: 20px;
}
label, select, button, input[type="button"], input[type="reset"], input[type="submit"], input[type="radio"], input[type="checkbox"] {
    cursor: pointer;
}
.form-horizontal .control-label {
    text-align: right;
}
.form-horizontal .control-label {
    float: left;
    width: 160px;
    padding-top: 5px;
    text-align: right;
}
legend {
    display: block;
    width: 100%;
    padding: 0px;
    margin-bottom: 20px;
    font-size: 21px;
    line-height: 40px;
    color: rgb(51, 51, 51);
    border-width: 0px 0px 1px;
    border-style: none none solid;
    border-color: -moz-use-text-color -moz-use-text-color rgb(229, 229, 229);
    -moz-border-top-colors: none;
    -moz-border-right-colors: none;
    -moz-border-bottom-colors: none;
    -moz-border-left-colors: none;
    border-image: none;
}
</style>

<div class="content">
	<div class="container-fluid">
		<?php echo form_open('login', array('id'=>'frmlogin', 'class'=>'form-horizontal'));?>
			<fieldset>
				<?php echo msg_block();?>
				<legend>Login Page</legend>
				<div class="control-group">
					<label class="control-label" for="userid">User ID</label>
					<div class="controls"> 
						<div class="input-prepend">
							<span class="add-on"><i class="icon-user"></i></span>
							<input type="text" name="userid" placeholder="User ID" autocomplete="off" />
						</div>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="passwd">Password</label>
					<div class="controls">
						<div class="input-prepend">
							<span class="add-on"><i class="icon-lock"></i></span>
							<input type="password" name="passwd" placeholder="Password" autocomplete="off" />
						</div>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<!--label class="checkbox">
							<input type="checkbox"> Remember me
						</label-->
						<button type="submit" class="btn btn-primary">Sign in</button>
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>

<?php $this->session->sess_destroy();?>
<?php $this->load->view('_foot'); ?>
