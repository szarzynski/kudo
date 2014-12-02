<?php

class Lang
{

	public function error($err) 
	{

		$errorsArr = array(

			'login_error' => 'Wpisano błędne dane przy logowaniu.'

		);

		return $errorsArr[$err];

	}

	public function success($succ) 
	{

		$successArr = array(

			'login_success' => 'Udane logowanie.'

		);

		return $successArr[$succ];

	}

}