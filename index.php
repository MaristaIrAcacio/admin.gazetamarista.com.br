<?php
    // Fix, acessar direto o index.php não funcionava thumbs, e urls ficavam todas com index.php
    $_SERVER["REQUEST_URI"] = str_replace('index.php', '', $_SERVER["REQUEST_URI"]);

    // Localização de data
    setlocale(LC_TIME, 'ptb', 'pt_BR', 'portuguese-brazil', 'bra', 'brazil', 'pt_BR.utf-8', 'pt_BR.iso-8859-1', 'br');
    setlocale(LC_CTYPE, 'pt_BR');
    date_default_timezone_set('America/Sao_Paulo');

    // Força a codificação
    header("Content-Type: text/html; charset=utf-8");

    ini_set('session.gc_maxlifetime', 36000);
    session_set_cookie_params(36000);

    // Seta o tipo do erro
    error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE & ~E_STRICT);

    // Define path to application directory
    defined("APPLICATION_PATH") || define("APPLICATION_PATH", dirname(__FILE__) . "/application");

    // Define application environment
    defined("APPLICATION_ENV") || define("APPLICATION_ENV", (getenv("APPLICATION_ENV") ? getenv("APPLICATION_ENV") : "production"));

    // Ensure library/ is on include_path
    set_include_path(implode(PATH_SEPARATOR, array(
        APPLICATION_PATH . "/../library",
        APPLICATION_PATH . "/modules",
        get_include_path(),
    )));

    /** gazetamarista_Application */
    require_once("library/gazetamarista/Application.php");

    // helpers
    require_once("library/gazetamarista/_helpers.php");

    // Create application, bootstrap, and run
    $application = new gazetamarista_Application(
        APPLICATION_ENV,
        APPLICATION_PATH . "/configs/application.ini"
    );

    $application->bootstrap()->run();
?>