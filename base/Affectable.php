<?php
 /**
  * This interface must be implemented by all objects which properties or characteristics
  * can be affected by another objects.
  * 
  * @package models
  * @author nikelin
  */
  
interface Affectable {
    const TYPE_BUILDING = 1;
    const TYPE_RESOURCE = 2;
}