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

class DDL
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
	 * Create table
	 * @param  string $table   table name
	 * @param  array  $data    table data
	 * @param  string $options table options
	 * @return boolean
	 */
	public function create($table, array $data, $options = null)
	{

		$sql = "CREATE TABLE @prefix_{$table} (";
		
		foreach ($data as $key => $val) {
			$sql .= "`{$key}` {$val},";
		}

		$sql = $this->connect->sqlFormat( rtrim($sql, ',') .  ") {$options};" );

		return $this->connect->query($sql);
	}

	/**
	 * DROP 
	 * @param  string $sql the command
	 * @return boolean
	 */
	public function drop($sql)
	{
		return $this->connect->query('DROP ' . $this->connect->sqlFormat($sql) );
	}

	/**
	 * Alter table
	 * @param  string $table table name
	 * @param  string $sql   commad
	 * @return boolean
	 */
	public function alter($table, $sql)
	{
		return $this->connect->query($this->connect->sqlFormat("ALTER TABLE {$this->prefix}{$table} $sql"));
	}

	/**
	 * Rename Tables
	 * @param  string $table   table name
	 * @param  string $newName new tabel name
	 * @return boolean
	 */
	public function rename($table, $newName)
	{
		return $this->connect->query("RENAME TABLE {$this->prefix}{$table} TO {$this->prefix}{$newName}");
	}

	/** 
	 * TRUNCATE Table 
	 * @param  string $table table name
	 * @return boolean
	 */
	public function truncate($table)
	{
		return $this->connect->query("TRUNCATE TABLE {$this->prefix}{$table}");
	}

}
