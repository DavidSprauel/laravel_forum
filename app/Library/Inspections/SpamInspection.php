<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 07/02/2018
 * Time: 09:39
 */

namespace Forum\Library\Inspections;


interface SpamInspection {
    
    public function detect($body);
    
}