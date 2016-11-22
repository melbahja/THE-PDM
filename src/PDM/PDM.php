<?php
/**
 * THE PDM 
 * @package PDM
 * @link https://github.com/melbahja/THE-PDM/ The PDM Github Repo
 * @author Mohamed Elbahja <mohamed@elbahja.me>
 * @copyright 2016 Dinital.com
 * @license	http://opensource.org/licenses/MIT	MIT License
 */

namespace PDM; 

/**
 * Require Constants 
 */
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'Constants.config.php');

class PDM extends Loader implements Interfaces\PDM
{

	/**
	 * instance
	 */
	private static $instance;

	/**
	 * sql commands
	 * @var array
	 */
	private $commads = array('DDL', 'DML', 'DCL');

	/**
	 * construct
	 */
	public function __construct() 
	{ 

	}

	/**
	 * get instance
	 * @return object
	 */
	public static function getInstance()
	{

		if (self::$instance === null) {

			self::$instance = new self();
		}

		return self::$instance;
	}  

	/**
	 * load commands
	 * @param  string $command 
	 *    DML : data manipulation language, SELECT - INSERT - UPDATE - DELETE
	 *    DDL : Data definition language, CREATE - DROP - ALTER - RENAME - TRUNCATE 
	 *    TCL : Transaction Control Language, 
	 *    DCL : Data control language
	 * @param  string $config  file name in config directory
	 * @return mixed
	 */
	public function load($command, $config = 'Database1')
	{

		$config = $this->config($config);

		if (!in_array($command, $this->commads)) {
		
			exit('Error: Sql Command not exists');
		
		} elseif ($config === false) {

			exit('Error: config file not exists');
		}	

		return $this->command($command, $config);	
	}
} 