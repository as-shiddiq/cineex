<div class="row form-group mb-5">
	<label class="col-md-3">Nama Web</label>
	<div class="col-md-9 pristine-validate">
		<?= input_text('config_web_nama','', '', 'required') ?>
	</div>
</div>
<div class="row form-group mb-5">
	<label class="col-md-3">Deskripsi</label>
	<div class="col-md-9 pristine-validate">
		<?= textarea('config_web_deskripsi','', '', 'required') ?>
	</div>
</div>
<div class="row form-group mb-5">
	<label class="col-md-3">Alamat</label>
	<div class="col-md-9 pristine-validate">
		<?= textarea('config_web_alamat','', '', '') ?>
	</div>
</div>
<div class="row form-group mb-5">
	<label class="col-md-3">No. HP</label>
	<div class="col-md-9 pristine-validate">
		<?= input_text('config_web_hp','', '', '') ?>
	</div>
</div>
<div class="row form-group mb-5">
	<label class="col-md-3">Email</label>
	<div class="col-md-9 pristine-validate">
		<?= input_text('config_web_email','', '', '') ?>
	</div>
</div>