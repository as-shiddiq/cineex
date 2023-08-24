<!-- Core -->
<script src="/templates/<?=getenv('cineex.template.dashboard')?>/vendor/jquery/dist/jquery.min.js"></script>
<script src="/templates/<?=getenv('cineex.template.dashboard')?>/vendor/popper.js/dist/umd/popper.min.js"></script>
<script src="/templates/<?=getenv('cineex.template.dashboard')?>/vendor/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="/templates/<?=getenv('cineex.template.dashboard')?>/vendor/headroom.js/dist/headroom.min.js"></script>

<!-- Vendor JS -->
<script src="/templates/<?=getenv('cineex.template.dashboard')?>/vendor/onscreen/dist/on-screen.umd.min.js"></script>
<script src="/templates/<?=getenv('cineex.template.dashboard')?>/vendor/nouislider/distribute/nouislider.min.js"></script>
<script src="/templates/<?=getenv('cineex.template.dashboard')?>/vendor/waypoints/lib/jquery.waypoints.min.js"></script>
<script src="/templates/<?=getenv('cineex.template.dashboard')?>/vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js"></script>

<script async defer src="https://buttons.github.io/buttons.js"></script>

<!-- Neumorphism JS -->
<script src="/templates/<?=getenv('cineex.template.dashboard')?>/assets/js/neumorphism.js"></script>
<link href="https://cdn.datatables.net/v/bs4/dt-1.13.6/r-2.5.0/sl-1.7.0/datatables.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/v/bs4/dt-1.13.6/r-2.5.0/sl-1.7.0/datatables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="/assets/js/pristine/pristine.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>
<!--end::Page Custom Javascript-->
<!--end::Javascript-->
<script type="text/javascript">
let siteUrl = `<?=site_url('dashboard/')?>`;
let apiUrl = '<?=site_url('api')?>/';
let nowUrl = '<?=$url?>';
let id = '<?=$id??''?>';
let elConnectionStatus = document.querySelector('.connection-status');
let elFormData = document.querySelector('#form-data');
let elBtnReconnect = document.querySelector('.btn-reconnect');
let elBtnAdd = document.querySelector('.btn-add');
let elBtnSort = document.querySelector('.btn-sort');
let elBtnBack = document.querySelector('.btn-back');
let elBtnReset = document.querySelector('.btn-reset');
let elBtnDeleteMarked = document.querySelector('.btn-delete-marked');
let elBtnRefresh = document.querySelector('.btn-refresh');
let markedData = [];


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
let Toast = Swal.mixin({
	  toast: true,
	  position: 'top-end',
	  showConfirmButton: false,
	  timer: 2000
	});

let refreshDt = () => {
	$('#kt_datatable').DataTable().ajax.reload();
}

 // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
var dtSearch = () => {
    // const filterSearch = document.querySelector('[data-kt-filter="search"]');
    // filterSearch.addEventListener('keyup', function (e) {
    //     $('#kt_datatable').DataTable().search(e.target.value).draw();
    // });
}
var dtCreateInstances = () => {
	$('#kt_datatable').DataTable().on('draw', function () {
     	// KTMenu.createInstances();
	});
}
let dtSelect = () => {
	function removeArray(arr, value) {
	  var i = 0;
	  while (i < arr.length) {
	    if (arr[i] === value) {
	      arr.splice(i, 1);
	    } else {
	      ++i;
	    }
	  }
	  return arr;
	}

	let checkMarked = () => {
		if(markedData.length>0)
	    {
	      elBtnDeleteMarked.classList.remove('d-none');
	    }
	    else
	    {
	      elBtnDeleteMarked.classList.add('d-none');
	    }
	}

	$('#kt_datatable').on('change','.checkable',function(){
		if($(this).prop('checked'))
		{
			markedData.push($(this).val());
		}
		else
		{
			markedData = removeArray(markedData,$(this).val());
		}
		checkMarked();
	})

	$('#kt_datatable').on('change', '.group-checkable', function() {
		let set = $(this).closest('table').find('td:first-child .checkable');
		let checked = $(this).is(':checked');

		$(set).each(function() {
			if (checked) {
				markedData.push($(this).val());
				$(this).prop('checked', true);
				$('#kt_datatable').DataTable().rows($(this).closest('tr')).select();
			}
			else {
				markedData = removeArray(markedData,$(this).val());
				$(this).prop('checked', false);
				$('#kt_datatable').DataTable().rows($(this).closest('tr')).deselect();
			}
		});
		checkMarked();
	});
} 

if(elBtnRefresh!=null)
{
	elBtnRefresh.addEventListener('click',()=>{
		refreshDt();
	});

}

let showPw = (thisValue,target) => {
	let elTarget = document.querySelector(`[name=${target}]`);
	if(elTarget.type=='text')
	{
		elTarget.type = 'password';
	}
	else
	{
		elTarget.type = 'text';
	}
	for(el of thisValue.children)
	{
    	el.classList.toggle('d-none');
	}
}


let buttonAction = (typeBtn = [],setId,setText,setUrl='',setClassBtn='btn-active-light-primary') => {
	let btn = '';
	if(setUrl=='')
	{
		setUrl = nowUrl;
	}
	for(elBtn in typeBtn)
	{
		if(typeBtn[elBtn]=='edit')
		{
			btn += `<li>
	                    <a href="${siteUrl}${setUrl}/form/${setId}" title="Edit Data" class="dropdown-item">
							Edit
	                    </a>
	                </li>`;
		}
		if(typeBtn[elBtn]=='detail')
		{
			btn += `<li>
	                    <a href="${siteUrl}${setUrl}/detail/${setId}" title="Detail Data" class="dropdown-item">
							Detail
	                    </a>
	                </li>`;
		}
		if(typeBtn[elBtn]=='delete')
		{
			btn += `<li>
	                    <a href="#" onclick="deleteData('${setId}','${setText}')" title="Delete Data" class="dropdown-item">
							Delete
	                    </a>
	                </div>`;	
		}
		if(Array.isArray(typeBtn[elBtn]))
		{
			for(i in typeBtn[elBtn])
			{
				btn += typeBtn[elBtn][i]
			}
		}
	}
	return `<div class="nav-item dropdown ${setClassBtn} ">
		    	<a href="#" class="nav-link" data-toggle="dropdown" >
                    <span class="nav-link-inner-text">Aksi</span>
                    <span class="bi bi-chevron-down nav-link-arrow ml-2"></span>
                </a>
				<ul class="dropdown-menu">
					${btn}
				</ul>
			</div>`;
}

let warningText = (icon='',title='',text='') => {
	if(icon=='')
	{
		setIcon = `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
							<path opacity="0.3" d="M20.5543 4.37824L12.1798 2.02473C12.0626 1.99176 11.9376 1.99176 11.8203 2.02473L3.44572 4.37824C3.18118 4.45258 3 4.6807 3 4.93945V13.569C3 14.6914 3.48509 15.8404 4.4417 16.984C5.17231 17.8575 6.18314 18.7345 7.446 19.5909C9.56752 21.0295 11.6566 21.912 11.7445 21.9488C11.8258 21.9829 11.9129 22 12.0001 22C12.0872 22 12.1744 21.983 12.2557 21.9488C12.3435 21.912 14.4326 21.0295 16.5541 19.5909C17.8169 18.7345 18.8277 17.8575 19.5584 16.984C20.515 15.8404 21 14.6914 21 13.569V4.93945C21 4.6807 20.8189 4.45258 20.5543 4.37824Z" fill="currentColor"></path>
							<path d="M10.5606 11.3042L9.57283 10.3018C9.28174 10.0065 8.80522 10.0065 8.51412 10.3018C8.22897 10.5912 8.22897 11.0559 8.51412 11.3452L10.4182 13.2773C10.8099 13.6747 11.451 13.6747 11.8427 13.2773L15.4859 9.58051C15.771 9.29117 15.771 8.82648 15.4859 8.53714C15.1948 8.24176 14.7183 8.24176 14.4272 8.53714L11.7002 11.3042C11.3869 11.6221 10.874 11.6221 10.5606 11.3042Z" fill="currentColor"></path>
						</svg>`;
	}
	return `<div class="alert alert-danger d-flex align-items-center p-5">
			    <span class="svg-icon svg-icon-2hx svg-icon-alert me-3">
					${setIcon}
			    </span>	
			    <div class="d-flex flex-column">
			        <h4 class="mb-1 text-dark">${title}</h4>
			        <span>${text}</span>
			    </div>
			</div>`;
}

function formatBytes(bytes, decimals = 2) {
    if (bytes === 0) return '0 Bytes';

    const k = 1024;
    const dm = decimals < 0 ? 0 : decimals;
    const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];

    const i = Math.floor(Math.log(bytes) / Math.log(k));

    return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
}

let progressBarUsage = (percent) =>
{
	if(percent>90)
	{
		return 'bg-danger';
	}
	else if(percent>70)
	{
		return 'bg-warning';
	}
	if(percent>50)
	{
		return 'bg-info';
	}
	else
	{
		return 'bg-success';
	}
}






let dmyFormat = (date) => 
{
	return moment(date).format('DD/MM/YYYY HH:mm')
}
let dmyShort = (date) => 
{
	return moment(date).format('DD MMM YY')
}

let toSlug = (str) => 
{
  return str.toLowerCase()
             .replace(/ /g, '-')
             .replace(/[^\w-]+/g, '');
}

let stripTags = (html) =>
{
	let tmp = document.createElement("DIV");
	tmp.innerHTML = html;
	return tmp.textContent || tmp.innerText || "";
}

let findMostRepeatedWord = (str) => {
  if (str.length === 0) {
	    return null
	}

	str = str.toLowerCase()
	let listWord = {}
	str = str.match(/\w+/g)
	str.forEach(word=>{
		if(word.length>5)
		{
			if(listWord[word]==undefined)
			{
				listWord[word] = 0;
			}
			else
			{
				listWord[word] = listWord[word]+1;
			}
		}
	})
	let newList = [];
	for(i in listWord)
	{
		newList.push(`{"id":"${i}","value":${listWord[i]}}`);
	}
	listWord = JSON.parse(`[${newList.join(',')}]`);
	listWord.sort((a, b) => b.value - a.value);
	return listWord;	    
}


let select2 = (sel,setUrl,q,valId,valText,setUrlCustome=false) => {
	if(!setUrlCustome)
	{
		setUrl = `${apiUrl}restful/data/${setUrl}`;
	}
	$(sel).select2({
	  ajax: {
	    url: `${setUrl}`,
	    data: function (params) {
			if(params.term==undefined)
			{
				return '';
			}
			let checkQ = q.split(',');
			if(checkQ.length>1)
			{
				let ar = {};
				for(x in checkQ)
				{
					ar[checkQ[x]] = params.term;
				}
				query = {
					search : ar,
				}
			}
			else
			{
				query = {
					search : JSON.parse(`{"${q}":"${params.term}"}`),
				}	
			}
			// Query parameters will be ?search=[term]&type=public
			return query;
	    },
	    processResults: function (resp) {
	    	let data = resp.data;
	    	let ar = [];
	    	for(i in data)
	    	{
	    		ar.push({'id':data[i][valId],'text':data[i][valText]});
	    	}
			return {
				results: ar
			};
	    }
	  }
	});
}


let switchSetChange = async (setId,setField,setText,setVar,defaultChecked,e,setUrl='') => {
	let sp = setVar.split('&&');
	let arOk = sp[0].split(',');
	let arNo = sp[1].split(',');
	if(e.target.checked)
	{
		value = arOk[0];
		text = arOk[1];
	}
	else
	{
		value = arNo[0];
		text = arNo[1];
	}
	if(setUrl=='')
	{
		setUrl = nowUrl;
	}
	Swal.fire({
          title: setText,
          html: "Ubah menjadi <strong class='text-warning'>"+text+"</strong>",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya, lanjutkan!',
          cancelButtonText: 'Batalkan'
        }).then(async (result) => {
          if (result.value) {
         	let update = await fetch(`${apiUrl}restful/update/${setUrl}/${setId}`,{
					method : 'PUT',
					body : `${setField}=${value}`,
					headers: {
						"Content-Type":"application/x-www-form-urlencoded",
					    "X-Requested-With": "XMLHttpRequest"
					}
			});
			let resp = await update.json();
				if(resp.error==false)
					{
						Swal.fire({
		                icon: 'success',
		                html: `Data telah diubah!`
				       });
					}
				elBtnRefresh.click();
          }
          else
          {
          	if(defaultChecked=='checked')
          	{
          		checked =true;
          	}
          	else
          	{
          		checked =false;
          	}
          	e.target.checked  = checked;
          }
    });
	
}

let switchRender = (setId,setField,setText,setVal,setVar,arStatus=[],setUrl='') => {
	let checked = '';
	let sp = setVar.split('&&');
	let arValue = sp[0].split(',');
	if(setVal==arValue[0])
	{
		checked = 'checked';
	}
	return `<label class="form-check form-switch form-switch-sm form-check-custom form-check-solid flex-stack">
					<input class="form-check-input m-auto" type="checkbox" ${checked} onchange="switchSetChange('${setId}','${setField}','${setText}','${setVar}','${checked}',event,'${setUrl}')">
				</label>`;
}
</script>