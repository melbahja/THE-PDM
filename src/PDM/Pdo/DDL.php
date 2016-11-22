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

class DDL
{

	/**
	 * prefix
	 */
	protected $prefix;
	
	/**
	 * Connection
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
	 * Create table
	 * @param  string $table   table name
	 * @param  array  $data    table data
	 * @param  string $options table options
	 * @return boolean
	 */
	public function create($table, $sql)
	{

		$sql = $this->connect->sqlFormat("CREATE TABLE @prefix_{$table} {$sql}");
		if ($this->connect->query($sql)) return true;
		return false;
	}

	/**
	 * DROP 
	 * @param  string $sql the command
	 * @return boolean
	 */
	public function drop($sql)
	{
		if ($this->connect->query('DROP ' . $this->connect->sqlFormat($sql) )) return true;
		return false;
	}

	/**
	 * Alter table
	 * @param  string $table table name
	 * @param  string $sql   commad
	 * @return boolean
	 */
	public function alter($table, $sql)
	{
		if ($this->connect->query($this->connect->sqlFormat("ALTER TABLE {$this->prefix}{$table} $sql"))) return true;
		return false;
	}

	/**
	 * Rename Tables
	 * @param  string $table   table name
	 * @param  string $newName new tabel name
	 * @return boolean
	 */
	public function rename($table, $newName)
	{
		if ($this->connect->query("RENAME TABLE {$this->prefix}{$table} TO {$this->prefix}{$newName}")) return true;
		return false;
	}

	/** 
	 * TRUNCATE Table 
	 * @param  string $table table name
	 * @return boolean
	 */
	public function truncate($table)
	{
		if ($this->connect->query("TRUNCATE TABLE {$this->prefix}{$table}")) return true;
		return false;
	}

}