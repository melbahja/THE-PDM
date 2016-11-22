# THE-PDM
 THE PDM is a Library to deal with different databases with PDO or mysqli

## Usage

### Config file
edit config folder path in : src/PDM/Constants.config.php

### Database Config
Each database can create a setup file in config directory 

- manager : Database Book PDO or Mysqli
- host    : Database Host name
- name    : Databbase name
- user    : Database user
- pwd     : database password
- prefix  : for security, You can change it at any time
- charset : db encoding

## examples : 

#### Connect MySQL Database via Mysqli 
```php
<?php defined('PDM_CONFIG_DIR') || exit;

// database1.config.php

return array(
	'manager' 	=> 'Mysqli',
	'host' 		=> 'localhost',
	'name' 		=> 'databaseNameHere',
	'user' 		=> 'databaseUserNameHere',
	'pwd' 		=> 'databasePassword',
	'prefix' 	=> 'PrefixKey_',
	'charset' 	=> 'utf8mb4',
);

```

### Connect MySQL Database via PDO
```php
<?php defined('PDM_CONFIG_DIR') || exit;

// database1.config.php

return array(
	'manager' 	=> 'PDO:mysql',
	'host' 		=> 'localhost',
	'name' 		=> 'databaseNameHere',
	'user' 		=> 'databaseUserNameHere',
	'pwd' 		=> 'databasePassword',
	'prefix' 	=> 'PrefixKey_',
	'charset' 	=> 'utf8mb4',
);

```

### Connect SQLite Database via PDO
```php
<?php defined('PDM_CONFIG_DIR') || exit;

// database1.config.php

return array(
	'manager' 	=> 'PDO:sqlite',
	'host' 		=> null,
	'name' 		=> 'path/to/databaseFile.db',
	'user' 		=> null,
	'pwd' 		=> null,
	'prefix' 	=> 'PrefixKey_',
);

```





