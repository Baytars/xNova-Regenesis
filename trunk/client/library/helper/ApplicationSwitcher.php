<?php
/**
 * Choose what application actual at the moment (site, admin, game, etc.)
 */
class ApplicationSwitcher {

    const AREA_ADMIN = "admin";
    const AREA_SITE = "site";
    const AREA_GAME = "game";

    public static function choose() {
        $user = User_Proxy::getInstance();

        if ( $user->isRegistered() ) {
            if ( $user->isAdmin() && Zend_Controller_Front::getInstance()->getRequest()->getControllerName() == self::AREA_ADMIN ) {
                return self::AREA_ADMIN;
            } else {
                return self::AREA_GAME;
            }
        } else{
            return self::AREA_SITE;
        }
    }
    
}
