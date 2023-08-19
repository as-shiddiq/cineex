<?= $this->extend('MainView') ?>
<?= $this->section('stylesheet') ?>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<?php
$configWeb = configWeb();
?>
<!-- Hero -->
<section class="section section bg-soft pb-5 overflow-hidden z-2">
    <div class="container z-2">
        <div class="row justify-content-center text-center pt-6">
            <div class="col-lg-8 col-xl-8">
            	<img src="<?=$configWeb->config_web_logo_light_url?>" alt="Cineex" height="100px">
                <p class="lead px-md-6 mb-5">CodeIgniter Next & Extendable</p>
                <div class="d-flex flex-column flex-wrap flex-md-row justify-content-md-center mb-5">
                    <a href="https://github.com/as-shiddiq/cineex" target="_blank" class="btn btn-primary mb-3 mb-lg-0 mr-3"><i class="fas fa-cloud-download-alt mr-2"></i> Install</a>
                    <div class="mt-2">
                        <a class="github-button" href="https://github.com/as-shiddiq/cineex" data-color-scheme="no-preference: dark; light: light; dark: light;" data-icon="octicon-star" data-size="large" data-show-count="true" aria-label="Star as-shiddiq/cineex on GitHub">Star</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>

<?= $this->section('javascript') ?>


<?=$this->renderSection('javascript-part')?>

<?= $this->endSection() ?>