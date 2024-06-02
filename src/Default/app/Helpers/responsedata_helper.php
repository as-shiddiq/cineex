<?php

function responseData($model, $config = [])
{
    $request = \Config\Services::request();
    $getData = $model->withAddons('', $config);
    $getData = _id($getData, $config);
    $getData = _query($getData, $config);
    $getData = _where($getData, $config);
    $getData = _sort($getData, $config);
    $data = _findAll($getData);
    if ($config['debug']) {
        dd($getData->getLastQuery());
    }
    //get filtered
    // $getData = $model;
    //jika pakai ID
    if ( $config['id'] == 'all' || $config['id'] == '') {
        $getData = $model->withAddons()
                    ->select('COUNT(*) as filtered');
        $getData = _query($getData, $config);
        $getData =_where($getData, $config);
        $result = $getData->first();
        $meta['total_filtered'] = $result->filtered;

        //set meta 
        if ($request->getGet('start') && $request->getGet('length')) {
            $meta['start'] = $request->getGet('start');
            $meta['length'] = $request->getGet('length');
        }
        $meta['total'] = $request->getGet('length')??0;
    }
    else
    {
        $meta['total_filtered'] = 1;
        $meta['total'] = 1;
    }

    return [
        'data' => $data,
        'meta' => $meta
    ];
}

function _skipColumn($skipColumn)
{
    $def = ['created_at', 'updated_at', 'deleted_at', 'created_by', 'updated_by', 'deleted_by'];
    return array_merge($skipColumn, $def);
}

function _whereColumn($config)
{
    $def = $config['column'];
    $add = $config['whereColumn'];
    $_whereColumn = array_merge($add, $def);
    foreach (_skipColumn($config['skipColumn']) as $key => $value) {
        if(in_array($value,$_whereColumn))
        {
            unset($_whereColumn[$value]);
        }
    }
    return $_whereColumn;
}

function _id($getData, $config)
{
    if ($config['id'] !== false && $config['id'] != 'all' && $config['id'] != '') {
        $getData->where($config['table'].'.id',$config['id']);
    }
    return $getData;
}

function _where($getData, $config,$type='')
{
    $request = \Config\Services::request();
    // bypass where
    if ($request->getGet('where') || isset($_GET['where'])) {
        $where = $request->getGet('where');
        if($where==null)
        {
            $where = $_GET['where'];
        }
        else
        {
            if(is_array($where))
            {
                $where = array_merge($where,$_GET['where']);
            }
        }
        if (is_array($where)) {
            //cek apakah perlu di groupkan
            $exists = false;
            foreach ($where as $key => $value) {
                if ($value == '') {
                    $value = null;
                }
                if (in_array($key, _whereColumn($config))) {
                    $exists = true;
                    continue;
                }
            }

            if($exists)
            {
                $getData->groupStart();
            }

            foreach ($where as $key => $value) {
                if ($value == '') {
                    $value = null;
                }
                if(is_array($value))
                {
                    foreach ($value as $k => $v) {
                        $substr = substr($v, 0,1);
                        if($substr=='!')
                        {
                            $v = substr($v,1);
                            if (in_array($key, _whereColumn($config))) {
                                $getData->where($config['table'] . '.' . $key.' !=', $v);
                            } else {
                                if($type!=='base')
                                {
                                    $getData->where($key.' !=', $v);
                                }
                            }
                        }
                        else
                        {
                            if (in_array($key, _whereColumn($config))) {
                                $getData->where($config['table'] . '.' . $key, $v);
                            } else {
                                if($type!=='base')
                                {
                                    $getData->where($key, $v);
                                }
                            }
                        }
                    }
                }
                else
                {
                    $substr = substr($value, 0,1);
                    if($substr=='!')
                    {
                        $value = substr($value,1);
                        if (in_array($key, _whereColumn($config))) {
                            $getData->where($config['table'] . '.' . $key.' !=', $value);
                        } else {
                            if($type!=='base')
                            {
                                $getData->where($key.' !=', $value);
                            }
                        }
                    }
                    else
                    {
                        if (in_array($key, _whereColumn($config))) {
                            $getData->where($config['table'] . '.' . $key, $value);
                        } else {
                            if($type!=='base')
                            {
                                $getData->where($key, $value);
                            }
                        }
                    }
                }
            }
            if($exists)
            {
                $getData->groupEnd();
            }
        } else {
            $value = $request->getGet('value');
            $getData->where($where, $value);
        }
    }
    return $getData;
}


function _query($getData, $config)
{
    $request = \Config\Services::request();
    $_whereColumn = _whereColumn($config);
    if ($request->getGet('search')) {
        if (isset($request->getGet('search')['value'])) {
            $search = $request->getGet('search')['value'];
            $getData->groupStart();
            foreach ($_whereColumn as $key => $value) {
                if (!in_array($value, _skipColumn($config['skipColumn']))) {
                    if(in_array($value,$config['column']))
                    {
                         $getData->orLike($config['table'] . '.' . $value, $search);
                    }
                    else
                    {
                         $getData->orLike($value, $search);
                    }
                }
            }
            $getData->groupEnd();
        } else {
            if (is_array($request->getGet('search'))) {
                $search = $request->getGet('search');
                $getData->groupStart();
                //check search compare with field table
                foreach ($search as $key => $value) {
                     if (in_array($key, $_whereColumn)) {
                        $getData->orLike($config['table'] . '.' . $key, $value);
                     }
                     else
                     {
                        $getData->orLike($key, $value);
                     }
                }
                $getData->groupEnd();
            } else {
                $column = array_diff($config['column'], _skipColumn($config['skipColumn']));
                $search = $request->getGet('search');
                $getData->groupStart();
                foreach ($column as $key => $value) {
                    $getData->orLike($config['table'] . '.' . $value, $search);
                }
                $getData->groupEnd();
            }
        }
    }

    //if search by column 
    $columns = $request->getGet('columns')??[];
    foreach ($columns as $key => $value) {
        if($value['searchable']=='true')
        {
            $search = $value['search']['value'];
            if($search!='')
            {
                $getData->like($value['name'], $search);
            }
        }
    }

    return $getData;
}

function _sort($getData, $config)
{
    $request = \Config\Services::request();
    if ($request->getGet('order')) {
        $order = $request->getGet('order');
        $columns = $request->getGet('columns');
        foreach ($order as $key => $value) {
            $field = $columns[$order[$key]['column']]['name'];
            $sort = $order[$key]['dir'];
            $getData->orderBy($field,$sort);
        }
    }
    return $getData;
}

function _findAll($getData, $limit = true)
{
    $request = \Config\Services::request();

    if ($request->getGet('length') && is_numeric($request->getGet('start')) && $limit == true) {
        $limit = $request->getGet('length');
        $offset = $request->getGet('start') / $limit * $limit;
        if($limit!='-1')
        {
            $data = $getData->findAll($limit, $offset);
        }
        else
        {
            $data = $getData->findAll();
        }
    }
    else {
        $data = $getData->findAll();
    }
    // echo $getData->getCompiledSelect();
    return $data;
}
