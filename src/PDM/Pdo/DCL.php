<?php
/**
 * THE PDM 
 * @package PDM
 * @link https://github.com/melbahja/THE-PDM/ The PDM Github Repo
 * @author Mohamed Elbahja <mohamed@elbahja.me>
 * @copyright 2016 Dinital.com
 * @license	http://opensource.org/licenses/MIT	MIT License
 */
namespace PDM\Pdo;

class DCL
{

	/**
	 * tables prefix
	 */
	protected $prefix;

	/**
	 * get db Connection
	 */
	public $connect;

	/**
	 * construct
	 * @param array $config 
	 */
	public function __construct(array $config)
	{

		$this->connect = Connect::getInstance();
		$this->prefix	= $config['prefix'];
		$this->connect->setConfig($config);
		unset($config);
	}

	/**
	 * destruct
	 */
	public function __destruct()
	{
		$this->connect = null;
	}

	/**
	 * start database connection 
	 * @return void
	 */
	public function start()
	{
		$this->connect->start();
	}

	/**
	 * GRANT
	 * @param  string $priv Privilege ex : SELECT, UPDATE ...
	 * @see https://www.techonthenet.com/mysql/grant_revoke.php
	 * @return boolean
	 */
	public function grant($priv)
	{
		if ($this->connect->query( $this->connect->sqlFormat("GRANT {$priv} ON @dbname TO '@user'@'@host'") )) return true;
		return false;
	}

	/**
	 * REVOKE
	 * @param  string $priv Privilege
	 * @see https://www.techonthenet.com/mysql/grant_revoke.php
	 * @return boolean
	 */
	public function revoke($priv)
	{
		if ($this->connect->query( $this->connect->sqlFormat("REVOKE {$priv} ON @dbname FROM '@user'@'@host'") )) return true;
		return false;
	}
}