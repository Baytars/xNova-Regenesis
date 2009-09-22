<?php
require realpath(dirname(__FILE__) . '/../bootstrap.php');

try {
    echo str_pad( "Dropping databases ", 30, "." ) . " ";
    Doctrine_Manager::getInstance()->dropDatabases();
    echo "[ OK ]" . PHP_EOL;

    echo str_pad( "Creating databases ", 30, "." ) . " ";
    Doctrine_Manager::getInstance()->createDatabases();

    echo "[ OK ]\n";

    echo str_pad( "Creating tables ", 30, "." ) . "\r\n";

    $dirs = array(
        "models",
        "library/helper/Zend"
    );

    foreach( $dirs as $dir ) {
        print "Loading from ".$dir."\r\n";
        Doctrine::loadModels( ROOT."/".$dir );
    }
    
    Doctrine::createTablesFromModels();

    echo str_pad("", 30, ".") . " [ OK ]". PHP_EOL;

    echo str_pad( "Loading additional data ", 30, "." ) . " ";
    Doctrine::loadData( ( ROOT . '/db/fixtures' . ( Zend_Registry::get("config")->server->development ? ".dev" : "" ) ) );
    echo "[ OK ]" . PHP_EOL;

} catch ( Exception $e ) {
    Zend_Debug::dd($e );
}
