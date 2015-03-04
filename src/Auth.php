<?php namespace Hacklee\Multiauth;

use Illuminate\Foundation\Application;
class Auth {

	/**
	 * @var Illuminate\Foundation\Application $app
	 */
	protected $app;
	protected $config;
	protected $providers = array();
	public function __construct(Application $app) {
		$this->app = $app;
		$this->config = $this->app['config']['auth'];
		foreach($this->config as $key => $config) {
			$this->providers[$key] = new XhAuthManager($this->app, $key, $config);
		}
	}
	public function __call($name, $arguments = array()) {
		if(array_key_exists($name, $this->providers)) {
			return $this->providers[$name];
		}
	}
}
