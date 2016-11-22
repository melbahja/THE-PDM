<?php

/**
 * require autoloader
 */
require_once('../autoload.php');


$pdm = PDM\PDM::getInstance();

/**
 * load command
 */
$dml = $pdm->load('DML', 'PdoMysql');

// $pdm->load(commad, config name);

/** start db connection */
$dml->start();

/**
 * Select Data 1
 */
// table name is prefix_users
// $users = $dml->getUsers();

// options

// $users = $dml->getUsers(['limit' => 10]);

// $id = $dml->connect->escape($_GET['id'], 'int');
// $options = array(
// 	'get' 	=> 'firsname, lastname, username',
// 	'cond'	=> 'WHERE id=' . $id,
// 	'limit'  => 1
// );

// $users = $dml->getUsers($options);
// if table name = prefix_Users
// $users = $dml->getUsers($options, true);
// $dml->getTablename(options, is upper);

/**
 * Select Data 2
 */

//$users = $dml->select('firsname, lastname, username', 'users', 'WHERE ... LIMIT 12');
// get num_rows
// pdo $users->rowCount()
// mysqli $users->num_rows
// 

/** 
 * get one row
 */
// $user = $dml->selectOne('firsname, lastname, username', 'users', 'WHERE id=1');
// echo $user['username'];

/**
 * insert data 1 
 */
// $data = array(
// 	'firstname' => 'mohamed',
// 	'lastname'	=> 'elbahja',
// 	'username' => 'emohamed',
// );
// if ($dml->setUsers($data) === true) {

// 	// true
// }

/** insert data 2 */

// if ($dml->insert($data, 'users') === true) {
// 	//true
// }

// get insert id 
// mysqli $dml->connect->insert_id;
// pdo $dml->connect->lastInsertId();
// 
/**
 * multi insert
 */
// $data = array(
// 	'insert1' => array(
// 		'firsname' => 'text',
// 		'lastname' => 'ss'
// 	),
// 	'insert2' => array(
// 		'firsname' => 'text2',
// 		'lastname' => 'ss2'
// 	),
// );

// if ($dml->multiInsert($data, 'users') === true) {

// 	// true
// }
// get insert ids 
// array $dml->insert_ids

/**
 * update data 
 */
// $data = array(
// 	'firstname' => 'testss',
// 	'lastname' => 'ss',
// );
// if ($dml->update('users', $data, 'WHERE id=2') === true) {
// 	// true
// }

/**
 * Delete
 */
// if ($dml->delete('users', 'WHERE id=2')) {
// 	//1
// }

