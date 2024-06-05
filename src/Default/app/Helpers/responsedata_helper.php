<?php

function responseData($model, $config = [])
{
    // disabling agregate
    $db = \Config\Database::connect();
    $query = "SET SESSION sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''))";
    $db->query($query);
    // disabling agregate

    $request = \Config\Services::request();
    $getData = $model->withAddons('', $config);
    $getData = _idResp($getData, $config);
    $getData = _queryResp($getData, $config);
    $getData = _whereResp($getData, $config);
    $getData = _sortResp($getData, $config);
    $data = _findAllResp($getData);
    if ($config['debug']) {
        dd($getData->getLastQuery());
    }
    //get filtered
    // $getData = $model;
    //jika pakai ID
    if ( $config['id'] == 'all' || $config['id'] == '') {
        $getData = $model->withAddons()
                        ->select('COUNT(*) as filtered');
        $getData = _queryResp($getData, $config);
        $getData =_whereResp($getData, $config);
        $result = $getData->first();
        $totalFiltered = $result->filtered??0;
        $meta['total_filtered'] = $totalFiltered;

        //set meta 
        if ($request->getGet('start') && $request->getGet('length')) {
            $meta['start'] = $request->getGet('start');
            $meta['length'] = $request->getGet('length');
        }
        //cek if total data lower than length
        $total = $request->getGet('length')??0;
        if($total>$totalFiltered)
        {
            $total = $totalFiltered;
        }
        $meta['total'] = $total;
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

function _skipColumnResp($skipColumn)
{
    $def = ['created_at', 'updated_at', 'deleted_at', 'created_by', 'updated_by', 'deleted_by'];
    return array_merge($skipColumn, $def);
}

function _whereRespColumn($config)
{
    $def = $config['column'];
    $add = $config['whereColumn'];
    $_whereRespColumn = array_merge($add, $def);
    foreach (_skipColumnResp($config['skipColumn']) as $key => $value) {
        if(in_array($value,$_whereRespColumn))
        {
            unset($_whereRespColumn[$value]);
        }
    }
    return $_whereRespColumn;
}

function _idResp($getData, $config)
{
    if ($config['id'] !== false && $config['id'] != 'all' && $config['id'] != '') {
        $getData->where($config['table'].'.id',$config['id']);
    }
    return $getData;
}

function _whereResp($getData, $config,$type='')
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
                if (in_array($key, _whereRespColumn($config))) {
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
                            if (in_array($key, _whereRespColumn($config))) {
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
                            if (in_array($key, _whereRespColumn($config))) {
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
                        if (in_array($key, _whereRespColumn($config))) {
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
                        if (in_array($key, _whereRespColumn($config))) {
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


function _queryResp($getData, $config)
{
    $request = \Config\Services::request();
    $_whereRespColumn = _whereRespColumn($config);
    if ($request->getGet('search')) {
        if (isset($request->getGet('search')['value'])) {
            $search = $request->getGet('search')['value'];
            $getData->groupStart();
            foreach ($_whereRespColumn as $key => $value) {
                if (!in_array($value, _skipColumnResp($config['skipColumn']))) {
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
                     if (in_array($key, $_whereRespColumn)) {
                        $getData->orLike($config['table'] . '.' . $key, $value);
                     }
                     else
                     {
                        $getData->orLike($key, $value);
                     }
                }
                $getData->groupEnd();
            } else {
                $column = array_diff($config['column'], _skipColumnResp($config['skipColumn']));
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

function _sortResp($getData, $config)
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

function _findAllResp($getData, $limit = true)
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
