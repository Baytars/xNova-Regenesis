<?php
require_once realpath( dirname(__FILE__) .'/../../bootstrap.php' );

try {
    $q = Doctrine_Query::create()->from("User")->select("*");
    $pager = new Doctrine_Pager( $q, 0, 30 );
    while( FALSE !== ( $users = $pager->execute() ) ) {
        foreach( $users as $user ) {
            $user->updateResources();
            print $user->getLogin() . " stats was updated." . PHP_EOL;
        }

        if ( $pager->haveToPaginate() ) {
            $pager->setPage( $pager->getNextPage() );
        } else {
            break;
        }
    }
} catch ( Exception $e ) {
    Zend_Debug::dd($e);
}