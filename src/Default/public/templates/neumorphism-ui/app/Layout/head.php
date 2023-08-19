<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- Primary Meta Tags -->
<title><?=$title??'Dashboard'?></title>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="title" content="<?=$title??'Dashboard'?>">
<meta name="author" content="as-shiddiq">
<link rel="canonical" href="<?=site_url()?>" />
<!--  Social tags -->
<meta name="keywords" content="<?=$configWeb->config_web_meta_keyword?>">
<meta name="description" content="<?=$configWeb->config_web_meta_description?>.">

<!-- Favicon -->
<link rel="shortcut icon" href="<?=$configWeb->config_web_icon_light_url?>" />
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="theme-color" content="#ffffff">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<!-- Pixel CSS -->
<link type="text/css" href="/templates/<?=getenv('cineex.template.dashboard')?>/css/neumorphism.css" rel="stylesheet">
<style type="text/css">
	.is-invalid .form-control {
	    border-color: #F64E60;
	    padding-right: calc(1.5em + 1.3rem);
	    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' stroke='%23F64E60' viewBox='0 0 12 12'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23F64E60' stroke='none'/%3e%3c/svg%3e") !important;
	    background-repeat: no-repeat;
	    background-position: right calc(0.375em + 0.325rem) center;
	    background-size: calc(0.75em + 0.65rem) calc(0.75em + 0.65rem);
	}
	.is-valid .form-control {
	    border-color: #1BC5BD;
	    padding-right: calc(1.5em + 1.3rem);
	    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8' viewBox='0 0 8 8'%3e%3cpath fill='%231BC5BD' d='M2.3 6.73L.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e");
	    background-repeat: no-repeat;
	    background-position: right calc(0.375em + 0.325rem) center;
	    background-size: calc(0.75em + 0.65rem) calc(0.75em + 0.65rem);
	}
	.table thead tr th{
		vertical-align: middle;
		color: #777;
		font-weight: bold;
		text-transform: uppercase;
		font-size: .6rem;
	}
    .invalid-feedback{
        display: block !important;
    }
    .navbar-nav .dropdown .nav-link> .bi-chevron-down::before{
    	transition: .5s;
    }
    .navbar-nav > .dropdown:hover > .nav-link .bi-chevron-down::before{
	    transform: rotate(180deg);
    	transition: .5s;
    }
    .gap{
    	gap: 10px;
    }
    .me-3{
    	margin-right: 1rem;
    }
    .me-md-2, .mx-md-2{
    	margin-right: .5rem;
    }
    .form-check .form-check-label::after{
    	font-family: bootstrap-icons !important;
    	content: "\f633";
    }
    .form-check.square-check .form-check-label::before,
    .form-check input[type="checkbox"]:checked + .form-check-label::after{
    	margin-top: -10px;
    }
    .d-none{
    	display: none !important;
    }
    .navbar .navbar-nav .dropdown-submenu.show .dropdown-menu {
	    display: block;
	    opacity: 1;
	    pointer-events: all;
	}
    @media(min-width:900px)
    {

	    .d-md-block{
	    	display: block !important;
	    }	
    }
</style>
<!-- NOTICE: You can use the _analytics.html partial to include production code specific code & trackers -->
