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

/** start connection **/
$dml->start();

/**
 * Select DATA 
 * table name is : xprefix_users
 */
$users = $dml->getUsers();


/** Left Join **/
//$data = $dml->select('@prefix_tableName.id, @prefix_tableNameTwo.user', 'tableName', 'LEFT JOIN @prefix_tableNameTwo ON @prefix_tableName.id=@prefix_tableNameTwo.uid');


/** DDL **/
$ddl = $pdm->load('DDL', 'Database1');
$ddl->start();

$c = $ddl->create('tableName', array(
    'id'          => 'int NOT NULL PRIMARY KEY',
    'name'        => 'varchar(122) COLLATE @charset_general_ci NOT NULL',
    'username'    => 'varchar(50) COLLATE @charset_general_ci NOT NULL')); // @charset = default charset in config file

var_dump($c);
