<?php namespace Hacklee\Multiauth;


use Illuminate\Support\Manager;
use Illuminate\Auth\DatabaseUserProvider;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Auth\Guard;
class XhAuthManager extends Manager{
	
	protected $config;
	protected $name;
	
	public function __construct($app, $name, $config) {
		parent::__construct($app);
		$this->config = $config;
		$this->name = $name;
	}
	
	
	/**
	 * Create a new driver instance.
	 *
	 * @param  string  $driver
	 * @return mixed
	 */
	protected function createDriver($driver)
	{
		
		$guard = parent::createDriver($driver);

		// When using the remember me functionality of the authentication services we
		// will need to be set the encryption instance of the guard, which allows
		// secure, encrypted cookie values to get generated for those cookies.
		$guard->setCookieJar($this->app['cookie']);
	
		$guard->setDispatcher($this->app['events']);
	
		return $guard->setRequest($this->app->refresh('request', $guard, 'setRequest'));
	}
	
	/**
	 * Call a custom driver creator.
	 *
	 * @param  string  $driver
	 * @return \Illuminate\Auth\Guard
	 */
	protected function callCustomCreator($driver)
	{
		$custom = parent::callCustomCreator($driver);
	
		if ($custom instanceof Guard) return $custom;
	
		return new XhGuard($custom, $this->app['session.store'],$this->name);
	}
	
	/**
	 * Create an instance of the database driver.
	 *
	 * @return \Illuminate\Auth\Guard
	 */
	public function createDatabaseDriver()
	{
		$provider = $this->createDatabaseProvider();
	
		return new XhGuard($provider, $this->app['session.store'],$this->name);
	}
	
	/**
	 * Create an instance of the database user provider.
	 *
	 * @return \Illuminate\Auth\DatabaseUserProvider
	 */
	protected function createDatabaseProvider()
	{
		$connection = $this->app['db']->connection();
	
		// When using the basic database user provider, we need to inject the table we
		// want to use, since this is not an Eloquent model we will have no way to
		// know without telling the provider, so we'll inject the config value.
		$table = $this->config['table'];
	
		return new DatabaseUserProvider($connection, $this->app['hash'], $table);
	}
	
	/**
	 * Create an instance of the Eloquent driver.
	 *
	 * @return \Illuminate\Auth\Guard
	 */
	public function createEloquentDriver()
	{
		$provider = $this->createEloquentProvider();
	
		return new XhGuard($provider, $this->app['session.store'],$this->name);
	}
	
	
	/**
	 * Create an instance of the Eloquent user provider.
	 *
	 * @return \Illuminate\Auth\EloquentUserProvider
	 */
	protected function createEloquentProvider()
	{
		$model = $this->config['model'];
	
		return new EloquentUserProvider($this->app['hash'], $model);
	}
	
	/**
	 * Get the default authentication driver name.
	 *
	 * @return string
	 */
	public function getDefaultDriver()
	{
		return $this->config['driver'];
	}
	
	/**
	 * Set the default authentication driver name.
	 *
	 * @param  string  $name
	 * @return void
	 */
	public function setDefaultDriver($name)
	{
		$this->config['driver'] = $name;
	}
	
	
	public function createApiDriver(){
		$provider = $this->createEloquentProvider();
	
		return new ApiGuard($provider, $this->app['session.store'],$this->name);
	}
	
	public function createOpDriver(){
		$provider = $this->createEloquentProvider();
	
		return new OpGuard($provider, $this->app['session.store'],$this->name);
	}
	
	public function createCpDriver(){
		$provider = $this->createEloquentProvider();
	
		return new CpGuard($provider, $this->app['session.store'],$this->name);
	}
}
