<?php namespace Hacklee\Multiauth;


use Illuminate\Contracts\Auth\UserProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Illuminate\Auth\Guard;

class XhGuard extends Guard{
	protected $name;
/**
	 * Create a new authentication guard.
	 *
	 * @param  \Illuminate\Contracts\Auth\UserProvider  $provider
	 * @param  \Symfony\Component\HttpFoundation\Session\SessionInterface  $session
	 * @param  \Symfony\Component\HttpFoundation\Request  $request
	 * @return void
	 */
	public function __construct(UserProvider $provider,
								SessionInterface $session,
								$name,
								Request $request = null)
	{
		parent::__construct($provider, $session, $request);
		$this->name = $name;
	}
	public function getName() {
		return 'login_' . $this->name . '_' . md5(get_class($this));
	}
	public function getRecallerName() {
		return 'remember_' . $this->name . '_' . md5(get_class($this));
	}
	public function get() {
		return $this->user();
	}
	public function impersonate($type, $id, $remember = false) {
		if($this->check()) {
			return Auth::$type()->loginUsingId($id, $remember);
		}
	}
}
