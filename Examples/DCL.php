<?php

/**
 * require autoloader
 */
require_once('../autoload.php');


$pdm = PDM\PDM::getInstance();

/**
 * load command
 */
$dcl = $pdm->load('DCL', 'mysqli');

/**
 * start db connection
 */
$dcl->start();


/**
 * grant 
 */

// if ($dcl->grant('SELECT, UPDATE....') === true) {

// 	//true
// }


/**
 * REVOKE
 */

// if ($dcl->revoke('ALTER, DROP ....')) {

// 	// true 
// }

