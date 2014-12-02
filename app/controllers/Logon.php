<?php

use Respect\Validation\Validator as v;

class Logon 
{

	protected function validate($usr)
	{

		$usernameValidator = v::alnum()->noWhitespace();
		return $usernameValidator->validate($usr);

	}

	public function viewLogin() 
	{

		$username = null;
		View::display('front.login.tpl', compact('username'));
		
	}

	public function postLogin() 
	{

		$username = Input::post('username');
		$password = Input::post('password');
		
		$authenticator = App::make('authenticator');
		$result = $authenticator->authenticate($username, $password);
		
		if ($result->isValid() && $this->validate($username)) {

			App::flash('success', Lang::success('login_success'));
			Response::redirect('/admin');

		} else {

			App::flashNow('error', Lang::error('login_error'));
			View::display('front.login.tpl');

		}
		
	}

	public function logout() 
	{

		$authenticator = App::make('authenticator');
		$authenticator->logout();
		Response::redirect('/login');

	}

}