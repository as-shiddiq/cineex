<script type="text/javascript">
    //delete data
    let deleteData = async (setId=null, text, to='',setUrl='',setUrlFull=false,setText='') => {
      if(setUrl == '')
      {
        setUrl = nowUrl;
      }
      if(setId==null)
      {
        setId = id;
      }
      if(setText=='')
      {
        setText =  "menghapus data <strong class='text-warning'>"+text+"</strong>";
      }
      await new Promise((resolve,reject) => {
        Swal.fire({
                title: 'Apakah anda yakin?',
                html: setText,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, lanjutkan!',
                cancelButtonText: 'Batalkan'
              }).then((result) => {
                if (result.isConfirmed) {
                  let action = `${apiUrl}restful/delete/${setUrl}`;
                  if(setUrlFull)
                  {
                    action = setUrl;
                  }
                  fetch(`${action}`,{
                    method : "DELETE",
                    headers: {
                      'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body:'id='+setId
                  })
                  .then(resp => resp.json())
                  .then(resp => {
                    if(resp.status == 200)
                    {
                      if(to=='')
                      {
                        refreshDt();
                      }
                      Toast.fire({
                          icon: 'success',
                          title: resp.message
                      }).then((result)=>{
                          if(to!='')
                          {
                            if(result.isConfirmed)
                            {
                              window.location = to;
                            }
                          }
                        })
                    }
                    else
                    {
                      Toast.fire({
                          icon: 'error',
                          title: resp.message
                      })
                    }
                  });
                  return resolve();
                }
                else
                {
                  return reject('false');
                }
            })
      });


      return true;
    } 

    let deleteMarked = (e, target) => {
        e.preventDefault();
        let totaldata = markedData.length;
        if(totaldata>0)
        {
            Swal.fire({
              title: 'Apakah Anda yakin?',
              html: `untuk menghapus <strong>${totaldata}</strong> data yang terpilih`,
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Ya, lanjutkan!',
              cancelButtonText: 'Batalkan'
            }).then((result) => {
              if (result.value) {
                 fetch(`${target.href}`, {
                      method: "DELETE",
                      body: 'id='+markedData.join(","),
                      headers: {
                        'Content-Type':'application/x-www-form-urlencoded',
                      }
                  })
                  .then(response => response.json())
                  .then(response => {
                    if(response.error==false){
                        elBtnRefresh.click();
                        markedData = [];
                        Swal.fire({
                            icon: 'success',
                            html: `<strong>${totaldata}</strong> data yang dipilih telah dihapus`
                        });
                    } else{
                        Swal.fire({
                            icon: 'error',
                            title: response.message
                        });
                    }
                    elBtnDeleteMarked.classList.add('d-none');
                  });

              }
        });
      }
      else
      {
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Tidak ada data yang dipilih!',
          confirmButtonText: 'Ok',
        })
      }
    }


    let saveData = async (urlCustom='',setId=null,setUrl='',setFormData=null,setUrlFull=false) => {
        if(setUrl=='')
        {
          setUrl = nowUrl;
        }
        
        if(id=='' || setId=='')
        {
          method = 'POST';
        }
        else
        {
          method = 'PUT';
        } 

        if(setId==null)
        {
          setId = id;
        }

        if(method=='POST')
        {
          setAction = `${apiUrl}restful/create/${setUrl}`;
        }
        else
        {
          setAction = `${apiUrl}restful/update/${setUrl}/${setId}`;
        }

        /** BYPAS SETACTION **/
        if(setUrlFull)
        {
          setAction = setUrlFull;
        }


        if(setFormData==null)
        {
          setFormData = $("#form-data").serialize();
        }

        let post = await fetch(setAction,{
          method : method,
          body : setFormData,
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
          },
        })
        let response = await post.json();
        if(response.status==200)
        {
            Toast.fire({
              icon: 'success',
              title:response.message
          });
          if(urlCustom=='return')
          {
            return response;
          }
          else
          {
            setTimeout(()=>{
              if(urlCustom=='refresh')
              {
                refreshDt();
              }
              else
              {
                if(urlCustom=='')
                {
                  window.location = siteUrl+nowUrl;
                }
                else
                {
                  window.location = urlCustom;
                }
              }
            },500);
          }
          
        }
        else
        {
          msg = response.message;
          let errorText = msg;
          if (typeof msg != "undefined") {
            errorText = '';
            for(i in msg)
            {
              errorText += msg[i];
            }
          }
          Toast.fire({
                icon: 'error',
                title: errorText
          });
          if(urlCustom=='return')
          {
            return response;
          }

        }
      }



    let getData = async (setId=null,setUrl='') => {
      if(setUrl=='')
      {
        setUrl = nowUrl
      }
      if(setId==null)
      {
        setData = '';
      }
      else
      {
        setData = '/'+setId;
      }
      let response = await fetch(`${apiUrl}restful/data/${setUrl}${setData}`, {
              method: "get",
          });
      let json = await response.json();
      if(json.status==200)
      {
        let data = json.data;
        return data;
      }
    }


    let signout = async () => {
      Swal.fire({
          title: 'Apakah anda yakin?',
          html: "Untuk keluar, dan menghapus session",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya, lanjutkan!',
          cancelButtonText: 'Batalkan'
        }).then((result) => {
          if (result.value) {
          fetch(`${apiUrl}auth/signout`,{
            method : "POST"
          })
          .then(resp => resp.json())
          .then(resp => {
            if(resp.status == 200)
            {
              window.location = resp.redirect;
            }
          });

          }
        });
    }
</script>