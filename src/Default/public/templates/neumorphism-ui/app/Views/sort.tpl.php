<@=$this->extend('DashboardView') ?>
<@=$this->section('stylesheet') ?>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/nestable2/1.6.0/jquery.nestable.min.css"></link>
<style type="text/css">
		.dd{
			max-width: 100%;
		}
		.dd-body {
			background: #F5F8FA;
			margin-bottom: 5px;
			border-radius: .75rem;
		}
        .dd3-content {
            display: block;
            margin: 5px 0;
            padding: 5px 10px;
            color: #333;
            text-decoration: none;
            font-weight: bold;
            -webkit-border-radius: 3px;
            border-radius: 3px;
            box-sizing: border-box;
            -moz-box-sizing: border-box;
            background: transparent;
        }
		.dd-handle {
		    display: inherit;
		    height: auto;
		    margin: 0;
		    cursor: pointer;
		    padding: 0;
		    color: #333;
		    text-decoration: none;
		    font-weight: 700;
		    border: 0;
		    background: inherit;
		    border-radius: 0;
		    font-size: 1.4rem;
		    box-sizing: border-box;
    		background: transparent;
	   		padding: 5px 10px;
		}
		.dd-handle i{
			    font-size: 2rem;
			}

        .dd-body:hover {
            color: #2ea8e5;
            background: #fdfdfd;
            transition: .5s all;
        }
        .dd3-content:hover {
            color: inherit;
            background: transparent;
        }

        .dd-dragel > .dd3-item > .dd3-content {
            margin: 0;
        }

        .dd3-item > button {
            margin-left: 30px;
        }
        .dd3-handle:hover {
            background: transparent;
        }
        .dd-item>button {
			    position: relative;
			    cursor: pointer;
			    float: right;
			    width: 40px;
			    height: 40px;
			    border-radius: 1rem;
			    padding: 0;
			    text-indent: 100%;
			    white-space: nowrap;
			    overflow: hidden;
			    border: 0;
			    background: #ccc;
			    color: #fff;
			    font-size: 18px;
			    line-height: 1;
			    text-align: center;
			    font-weight: 700;
			    margin-top: 10px;
			    margin-left: -20px;
			    box-shadow: 0px 0px 50px 0px rgb(82 63 105 / 15%);
			}
	</style>
<@=$this->endSection() ?>

<@=$this->section('content') ?>
	<@=contentOpen([
	'title' => $title,
	'page' => $page,
	'url' => $url,
	'configBtn'=>['refresh','back']
])?>
		<div class="dd" id="nestable3">
		    <ol class='dd-list dd3-list'>
		    </ol>
		</div>
<@=contentClose()?>

<!--begin::Modal - Create account-->
<@=$this->endSection() ?>


<@=$this->section('javascript') ?>
<script src="//cdnjs.cloudflare.com/ajax/libs/nestable2/1.6.0/jquery.nestable.min.js"></script>
<script type="text/javascript">

let setNested = async () => {
	let getNested = await fetch(`${apiUrl}restful/nested/${nowUrl}`);
	let respNested = await getNested.json();
	let nestedData = respNested.data;
	let output = '';
  	function buildItem(row) {
  		let setActive = '';
  		
      var html = `<li class="dd-item" data-id="${row.id}">
      		<div class="d-flex align-items-center dd-body justify-content-between ${setActive}">
      		<div class="d-flex align-items-center ">
				<div class="dd-handle dd3-handle">
      					<i class="bi bi-list"></i>
				</div>
                <div class="dd3-content d-flex align-items-center">
               		<div>
		                <h5 class="fw-bold mb-0">${row.text}</h5>
		                <span class="text-muted">
		                <!--edit other nested here-->
		                <a href="#" target="_blank">Others</a></span>
		                <!--edit other nested here-->
               		</div>
                </div>
			</div>
            <div class="pe-3">
            <a href="#" class="btn btn-icon btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
                <span class="bi bi-three-dots-vertical m-0"></span>
            </a>
            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
            	<div class="menu-item px-3">
	                    <a href="form/${row.id}"title="Edit Data" class="menu-link px-3">
							Edit
	                    </a>
	                </div>
           	 </div>
            </div>
        </div>`;

      if (row.children) {

          html += "<ol class='dd-list'>";
          $.each(row.children, function (index, sub) {
              html += buildItem(sub);
          });
          html += "</ol>";

      }

      html += "</li>";

      return html;
  }

  for(i in nestedData){
      output += buildItem(nestedData[i]);
  }
  $('.dd3-list').html(output);
  $('#nestable3').nestable({
  	maxDepth :3
  });
  KTMenu.createInstances();
}

setNested();

$('#nestable3').on('change',updateNestable);

async function updateNestable(){
    let data=$('#nestable3').nestable('serialize');
    let put = await fetch(`${apiUrl}restful/updatenested/${nowUrl}`, {
            method: "PUT",
            body:  "data="+JSON.stringify(data),
            headers: {
              'Content-Type':'application/x-www-form-urlencoded'
            }
        });
   	let resp = await put.json();
  if(resp.status==200){
  	if(!resp.error)
  	{
        Toast.fire({
              icon: 'success',
              title: resp.message
            });
        elBtnRefresh.click();
  	}
  	else
  	{
        Toast.fire({
              icon: 'error',
              title: resp.message
            });
  	}
  } else{
        Toast.fire({
        icon: 'error',
        title: resp.message
      });
  }
}

elBtnRefresh.addEventListener('click',setNested);
elBtnBack.addEventListener('click',()=>{
	history.back();
});

</script>
<@=$this->endSection() ?>