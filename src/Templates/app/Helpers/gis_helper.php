<?php

function modalGisStyle($target='')
{
ob_start();   
?>
<link href="/templates/<?=getenv('app.template.dashboard')?>/assets/plugins/custom/prismjs/prismjs.bundle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="https://bmsvieira.github.io/BVSelect-VanillaJS/css/bvselect.css">
<style type="text/css">
	code[class*=language-], pre[class*=language-]{
		font-size: .9rem !important;
   	 	line-height: 1rem;
		border-radius: .5rem;
	}
	.highlight-code pre{
		height: 500px;
		overflow-y: auto;
	}
	.bv_mainselect{
		padding: 0;
	}
	.bv_atual,.bv_ul_inner{
    border: 1px solid var(--bs-gray-300);
	}
	.nofocus{
		border-bottom: 1px solid var(--bs-gray-300);
	}
</style>
<!--begin::Modal - Create account-->
<div class="modal fade" id="modal-gis-style" tabindex="-1" aria-hidden="true">
	<!--begin::Modal dialog-->
	<div class="modal-dialog modal-xl">
		<!--begin::Modal content-->
		<div class="modal-content">
			<!--begin::Modal header-->
			<div class="modal-header">
				<h3>Style Config</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<!--end::Modal header-->
			<!--begin::Modal body-->
			<div class="modal-body detail-data">
				<div class="row">
					<div class="col-md-8">
						<ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
						    <li class="nav-item">
						        <a class="nav-link active" data-bs-toggle="tab" href="#tab-path">Path</a>
						    </li>
						    <li class="nav-item">
						        <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_3">Marker</a>
						    </li>
						</ul>

						<div class="tab-content" id="myTabContent">
						    <div class="tab-pane fade show active" id="tab-path" role="tabpanel">
						    	<div class="row">
						    		<div class="col-md-11">
											<div class="alert alert-info d-flex align-items-center p-5 mb-5" >
												<span class="svg-icon svg-icon-2hx svg-icon-info me-4">
													<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
														<path opacity="0.3" d="M20.5543 4.37824L12.1798 2.02473C12.0626 1.99176 11.9376 1.99176 11.8203 2.02473L3.44572 4.37824C3.18118 4.45258 3 4.6807 3 4.93945V13.569C3 14.6914 3.48509 15.8404 4.4417 16.984C5.17231 17.8575 6.18314 18.7345 7.446 19.5909C9.56752 21.0295 11.6566 21.912 11.7445 21.9488C11.8258 21.9829 11.9129 22 12.0001 22C12.0872 22 12.1744 21.983 12.2557 21.9488C12.3435 21.912 14.4326 21.0295 16.5541 19.5909C17.8169 18.7345 18.8277 17.8575 19.5584 16.984C20.515 15.8404 21 14.6914 21 13.569V4.93945C21 4.6807 20.8189 4.45258 20.5543 4.37824Z" fill="currentColor"></path>
														<path d="M10.5606 11.3042L9.57283 10.3018C9.28174 10.0065 8.80522 10.0065 8.51412 10.3018C8.22897 10.5912 8.22897 11.0559 8.51412 11.3452L10.4182 13.2773C10.8099 13.6747 11.451 13.6747 11.8427 13.2773L15.4859 9.58051C15.771 9.29117 15.771 8.82648 15.4859 8.53714C15.1948 8.24176 14.7183 8.24176 14.4272 8.53714L11.7002 11.3042C11.3869 11.6221 10.874 11.6221 10.5606 11.3042Z" fill="currentColor"></path>
													</svg>
												</span>
												<div class="d-flex flex-column">
													<h4 class="mb-1 text-info">Perhatian</h4>
													<span>Untuk dokumentasi penggunaan style Path bisa dilihat di <a href="https://leafletjs.com/reference.html#path" target="_blank">Di sini</a></span>
												</div>
											</div>
						    		</div>
						    		<div class="col-md-1"></div>
						    	</div>
					    		<div id="config-path" class="container-config" data-config="path"></div>
						    </div>
						    <div class="tab-pane fade" id="kt_tab_pane_3" role="tabpanel">
						    	<div class="row">
						    		<div class="col-md-11">
											<div class="alert alert-info d-flex align-items-center p-5 mb-5" >
												<span class="svg-icon svg-icon-2hx svg-icon-info me-4">
													<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
														<path opacity="0.3" d="M20.5543 4.37824L12.1798 2.02473C12.0626 1.99176 11.9376 1.99176 11.8203 2.02473L3.44572 4.37824C3.18118 4.45258 3 4.6807 3 4.93945V13.569C3 14.6914 3.48509 15.8404 4.4417 16.984C5.17231 17.8575 6.18314 18.7345 7.446 19.5909C9.56752 21.0295 11.6566 21.912 11.7445 21.9488C11.8258 21.9829 11.9129 22 12.0001 22C12.0872 22 12.1744 21.983 12.2557 21.9488C12.3435 21.912 14.4326 21.0295 16.5541 19.5909C17.8169 18.7345 18.8277 17.8575 19.5584 16.984C20.515 15.8404 21 14.6914 21 13.569V4.93945C21 4.6807 20.8189 4.45258 20.5543 4.37824Z" fill="currentColor"></path>
														<path d="M10.5606 11.3042L9.57283 10.3018C9.28174 10.0065 8.80522 10.0065 8.51412 10.3018C8.22897 10.5912 8.22897 11.0559 8.51412 11.3452L10.4182 13.2773C10.8099 13.6747 11.451 13.6747 11.8427 13.2773L15.4859 9.58051C15.771 9.29117 15.771 8.82648 15.4859 8.53714C15.1948 8.24176 14.7183 8.24176 14.4272 8.53714L11.7002 11.3042C11.3869 11.6221 10.874 11.6221 10.5606 11.3042Z" fill="currentColor"></path>
													</svg>
												</span>
												<div class="d-flex flex-column">
													<h4 class="mb-1 text-info">Perhatian</h4>
													<span>Silakan sesuaikan bentuk marker yang diinginkan</span>
												</div>
											</div>
											</div>
										</div>
						    	<div id="config-icon" class="container-config" data-config="icon"></div>
						    </div>
						</div>
					</div>
					<div class="col-md-4">
						<p class="fw-normal text-muted">Generated Style</p>
						<span class="separator mb-4"></span>
				      	<div class="highlight-code">
							<pre class="language-json mt-0" >
								<code class="language-json append-config"></code>
							</pre>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
    			<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
			</div>
			<!--end::Modal body-->
		</div>
		<!--end::Modal content-->
	</div>
	<!--end::Modal dialog-->
</div>

<script src="/templates/<?=getenv('app.template.dashboard')?>/assets/plugins/custom/prismjs/prismjs.bundle.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.8.4/components/prism-json.min.js"></script>
<script src="https://bmsvieira.github.io/BVSelect-VanillaJS/js/bvselect.js" type="text/javascript"></script>
<!--end::Modal - Create project-->
<script type="text/javascript">
	
let elModalGisStyle = document.querySelector('#modal-gis-style');
//default value
// multipolygon 
let pathConfig = {
    stroke: ['true','input_select',{
    	'step':1,
    	'max':10,
    	'min':0,
    },{'true':'true','false':'false'}],
    color: ["#999",'input_color'],
    weight: [3,'input_number',{
    	'step':1,
    	'max':10,
    	'min':0,
    }],
    opacity: [1,'input_number',{
    	'step':0.1,
    	'max':1,
    	'min':0,
    }],
    dashArray: ['null','input_number',{
    	'step':1,
    	'max':10,
    	'min':0,
    }],
    dashOffset: ['null','input_number',{
    	'step':1,
    	'max':10,
    	'min':0,
    }],
    fill: ['true','input_select',{
    	'step':1,
    	'max':10,
    	'min':0,
    },{'true':'true','false':'false'}],
    fillColor: ["#B0DE5C",'input_color'],
    fillOpacity: [0.2,'input_number',{
    	'step':0.1,
    	'max':1,
    	'min':0,
    }],
    className: ['defaultClass','input_text'],
}
//icon
let iconConfig = {
	icon: ['','input_select',{

	},{'':''}],
	// markerColor: ['#000099','input_select',{

	// },{
	// 	'red':'Red',
	// 	'darkred':'Darkred',
	// 	'orange':'Orange',
	// 	'green':'Green',
	// 	'darkgreen':'Dark Green',
	// 	'blue':'Blue',
	// 	'darkblue':'Dark Blue',
	// 	'cadetblue':'Cadet Blue',
	// 	'purple':'Purple',
	// }],
	markerColor: ['#000099','input_select',{

		},{
			'red':'Red',
			'darkred':'Darkred',
			'orange':'Orange',
			'green':'Green',
			'darkgreen':'Dark Green',
			'blue':'Blue',
			'darkblue':'Dark Blue',
			'cadetblue':'Cadet Blue',
			'purple':'Purple',
		}],
	iconColor: ['#000099','input_color'],
}


let generateForm = (config,setValue) =>
{
	let html = '';
	for(i in config)
	{
		let value = config[i][0];

		let attribute = '';
		if (typeof config[i][2] !== 'undefined') {
			let getAttributes = config[i][2];
			for(j in getAttributes)
			{
				attribute += ` ${j}="${getAttributes[j]}"`;
			}
		}


		if(config[i][1]=='input_number')
		{
			if(Array.isArray(value))
			{
				html += `<div class="row form-group mb-3">
							<label class="col-md-2 d-flex align-items-center">
								<div class="form-check form-check-sm form-check-custom form-check-solid me-2">
									<input class="form-check-input checked-style" for="${i}" type="checkbox"/>
								</div>${i}
							</label>`;
				for(k in value)
				{

						html +=	`<div class="col-md-4 pristine-validate">
									<input type="number" class="form-control ${i}" name="${i}" value="${value[k]}" ${attribute}>
								</div>`;
				}
				html += `<div class="col-md-1"></div></div>`;
			}
			else
			{
				html += `<div class="row form-group mb-3">
							<label class="col-md-2 d-flex align-items-center">
								<div class="form-check form-check-sm form-check-custom form-check-solid me-2">
									<input class="form-check-input checked-style" for="${i}" type="checkbox"/>
								</div>${i}
							</label>
							<div class="col-md-8 pristine-validate">
								<input type="number" class="form-control ${i}" name="${i}" value="${value}" ${attribute}>
							</div>
							<div class="col-md-1"></div>
						</div>
						`;

			}

		}
		else if(config[i][1]=='input_select')
		{
			let select = '';
			for(x in config[i][3])
			{
				let selected = '';
				if(config[i][3][x]==value)
				{
					selected = 'selected';
				}
				select += `<option value="${x}" ${selected}>${config[i][3][x]}</option>`;
			}
			html += `<div class="row form-group mb-3">
							<label class="col-md-2 d-flex align-items-center">
								<div class="form-check form-check-sm form-check-custom form-check-solid me-2">
									<input class="form-check-input checked-style" for="${i}" type="checkbox"/>
								</div>${i}
							</label>
							<div class="col-md-8 pristine-validate">
								<select class="form-control ${i}" name="${i}" >
									${select}
								</select>
							</div>
						<div class="col-md-1"></div>
						</div>`;

		}
		else if(config[i][1]=='input_color')
		{
			html += `<div class="row form-group mb-3">
							<label class="col-md-2 d-flex align-items-center">
								<div class="form-check form-check-sm form-check-custom form-check-solid me-2">
									<input class="form-check-input checked-style" for="${i}" type="checkbox"/>
								</div>${i}
							</label>
							<div class="col-md-8 pristine-validate">
								<input type="color" class="form-control ${i}" name="${i}" value="${value}">
							</div>
						<div class="col-md-1"></div>
						</div>`;

		}
		else if(config[i][1]=='input_text')
		{
			html += `<div class="row form-group mb-3">
							<label class="col-md-2 d-flex align-items-center">
								<div class="form-check form-check-sm form-check-custom form-check-solid me-2">
									<input class="form-check-input checked-style" for="${i}" type="checkbox"/>
								</div>${i}
							</label>
							<div class="col-md-8 pristine-validate">
								<input type="text" class="form-control ${i}" name="${i}" value="${value}">
							</div>
							<div class="col-md-1"></div>
						</div>`;

		}
	}
	return html;
}


//load modal gis style
let elConfigPath = elModalGisStyle.querySelector('#config-path');
let elConfigIcon = elModalGisStyle.querySelector('#config-icon');
elConfigPath.innerHTML = generateForm(pathConfig,'');
elConfigIcon.innerHTML += generateForm(iconConfig,'');


let getValueConfig = () => 
{
	let configObject = {};
	let containerConfig = document.querySelectorAll('.container-config');
	for(x of containerConfig)
	{
		let elCheckedStyle = x.querySelectorAll('.checked-style');
		let dataConfig = x.getAttribute('data-config');
		let ar = {};
		for(el of elCheckedStyle)
		{
			if(el.checked)
			{
				let forName = el.getAttribute('for');
				let elForm =  x.querySelector(`[name=${forName}]`);
				// cek jika ada name yang sama
				let value = elForm.value;
				if(value=='true' || value=='false')
				{
					value = (value === 'true');
				}
				else if(!isNaN(value) && value.toString().indexOf('.') != -1)
				{
				    value = parseFloat(value);
				}
				else if(!isNaN(value))
				{
					value = parseInt(value);
				}
				else if(value=='null')
				{
					value = null;
				}
				let valueData = value;
				let checkName = x.querySelectorAll(`[name=${forName}]`);
				if(checkName.length>1)
				{
					let arSave = [];
					for(ely of checkName)
					{
						arSave.push(parseInt(ely.value));
					}
					valueData = arSave;
				}
				ar[elForm.name] = valueData;
				configObject[dataConfig]=ar;
			}

		}
	}
	
	document.querySelector('<?=$target?>').value = JSON.stringify(configObject);
	document.querySelector('.append-config').innerHTML = JSON.stringify(configObject, null, 1);
	Prism.highlightElement(document.querySelector('.append-config'));
}

for (el of document.querySelectorAll('.checked-style'))
{
	el.addEventListener('click',getValueConfig);
}

for (el of elModalGisStyle.querySelectorAll('.form-control'))
{
	el.addEventListener('input',getValueConfig);
	el.addEventListener('change',getValueConfig);
}

let elIconUrl;
let elIcon;
if(elIconUrl==undefined)
{
	elIconUrl = document.querySelector('[name=icon]');
	elIconUrl.id = 'icon';
	elIconUrl.innerHTML = `
          <option data-icon="bi bi-geo" value="geo">Geo</option>
          <option data-icon="bi bi-cursor" value="cursor">Cursor</option>
          <option data-icon="bi bi-map" value="map">Peta</option>
          <option data-icon="bi bi-fuel-pump" value="fuel-pump">SPBU</option>
          <option data-icon="bi bi-airplane" value="airplane">Pesawat Terbang</option>
          <option data-icon="bi bi-activity" value="activity">Aktivitas</option>
          <option data-icon="bi bi-car-front" value="car-front">Mobil</option>
          <option data-icon="bi bi-cart" value="cart">Keranjang</option>
          <option data-icon="bi bi-wallet" value="wallet">Wallet</option>
          <option data-icon="bi bi-wallet2" value="wallet2">Wallet2</option>
          <option data-icon="bi bi-box" value="box">Kotak</option>
          <option data-icon="bi bi-whatsapp" value="whatsapp">Whatsapp</option>
          <option data-icon="bi bi-phone" value="phone">Phone</option>
          <option data-icon="bi bi-telephone" value="telephone">Telepon</option>
          <option data-icon="bi bi-bicycle" value="bicycle">Sepeda</option>
          <option data-icon="bi bi-tree" value="tree">Pohon</option>
          <option data-icon="bi bi-sign-post" value="sign-post">Tanda Jalan</option>
          <option data-icon="bi bi-bag" value="bag">Tas</option>
          <option data-icon="bi bi-balloon" value="balloon">Balon</option>
          <option data-icon="bi bi-book" value="book">Buku</option>
          <option data-icon="bi bi-brighness-high" value="brighness-high">Matahari</option>
          <option data-icon="bi bi-bus-front" value="bus-front">Bis</option>
          <option data-icon="bi bi-controller" value="controller">Controller</option>
          <option data-icon="bi bi-hospital" value="hospital">Rumah Sakit</option>
          <option data-icon="bi bi-basket" value="basket">Basket</option>
          <option data-icon="bi bi-exclamation-diamond" value="exclamation-diamond">Peringatan (Diamond)</option>
          <option data-icon="bi bi-bell" value="bell">Bell</option>
          <option data-icon="bi bi-bookmark" value="bookmark">Penanda</option>
          <option data-icon="bi bi-bookmark-check" value="bookmark-check">Penanda (Check)</option>
          <option data-icon="bi bi-building" value="building">Gedung</option>`;
	elIcon = new BVSelect({
      selector: '#icon',
      searchbox: true,
      offset: true
    });
}

getValueConfig(); 

let setValueGisStyle = (data) => {
	let configStyle = JSON.parse(data);
	elModalGisStyle.querySelector('.append-config').innerHTML = JSON.stringify(configStyle, null, 1);
	Prism.highlightElement(document.querySelector('.append-config'));
	for(i in configStyle)
	{
		for(j in configStyle[i])
		{
		elModalGisStyle.querySelector(`.container-config[data-config="${i}"] [for=${j}]`).checked = true;
		let elForm = elModalGisStyle.querySelector(`.container-config[data-config="${i}"] [name=${j}]`);
		if(j=='icon')
		{
			elIcon.SetOption({
				  type: "byIndex",
				  value: configStyle[i][j]
				});
		}
		else
		{
	    	elForm.value = configStyle[i][j];
		}

		}

	}
}

</script>
	<?php
	$modal = ob_get_clean(); 
	return $modal;      
}