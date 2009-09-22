<?php
Zend_Controller_Front::getInstance()->getRouter()
 # Sample:
    ->addRoute("new_building", new Zend_Controller_Router_Route(
        "new-building/:planet_id/:id",
        array(
            "controller" => "buildings",
            "action"     => "build",
        )
    ))
    ->addRoute("planet_buildings", new Zend_Controller_Router_Route(
       "infrastructure/:planet_id",
       array(
           "controller" => "buildings",
           'action' => "index"
       )
    ) )
    ->addRoute("view_planet", new Zend_Controller_Router_Route(
        "planet/:id",
        array(
            "controller" => "planet",
            "action" => "view"
        )
    ) )
    ->addRoute("building_ship", new Zend_Controller_Router_Route(
        "build-ship/:id",
        array(
            "controller" => "fleet",
            "action" => "ship"
        )
    ) );
;