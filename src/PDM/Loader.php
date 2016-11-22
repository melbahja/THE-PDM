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

use \PDM\Interfaces\Loader as loaderInterface;
use \PDM\Exceptions\PDMException;

class Loader implements loaderInterface
{

	/**
	 * instance
	 */
	private static $instance;

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
	 * load command object
	 * @param  string $command see PDM class line:57
	 * @param  array $config  database config
	 * @return object
	 */
	public function command($command, $config)
	{

		$config = PDM_CONFIG_DIR . DIRECTORY_SEPARATOR . $config . '.config.php';

		if (file_exists($config) === false) {

			throw new PDMException('Error: Config file not found or not exists');
		}

		$config = require_once($config);
		$config['type'] = explode(':', $config['type']);
		$obj = __NAMESPACE__  . '\\' . ucfirst($config['type'][0]). '\\' . $command;
		return new $obj($config);
	}
}