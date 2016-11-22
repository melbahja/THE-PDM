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

class DML
{

	/**
	 * get db connection
	 */
	public $connect;

	/**
	 * tables prefix
	 */
	protected $prefix;

	/**
	 * insert_ids for multiInsert
	 * @var array
	 */
	protected $insert_ids = array();

	/**
	 * construct
	 * @param array $config 
	 */
	public function __construct(array $config)
	{

		$this->connect = Connect::getInstance();
		$this->prefix	= $config['prefix'];
		$this->connect->setConfig($config);
		unset($config['type']);
	}

	/**
	 * destruct
	 */
	public function __destruct()
	{
		
		if ($this->connect->isConnected() === true) $this->connect->close();
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
     * [select : select data]
     * @param  string $select [columns ex: username, pass, email ....]
     * @param  string $from   [table name]
     * @param  string $where  [optional  ex: WHERE id='1']
     * @return object
     */
    public function select($select, $from, $where = '') 
    {
      $sql = 'SELECT ' . $select . ' FROM ' . $this->prefix . $from . ' ' . $where;
      $sql = $this->connect->sqlFormat($sql);
      return $this->connect->query($sql);
    }

    /**
     * [selectOne : select 1 row]
     * @param  string $select [columns ex: website_name, website_url, description ....]
     * @param  string $from   [table name]
     * @param  string $where  [optional]
     * @param  string $fetch  [fetch_assoc() = assoc ; fetch_row = row ; fetch_object = object]
     * @return mixed [if $fetch == assoc || row, return array ; if $fetch == object, return object; if $data == false return null]
     */
    public function selectOne($select, $from, $where = '', $fetch = 'assoc') 
    {

		  $fetch = 'fetch_' . $fetch;
		  $data = null;

		  	if ( $data = $this->select($select, $from,  $where . ' LIMIT 1') ) {

		      $data = $data->$fetch();
		      $data->close();
		  	}

		  unset($select, $from, $where, $fetch);
		  return $data; 
    }

    /**
    * [insert : insert data]
    * @param  string $into  [table name]
    * @param  array  $array [data , associative array : key = column and value = column value]
    * @return boolean
    */
    public function insert($into, array $array) 
    {

        $data   = array();

        foreach ($array as $key => $value) {
            $data[] = $this->connect->escape($key) . "='" . $this->connect->escape($value) . "'";
        }

        $data = implode(', ', $data);

        $sql  = 'INSERT INTO ' . $this->prefix . $into . ' SET ' . $data;

        unset($into, $array, $data);

        if ( $this->connect->query($sql) ) return true;

        return false;  
    }

	/**
	* [multiInsert Multi Insert data]
	* @param  string $into  [tablse name]
	* @param  array  $array [data , Multidimensional Associative Array]
	* @return boolean
	*/
	public function multiInsert($into, array $array) 
	{

	  	foreach( $array as $val ) {

	      if( !is_array($val) ) return false; 
	  	}

	  	foreach ( $array as $key => $value ) {

	      $this->insert_ids[$key] = ( $this->insert($into, $value) === true ) ? $this->connect->insert_id : false;
	  	}

	  	unset($into, $array, $ids);

	  	$fIds = array_filter($this->insert_ids);

	  	if ( !empty($fIds) ) return true;

	  	return false;       
	}

	/**
	* [update : update data]
	* @param  string $table [table name]
	* @param  array $array  [data , associative array : key = column and value = column value]
	* @param  string $where [optional]
	* @return boolean
	*/
	public function update($table, $array, $where = '') 
	{

	  	$data   = array();

	  	foreach ($array as $key => $value) {
	      $data[] = $this->connect->escape($key) . "='" . $this->connect->escape($value) . "'";
	  	}

	 	$data = implode(', ', $data);

	 	$sql  = 'UPDATE ' . $this->prefix . $table . ' SET ' . $data . ' ' . $where; 

	 	unset($table, $array, $where, $data);

	 	if ( $this->connect->query($sql) ) return true;

	 	return false;       
	}

	/**
	* [delete : delete data]
	* @param  string $from  [tabel name]
	* @param  string $where [optional]
	* @return boolean
	*/
	public function delete($from, $where = '') 
	{

	  $sql = 'DELETE FROM ' . $this->prefix . $from . ' ' . $where;

	  unset($from, $where);

	  if ( $this->connect->query($sql) ) return true;

	  return false;
	}

	/**
	 * __call
	 * @param  string $call   
	 * @param  array $params  :
	 *               first param array 
	 *               second param bool is upper first table name char after prefix 
	 * @return mixed
	 */
	public function __call($call, $params)
	{

		$key 		= strtolower(substr($call, 0, 3));
		$table 	= lcfirst(substr($call, 3));
		$isParam = array_key_exists(0, $params); 
		
		if (array_key_exists(1, $params) === true && $params[1] === true) {

			$table = ucfirst($table);
		}

		if ($key === 'get') {
				
			$select 	= ($isParam === true && isset($params[0]['get'])) ? $params[0]['get'] : '*';
			$where 	= ($isParam === true && isset($params[0]['cond'])) ? $params[0]['cond'] : '';
			$limit 	= ($isParam === true && isset($params[0]['limit'])) ? ' LIMIT ' . $params[0]['limit'] : '';
		 
			return $this->select($select, $table, $where . $limit);
		
		} elseif ($key === 'set') {
			
			if ($isParam === false) {

				/** data not found */
				return false;
			} 

			return $this->insert($table, $params[0]);	
		}
	}

}