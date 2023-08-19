<?= $this->extend('DashboardView') ?>
<?= $this->section('stylesheet') ?>
<style type="text/css">
.widget-card {
	position: relative;
	overflow: hidden;
}
.widget-card .bi{
	position: absolute;
	top: -10;
	bottom: 0;
	right: 10px;
	margin: auto;
	font-size: 10rem;
	color: #fff4;
	z-index: 0;
}
.widget-card .widget-total
{
	font-size: 6rem;
	z-index: 2;
}
.widget-card .widget-text
{
	font-weight: bold;
	z-index: 2;
}
</style>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="container-xxl" id="kt_content_container">
<div class="card" style="margin-top: -10px;">
<div class="card-body">
	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-4 mb-5">
					<?=view('Dashboard/Pengguna/widgets/card-profil')?>
				</div>
				<div class="col-md-8 mb-5">
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="row mb-5">
				<div class="col-md-6 mb-md-0 mb-5">
				</div>
				<div class="col-md-6">
				</div>
			</div>
			<div class="row mb-5">
				<div class="col-md-6 mb-md-0 mb-5">
				</div>
				<div class="col-md-6">
				</div>
			</div>
		</div>
		<div class="col-md-8">
			<div class="row mb-5">
				<div class="col-md-6 mb-5">
				</div>
				<div class="col-md-6 mb-5">
				</div>
			</div>
		</div>
	</div>
	</div>
</div>
</div>

<?= $this->endSection() ?>

<?= $this->section('javascript') ?>


<?=$this->renderSection('javascript-part')?>

<?= $this->endSection() ?>