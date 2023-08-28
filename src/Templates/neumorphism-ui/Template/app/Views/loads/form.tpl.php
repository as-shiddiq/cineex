<?php
  $saveForm = [];
  foreach($fields as $k => $v)
  {
      $formType = "<?=input_text('$k','')?>";
      $showInForm = false;
      if($k!='id')
      {
          if(isset($v['join']))
          {
            if(count($v['jointable']??[])!=0)
            {
            $showInForm = true;
            $formTypeSave = [];
                $formTypeSave[] = "<?php";
                foreach($v['jointable'] as $r)
                {
                  $formTypeSave[] = "\t".'$model = new \Modules\{module}\Models\\'.dashToCamelFirst(str_replace('id','',$k)).'Model();';
                  $formTypeSave[] = "\t".'$getData = $model->findAll();';
                  $formTypeSave[] = "\t\$op[''] = '--Pilih kategori--';";
                  $formTypeSave[] = "\tforeach (\$getData as \$row) {";
                  $formTypeSave[] = "\t\t\$op[\$row->id] = \$row->".$v['jointable'][0].";";
                  $formTypeSave[] = "\t}";
                  $formTypeSave[] = "?>";
                }
                $formTypeSave[] = "<?=select('$k',\$op,'')?>";
                $formType = implode("\n\t\t\t\t\t\t\t\t",$formTypeSave);
                $k = dashToUcwords($v['jointable'][0]);
              }
          }
          if($v['showform']??false==true)
          {
            $showInForm = true;
            $saveThead[] = "<th>".dashToUcwords($k)."</th>\n";
            if($v['type']=='ENUM')
            {
              $op = [];
              foreach($v['constraint'] as $r)
              {
                $op[] = '"'.$r.'"=>"'.$r.'",'."\n\t\t\t\t\t\t";
              }
              $formType = "<?=select('$k',[\n\t\t\t\t\t\t\t\t\t".implode("\t\t\t",$op)."\t\t],'')?>";
            }
            else if($v['type']=='DATE')
            {
              $formType = "<?=input_date('$k','')?>";
            }
          }
      }
      if($showInForm)
      {
        $saveForm[] = '<div class="row form-group mb-4">
      <label class="col-md-3 mb-3 m-md-auto">'.dashToUcwords($k).'</label>
      <div class="col-md-9 pristine-validate">
      '.$formType.'
      </div>
    </div>'."\n\n\t\t";
      }
  }
  $form = implode("",$saveForm);
  echo $form;
?>