<?php

/**
 * require autoloader
 */
require_once('../autoload.php');


$pdm = PDM\PDM::getInstance();

/**
 * load command
 */
$ddl = $pdm->load('DDL', 'PdoMysql');

/**
 * start db connection
 */
$ddl->start();

/**
 * create table
 */

// if ($ddl->create('TableName', 'firstname VARCHAR(40) NOT NULL,
// lastname VARCHAR(50) NOT NULL, .....') === true ) {

// 	// true
// }
// final table name is prefix_TableName
// 

/**
 * Drop
 */

// if ($ddl->drop('TABLE @prefix_TableName') === true) {

// 	// true
// }

/**
 * alter table
 */

// if ( $ddl->alter('TableName', 'sql command here') === true) {

// 	// true
// }
// 
/**
 * Rename table
 */
// if ($ddl->rename('TableName', 'NewtableName') === true) {

// 	// true
// }

/**
 * truncate
 */
// if ($ddl->truncate('TableName') === true) {

// 	// true
// }