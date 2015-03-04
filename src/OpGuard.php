<?php namespace Hacklee\Multiauth;

use Hacklee\Multiauth\XhGuard;

class OpGuard extends XhGuard {
	
	/**
	 * Attempt to authenticate a user using the given credentials.
	 *
	 * @param  array  $credentials
	 * @param  bool   $remember
	 * @param  bool   $login
	 * @return bool
	 */
	public function attempt(array $credentials = [], $remember = false, $login = true)
	{
		echo 'opAttempt';
	} 
}