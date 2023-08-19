<?php
$configWeb = configWeb();
?>
<!DOCTYPE html>
<html lang="en">
	<!--begin::Head-->
	<head>
		<?php include includeView('dashboard','head.php')?>
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="app-blank app-blank">
		<!--begin::Root-->
		<div class="d-flex flex-column flex-root" id="kt_app_root">
			<!--begin::Authentication - Sign-in -->
			<div class="d-flex flex-column flex-lg-row flex-column-fluid">
				<!--begin::Body-->
				<div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10 order-2 order-lg-1">
					<!--begin::Form-->
					<div class="d-flex flex-center flex-column flex-lg-row-fluid">
						<!--begin::Wrapper-->
						<div class="w-md-500px w-100 p-10">
							<!--begin::Form-->
								<form class="form w-100" novalidate="novalidate"  id="form-data" action="#">
								<div class="text-center mb-11">
									<!--begin::Title-->
									<h1 class="text-dark fw-bolder mb-3">Sign In</h1>
									<!--end::Title-->
									<!--begin::Subtitle-->
									<div class="text-gray-500 fw-semibold fs-6">Gunakan akun yang terdaftar</div>
									<!--end::Subtitle=-->
								</div>
								<!--begin::Heading-->
								<!-- <div class="separator separator-content my-14">
									<span class="w-125px text-gray-500 fw-semibold fs-7">Or with email</span>
								</div> -->
								<!--begin::Heading-->
								<!--begin::Input group-->
								<div class="fv-row mb-10 pristine-validate">
									<!--begin::Label-->
									<label class="form-label fs-6 fw-bolder text-dark">Username</label>
									<!--end::Label-->
									<!--begin::Input-->
									<input class="form-control form-control-lg " required type="text" name="username" autocomplete="off" />
									<!--end::Input-->
								</div>
								<!--end::Input group-->
								<!--begin::Input group-->
								<div class="fv-row mb-10 pristine-validate">
									<!--begin::Wrapper-->
									<div class="d-flex flex-stack mb-2">
										<!--begin::Label-->
										<label class="form-label fw-bolder text-dark fs-6 mb-0">Password</label>
										<!--end::Label-->
										<!--begin::Link-->
										<!-- <a href="/auth/forgot" class="link-primary fs-6 fw-bolder" tabindex="-1">Lupa Password ?</a> -->
										<!--end::Link-->
									</div>
									<!--end::Wrapper-->
									<!--begin::Input-->
									<div class="position-relative mb-3">
										<input class="form-control form-control-lg " type="password" placeholder="" id="pwd" required name="password" autocomplete="off" />
										<span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility" onclick="showPw(this,'password')">
											<i class="bi bi-eye-slash fs-2"></i>
											<i class="bi bi-eye fs-2 d-none"></i>
										</span>
									</div>
									<!--end::Input-->
								</div>
								<!--end::Input group-->
								<!--begin::Actions-->
								<div class="text-center">
									<!--begin::Submit button-->
									<button type="submit" id="kt_sign_in_submit" class="btn btn-lg btn-info mb-5 w-100">
										<span class="indicator-label">Masuk</span>
									</button>
								</div>
								<!--end::Submit button-->
								<!--begin::Sign up-->
							<!-- 	<div class="text-gray-500 text-center fw-semibold fs-6">Not a Member yet? 
								<a href="/metronic8/demo26/../demo26/authentication/layouts/corporate/sign-up.html" class="link-primary">Sign up</a></div> -->
								<!--end::Sign up-->
							</form>
							<!--end::Form-->
						</div>
						<!--end::Wrapper-->
					</div>
					<!--end::Form-->
					<!--begin::Footer-->
					<div class="d-flex flex-center flex-wrap px-5">
						<!--begin::Links-->
						<div class="d-flex fw-semibold text-danger fs-base">
							<a href="/" class="px-5 text-danger" target="_blank">Beranda</a>
							<a href="/artikel" class="px-5 text-danger" target="_blank">Artikel</a>
							<a href="/kontak" class="px-5 text-danger" target="_blank">Kontak</a>
						</div>
						<!--end::Links-->
					</div>
					<!--end::Footer-->
				</div>
				<!--end::Body-->
				<!--begin::Aside-->
				<div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center order-1 order-lg-2" style="background:#539">
					<!--begin::Content-->
					<div class="d-flex flex-column flex-center py-7 py-lg-15 px-5 px-md-15 w-100">
						<!--begin::Logo-->
						<!--end::Logo-->
						<!--begin::Image-->
						<img class="d-none d-lg-block mx-auto w-275px w-md-50 w-xl-500px mb-10 mb-lg-20" src="/templates/<?=getenv('app.template.dashboard')?>/assets/media/misc/auth-screens.png" alt="" />
						<!--end::Image-->
						<!--begin::Title-->
						<h1 class="d-none d-lg-block text-white fs-2qx fw-bolder text-center mb-7"><?=$configWeb->config_web_nama?></h1>
						<!--end::Title-->
						<!--begin::Text-->
						<div class="d-none d-lg-block text-white fs-base text-center"><?=$configWeb->config_web_deskripsi?></div>
						<!--end::Text-->
					</div>
					<!--end::Content-->
				</div>
				<!--end::Aside-->
			</div>
			<!--end::Authentication - Sign-in-->
		</div>
		<!--end::Root-->
		<!--begin::Javascript-->
		<script>var hostUrl = "/metronic8/demo26/assets/";</script>
		<!--begin::Global Javascript Bundle(mandatory for all pages)-->
		<script src="/templates/<?=getenv('app.template.dashboard')?>/assets/plugins/global/plugins.bundle.js"></script>
		<script src="/templates/<?=getenv('app.template.dashboard')?>/assets/js/scripts.bundle.js"></script>
		<script src="/assets/js/pristine/pristine.js" type="text/javascript"></script>
		<!--end::Root-->
		<!--end::Main-->
		<!--end::Page Custom Javascript-->
		<!--end::Javascript-->
		<script type="text/javascript">
			let elFormData = document.querySelector('#form-data');

			var langPristine = {
			    required: "Bidang isian tidak boleh kosong",
			    email: "Alamat Surel tidak benar",
			    number: "Bidang isian hanya berupa nomor/angka",
			    integer: "Bidang isian hanya boleh diisi dengan angka",
			    url: "This field requires a valid website URL",
			    tel: "This field requires a valid telephone number",
			    maxlength: "Bidang isian harus diisi maksimal ${1} karakter",
			    minlength: "Bidang isian harus diisi minimal ${1} karakter",
			    min: "Minimum value for this field is ${1}",
			    max: "Maximum value for this field is ${1}",
			    pattern: "Please match the requested format",
			    equals: "The two fields do not match"
			};

			Pristine.addMessages('id', langPristine);
			Pristine.setLocale('id');
			let pristineConfig = {
			    // class of the parent element where the error/success class is added
			    classTo: 'pristine-validate',
			    errorClass: 'is-invalid',
			    successClass: 'is-valid',
			    // class of the parent element where error text element is appended
			    errorTextParent: 'pristine-validate',
			    // type of element to create for the error text
			    errorTextTag: 'div',
			    // class of the error text element
			    errorTextClass: 'invalid-feedback'
			};
		    let pristine;
			pristine = new Pristine(elFormData,pristineConfig);  

		    elFormData.addEventListener('submit', async function (e) {
		        let valid = pristine.validate();
		        e.preventDefault();
		        if(valid)
		        {
		        	let post = await fetch(`/api/auth/login`,{
		        		method : 'POST',
		        		body:`username=${document.querySelector('[name=username]').value}&password=${document.querySelector('[name=password]').value}`,
		        		headers: {
							"Content-Type":"application/x-www-form-urlencoded",
						    "X-Requested-With": "XMLHttpRequest"
						}
		        	});
		        	
	        		let resp = await post.json();
	        		if(resp.status==200)
	        		{
		        		Swal.fire({
		        			title : 'Sukses',
		        			icon : 'success',
		        			html : resp.message
		        		}).then(()=>{
		        			window.location = resp.redirect;
		        		});
	        		}
	        		else
	        		{
		        		Swal.fire({
		        			title : 'Error',
		        			icon : 'error',
		        			html : resp.message
		        		});
	        		}
		        	
		        }
		    });
		</script>
	</body>
	<!--end::Body-->
</html>