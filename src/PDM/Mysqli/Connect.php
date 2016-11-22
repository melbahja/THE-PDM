<?php
/**
 * THE PDM 
 * @package PDM
 * @link https://github.com/melbahja/THE-PDM/ The PDM Github Repo
 * @author Mohamed Elbahja <mohamed@elbahja.me>
 * @copyright 2016 Dinital.com
 * @license	http://opensource.org/licenses/MIT	MIT License
 */
namespace PDM\Mysqli;

class Connect extends \Mysqli
{


	private static $instance;
	private $config 		= false;
	private $isConnected = false;
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
		return str_replace(array('@prefix_', '@charset', '@dbname', '@user', '@host'), array($this->config['prefix'], $this->config['charset'], $this->config['name'], $this->config['user'], $this->config['host']), $sql);
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

			return (int) $this->real_escape_string($data);
		}

		return $this->real_escape_string($data);
	}

	/**
	 * start database connection
	 * @return mixed
	 */
	public function start() 
	{

		parent::__construct($this->config['host'], $this->config['user'], $this->config['pwd'], $this->config['name']);

		if ($this->connect_error) exit('Failed Connect to Database <br /> Error Info : ' . $this->connect_error);

		$this->set_charset($this->config['charset']);
		$this->connectedDb	= $this->config['name'];
		$this->isConnected	= true;
	}
}