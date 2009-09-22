<?php
interface Buildable_Interface {

    public function increaseLevel();

    public function decreaseLevel();

    public function getHoldingFields();

    public function getLevel();
    
    public function getConstructionTime();

}