<!--end::Dropzone-->
<div class="row form-group mb-5">
	<label class="col-md-3">Description</label>
	<div class="col-md-9 pristine-validate">
		<?= textarea('config_web_meta_description','', '', 'required') ?>
	</div>
</div>
<div class="row form-group mb-5">
	<label class="col-md-3">Keywords</label>
	<div class="col-md-9 pristine-validate">
		<?= textarea('config_web_meta_keyword','', '', 'required') ?>
	</div>
</div>
<div class="row form-group mb-5">
	<label class="col-md-3">Top Script</label>
	<div class="col-md-9 pristine-validate">
		<?= textarea('config_web_script_top','', '', '') ?>
	</div>
</div>
<div class="row form-group mb-5">
	<label class="col-md-3">Bottom Script</label>
	<div class="col-md-9 pristine-validate">
		<?= textarea('config_web_script_bottom','', '', '') ?>
	</div>
</div>