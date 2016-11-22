<?php
/**
 * THE PDM 
 * @package PDM
 * @link https://github.com/melbahja/THE-PDM/ The PDM Github Repo
 * @author Mohamed Elbahja <mohamed@elbahja.me>
 * @copyright 2016 Dinital.com
 * @license	http://opensource.org/licenses/MIT	MIT License
 */
namespace PDM\PDO;

use \PDM\Exceptions\PDMException;

class Connect extends \PDO
{

	/**
	 * Instance
	 */
	private static $instance;
	
	/**
	 * confg
	 * @var boolean|array
	 */
	private $config = false;

	/**
	 * is connected
	 * @var boolean
	 */
	private $isConnected = false;

	/**
	 * connected db name
	 * @var boolean|string
	 */
	private $connectedDb = false; 

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
	 * overloading
	 */
	public function __construct()
	{

	}

	/**
	 * set config
	 * @param array $config database config
	 */
	public function setConfig(array $config)
	{
		$this->config = $config;
	}

	/**
	 * check database is connected
	 * @return boolean
	 */
	public function isConnected()
	{
		return $this->isConnected;
	}

	/**
	 * get connected database name
	 * @return string|false
	 */
	public function getConnectedDatabase()
	{
		return $this->connectedDb;
	}

	/**
	 * format sql commad
	 * @param  string $sql 
	 * @return string
	 */
	public function sqlFormat($sql)
	{	
		return str_replace(array('@prefix_', '@charset', '@dbname', '@user', '@host'), array($this->config['prefix'], $this->config['charset'], $this->config['info']['name'], $this->config['info']['user'], $this->config['info']['host']), $sql);
	}

	/**
	 * real escape string
	 * @param  string $data
	 * @param  string $type
	 * @return string|integer
	 */
	public function escape($data, $type = 'str')
	{
		$data = (get_magic_quotes_gpc()) ? stripslashes($data) : $data;

		if ($type === 'int') {

	      return (int) substr(parent::quote($data), 1, -1);
	   }

	   return substr(parent::quote($data), 1, -1);
	}

	/**
	 * start database connection
	 * @return mixed
	 */
	public function start() 
	{


		$dsn = isset($this->config['type'][1]) ? $this->config['type'][1] : 'mysql';

		$dsn .= ($dsn === 'sqlite') ? ":{$this->config['info']['name']}" : ":host={$this->config['info']['host']};dbname={$this->config['info']['name']};charset={$this->config['charset']}";

		try {
			
			parent::__construct($dsn, $this->config['info']['user'], $this->config['info']['pwd'], array(
			parent::ATTR_ERRMODE => parent::ERRMODE_SILENT,
			parent::ATTR_EMULATE_PREPARES => false));

		} catch(\PDOException $e) {

			throw new PDMException('Failed Connect to Database <br /> Error Info : ' . $e->getMessage());
		}	

		$this->connectedDb = $this->config['info']['name'];
		$this->isConnected = true;
	}
 
}
