<@php

$routes->group('dashboard',['namespace' => 'Modules\{module}\Controllers\Dashboard'], static function ($routes) {
    <?php
        $routes = [];
        foreach ($classList as $k => $v) {
            $class = new $v;
            $ex = explode('\\',$v);
            $fileName = $ex[count($ex)-1];
            $class_methods = array_diff(get_class_methods($class),['__construct','initController']);
            $routes[] = "#$fileName\n"; 
            foreach ($class_methods as $r) {
                if($r=='index')
                {
                    $routes[] = "\t\$routes->get('".strtolower($fileName)."', '$fileName::$r');\n";
                }
                else
                {
                    $routes[] = "\t\$routes->get('".strtolower($fileName)."/$r', '$fileName::$r');\n";
                    $routes[] = "\t\$routes->get('".strtolower($fileName)."/$r/(:any)', '$fileName::$r/$1');\n";
                }
            }
            $routes[] = "\n"; 
        }
        echo implode("", $routes);
    ?>
});

$routes->group('artikel',['namespace' => 'Modules\{module}\Controllers\Main'], static function ($routes) {
    //please add your custom route for main
});

$routes->group('api',['namespace' => 'Modules\{module}\Controllers\Api'], static function ($routes)   
{
    //please add your custom route for api
});
