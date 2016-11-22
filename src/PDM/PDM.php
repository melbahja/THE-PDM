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
 * PDM Config Dir
 */
define('PDM_CONFIG_DIR', __DIR__ . DIRECTORY_SEPARATOR . 'Config');

use Exceptions\PDMException;
use Interfaces\PDM as pdmInterface;

class PDM implements Interfaces\PDM
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
	 * loader
	 */
	private $loader;

	/**
	 * construct
	 */
	public function __construct() 
	{ 
		$this->loader = Loader::getInstance();
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
	public function load($command, $config)
	{

		if (!in_array($command, $this->commads)) {
		
			throw new PDMException('Error: Sql Command not exists');
		
		}

		return $this->loader->command($command, $config);	
	}
} 