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

class Connect extends \PDO
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

		$dsn = $this->config['dirver'] . ':host=' . $this->config['host'] . ';dbname=' . $this->config['name'] . ';charset=' . $this->config['charset']; 
		try {
			
			parent::__construct($dsn, $this->config['user'], $this->config['pwd'], array(
			parent::ATTR_ERRMODE => parent::ERRMODE_EXCEPTION,
			parent::ATTR_EMULATE_PREPARES => false));

		} catch(\PDOException $e) {

			exit('Failed Connect to Database <br /> Error Info : ' . $e->getMessage());
		}	

		$this->connectedDb	= $this->config['name'];
		$this->isConnected	= true;
	}
 
}