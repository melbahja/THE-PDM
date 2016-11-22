# THE-PDM
 THE PDM is a Library to deal with different databases with PDO or mysqli

## Usage

### Config file
edit PDM_CONFIG_DIR config folder path in : src/PDM/PDM.php

### Database Config
Each database can create a setup file in config directory 

- type : Database Book PDO or Mysqli
- info.host    : Database Host name
- info.name    : Databbase name
- info.user    : Database user
- info.pwd     : database password
- prefix  : for security, You can change it at any time
- charset : db encoding

## examples : 

#### Connect MySQL Database via Mysqli 
```php
<?php defined('PDM_CONFIG_DIR') || exit;

// Database1.config.php

return array
(
  'type'  => 'mysqli',
  'info'  => array
  (
  	'host'	=> 'localhost',
    'name'	=> 'dbname',
    'user'  => 'root',
    'pwd'   => '',
  ),
  'prefix'    => 'prefix_',
  'charset'   => 'utf8mb4',
);

```

### Connect MySQL Database via PDO
```php
<?php defined('PDM_CONFIG_DIR') || exit;

// Database2.config.php

return array
(
  'type'  => 'pdo:mysql',
  'info'  => array
  (
  	'host'	=> 'localhost',
    'name'	=> 'Dbname',
    'user'  => 'root',
    'pwd'   => '',
  ),
  'prefix'    => 'prefix_',
  'charset'   => 'utf8mb4',
);

```

### Connect SQLite Database via PDO
```php
<?php defined('PDM_CONFIG_DIR') || exit;

// Database3.config.php

return array
(
  'type'  => 'pdo:sqlite',
  'info'  => array
  (
     'host' => NULL,
    'name'  => 'path/to/sqlite.sq3',
    'user'  => NULL,
    'pwd'   => NULL,
  ),
  'prefix'    => 'prefix_',
  'charset'   => NULL,
);

```
## Start PDM Object
```php
/**
 * Require PSR-4 Autoloader
 */
require_once(dirname(__FILE__) . '/autoload.php');

/**
 * Start PDM Object
 * @var 
 */
$pdm = PDM\PDM::getInstance();
```
### Load SQL Command
```php

// $pdm->load(command, DbConfigName)

$dml = $pdm->load('DML', 'Database1');

$ddl = $pdm->load('DDL', 'Database2');

$dcl = $pdm->load('DCL', 'Database1');
```
- DML : data manipulation language, SELECT - INSERT - UPDATE - DELETE
- DDL : Data definition language, CREATE - DROP - ALTER - RENAME - TRUNCATE
- DCL : Data control language, GRANT - REVOKE
- <del>TCL : Transaction Control Language</del>

## DML 
```php
/**
 * Require PSR-4 Autoloader
 */
require_once('path/to/autoload.php');

/**
 * Start PDM Object
 * @var 
 */
$pdm = PDM\PDM::getInstance();

/** load DML */
$dml = $pdm->load('DML', 'Database1');
```
### Run Query & DB connection
```php

// start database connecton
$dml->start();

/** check database is connected **/
// boolean $dml->connect->isConnected();

/** get connected database name **/
// string|false $dml->connect->getConnectedDatabase();

$query = $dml->connect->query('SELECT ....');

```

### Select Data 
```php

/**
 * table name is : PrefixKey_users
 */
$users = $dml->getUsers();
// mysqli $users->num_rows
// pdo $users->rowCount();

/**
 * table name is : PrefixKey_Users
 */
$users = $pdm->getUsers(null, true);

/**
 * Options 
 */
 
$users = $pdm->getUsers(['limit' => 10]);
 
/**
 * Escape Data
 */
$id = $dml->connect->escape($_GET['id'], 'int');

$options = array(
	
	'get' 	=> 'first_name, last_name, username',
	'cond'	=> 'WHERE user_id=' . $id,
	'limit'  => 1
);

$users = $dml->getUsers($options);

```
### Select data way 2
```php

$id = (isset($_GET['id'])) ? $_GET['id'] : null;

$id = $dml->connect->escape($id, 'int');
$un = $dml->connect->escape('moh'); // escape string
$users = $dml->select('first_name, last_name...', 'users', "WHERE id=$id AND username='{$un}'");

```

### Select One Row 
```php

$user = $dml->selectOne('first_name, last_name', 'users', 'WHERE id=1');

echo $user['last_name'];

```
Please read the classes doc for more information & examples dir
