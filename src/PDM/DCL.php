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

class DCL
{

	protected $prefix;
	public $connect;

	/**
	 * __construct
	 * @param array $config
	 */
	public function __construct(array $config)
	{
		$connect = __NAMESPACE__ . '\\' . $config['manager'] . '\Connect'; 
		$this->connect = $connect::getInstance();
		$this->prefix	= $config['prefix'];
		$this->connect->setConfig($config);
		unset($config, $connect);
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
		return $this->connect->query( $this->connect->sqlFormat("GRANT {$priv} ON @dbname TO '@user'@'@host'") );
	}

	/**
	 * REVOKE
	 * @param  string $priv Privilege
	 * @see https://www.techonthenet.com/mysql/grant_revoke.php
	 * @return boolean
	 */
	public function revoke($priv)
	{
		return $this->connect->query( $this->connect->sqlFormat("REVOKE {$priv} ON @dbname FROM '@user'@'@host'") );
	}
}