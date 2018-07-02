<?php
    date_default_timezone_set('Africa/Johannesburg');

    function view($data) { echo '<pre>'; print_r($data); echo '</pre>'; }

    $host = "http://".$_SERVER['HTTP_HOST'] . "/";

    define('ROOT', __DIR__);
    define('APP', ROOT . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR);
    define('VIEW', ROOT . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR);
    define('VIEW_LAYOUT', ROOT . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR . 'layout' . DIRECTORY_SEPARATOR);
    define('MODEL', ROOT . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'model' . DIRECTORY_SEPARATOR);
    define('DATA', ROOT . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR);
    define('CORE', ROOT . DIRECTORY_SEPARATOR .  'app' . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR);
    define('CONTROLLER', ROOT . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'controller' . DIRECTORY_SEPARATOR);

    define('ASSETS', $host . 'deliverySystem' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'assets');

    define('DB', CORE . 'database' . DIRECTORY_SEPARATOR);

    $modules = [ROOT, APP, CORE, CONTROLLER, DATA, DB];

    set_include_path(get_include_path() . PATH_SEPARATOR . implode(PATH_SEPARATOR, $modules));
    
    spl_autoload_register('spl_autoload', false);
    
    new Application;
