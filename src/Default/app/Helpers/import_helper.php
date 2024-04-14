<?php 
function importForm($arHeader=[],$exampleFile='')
{
	ob_start();
	?>
	<style type="text/css">
		.container-show-progress{
			position: fixed;
			bottom: 15px;
			left: 15px;
			z-index: 1000;
		}
	</style>

	<!--begin::Modal - Create account-->
	<div class="modal fade" id="modal-import" tabindex="-1" aria-hidden="true">
		<!--begin::Modal dialog-->
		<div class="modal-dialog modal-dialog-centered">
			<!--begin::Modal content-->
			<div class="modal-content">
				<!--begin::Modal header-->
				<div class="modal-header">
					<h3>Import Data</h3>
					<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
						<span class="bi bi-x fs-2x"></span>
					</div>
				</div>
				<!--end::Modal header-->
				<!--begin::Modal body-->
				<div class="modal-body detail-data">
					<a href="<?=$exampleFile?>" target="_BLANK" class="btn btn-success mb-3"><i class="bi bi-file-earmark-excel"></i> Template XLSX</a>

					 <div class="dropzone bg-light-success border-success mb-5" id="uploadForm">
					    <div class="dz-message needsclick h-100px align-items-center">
					        <i class="ki-duotone ki-file-up fs-6x text-success"><span class="path1"></span><span class="path2"></span></i>
					        <div class="ms-4">
					            <h3 class="fs-3 fw-bold text-success mb-1">Drag and Drop File to Import.</h3>
					            <span class="fs-4 fw-semibold text-gray-600 d-block">Only support extensions *xlsx</span>
					        </div>
					    </div>
					</div>
					<div class="border border-success border-dashed rounded p-5 container-validation d-none">
						<p class="fs-1">
							Total Data : <strong class="total">0</strong> Rows
						</p>
						<h5>Header Validations</h5> 
						<ul class="list-header">
							<?php
							foreach ($arHeader as $v) {
								?>
								<li data-header="<?=$v?>"><?=$v?></li>
								<?php
							}
							?>
						</ul>

						<em>Resulf of validation header <strong class="passed-template text-success">0</strong> Passed, <strong class="error-template text-danger">0</strong> Error</em>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-success btn-import d-none ms-0 me-md-2 font-weight-bolder"><i class="bi bi-file-earmark-excel"></i> Import Data</button>
	    			<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				</div>
				<!--end::Modal body-->
			</div>
			<!--end::Modal content-->
		</div>
		<!--end::Modal dialog-->
	</div>


	<!--begin::Modal - Create account-->
	<div class="modal fade" id="modal-progress"  data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
		<!--begin::Modal dialog-->
		<div class="modal-dialog modal-dialog-centered">
			<!--begin::Modal content-->
			<div class="modal-content">
				<!--begin::Modal header-->
				<div class="modal-header border-0 pb-0">
					<h3>Importing data....</h3>
					<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal" onclick="hideModalProgress()">
						<span class="bi bi-dash fs-2x"></span>
					</div>
				</div>
				<!--end::Modal header-->
				<!--begin::Modal body-->
				<div class="modal-body detail-data">
					<div class="progress mb-5">
					  <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
					</div>
					<p class="mb-0">
						Sedang memproses <strong class="imported"></strong> dari <strong class="total"></strong> data 
					</p>
					<small class="text-muted">estimasi <span class="estimasi"><strong>0</strong> menit <strong>0</strong> detik</span></small>
				</div>
				<!--end::Modal body-->
			</div>
			<!--end::Modal content-->
		</div>
		<!--end::Modal dialog-->
	</div>


	<div class="container-show-progress d-flex align-items-center gap-2 bg-light p-5 rounded-3 shadow cursor-pointer d-none" onclick="showModalProgress()">
		<button class="btn btn-icon btn-primary rounded-circle"><i class="bi bi-terminal fs-2x"></i></button>
		<span class="ms-2">
			 <h4 class="mb-0">Progress</h4>
			<span class="progress-percent">0%</span>
		</span>
	</div>

	<?php
	return ob_get_clean();
}

function importFormJs($setUrl='')
{
	ob_start();
	?>
	<script src="/assets/js/countUp/countUp.umd.js" type="text/javascript"></script>
	<!-- <script src="https://unpkg.com/read-excel-file@5.x/bundle/read-excel-file.min.js"></script> -->
	<script src="/assets/js/read-excel-file/read-excel-file.min.js"></script>
	<script type="text/javascript">
	let elModalImport = document.getElementById('modal-import');
	let elModalProgress = document.getElementById('modal-progress');
		
	let modalImport = new bootstrap.Modal(elModalImport, {
	  keyboard: false
	});

	let modalProgress = new bootstrap.Modal(elModalProgress, {
	  keyboard: false
	});

	let resetCheckerHeader = () => {
		elBtnImport.classList.add('d-none');
		elContainerValidation.classList.add('d-none');
		for(x in listHeader)
		{
			let y = listHeader[x];
			elContainerValidation.querySelector(`.list-header li[data-header="${y}"]`).innerHTML = y;
		}

	}
	//import
	let importModal = (setId='') => {
		resetCheckerHeader();
		modalImport.show();
	}
	let elProgressImport = elModalProgress.querySelector('.progress .progress-bar');
	let elContainerShowProgress = document.querySelector('.container-show-progress');
	let elContainerValidation = elModalImport.querySelector('.container-validation');
	let elBtnImport = elModalImport.querySelector('.btn-import');
	let elListHeader = elContainerValidation.querySelectorAll('.list-header li');
	let listHeader  = [];
	let dataImport = [];
	for(el of elListHeader)
	{
		listHeader.push(el.innerText);
	}
	//dropzone
	let elDz = document.querySelector('#uploadForm');
	let dz = new Dropzone(elDz, { 
	    url: `#`,
	    acceptedFiles: '.xlsx',
	    autoProcessQueue : false
	});

	dz.on("addedfile", file => {
		// elContainerUpload.classList.add('d-none');
		elContainerValidation.classList.remove('d-none');
		resetCheckerHeader();
		let total = 0;
		let errorTemplate = 0;
		dataImport = [];
		readXlsxFile(file).then(function(rows) {
			elBtnImport.classList.add('d-none');
		 	for(i in rows)
		 	{
		 		let r = rows[i]
		 		if(i==0)
		 		{
		 			for(x in listHeader)
		 			{
		 				let y = listHeader[x];
	 					let el = elContainerValidation.querySelector(`.list-header li[data-header="${y}"]`);
		 				if(y===r[x])
		 				{
		 					el.innerHTML += '<i class="bi bi-check-lg text-success"></i>';
		 				}
		 				else
		 				{
		 					errorTemplate++;
		 					el.innerHTML += '<i class="bi bi-x-lg text-danger"></i>';
		 				}
		 			}
		 		}
		 		else
		 		{
				 	total++;
				 	dataImport.push(r);
		 		}
		 	}
		}).then((r)=>{
			if(errorTemplate==0)
			{
				elBtnImport.classList.remove('d-none');
				elContainerValidation.classList.remove('d-none');
			}
	  	dz.removeAllFiles();
			elContainerValidation.querySelector('.passed-template').innerHTML = (listHeader.length-errorTemplate).toString();
			elContainerValidation.querySelector('.error-template').innerHTML = (errorTemplate).toString();
			elContainerValidation.querySelector('.total').innerHTML = total;
			elModalProgress.querySelector('.total').innerHTML = total;
		});
	});

	let setProgress = (percent) => {
	  elProgressImport.style.width = percent + '%';
	  if (percent === 100) {
	    elProgressImport.classList.remove('bg-info');
	    elProgressImport.classList.remove('bg-warning');
	    elProgressImport.classList.remove('bg-danger');
	    elProgressImport.classList.add('bg-success');
	  } else if (percent >= 70) {
	    elProgressImport.classList.remove('bg-warning');
	    elProgressImport.classList.remove('bg-danger');
	    elProgressImport.classList.remove('bg-success');
	    elProgressImport.classList.add('bg-info');
	  } else if (percent >= 30) {
	    elProgressImport.classList.remove('bg-info');
	    elProgressImport.classList.remove('bg-success');
	    elProgressImport.classList.remove('bg-danger');
	    elProgressImport.classList.add('bg-warning');
	  } else {
	    elProgressImport.classList.remove('bg-success');
	    elProgressImport.classList.remove('bg-warning');
	    elProgressImport.classList.remove('bg-info');
	    elProgressImport.classList.add('bg-danger');
	  }
	}

	//coutup
	var numAnim = new countUp.CountUp(elModalProgress.querySelector('.imported'), 0,{
		duration:40
	});
	numAnim.start();


	let importingStatus = false;
	var postingTimes = [];
	let imported = 0;
	let totalData = 0;
	let totalPostingTime = 0;

	let hideModalProgress = () => {
		elContainerShowProgress.classList.remove('d-none');
	}
	let showModalProgress = () => {
		elContainerShowProgress.classList.add('d-none');
		if(importingStatus)
		{
			modalProgress.show();
		}
	}
	// Fungsi untuk menambahkan waktu mulai dan waktu selesai ke dalam totalPostingTime
	function addPostingTime(startTime, endTime) {
	  totalPostingTime += (endTime - startTime);
	}

	// Fungsi untuk menghitung waktu rata-rata posting
	function calculateAveragePostingTime() {
	  if (imported === 0) return 0;
	  return totalPostingTime / imported;
	}

	function estimateRemainingTime() {
	  var averagePostingTime = calculateAveragePostingTime();
	  var remainingDataCount = totalData - imported;
	  var remainingTimeMillis = remainingDataCount * averagePostingTime;

	  // Waktu sekarang
	  var currentTime = new Date();
	  // Menambahkan estimasi waktu yang tersisa ke dalam waktu sekarang
	  var estimatedEndTime = new Date(currentTime.getTime() + remainingTimeMillis);

	  // Mengonversi waktu dari milidetik menjadi menit dan detik
	  var remainingMinutes = Math.floor(remainingTimeMillis / 60000);
	  var remainingSeconds = ((remainingTimeMillis % 60000) / 1000).toFixed(0);

	  // Format jam selesai dalam format HH:MM:SS
	  var hours = estimatedEndTime.getHours().toString().padStart(2, '0');
	  var minutes = estimatedEndTime.getMinutes().toString().padStart(2, '0');
	  var seconds = estimatedEndTime.getSeconds().toString().padStart(2, '0');
	  var estimatedEndTimeString = hours + ':' + minutes;

	  return `<strong>${remainingMinutes}</strong> menit <strong>${remainingSeconds}</strong> detik (${estimatedEndTimeString})`;
	}

	let importingData = async () => {
	  elProgressImport.style.width = '0%';
	  elProgressImport.classList.remove('bg-info');
	  elProgressImport.classList.remove('bg-warning');
	  elProgressImport.classList.remove('bg-danger');
	  elProgressImport.classList.remove('bg-success');
		let chunkSize = 100;
		totalData = dataImport.length;
		importingStatus = true;
		modalProgress.show();
		for (var i = 0; i < dataImport.length; i += chunkSize) {
		 	startTime = new Date().getTime(); // Waktu mulai posting
			var chunk = dataImport.slice(i, i + chunkSize); 
		  imported += chunk.length;
			numAnim.update(imported);
			let post = await fetch(`${apiUrl}restful/importjson/<?=$setUrl?>`,{
	      method : 'post',
		    body: JSON.stringify(chunk),
		    headers: {
		      'Content-Type': 'application/json',
		    },
	    });		
	    let resp = await post.json();
	    let percent = imported/totalData*100;
			setProgress(percent);
			elContainerShowProgress.querySelector('.progress-percent').innerHTML = (percent.toFixed(1))+'%';

			endTime = new Date().getTime();
			addPostingTime(startTime, endTime); 
			elModalProgress.querySelector('.estimasi').innerHTML = estimateRemainingTime();
	    if(imported==dataImport.length)
	    {
	    	Swal.fire({
	    		icon : 'success', 
	    		title : 'Import data berhasil'
	    	});
				importingStatus = false;
				elContainerShowProgress.classList.add('d-none');
	    	modalProgress.hide();
	    	elBtnRefresh.click();
	    }
		}
	}


	elBtnImport.addEventListener('click',()=>{
		Swal.fire({
	      title: 'Apakah Anda yakin?',
	      html: `Melakukan import data`,
	      icon: 'warning',
	      showCancelButton: true,
	      confirmButtonColor: '#3085d6',
	      cancelButtonColor: '#d33',
	      confirmButtonText: 'Ya, lanjutkan!',
	      cancelButtonText: 'Batalkan'
	    }).then((result) => {
	      if (result.value) {
	      	modalImport.hide();
	      	importingData();
	      }
	  });
	})
	</script>
	<?php
	return ob_get_clean();
}