<?php namespace Hacklee\Multiauth;

use Illuminate\Auth\AuthServiceProvider;
use Hacklee\Multiauth\Auth;

class XhAuthServiceProvider extends AuthServiceProvider{
	/**
	 * Register the authenticator services.
	 *
	 * @return void
	 */
	protected function registerAuthenticator()
	{
		$this->app->singleton('auth', function($app)
		{
			// Once the authentication service has actually been requested by the developer
			// we will set a variable in the application indicating such. This helps us
			// know that we need to set any queued cookies in the after event later.
			$app['auth.loaded'] = true;
	
			return new Auth($app);
		});
	
		$this->app->singleton('auth.driver', function($app)
		{
			return $app['auth']->driver();
		});
	}
}