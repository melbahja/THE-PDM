<?php

require_once(dirname(__FILE__) . '/autoload.php');

/**
 * Start PDM Object
 * @var 
 */
$pdm = PDM\PDM::getInstance();

/**
 * Load Command
 * @var oject
 */
$dml = pdm->load('DML', 'Database1');

/**
 * Select DATA 
 * table name is : xprefix_users
 */
$users = $dml->getUsers();
