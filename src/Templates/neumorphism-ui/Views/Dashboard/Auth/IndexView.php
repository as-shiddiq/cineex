<?php
$configWeb = configWeb();
?>
<!DOCTYPE html>
<html lang="en">
	<!--begin::Head-->
	<head>
		<?php include includeView('main','head.php')?>
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body>
		<main>
        <!-- Section -->
        <section class="min-vh-100 d-flex bg-primary align-items-center">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-8 col-lg-6 justify-content-center">
                        <div class="card bg-primary shadow-soft border-light p-4">
                            <div class="card-header text-center pb-0">
	                        	<img src="<?=$configWeb->config_web_logo_light_url?>" width="150px">
                                <h2 class="h4">Sign in to our platform</h2>  
                            </div>
                            <div class="card-body">
                                <form action="#" id="form-data" class="mt-4">
                                    <!-- Form -->
                                    <div class="form-group pristine-validate">
                                        <label for="exampleInputIcon3">Username</label>
                                        <div class="input-group mb-4">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><span class="bi bi-person"></span></span>
                                            </div>
                                            <input class="form-control" name="username" id="exampleInputIcon3" placeholder="Type your username" type="text" aria-label="username">
                                        </div>
                                    </div>
                                    <!-- End of Form -->
                                    <div class="form-group">
                                        <!-- Form -->
                                        <div class="form-group pristine-validate">
                                            <label for="exampleInputPassword6">Password</label>
                                            <div class="input-group mb-4">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><span class="bi bi-key"></span></span>
                                                </div>
                                                <input class="form-control" name="password" id="exampleInputPassword6" placeholder="Password" type="password" aria-label="Password" required>
                                            </div>
                                        </div>
                                        <!-- End of Form -->
                                        <div class="d-block d-sm-flex justify-content-between align-items-center mb-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck5">
                                                <label class="form-check-label" for="defaultCheck5">
                                                  Remember me
                                                </label>
                                            </div>
                                            <div><a href="#" class="small text-right">Lost password?</a></div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-block btn-primary" form="form-data">Sign in</button>
                                </form>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
		<!--end::Root-->
		<!--begin::Javascript-->
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
		<script src="/assets/js/pristine/pristine.js" type="text/javascript"></script>

		<script src="/templates/<?=getenv('cineex.template.dashboard')?>/vendor/jquery/dist/jquery.min.js"></script>
		<script src="/templates/<?=getenv('cineex.template.dashboard')?>/vendor/popper.js/dist/umd/popper.min.js"></script>
		<script src="/templates/<?=getenv('cineex.template.dashboard')?>/vendor/bootstrap/dist/js/bootstrap.min.js"></script>
		<script src="/templates/<?=getenv('cineex.template.dashboard')?>/vendor/headroom.js/dist/headroom.min.js"></script>

		<!-- Vendor JS -->
		<script src="/templates/<?=getenv('cineex.template.dashboard')?>/vendor/onscreen/dist/on-screen.umd.min.js"></script>
		<script src="/templates/<?=getenv('cineex.template.dashboard')?>/vendor/nouislider/distribute/nouislider.min.js"></script>
		<script src="/templates/<?=getenv('cineex.template.dashboard')?>/vendor/waypoints/lib/jquery.waypoints.min.js"></script>
		<script src="/templates/<?=getenv('cineex.template.dashboard')?>/vendor/jarallax/dist/jarallax.min.js"></script>
		<script src="/templates/<?=getenv('cineex.template.dashboard')?>/vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js"></script>

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