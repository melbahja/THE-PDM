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

use PDM\Interfaces\Loader as loaderInterface;

class Loader implements loaderInterface
{

	/** 
	 * load config file
	 * @param  string $config config file name
	 * @return array
	 */
	public function config($config) 
	{

		$config = PDM_CONFIG_DIR . DIRECTORY_SEPARATOR . $config . '.config.php';

		if (file_exists($config) === false) return false;

		$config 					= require_once($config);
		$dbInfo 					= explode(':', $config['manager']);
		$config['manager'] 	= ucfirst($dbInfo[0]);
		$config['dirver']		= (isset($dbInfo[1])) ? $dbInfo[1] : null;
		return $config;  
	}

	/**
	 * load command object
	 * @param  string $command see PDM class line:57
	 * @param  array $config  database config
	 * @return object
	 */
	public function command($command, $config)
	{
		$obj = __NAMESPACE__  . '\\' . $command;
		return new $obj($config);
	}
}